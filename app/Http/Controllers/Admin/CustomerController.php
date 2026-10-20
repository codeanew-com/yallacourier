<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChangeCustomerStatusRequest;
use App\Http\Requests\Admin\StoreCustomerRequest;
use App\Http\Requests\Admin\UpdateCustomerRequest;
use App\Models\CourierModel;
use App\Models\CustomerModel;
use App\Models\CustomerTopupModel;
use App\Models\LogModel;
use App\Models\OrderMetaModel;
use App\Models\OrderModel;
use App\Models\TransactionModel;
use App\Models\User;
use App\Services\Customers\CustomerAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

/**
 * Customer accounts in the admin panel. Every action is authorised by
 * App\Policies\CustomerPolicy (in the controller, or in the Form Request).
 */
class CustomerController extends Controller
{
    public function __construct(private CustomerAccountService $accounts) {}

    public function index(Request $request)
    {
        $this->authorize('viewAny', CustomerModel::class);

        $status = in_array($request->input('status'), CustomerModel::STATUSES, true) ? $request->input('status') : '';
        $q = trim((string) $request->input('q', ''));

        $query = CustomerModel::query();
        if ($status !== '') {
            $query->withStatus($status);
        }
        if ($q !== '') {
            $like = '%'.str_replace(['\\', '%', '_'], ['\\\\', '\%', '\_'], ltrim($q, '#')).'%';
            $query->where(function ($w) use ($like, $q) {
                if (ctype_digit(ltrim($q, '#'))) {
                    $w->orWhere('id', (int) ltrim($q, '#'));
                }
                foreach (['name', 'email', 'phone', 'company_name'] as $col) {
                    $w->orWhere($col, 'like', $like);
                }
            });
        }

        $sort = in_array($request->input('sort'), ['newest', 'oldest', 'name', 'orders', 'spent', 'last_login'], true) ? $request->input('sort') : 'newest';
        // Order totals come from one grouped subquery, not one query per row.
        $stats = OrderModel::where('customer_id', '>', 0)
            ->selectRaw('customer_id, COUNT(*) as orders_count, COALESCE(SUM(CASE WHEN status <> "cancelled" THEN total ELSE 0 END),0) as orders_total')
            ->groupBy('customer_id');
        $query->leftJoinSub($stats, 'os', 'os.customer_id', '=', 'customers.id')
            ->select('customers.*', DB::raw('COALESCE(os.orders_count,0) as orders_count'), DB::raw('COALESCE(os.orders_total,0) as orders_total'));
        match ($sort) {
            'oldest' => $query->orderBy('customers.id'),
            'name' => $query->orderBy('customers.name'),
            'orders' => $query->orderByDesc('orders_count'),
            'spent' => $query->orderByDesc('orders_total'),
            'last_login' => $query->orderByRaw('customers.last_login_at IS NULL, customers.last_login_at DESC'),
            default => $query->orderByDesc('customers.id'),
        };

        $counts = ['' => CustomerModel::count()];
        foreach (CustomerModel::STATUSES as $st) {
            $counts[$st] = CustomerModel::withStatus($st)->count();
        }

        return view('admin.customer.index', [
            'customers' => $query->paginate(25)->withQueryString(),
            'status' => $status,
            'q' => $q,
            'sort' => $sort,
            'counts' => $counts,
        ]);
    }

    public function show(Request $request, int $id)
    {
        $c = CustomerModel::findOrFail($id);
        $this->authorize('view', $c);

        $orders = OrderModel::where('customer_id', $c->id)->orderBy('id', 'DESC')->get();
        $meta = OrderMetaModel::whereIn('order_id', $orders->pluck('id'))
            ->whereIn('key', ['reciever_name', 'sender_state', 'reciever_state', 'sender_address', 'sender_city', 'sender_area', 'sender_country', 'searchdeladd', 'reciever_city', 'reciever_country', 'reciever_phone'])
            ->get()->groupBy('order_id')->map(fn ($rows) => $rows->pluck('value', 'key'));

        // Addresses this customer has used, derived from their orders (most recent first, de-duplicated).
        $pickupAddresses = collect();
        $recipients = collect();
        foreach ($orders as $o) {
            $m = $meta[$o->id] ?? collect();
            $pickup = trim(implode(', ', array_filter([$m['sender_address'] ?? null, $m['sender_city'] ?? null, $m['sender_state'] ?? null, $m['sender_country'] ?? null])));
            if ($pickup !== '' && ! $pickupAddresses->has(strtolower($pickup))) {
                $pickupAddresses[strtolower($pickup)] = ['address' => $pickup, 'last_used' => $o->created_at, 'order' => $o->id];
            }
            $to = trim(implode(', ', array_filter([$m['searchdeladd'] ?? null, $m['reciever_city'] ?? null, $m['reciever_state'] ?? null, $m['reciever_country'] ?? null])));
            $key = strtolower(($m['reciever_name'] ?? '').'|'.$to);
            if ($to !== '' && ! $recipients->has($key)) {
                $recipients[$key] = ['name' => $m['reciever_name'] ?? '', 'phone' => $m['reciever_phone'] ?? '', 'address' => $to, 'last_used' => $o->created_at, 'order' => $o->id];
            }
        }

        $live = $orders->where('status', '<>', 'cancelled');
        $activity = LogModel::where('mess', 'like', 'Customer #'.$c->id.':%')->orderBy('id', 'DESC')->limit(50)->get();

        return view('admin.customer.view', [
            'c' => $c,
            'orders' => $orders,
            'meta' => $meta,
            'finance' => [
                'billed' => $live->sum('total'),
                'paid' => $live->where('payment_status', 1)->sum('total'),
                'outstanding' => $live->where('payment_status', '<>', 1)->sum('total'),
                'outstanding_count' => $live->where('payment_status', '<>', 1)->where('total', '>', 0)->count(),
            ],
            'pickupAddresses' => $pickupAddresses->values(),
            'recipients' => $recipients->values()->take(20),
            'topups' => CustomerTopupModel::where('customer_id', $c->id)->orderBy('id', 'DESC')->get(),
            'transactions' => TransactionModel::where('customer_id', $c->id)->orderBy('id', 'DESC')->get(),
            'couriers' => CourierModel::pluck('name', 'id'),
            'activity' => $activity,
            'admins' => User::whereIn('id', $activity->pluck('added_by')->push($c->status_changed_by)->filter())->pluck('name', 'id'),
            'creator' => $c->created_by ? User::whereKey($c->created_by)->value('name') : null,
            'tab' => in_array($request->input('tab'), ['overview', 'orders', 'payments', 'addresses', 'wallet', 'activity'], true) ? $request->input('tab') : 'overview',
        ]);
    }

