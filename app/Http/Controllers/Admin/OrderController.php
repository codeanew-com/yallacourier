<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Models\CourierModel;
use App\Models\CustomerModel;
use App\Models\LogModel;
use App\Models\OrderDimensionModel;
use App\Models\OrderMetaModel;
use App\Models\OrderModel;
use App\Models\OrderPackagesModel;
use App\Models\User;
use App\Services\Orders\CourierSettlementService;
use App\Services\Orders\OrderFilters;
use App\Services\Orders\OrderMailService;
use App\Services\Orders\OrderPricing;
use App\Services\Orders\OrderUpdater;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /** Meta keys shown in the orders table — loaded in one query per page instead of per row. */
    private const LIST_META_KEYS = ['sender_name', 'sender_phone', 'sender_state', 'reciever_name', 'reciever_state', 'reciever_country'];

    public function index(Request $request)
    {
        $filters = OrderFilters::fromRequest($request);
        $query = OrderFilters::query($filters);

        $orders = (clone $query)->orderBy('id', 'DESC')->paginate(30)->withQueryString();

        $meta = OrderMetaModel::whereIn('order_id', $orders->pluck('id'))
            ->whereIn('key', self::LIST_META_KEYS)
            ->get()
            ->groupBy('order_id')
            ->map(fn ($rows) => $rows->pluck('value', 'key'));

        $stats = (clone $query)->toBase()->selectRaw('
                COUNT(*) as orders,
                COALESCE(SUM(total),0) as revenue,
                COALESCE(SUM(courier_quote + courier_vat),0) as courier_cost,
                COALESCE(SUM(comission + service_fee + over_head),0) as profit,
                COALESCE(SUM(order_settled),0) as courier_paid,
                COALESCE(SUM(CASE WHEN order_settled = 0 AND status <> "cancelled" THEN courier_quote + courier_vat ELSE 0 END),0) as courier_outstanding,
                COALESCE(SUM(CASE WHEN order_settled = 0 AND status <> "cancelled" AND (courier_quote + courier_vat) > 0 THEN 1 ELSE 0 END),0) as unsettled_count
            ')->first();

        // Tab counts ignore the status filter itself so every tab shows what it would contain.
        $statusCounts = OrderFilters::query(array_merge($filters, ['status' => '']))
            ->toBase()
            ->select('status', DB::raw('COUNT(*) as n'))
            ->groupBy('status')
            ->pluck('n', 'status');

        return view('admin.order.index', [
            'orders' => $orders,
            'meta' => $meta,
            'couriers' => CourierModel::orderBy('name')->get()->keyBy('id'),
            'stats' => $stats,
            'statusCounts' => $statusCounts,
            'filters' => $filters,
            'statuses' => OrderModel::STATUSES,
        ]);
    }

    /**
     * The old standalone "Search Finances" page is now just the orders list with
     * filters applied — kept as a redirect so existing bookmarks still work.
     */
    public function search(Request $request)
    {
        $params = $request->except('_token');
        if (($params['courier'] ?? '') === '0') {
            unset($params['courier']);
        }

        return redirect()->route('admin.order.index', $params);
    }

    public function show(int $id)
    {
        $o = OrderModel::findOrFail($id);
        $meta = OrderMetaModel::where('order_id', $o->id)->pluck('value', 'key');
        $couriers = CourierModel::orderBy('name')->get();
        $courier = $couriers->firstWhere('id', $o->courier);

        $isIntl = OrderPricing::isInternational($meta['sender_country'] ?? null, $meta['reciever_country'] ?? null);
        $isDocument = str_contains(strtolower((string) ($meta['box_contents'] ?? '')), 'document');

        // Start in automatic commission mode when the stored figure is empty or
        // already what the courier's rate produces; otherwise respect the
        // manually entered value the order already has.
        $commissionAuto = true;
        if ($courier && $o->comission > 0) {
            $expected = OrderPricing::commission((float) $o->subtotal, OrderPricing::commissionRate($courier, $isIntl, $isDocument));
            $commissionAuto = abs($expected - (float) $o->comission) < 0.02;
        } elseif (! $courier && $o->comission > 0) {
            $commissionAuto = false;
        }

        $activity = LogModel::where('mess', 'like', 'Order #'.$o->id.':%')
            ->orderBy('id', 'DESC')->limit(15)->get();

        return view('admin.order.show', [
            'o' => $o,
            'meta' => $meta,
            'dimensions' => OrderDimensionModel::where('order_id', $o->id)->get(),
            'packages' => OrderPackagesModel::where('order_id', $o->id)->get(),
            'couriers' => $couriers,
            'courier' => $courier,
            'rates' => OrderPricing::courierRates($couriers),
            'isIntl' => $isIntl,
            'isDocument' => $isDocument,
            'commissionAuto' => $commissionAuto,
            'quoteSameAsSubtotal' => abs((float) $o->courier_quote - (float) $o->subtotal) < 0.005,
            'activity' => $activity,
            'admins' => User::whereIn('id', $activity->pluck('added_by'))->pluck('name', 'id'),
            'statuses' => OrderModel::STATUSES,
            'customer' => $o->customer_id ? CustomerModel::find($o->customer_id) : null,
        ]);
    }

    public function update(UpdateOrderRequest $request, int $id, OrderUpdater $updater)
    {
        $order = $updater->update(OrderModel::findOrFail($id), $request);

        Session::flash('msg', 'Order #'.$order->id.' saved. Total is AED '.number_format($order->total, 2).'.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin.view.order', $order->id);
    }

    /** Mark the courier cost of the selected (or all filtered) orders as paid. */
    public function settle(Request $request, CourierSettlementService $settlement)
    {
        $ids = $request->input('apply_to') === 'filtered'
            ? OrderFilters::query(OrderFilters::fromRequest($request))->pluck('id')->all()
            : array_filter((array) $request->input('order_id', []), 'is_numeric');

        [$count, $amount] = $settlement->settle($ids);

        if ($count > 0) {
            Session::flash('msg', 'Settled '.$count.' order'.($count === 1 ? '' : 's').' — AED '.number_format($amount, 2).' marked as paid to couriers.');
            Session::flash('class', 'alert-success');
        } else {
            Session::flash('msg', 'Nothing to settle: the selected orders are already settled, cancelled, or have no courier cost yet.');
            Session::flash('class', 'alert-warning');
        }

        return redirect()->back();
    }

    /** Resend the confirmation and invoice emails to both sender and receiver. */
    public function resendEmails(string $id, OrderMailService $mailer)
    {
        $o = OrderModel::find($id) ?? abort(404);

        $results = $mailer->resendAll($o);
        $sent = count(array_filter($results));
        if ($sent === count($results)) {
            Session::flash('msg', 'All 4 emails (confirmation + invoice to sender and receiver) were sent for order #'.$o->id.'.');
            Session::flash('class', 'alert-success');
        } else {
            Session::flash('msg', $sent.' of '.count($results).' emails were sent for order #'.$o->id.'. Check that both email addresses are valid; failures are written to the Laravel log.');
            Session::flash('class', $sent ? 'alert-warning' : 'alert-danger');
        }

        return redirect()->back();
    }
}
