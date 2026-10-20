@extends('admin.layouts.master')
@section('title', 'Dashboard')
@section('content')
@php
    $trend = function ($now, $before) {
        if ($before <= 0) {
            return $now > 0 ? ['new', 'text-success'] : null;
        }
        $pct = round(($now - $before) / $before * 100);
        return [($pct >= 0 ? '+' : '').$pct.'% vs same point last month', $pct >= 0 ? 'text-success' : 'text-danger'];
    };
    $hour = (int) now()->format('G');
    $greeting = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');
@endphp

@include('admin.partials.page-header', [
    'title' => $greeting.', '.e(Auth::user()->name),
    'subtitle' => e(now()->format('l, d F Y')).' · Here is what needs your attention.',
    'actions' => '<a href="'.e(route('admin.order.index', ['status' => 'pending'])).'" class="btn btn-primary"><i class="bx bx-list-check me-1"></i>Work the pending queue</a>',
])

{{-- Work queues --}}
<div class="row g-3 mb-3">
    @foreach([
        ['Pending requests', $queues['pending'], 'New shipment requests to review', route('admin.order.index', ['status' => 'pending']), 'bx-time-five', 'warning'],
        ['No courier yet', $queues['unassigned'], 'Open orders without a courier', route('admin.order.index', ['courier' => 'unassigned']), 'bx-car', 'warning'],
        ['Awaiting payment', $queues['unpaid'], 'Priced orders not marked paid', route('admin.order.index', ['payment' => 'unpaid']), 'bx-credit-card', 'info'],
        ['Owed to couriers', 'AED '.number_format($queues['unsettled_amount'], 2), number_format($queues['unsettled']).' orders not settled', route('admin.order.index', ['settled' => 'no']), 'bx-transfer', 'danger'],
    ] as [$label, $value, $note, $url, $icon, $tone])
        <div class="col-sm-6 col-xl-3">
            <a href="{{ $url }}" class="adm-kpi-link">
                <div class="card adm-kpi mb-0">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="adm-kpi-label">{{ $label }}</div>
                        <span class="adm-pill adm-pill-{{ $tone }}" aria-hidden="true" style="padding:.3rem;"><i class="bx {{ $icon }}"></i></span>
                    </div>
                    <div class="adm-kpi-value">{{ is_numeric($value) ? number_format($value) : $value }}</div>
                    <div class="adm-kpi-note">{{ $note }} <i class="bx bx-right-arrow-alt"></i></div>
                </div>
            </a>
        </div>
    @endforeach
</div>

{{-- This month --}}
<div class="row g-3 mb-3">
    @foreach([
        ['Orders this month', number_format($thisMonth->orders), $trend($thisMonth->orders, $lastMonthToDate->orders)],
        ['Revenue this month', 'AED '.number_format($thisMonth->revenue, 2), $trend($thisMonth->revenue, $lastMonthToDate->revenue)],
        ['Profit this month', 'AED '.number_format($thisMonth->profit, 2), $trend($thisMonth->profit, $lastMonthToDate->profit)],
        ['Business leads this month', number_format($leadsThisMonth), [number_format($customersCount).' customer accounts in total', 'text-muted']],
    ] as [$label, $value, $t])
        <div class="col-sm-6 col-xl-3">
            <div class="card adm-kpi mb-0">
                <div class="adm-kpi-label">{{ $label }}</div>
                <div class="adm-kpi-value">{{ $value }}</div>
                <div class="adm-kpi-note {{ $t[1] ?? '' }}">{{ $t[0] ?? 'No orders in the same period last month' }}</div>
            </div>
        </div>
    @endforeach
</div>

<div class="row g-3">
    <div class="col-xl-6">
        <div class="card h-100 mb-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Oldest pending requests</h5>
                <a href="{{ route('admin.order.index', ['status' => 'pending']) }}" class="small">View all</a>
            </div>
            <div class="card-body p-0">
                @if($oldestPending->isEmpty())
                    <div class="adm-empty"><i class="bx bx-check-circle text-success"></i>No pending requests. Nice work.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <tbody>
                            @foreach($oldestPending as $o)
                                @php $m = $meta[$o->id] ?? collect(); @endphp
                                <tr>
                                    <td><a href="{{ route('admin.view.order', $o->id) }}" class="fw-semibold">#{{ $o->id }}</a></td>
                                    <td>{{ $m['sender_name'] ?? '—' }}<div class="small text-muted">{{ $m['sender_state'] ?? '—' }} → {{ $m['reciever_state'] ?? '—' }}</div></td>
                                    <td class="small {{ $o->created_at->lt(now()->subDay()) ? 'text-danger fw-semibold' : 'text-muted' }}">waiting {{ $o->created_at->diffForHumans(null, true) }}</td>
                                    <td class="text-end"><a href="{{ route('admin.view.order', $o->id) }}" class="btn btn-sm btn-primary">Process</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="col-xl-6">
        <div class="card h-100 mb-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Latest orders</h5>
                <a href="{{ route('admin.order.index') }}" class="small">All orders</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <tbody>
                        @forelse($recent as $o)
                            @php $m = $meta[$o->id] ?? collect(); @endphp
                            <tr>
                                <td><a href="{{ route('admin.view.order', $o->id) }}" class="fw-semibold">#{{ $o->id }}</a><div class="small text-muted">{{ $o->created_at->format('d M, H:i') }}</div></td>
                                <td>{{ $m['sender_name'] ?? '—' }}<div class="small text-muted">{{ $couriers[$o->courier] ?? 'No courier' }}</div></td>
                                <td>@include('admin.order.partials.status-pill', ['status' => $o->status])</td>
                                <td class="text-end text-nowrap">{{ $o->total > 0 ? 'AED '.number_format($o->total, 2) : '—' }}</td>
                            </tr>
                        @empty
                            <tr><td class="adm-empty">No orders yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Newest business leads</h5>
                <a href="{{ route('admin.businessleads') }}" class="small">All leads</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead><tr><th>Name</th><th>Company</th><th>Parcels</th><th>Contact</th><th>Received</th></tr></thead>
                        <tbody>
                        @forelse($leads as $lead)
                            <tr>
                                <td><a href="{{ route('admin.businessleads.show', $lead->id) }}" class="{{ $lead->read_at ? 'fw-medium' : 'fw-bold' }}">{{ $lead->first_name }} {{ $lead->last_name }}</a>@if(!$lead->read_at) <span class="adm-pill adm-pill-info ms-1">New</span>@endif<div class="small text-muted">{{ $lead->position }}</div></td>
                                <td>{{ $lead->company_name }}</td>
                                <td>{{ $lead->number_of_parcel }}</td>
                                <td class="small"><a href="mailto:{{ $lead->email }}">{{ $lead->email }}</a><br><a href="tel:{{ preg_replace('/[^0-9+]/', '', $lead->phone) }}">{{ $lead->phone }}</a></td>
                                <td class="small text-muted">{{ $lead->created_at && $lead->created_at->year > 1970 ? $lead->created_at->diffForHumans() : '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="adm-empty">No leads yet.</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