    public function create()
    {
        $this->authorize('create', CustomerModel::class);

        return view('admin.customer.create');
    }

    /** Create an account; the customer either gets a setup link (default) or a one-time temporary password. */
    public function store(StoreCustomerRequest $request)
    {
        [$c, $temporary] = $this->accounts->create($request->only(['name', 'email', 'phone', 'company_name', 'designation', 'account_status', 'onboarding']));

        if ($temporary) {
            return $this->showTemporaryPassword($c, $temporary, true);
        }

        [$ok, $msg] = $this->accounts->sendPasswordLink($c, 'setup');
        Session::flash('msg', 'Account created for '.$c->name.'. '.$msg);
        Session::flash('class', $ok ? 'alert-success' : 'alert-warning');

        return redirect()->route('admin.single.customer', $c->id);
    }

    public function sendPasswordReset(int $id)
    {
        $c = CustomerModel::findOrFail($id);
        $this->authorize('resetPassword', $c);

        [$ok, $msg] = $this->accounts->sendResetOrSetupLink($c);
        Session::flash('msg', $msg);
        Session::flash('class', $ok ? 'alert-success' : 'alert-warning');

        return redirect()->back();
    }

    public function temporaryPassword(int $id)
    {
        $c = CustomerModel::findOrFail($id);
        $this->authorize('resetPassword', $c);

        return $this->showTemporaryPassword($c, $this->accounts->issueTemporaryPassword($c), false);
    }

    public function edit(int $id)
    {
        $c = CustomerModel::findOrFail($id);
        $this->authorize('update', $c);

        return view('admin.customer.edit', ['c' => $c]);
    }

    public function update(UpdateCustomerRequest $request)
    {
        $c = $request->customer();

        if (! $this->accounts->updateProfile($c, $request->all())) {
            Session::flash('msg', 'No changes to save.');
            Session::flash('class', 'alert-info');

            return redirect()->route('admin.single.customer', $c->id);
        }

        Session::flash('msg', 'Customer details saved.');
        Session::flash('class', 'alert-success');

        return redirect()->route('admin.single.customer', $c->id);
    }

    /** Suspend / ban / disable / reactivate. Blocking also ends every active session. */
    public function changeStatus(ChangeCustomerStatusRequest $request)
    {
        $c = $request->customer();
        $action = $request->action;

        $ended = $this->accounts->changeStatus(
            $c,
            $action,
            $request->reason,
            $request->filled('suspended_until') ? $request->date('suspended_until') : null,
        );

        $msg = match ($action) {
            'suspend' => $c->name.' is suspended'.($c->suspended_until ? ' until '.$c->suspended_until->format('d M Y, H:i') : ' until reactivated').'.',
            'ban' => $c->name.' is banned.',
            'disable' => $c->name.'\'s account is disabled.',
            'reactivate' => $c->name.' can log in again.',
        };
        if ($action !== 'reactivate') {
            $msg .= ' They were signed out of '.$ended.' active session(s) and cannot log in. Orders and payment history are kept.';
        }
        Session::flash('msg', $msg);
        Session::flash('class', 'alert-success');

        return redirect()->back();
    }

    public function revokeSessions(int $id)
    {
        $c = CustomerModel::findOrFail($id);
        $this->authorize('manageAccess', $c);

        $ended = $this->accounts->revokeSessions($c);
        Session::flash('msg', $c->name.' was signed out of '.$ended.' active session(s).');
        Session::flash('class', 'alert-success');

        return redirect()->back();
    }

    /**
     * Rendered directly (not via redirect + flash) so the plain password is
     * never written to the session store; the page itself is not cached.
     */
    private function showTemporaryPassword(CustomerModel $c, string $password, bool $isNew)
    {
        return response()
            ->view('admin.customer.temporary-password', ['c' => $c, 'password' => $password, 'isNew' => $isNew])
            ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->header('Pragma', 'no-cache');
    }
}
