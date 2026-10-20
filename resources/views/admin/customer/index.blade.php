@extends('admin.layouts.master')
@section('title', 'Customers')
@section('content')
@php
    $tabs = ['' => 'All', 'active' => 'Active', 'suspended' => 'Suspended', 'banned' => 'Banned', 'disabled' => 'Disabled'];
    $url = fn (array $over) => route('admin.view.customer', array_filter(array_merge(['status' => $status, 'q' => $q, 'sort' => $sort === 'newest' ? null : $sort], $over), fn ($v) => $v !== null && $v !== ''));
@endphp
@include('admin.partials.page-header', [
    'title' => 'Customers',
    'subtitle' => number_format($counts['']).' customer accounts'.($counts['suspended'] + $counts['banned'] + $counts['disabled'] > 0 ? ' · '.number_format($counts['suspended'] + $counts['banned'] + $counts['disabled']).' with restricted access' : ''),
    'crumbs' => ['Customers' => null],
    'actions' => auth()->user()->can('create', \App\Models\CustomerModel::class)
        ? '<a href="'.e(route('admin.customer.create')).'" class="btn btn-primary"><i class="bx bx-user-plus me-1"></i>New customer</a>' : '',
])

<nav class="adm-tabs" aria-label="Filter by account status">
    @foreach($tabs as $key => $label)
        <a href="{{ $url(['status' => $key, 'page' => null]) }}" class="{{ $status === $key ? 'active' : '' }}" @if($status === $key) aria-current="page" @endif>{{ $label }}<span class="adm-count">{{ number_format($counts[$key]) }}</span></a>
    @endforeach
</nav>

<div class="card">
    <div class="card-body">
        <form method="get" action="{{ route('admin.view.customer') }}" class="adm-filterbar mb-3" role="search">
            @if($status)<input type="hidden" name="status" value="{{ $status }}">@endif
            <div class="adm-grow">
                <label class="form-label" for="f-q">Search</label>
                <input type="search" id="f-q" name="q" value="{{ $q }}" class="form-control" placeholder="Name, email, phone, company or #ID">
            </div>
            <div>
                <label class="form-label" for="f-sort">Sort by</label>
                <select id="f-sort" name="sort" class="form-select" onchange="this.form.submit()">
                    @foreach(['newest' => 'Newest first', 'oldest' => 'Oldest first', 'name' => 'Name A–Z', 'orders' => 'Most orders', 'spent' => 'Highest spend', 'last_login' => 'Last login'] as $k => $l)
                        <option value="{{ $k }}" @selected($sort === $k)>{{ $l }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bx bx-search me-1"></i>Search</button>
            @if($q !== '')<a href="{{ $url(['q' => null, 'page' => null]) }}" class="btn btn-light">Clear</a>@endif
        </form>

        @if($customers->isEmpty())
            <div class="adm-empty"><i class="bx bx-user"></i>{{ $q !== '' ? 'No customers match "'.$q.'".' : 'No customers in this list.' }}</div>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                <tr>
                    <th>Customer</th>
                    <th>Phone</th>
                    <th>Registered</th>
                    <th>Status</th>
                    <th class="text-end">Orders</th>
                    <th class="text-end">Order total</th>
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($customers as $c)
                    <tr>
                        <td>
                            <a href="{{ route('admin.single.customer', $c->id) }}" class="fw-semibold">{{ $c->name }}</a>
                            <div class="small text-muted">{{ $c->email }}{{ $c->company_name ? ' · '.$c->company_name : '' }}</div>
                        </td>
                        <td class="text-nowrap">{{ $c->phone ?: '—' }}</td>
                        <td class="small text-muted text-nowrap">{{ optional($c->created_at)->format('d M Y') ?? '—' }}</td>
                        <td>@include('admin.customer.partials.status-pill', ['customer' => $c])</td>
                        <td class="text-end">{{ number_format($c->orders_count) }}</td>
                        <td class="text-end text-nowrap">{{ $c->orders_total > 0 ? 'AED '.number_format($c->orders_total, 2) : '—' }}</td>
                        <td class="text-end text-nowrap">
                            <a href="{{ route('admin.single.customer', $c->id) }}" class="btn btn-sm btn-light"><i class="bx bx-show me-1"></i>View</a>
                            @can('update', $c)
                                <a href="{{ route('admin.customer.edit', $c->id) }}" class="btn btn-sm btn-light"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                            @endcan
                            @include('admin.customer.partials.access-actions', ['customer' => $c])
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="adm-table-footer">
            <div>Showing {{ $customers->firstItem() }}–{{ $customers->lastItem() }} of {{ number_format($customers->total()) }}</div>
            {{ $customers->onEachSide(1)->links() }}
        </div>
        @endif
    </div>
</div>
@include('admin.customer.partials.access-modal')
@endsection
