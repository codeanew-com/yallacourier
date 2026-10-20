@extends('admin.layouts.master')
@section('title', 'Orders')
@section('content')
@php
    $activeFilters = collect($filters)->except('status')->filter(fn ($v) => $v !== '' && $v !== null);
    $tabUrl = fn ($status) => route('admin.order.index', array_filter(array_merge($filters, ['status' => $status]), fn ($v) => $v !== '' && $v !== null));
    $totalAll = $statusCounts->sum();
@endphp

@include('admin.partials.page-header', [
    'title' => 'Orders',
    'subtitle' => number_format($stats->orders).' '.($stats->orders == 1 ? 'order' : 'orders').($activeFilters->isNotEmpty() || $filters['status'] ? ' match the current filters' : ' in total'),
])

{{-- Status tabs: the main way admins move through the queue --}}
<nav class="adm-tabs" aria-label="Filter by status">
    <a href="{{ $tabUrl('') }}" class="{{ $filters['status'] === '' ? 'active' : '' }}">All<span class="adm-count">{{ number_format($totalAll) }}</span></a>
    @foreach($statuses as $st)
        <a href="{{ $tabUrl($st) }}" class="{{ $filters['status'] === $st ? 'active' : '' }}" @if($filters['status'] === $st) aria-current="page" @endif>
            {{ ucfirst($st) }}<span class="adm-count">{{ number_format($statusCounts[$st] ?? 0) }}</span>
        </a>
    @endforeach
</nav>

