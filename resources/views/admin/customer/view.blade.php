@extends('admin.layouts.master')
@section('title', $c->name)
@section('content')
@php
    $status = $c->effectiveStatus();
    $tabs = [
        'overview' => ['Overview', null],
        'orders' => ['Orders', $orders->count()],
        'payments' => ['Payments & invoices', $finance['outstanding_count'] ?: null],
        'addresses' => ['Addresses', $pickupAddresses->count() + $recipients->count()],
        'wallet' => ['Wallet', $topups->count() + $transactions->count()],
        'activity' => ['Activity', $activity->count()],
    ];
    $actions = '';
    if (auth()->user()->can('update', $c)) {
        $actions .= '<a href="'.e(route('admin.customer.edit', $c->id)).'" class="btn btn-light"><i class="bx bx-edit-alt me-1"></i>Edit details</a>';
    }
    $actions .= '<a href="mailto:'.e($c->email).'" class="btn btn-light"><i class="bx bx-envelope me-1"></i>Email</a>';
@endphp
@include('admin.partials.page-header', [
    'title' => e($c->name),
    'subtitle' => '#'.$c->id.' · '.e($c->email).($c->company_name ? ' · '.e($c->company_name) : ''),
    'crumbs' => ['Customers' => route('admin.view.customer'), $c->name => null],
    'actions' => $actions.'<span class="d-inline-flex">'.view('admin.customer.partials.access-actions', ['customer' => $c, 'size' => ''])->render().'</span>',
])

@if($status !== 'active')
    <div class="alert {{ $status === 'banned' ? 'alert-danger' : 'alert-warning' }} adm-flash" role="status">
        <i class="bx bx-block" aria-hidden="true"></i>
        <div>
            <strong>Access {{ $status }}</strong>
            @if($status === 'suspended') {{ $c->suspended_until ? 'until '.$c->suspended_until->format('d M Y, H:i').' ('.$c->suspended_until->diffForHumans().')' : 'until reactivated' }} @endif
            · since {{ optional($c->status_changed_at)->format('d M Y, H:i') ?? '—' }}{{ $c->status_changed_by && isset($admins[$c->status_changed_by]) ? ' by '.$admins[$c->status_changed_by] : '' }}
            <div class="mt-1"><span class="text-muted">Reason:</span> {{ $c->status_reason ?: 'No reason recorded.' }}</div>
            <div class="small mt-1">The customer cannot log in and any open session is ended on their next request.</div>
        </div>
    </div>
@elseif($c->account_status === 'suspended' && $c->suspended_until)
    <div class="alert alert-info adm-flash" role="status"><i class="bx bx-time" aria-hidden="true"></i><div>A suspension ended on {{ $c->suspended_until->format('d M Y, H:i') }}; the customer can log in again.</div></div>
@endif

<div class="row g-3 mb-3">
    @foreach([
        ['Orders', number_format($orders->count()), $orders->whereIn('status', ['pending', 'processing'])->count().' open'],
        ['Total billed', 'AED '.number_format($finance['billed'], 2), 'Excluding cancelled orders'],
        ['Outstanding', 'AED '.number_format($finance['outstanding'], 2), $finance['outstanding_count'].' unpaid order(s)'],
        ['Wallet balance', 'AED '.number_format((float) $c->balance, 2), $topups->count().' top-up(s)'],
    ] as [$label, $value, $note])
        <div class="col-6 col-xl-3"><div class="card adm-kpi mb-0 {{ $label === 'Outstanding' && $finance['outstanding'] > 0 ? 'border-warning' : '' }}"><div class="adm-kpi-label">{{ $label }}</div><div class="adm-kpi-value">{{ $value }}</div><div class="adm-kpi-note">{{ $note }}</div></div></div>
    @endforeach
</div>

