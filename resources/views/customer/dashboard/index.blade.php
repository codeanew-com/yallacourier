@extends('frontend.layouts.master');

@push('header_scripts')
<link rel="stylesheet" href="{{ asset('front_assets/css/customer-dashboard.css') }}">
@endpush

@section('content')
<div class="customer-area">

    <section class="customer-titlebar">
        <div class="container customer-titlebar-inner">
            <div class="customer-titlebar-branding">
                <img src="{{ asset('front_assets/images/header-logo.svg') }}" alt="Yalla Courier">
                <h1>Welcome {{ Auth::guard('customers')->user()->name }}!</h1>
            </div>
            @include('customer.add-shipment-modal.index')
        </div>
    </section>

    <div class="container">
        <div class="customer-shell">
            @include('customer.nav.index')

            <main class="customer-content">

                <div class="customer-stats">
                    <div class="customer-stat">
                        <div class="label">Today</div>
                        <div class="value">{{ \App\Models\OrderModel::where('customer_id',Auth::guard('customers')->user()->id)->whereDate('created_at',Date('Y-m-d'))->count() }}</div>
                    </div>
                    <div class="customer-stat">
                        <div class="label">Total shipments</div>
                        <div class="value">{{ \App\Models\OrderModel::where('customer_id',Auth::guard('customers')->user()->id)->count() }}</div>
                    </div>
                    <div class="customer-stat">
                        <div class="label">Topups</div>
                        <div class="value">AED {{ number_format(\App\Models\CustomerTopupModel::where('customer_id',Auth::guard('customers')->user()->id)->where('status',1)->sum('amount'),2) }}</div>
                    </div>
                    <div class="customer-stat">
                        <div class="label">Total spent</div>
                        <div class="value">AED {{ number_format(\App\Models\OrderModel::where('customer_id',Auth::guard('customers')->user()->id)->sum('total'),2) }}</div>
                    </div>
                </div>

                @php $recentShipments = \App\Models\OrderModel::where('customer_id',Auth::guard('customers')->user()->id)->latest()->take(5)->get(); @endphp
                <div class="customer-card">
                    <div class="d-flex align-items-center justify-content-between flex-wrap" style="gap:8px;">
                        <h2 class="m-0">Recent shipments</h2>
                        <a href="{{ route('frontend.customer.shipmentsetting.index') }}" style="font-size:0.85rem;font-weight:600;color:var(--cd-primary);">View all</a>
                    </div>

                    @if($recentShipments->isEmpty())
                        <div class="customer-empty">
                            <p class="m-0">You haven't booked a shipment yet.</p>
                        </div>
                    @else
                        <div class="customer-table-wrap">
                            <table class="customer-table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Shipper</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentShipments as $s)
                                    <tr>
                                        <td>#{{ $s->id }}</td>
                                        <td>@php $ss=\App\Models\OrderMetaModel::where('key','sender_name')->where('order_id',$s->id)->first(); if($ss) { echo $ss->value; } @endphp</td>
                                        <td>@php $ss=\App\Models\OrderMetaModel::where('key','sender_state')->where('order_id',$s->id)->first(); if($ss) { echo $ss->value; } @endphp</td>
                                        <td>@php $ss=\App\Models\OrderMetaModel::where('key','reciever_state')->where('order_id',$s->id)->first(); if($ss) { echo $ss->value; } @endphp</td>
                                        <td><span class="customer-badge {{ $s->status === 'pending' ? 'pending' : 'default' }}">{{ ucfirst($s->status ?? 'pending') }}</span></td>
                                        <td>{{ $s->created_at->diffForHumans() }}</td>
                                        <td><a href="{{ route('customer.view.order',$s->id) }}" class="purple-theme-btn" style="padding:6px 16px;font-size:0.85rem;"><span>View</span></a></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </main>
        </div>
    </div>
</div>
@endsection