<div class="card">
    <div class="card-body">
        <form method="get" action="{{ route('admin.order.index') }}" class="adm-filterbar" id="orderFilters">
            @if($filters['status'])<input type="hidden" name="status" value="{{ $filters['status'] }}">@endif
            <div class="adm-grow">
                <label class="form-label" for="f-q">Search</label>
                <input type="search" id="f-q" name="q" value="{{ $filters['q'] }}" class="form-control" placeholder="Order #, sender/receiver name, phone, email or AWB">
            </div>
            <div>
                <label class="form-label" for="f-courier">Courier</label>
                <select id="f-courier" name="courier" class="form-select">
                    <option value="">All couriers</option>
                    <option value="unassigned" @selected($filters['courier'] === 'unassigned')>Unassigned</option>
                    @foreach($couriers as $c)
                        <option value="{{ $c->id }}" @selected($filters['courier'] === (string) $c->id)>{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="form-label" for="f-payment">Customer payment</label>
                <select id="f-payment" name="payment" class="form-select">
                    <option value="">Any</option>
                    <option value="unpaid" @selected($filters['payment'] === 'unpaid')>Unpaid</option>
                    <option value="paid" @selected($filters['payment'] === 'paid')>Paid</option>
                </select>
            </div>
            <div>
                <label class="form-label" for="f-settled">Courier settlement</label>
                <select id="f-settled" name="settled" class="form-select">
                    <option value="">Any</option>
                    <option value="no" @selected($filters['settled'] === 'no')>Not settled</option>
                    <option value="yes" @selected($filters['settled'] === 'yes')>Settled</option>
                </select>
            </div>
            <div>
                <label class="form-label" for="f-from">From</label>
                <input type="date" id="f-from" name="s_date" value="{{ $filters['s_date'] }}" class="form-control">
            </div>
            <div>
                <label class="form-label" for="f-to">To</label>
                <input type="date" id="f-to" name="e_date" value="{{ $filters['e_date'] }}" class="form-control">
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="bx bx-filter-alt me-1"></i>Apply</button>
                @if($activeFilters->isNotEmpty())
                    <a href="{{ route('admin.order.index', array_filter(['status' => $filters['status']])) }}" class="btn btn-light">Clear</a>
                @endif
            </div>
        </form>
        <div class="d-flex flex-wrap gap-2 mt-2 small" aria-label="Date shortcuts">
            <span class="text-muted">Quick range:</span>
            <button type="button" class="adm-link-btn" data-range="today">Today</button>
            <button type="button" class="adm-link-btn" data-range="7d">Last 7 days</button>
            <button type="button" class="adm-link-btn" data-range="month">This month</button>
            <button type="button" class="adm-link-btn" data-range="lastmonth">Last month</button>
        </div>
    </div>
</div>

{{-- Finance summary for exactly what's filtered above --}}
<div class="row g-3 mb-3">
    <div class="col-6 col-xl">
        <div class="card adm-kpi mb-0"><div class="adm-kpi-label">Revenue</div><div class="adm-kpi-value">AED {{ number_format($stats->revenue, 2) }}</div><div class="adm-kpi-note">Sum of order totals</div></div>
    </div>
    <div class="col-6 col-xl">
        <div class="card adm-kpi mb-0"><div class="adm-kpi-label">Courier cost</div><div class="adm-kpi-value">AED {{ number_format($stats->courier_cost, 2) }}</div><div class="adm-kpi-note">Courier quote + courier VAT</div></div>
    </div>
    <div class="col-6 col-xl">
        <div class="card adm-kpi mb-0"><div class="adm-kpi-label">Profit</div><div class="adm-kpi-value">AED {{ number_format($stats->profit, 2) }}</div><div class="adm-kpi-note">Commission + service fee + overhead</div></div>
    </div>
    <div class="col-6 col-xl">
        <div class="card adm-kpi mb-0"><div class="adm-kpi-label">Paid to couriers</div><div class="adm-kpi-value">AED {{ number_format($stats->courier_paid, 2) }}</div><div class="adm-kpi-note">Settled courier payments</div></div>
    </div>
    <div class="col-12 col-xl">
        <div class="card adm-kpi mb-0 {{ $stats->courier_outstanding > 0 ? 'border-warning' : '' }}">
            <div class="adm-kpi-label">Owed to couriers</div>
            <div class="adm-kpi-value">AED {{ number_format($stats->courier_outstanding, 2) }}</div>
            @if($stats->unsettled_count > 0)
                <form method="post" action="{{ route('admin.settle.courier') }}" class="mt-1"
                      data-confirm="Mark {{ $stats->unsettled_count }} unsettled {{ $stats->unsettled_count == 1 ? 'order' : 'orders' }} in this view as paid to the courier (AED {{ number_format($stats->courier_outstanding, 2) }})?">
                    @csrf
                    <input type="hidden" name="apply_to" value="filtered">
                    @foreach($filters as $k => $v)
                        @if($v !== '')<input type="hidden" name="{{ $k }}" value="{{ $v }}">@endif
                    @endforeach
                    <button type="submit" class="btn btn-sm btn-warning">Settle all {{ number_format($stats->unsettled_count) }} in view</button>
                </form>
            @else
                <div class="adm-kpi-note">Nothing outstanding</div>
            @endif
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @if($orders->isEmpty())
            <div class="adm-empty">
                <i class="bx bx-package"></i>
                <p class="mb-2">No orders match these filters.</p>
                <a href="{{ route('admin.order.index') }}" class="btn btn-sm btn-light">Show all orders</a>
            </div>
        @else
        <form action="{{ route('admin.settle.courier') }}" method="post" id="settleCourierForm">
            @csrf
            {{-- Bulk actions appear above the table as soon as a row is selected, and stay pinned under the top bar while scrolling. --}}
            <div class="adm-bulkbar" id="bulkBar" role="region" aria-label="Bulk actions" aria-live="polite">
                <div><strong id="bulkCount">0</strong> selected · courier cost <strong>AED <span id="bulkAmount">0.00</span></strong></div>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-sm btn-outline-light" id="bulkClear">Clear selection</button>
                    <button type="submit" class="btn btn-sm btn-success" id="settleCourierBtn"><i class="bx bx-check-double me-1"></i>Mark as paid to courier</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                    <tr>
                        <th style="width:36px;"><input type="checkbox" id="selectAllOrders" class="form-check-input" aria-label="Select all unsettled orders on this page"></th>
                        <th>Order</th>
                        <th>Sender</th>
                        <th>Route</th>
                        <th>Courier</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th class="text-end">Total</th>
                        <th class="text-end">Courier payment</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $s)
                        @php
                            $m = $meta[$s->id] ?? collect();
                            $payable = (float) $s->courier_quote + (float) $s->courier_vat;
                            $canSettle = $s->order_settled == 0 && $s->status !== 'cancelled' && $payable > 0;
                            $courier = $couriers[$s->courier] ?? null;
                            $intl = !\App\Services\Orders\OrderPricing::isUae($m['reciever_country'] ?? null);
                        @endphp
                        <tr>
                            <td>
                                <input type="checkbox" name="order_id[]" class="form-check-input order-select-checkbox" value="{{ $s->id }}" data-payable="{{ $payable }}"
                                       aria-label="Select order {{ $s->id }}" @disabled(!$canSettle)
                                       @if(!$canSettle) title="{{ $s->order_settled > 0 ? 'Already settled' : ($s->status === 'cancelled' ? 'Cancelled order' : 'No courier cost entered yet') }}" @endif>
                            </td>
                            <td>
                                <a href="{{ route('admin.view.order', $s->id) }}" class="fw-semibold">#{{ $s->id }}</a>
                                <div class="small text-muted" title="{{ $s->created_at->format('d M Y, H:i') }}">{{ $s->created_at->format('d M Y') }}<br>{{ $s->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <div>{{ $m['sender_name'] ?? '—' }}</div>
                                @if(!empty($m['sender_phone']))<div class="small text-muted">{{ $m['sender_phone'] }}</div>@endif
                            </td>
                            <td>
                                {{ $m['sender_state'] ?? '—' }} <i class="bx bx-right-arrow-alt text-muted" aria-label="to"></i> {{ $m['reciever_state'] ?? '—' }}
                                @if($intl && !empty($m['reciever_country']))<span class="adm-pill adm-pill-info ms-1" title="International">{{ $m['reciever_country'] }}</span>@endif
                            </td>
                            <td>
                                @if($courier)
                                    {{ $courier->name }}
                                @else
                                    <span class="adm-pill adm-pill-warning">Unassigned</span>
                                @endif
                            </td>
                            <td>@include('admin.order.partials.status-pill', ['status' => $s->status])</td>
                            <td>
                                @if($s->payment_status == 1)
                                    <span class="adm-pill adm-pill-success">Paid</span>
                                @else
                                    <span class="adm-pill adm-pill-neutral">Unpaid</span>
                                @endif
                            </td>
                            <td class="text-end text-nowrap">
                                @if($s->total > 0) AED {{ number_format($s->total, 2) }} @else <span class="text-muted" title="Not priced yet">—</span> @endif
                            </td>
                            <td class="text-end text-nowrap">
                                @if($s->order_settled > 0)
                                    <span class="adm-pill adm-pill-success">AED {{ number_format($s->order_settled, 2) }}</span>
                                @elseif($payable > 0 && $s->status !== 'cancelled')
                                    <span class="adm-pill adm-pill-danger" title="Owed to the courier">Owed {{ number_format($payable, 2) }}</span>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.view.order', $s->id) }}" class="btn btn-sm btn-light">Open</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </form>

        <div class="adm-table-footer">
            <div>Showing {{ $orders->firstItem() }}–{{ $orders->lastItem() }} of {{ number_format($orders->total()) }}</div>
            {{ $orders->onEachSide(1)->links() }}
        </div>
        @endif
    </div>
</div>
@push('scripts')
<script>
    $(function () {
        var $boxes = $('.order-select-checkbox');
        function refresh() {
            var $checked = $boxes.filter(':checked'), sum = 0;
            $checked.each(function () { sum += parseFloat($(this).data('payable')) || 0; });
            $('#bulkCount').text($checked.length);
            $('#bulkAmount').text(sum.toFixed(2));
            $('#bulkBar').toggleClass('show', $checked.length > 0);
            var enabled = $boxes.not(':disabled');
            $('#selectAllOrders').prop('checked', enabled.length > 0 && $checked.length === enabled.length);
        }
        $('#selectAllOrders').on('change', function () {
            $boxes.not(':disabled').prop('checked', $(this).is(':checked'));
            refresh();
        });
        $boxes.on('change', refresh);
        $('#bulkClear').on('click', function () { $boxes.prop('checked', false); refresh(); });
        $('#settleCourierForm').on('submit', function (e) {
            var n = $boxes.filter(':checked').length;
            if (!n || !window.confirm('Mark ' + n + ' order(s) as paid to the courier (AED ' + $('#bulkAmount').text() + ')?')) {
                e.preventDefault();
                e.stopImmediatePropagation();
            }
        });

        // Quick date ranges fill the From/To inputs and apply immediately.
        function iso(d) { return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0'); }
        $('[data-range]').on('click', function () {
            var now = new Date(), from = new Date(now), to = new Date(now);
            switch ($(this).data('range')) {
                case '7d': from.setDate(now.getDate() - 6); break;
                case 'month': from = new Date(now.getFullYear(), now.getMonth(), 1); break;
                case 'lastmonth': from = new Date(now.getFullYear(), now.getMonth() - 1, 1); to = new Date(now.getFullYear(), now.getMonth(), 0); break;
            }
            $('#f-from').val(iso(from));
            $('#f-to').val(iso(to));
            $('#orderFilters').trigger('submit');
        });
    });
</script>
@endpush
@endsection