<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs" role="tablist">
            @foreach($tabs as $key => [$label, $count])
                <li class="nav-item" role="presentation">
                    <a class="nav-link {{ $tab === $key ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-{{ $key }}" role="tab" aria-controls="tab-{{ $key }}" aria-selected="{{ $tab === $key ? 'true' : 'false' }}" data-tab="{{ $key }}">
                        {{ $label }}@if($count) <span class="badge bg-light text-dark">{{ $count }}</span>@endif
                    </a>
                </li>
            @endforeach
        </ul>
        <div class="tab-content pt-3">
            {{-- Overview --}}
            <div class="tab-pane {{ $tab === 'overview' ? 'active show' : '' }}" id="tab-overview" role="tabpanel">
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="adm-section-title">Profile</div>
                        <dl class="row mb-0">
                            @foreach([
                                'Full name' => $c->name,
                                'Email' => $c->email,
                                'Phone' => $c->phone,
                                'Company' => $c->company_name,
                                'Designation' => $c->designation,
                                'Customer ID' => '#'.$c->id,
                            ] as $label => $value)
                                <dt class="col-sm-4 text-muted fw-medium mb-2">{{ $label }}</dt>
                                <dd class="col-sm-8 mb-2">{{ $value ?: '—' }}</dd>
                            @endforeach
                        </dl>
                    </div>
                    <div class="col-lg-6">
                        <div class="adm-section-title">Account</div>
                        <dl class="row mb-0">
                            <dt class="col-sm-4 text-muted fw-medium mb-2">Status</dt>
                            <dd class="col-sm-8 mb-2">@include('admin.customer.partials.status-pill', ['customer' => $c])</dd>
                            <dt class="col-sm-4 text-muted fw-medium mb-2">Registered</dt>
                            <dd class="col-sm-8 mb-2">{{ $c->created_at ? $c->created_at->format('d M Y, H:i').' ('.$c->created_at->diffForHumans().')' : '—' }}</dd>
                            <dt class="col-sm-4 text-muted fw-medium mb-2">Last login</dt>
                            <dd class="col-sm-8 mb-2">{{ $c->last_login_at ? $c->last_login_at->format('d M Y, H:i').' ('.$c->last_login_at->diffForHumans().')' : 'Not recorded yet' }}@if($c->last_login_ip)<div class="small text-muted">from {{ $c->last_login_ip }}</div>@endif</dd>
                            <dt class="col-sm-4 text-muted fw-medium mb-2">Email verified</dt>
                            <dd class="col-sm-8 mb-2">{{ $c->email_verified_at ? $c->email_verified_at->format('d M Y') : 'No' }}</dd>
                            <dt class="col-sm-4 text-muted fw-medium mb-2">Last updated</dt>
                            <dd class="col-sm-8 mb-2">{{ optional($c->updated_at)->format('d M Y, H:i') ?? '—' }}</dd>
                        </dl>
                        <div class="adm-section-title">Password &amp; sign-in</div>
                        <dl class="row mb-2">
                            <dt class="col-sm-4 text-muted fw-medium mb-2">Password</dt>
                            <dd class="col-sm-8 mb-2">
                                @if($c->must_change_password)
                                    <span class="adm-pill adm-pill-warning">Temporary: must change at next login</span>
                                @elseif($c->password_changed_at)
                                    Set by customer {{ $c->password_changed_at->diffForHumans() }}
                                @elseif($c->created_by)
                                    <span class="adm-pill adm-pill-neutral">Not set yet (setup link pending)</span>
                                @else
                                    Set at registration
                                @endif
                            </dd>
                            <dt class="col-sm-4 text-muted fw-medium mb-2">Created</dt>
                            <dd class="col-sm-8 mb-2">{{ $c->created_by ? 'By '.($creator ?? 'an admin').' on '.optional($c->created_at)->format('d M Y') : 'Self-registered on the website (before registration closed)' }}</dd>
                        </dl>
                        <div class="d-flex flex-wrap gap-2">
                            @can('resetPassword', $c)
                                <form method="post" action="{{ route('admin.customer.password.link', $c->id) }}" data-confirm="Email a password reset link to {{ $c->email }}?">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light"><i class="bx bx-mail-send me-1"></i>Send password reset link</button>
                                </form>
                                <form method="post" action="{{ route('admin.customer.password.temporary', $c->id) }}" data-confirm="Replace {{ $c->name }}'s password with a temporary one? Their current password stops working and they are signed out everywhere.">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light"><i class="bx bx-key me-1"></i>Issue temporary password</button>
                                </form>
                            @endcan
                            @can('manageAccess', $c)
                                <form method="post" action="{{ route('admin.customer.sessions.revoke', $c->id) }}"
                                      data-confirm="Sign {{ $c->name }} out of every device? They can log in again straight away (the account stays active).">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-light"><i class="bx bx-log-out-circle me-1"></i>Sign out of all devices</button>
                                </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>

            {{-- Orders --}}
            <div class="tab-pane {{ $tab === 'orders' ? 'active show' : '' }}" id="tab-orders" role="tabpanel">
                @if($orders->isEmpty())
                    <div class="adm-empty"><i class="bx bx-package"></i>This customer hasn’t placed any orders yet.</div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead><tr><th>Order</th><th>Receiver</th><th>Route</th><th>Courier</th><th>Status</th><th>Payment</th><th class="text-end">Total</th><th></th></tr></thead>
                        <tbody>
                        @foreach($orders as $s)
                            @php $m = $meta[$s->id] ?? collect(); @endphp
                            <tr>
                                <td><a href="{{ route('admin.view.order', $s->id) }}" class="fw-semibold">#{{ $s->id }}</a><div class="small text-muted">{{ $s->created_at->format('d M Y') }}</div></td>
                                <td>{{ $m['reciever_name'] ?? '—' }}</td>
                                <td>{{ $m['sender_state'] ?? '—' }} → {{ $m['reciever_state'] ?? '—' }}</td>
                                <td>{{ $couriers[$s->courier] ?? 'Unassigned' }}</td>
                                <td>@include('admin.order.partials.status-pill', ['status' => $s->status])</td>
                                <td>@if($s->payment_status == 1)<span class="adm-pill adm-pill-success">Paid</span>@else<span class="adm-pill adm-pill-neutral">Unpaid</span>@endif</td>
                                <td class="text-end text-nowrap">{{ $s->total > 0 ? 'AED '.number_format($s->total, 2) : '—' }}</td>
                                <td class="text-end"><a href="{{ route('admin.view.order', $s->id) }}" class="btn btn-sm btn-light">Open</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            {{-- Payments & invoices --}}
            <div class="tab-pane {{ $tab === 'payments' ? 'active show' : '' }}" id="tab-payments" role="tabpanel">
                <div class="row g-3 mb-3">
                    <div class="col-md-4"><div class="adm-summary-row"><span>Billed</span><span class="adm-summary-value">AED {{ number_format($finance['billed'], 2) }}</span></div></div>
                    <div class="col-md-4"><div class="adm-summary-row"><span>Paid</span><span class="adm-summary-value text-success">AED {{ number_format($finance['paid'], 2) }}</span></div></div>
                    <div class="col-md-4"><div class="adm-summary-row"><span>Outstanding</span><span class="adm-summary-value {{ $finance['outstanding'] > 0 ? 'text-danger' : '' }}">AED {{ number_format($finance['outstanding'], 2) }}</span></div></div>
                </div>
                @php $priced = $orders->filter(fn ($o) => $o->total > 0); @endphp
                @if($priced->isEmpty())
                    <div class="adm-empty"><i class="bx bx-receipt"></i>No priced orders yet, so there are no invoices.</div>
                @else
                <p class="small text-muted">Each priced order is invoiced to the customer by email (resend it from the order page).</p>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Invoice / order</th><th>Date</th><th class="text-end">Subtotal</th><th class="text-end">VAT</th><th class="text-end">Service fee</th><th class="text-end">Total</th><th>Payment</th><th>Paid via</th></tr></thead>
                        <tbody>
                        @foreach($priced as $s)
                            <tr class="{{ $s->status === 'cancelled' ? 'text-muted' : '' }}">
                                <td><a href="{{ route('admin.view.order', $s->id) }}">#{{ $s->id }}</a>@if($s->status === 'cancelled') <span class="adm-pill adm-pill-danger">Cancelled</span>@endif</td>
                                <td class="small text-nowrap">{{ $s->created_at->format('d M Y') }}</td>
                                <td class="text-end">{{ number_format($s->subtotal, 2) }}</td>
                                <td class="text-end">{{ number_format($s->vat, 2) }}</td>
                                <td class="text-end">{{ number_format($s->service_fee, 2) }}</td>
                                <td class="text-end fw-semibold text-nowrap">AED {{ number_format($s->total, 2) }}</td>
                                <td>@if($s->payment_status == 1)<span class="adm-pill adm-pill-success">Paid</span>@elseif($s->status === 'cancelled')<span class="text-muted">—</span>@else<span class="adm-pill adm-pill-warning">Outstanding</span>@endif</td>
                                <td class="small">{{ $s->payment_from ?: ($s->payment_status == 1 ? 'Recorded by admin' : '—') }}@if($s->payment_intent)<div class="text-muted"><code>{{ \Illuminate\Support\Str::limit($s->payment_intent, 18) }}</code></div>@endif</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            {{-- Addresses --}}
            <div class="tab-pane {{ $tab === 'addresses' ? 'active show' : '' }}" id="tab-addresses" role="tabpanel">
                <p class="small text-muted">Collected from this customer’s orders, most recently used first.</p>
                <div class="row g-4">
                    <div class="col-lg-6">
                        <div class="adm-section-title">Pickup addresses</div>
                        @forelse($pickupAddresses as $a)
                            <div class="adm-summary-row"><span>{{ $a['address'] }}</span><span class="small text-muted text-nowrap ms-3">last used <a href="{{ route('admin.view.order', $a['order']) }}">#{{ $a['order'] }}</a></span></div>
                        @empty
                            <p class="text-muted small">None yet.</p>
                        @endforelse
                    </div>
                    <div class="col-lg-6">
                        <div class="adm-section-title">Recipients</div>
                        @forelse($recipients as $r)
                            <div class="adm-summary-row">
                                <span><strong>{{ $r['name'] ?: 'Unnamed' }}</strong>{{ $r['phone'] ? ' · '.$r['phone'] : '' }}<br><span class="small">{{ $r['address'] }}</span></span>
                                <span class="small text-muted text-nowrap ms-3"><a href="{{ route('admin.view.order', $r['order']) }}">#{{ $r['order'] }}</a></span>
                            </div>
                        @empty
                            <p class="text-muted small">None yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Wallet --}}
            <div class="tab-pane {{ $tab === 'wallet' ? 'active show' : '' }}" id="tab-wallet" role="tabpanel">
                <div class="adm-summary-row mb-3"><span>Current wallet balance</span><span class="adm-summary-value">AED {{ number_format((float) $c->balance, 2) }}</span></div>
                <div class="row g-4">
                    <div class="col-xl-5">
                        <div class="adm-section-title">Top-ups</div>
                        @if($topups->isEmpty())
                            <p class="text-muted small">No wallet top-ups.</p>
                        @else
                        <table class="table align-middle mb-0">
                            <thead><tr><th>Date</th><th class="text-end">Amount</th><th>Reference</th></tr></thead>
                            <tbody>
                            @foreach($topups as $topup)
                                <tr><td class="small">{{ $topup->created_at->format('d M Y, H:i') }}</td><td class="text-end">AED {{ number_format((float) $topup->amount, 2) }}</td><td><code class="small">{{ \Illuminate\Support\Str::limit($topup->payment_intent, 20) }}</code></td></tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                    <div class="col-xl-7">
                        <div class="adm-section-title">Transactions</div>
                        @if($transactions->isEmpty())
                            <p class="text-muted small">No wallet transactions.</p>
                        @else
                        <table class="table align-middle mb-0">
                            <thead><tr><th>Date</th><th>Type</th><th class="text-end">Amount</th><th>Reference</th></tr></thead>
                            <tbody>
                            @foreach($transactions as $t)
                                <tr>
                                    <td class="small">{{ $t->created_at->format('d M Y, H:i') }}</td>
                                    <td>@if($t->type==0)<span class="adm-pill adm-pill-danger">Debit</span>@else<span class="adm-pill adm-pill-success">Credit</span>@endif</td>
                                    <td class="text-end">AED {{ number_format((float) $t->amount, 2) }}</td>
                                    <td class="small">{{ $t->ref_point }}{{ $t->summary ? ' · '.\Illuminate\Support\Str::limit(strip_tags($t->summary), 60) : '' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Activity --}}
            <div class="tab-pane {{ $tab === 'activity' ? 'active show' : '' }}" id="tab-activity" role="tabpanel">
                @if($activity->isEmpty())
                    <div class="adm-empty"><i class="bx bx-history"></i>No admin actions recorded for this customer yet. Edits and access changes are logged here.</div>
                @else
                    <ul class="adm-timeline">
                        @foreach($activity as $log)
                            <li>
                                <div>{{ ucfirst(\Illuminate\Support\Str::after($log->mess, ': ')) }}</div>
                                <div class="adm-time">{{ $admins[$log->added_by] ?? 'Admin' }} · {{ $log->created_at?->format('d M Y, H:i') }}</div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
@include('admin.customer.partials.access-modal')
@push('scripts')
<script>
    // Keep the open tab in the URL so reloads and redirects (e.g. after an action) land on it.
    $('[data-tab]').on('shown.bs.tab', function () {
        var u = new URL(window.location.href);
        u.searchParams.set('tab', $(this).data('tab'));
        history.replaceState(null, '', u);
    });
</script>
@endpush
@endsection
