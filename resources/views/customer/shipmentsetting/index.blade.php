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
                <h1>Welcome!</h1>
            </div>
            @include('customer.add-shipment-modal.index')
        </div>
    </section>

    <div class="container">
        <div class="customer-shell">
            @include('customer.nav.index')

            <main class="customer-content">

                @php $myShipments = \App\Models\OrderModel::where('customer_id',Auth::guard('customers')->user()->id)->latest()->get(); @endphp

                <div class="customer-card">
                    <h2>My shipments</h2>

                    @if($myShipments->isEmpty())
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
                                    @foreach($myShipments as $s)
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

                {{-- Shipment defaults removed (2026-10-18) — static form with no submit button, no action, and no backend to save these values; it did nothing. Rebuild fresh if/when this is actually needed.
                <div class="customer-card">
                    <h2>Shipment defaults</h2>
                    <form action="" class="form-wrapper">
                        <div class="row">
                            <div class="col-md-6 input-wrapper">
                                <label>Default unit of measurement</label>
                                <div class="form-check"><input type="radio" class="form-check-input" id="unit_metric" name="unit" value="metric"> <label for="unit_metric">Metric (kg / cm)</label></div>
                                <div class="form-check"><input type="radio" class="form-check-input" id="unit_imperial" name="unit" value="imperial"> <label for="unit_imperial">Imperial (lbs / in)</label></div>
                            </div>
                            <div class="col-md-6 input-wrapper">
                                <label>Reference 1</label>
                                <div class="form-check"><input type="checkbox" class="form-check-input" id="ref1_enabled" name="ref1_enabled"> <label for="ref1_enabled">Enabled</label></div>
                                <div class="form-check"><input type="checkbox" class="form-check-input" id="ref1_mandatory" name="ref1_mandatory"> <label for="ref1_mandatory">Mandatory</label></div>
                            </div>
                            <div class="col-md-6 input-wrapper">
                                <label>Reference 2</label>
                                <div class="form-check"><input type="checkbox" class="form-check-input" id="ref2_enabled" name="ref2_enabled"> <label for="ref2_enabled">Enabled</label></div>
                                <div class="form-check"><input type="checkbox" class="form-check-input" id="ref2_mandatory" name="ref2_mandatory"> <label for="ref2_mandatory">Mandatory</label></div>
                            </div>
                        </div>
                    </form>
                </div>
                --}}

            </main>
        </div>
    </div>
</div>
@endsection
