<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourierModel;
use App\Models\CustomerModel;
use App\Models\FormModel;
use App\Models\OrderMetaModel;
use App\Models\OrderModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $open = fn () => OrderModel::where('status', '<>', 'cancelled');

        // Work queues: every number links to the filtered orders list.
        $queues = [
            'pending' => OrderModel::where('status', 'pending')->count(),
            'unassigned' => $open()->whereNotIn('status', ['completed', 'delivered'])->where('courier', 0)->count(),
            'unpaid' => $open()->where('payment_status', '<>', 1)->where('total', '>', 0)->count(),
            'unsettled' => $open()->where('order_settled', 0)->whereRaw('(courier_quote + courier_vat) > 0')->count(),
            'unsettled_amount' => (float) $open()->where('order_settled', 0)->sum(DB::raw('courier_quote + courier_vat')),
        ];

        $monthStats = function (Carbon $from, Carbon $to) {
            return OrderModel::whereBetween('created_at', [$from, $to])->where('status', '<>', 'cancelled')->toBase()
                ->selectRaw('COUNT(*) as orders, COALESCE(SUM(total),0) as revenue, COALESCE(SUM(comission + service_fee + over_head),0) as profit')
                ->first();
        };
        $now = Carbon::now();
        $thisMonth = $monthStats($now->copy()->startOfMonth(), $now->copy()->endOfMonth());
        // Compare like-for-like: the same number of days into last month.
        $lastMonthStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $lastMonthToDate = $monthStats($lastMonthStart, $lastMonthStart->copy()->addDays($now->day - 1)->endOfDay()->min($lastMonthStart->copy()->endOfMonth()));

        $oldestPending = OrderModel::where('status', 'pending')->orderBy('id')->limit(6)->get();
        $recent = OrderModel::orderBy('id', 'DESC')->limit(8)->get();
        $meta = OrderMetaModel::whereIn('order_id', $oldestPending->pluck('id')->merge($recent->pluck('id')))
            ->whereIn('key', ['sender_name', 'sender_state', 'reciever_state'])
            ->get()->groupBy('order_id')->map(fn ($rows) => $rows->pluck('value', 'key'));

        return view('admin.home', [
            'queues' => $queues,
            'thisMonth' => $thisMonth,
            'lastMonthToDate' => $lastMonthToDate,
            'oldestPending' => $oldestPending,
            'recent' => $recent,
            'meta' => $meta,
            'couriers' => CourierModel::pluck('name', 'id'),
            'leads' => FormModel::orderBy('id', 'DESC')->limit(5)->get(),
            'leadsThisMonth' => FormModel::where('created_at', '>=', $now->copy()->startOfMonth())->count(),
            'customersCount' => CustomerModel::count(),
        ]);
    }
}
