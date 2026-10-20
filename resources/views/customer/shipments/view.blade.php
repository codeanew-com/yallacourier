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
                <h1>Shipment #{{ $o->id }}</h1>
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
                        <div class="label">ID</div>
                        <div class="value">#{{ $o->id }}</div>
                    </div>
                    <div class="customer-stat">
                        <div class="label">From</div>
                        <div class="value">@php $ss=\App\Models\OrderMetaModel::where('key','sender_state')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</div>
                    </div>
                    <div class="customer-stat">
                        <div class="label">To</div>
                        <div class="value">@php $ss=\App\Models\OrderMetaModel::where('key','reciever_state')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</div>
                    </div>
                    <div class="customer-stat">
                        <div class="label">Total</div>
                        <div class="value">AED {{ $o->total }}</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="customer-card">
                            <h2>Sender details</h2>
                            <div class="customer-table-wrap">
                                <table class="customer-table">
                                    <tbody>
                                        <tr><th>Name</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','sender_name')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Phone</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','sender_phone')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Country</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','sender_country')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>State</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','sender_state')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>City</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','sender_city')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Area</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','sender_area')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Address</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','sender_address')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Content of shipment</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','box_contents')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Declared value</th><td>AED @php $ss=\App\Models\OrderMetaModel::where('key','declared_value')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="customer-card">
                            <h2>Receiver details</h2>
                            <div class="customer-table-wrap">
                                <table class="customer-table">
                                    <tbody>
                                        <tr><th>Name</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','reciever_name')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Phone</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','reciever_phone')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Country</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','reciever_country')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>State</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','reciever_state')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>City</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','reciever_city')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Area</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','reciever_area')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Address</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','searchdeladd')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="customer-card">
                            <h2>Shipment details</h2>
                            <div class="customer-table-wrap">
                                <table class="customer-table">
                                    <tbody>
                                        <tr><th>Weight</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','shipment_weight')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Height</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','shipment_height')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Width</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','shipment_width')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Length</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','shipment_length')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                        <tr><th>Quantity</th><td>@php $ss=\App\Models\OrderMetaModel::where('key','shipment_qty')->where('order_id',$o->id)->first(); if($ss) { echo $ss->value; } @endphp</td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="customer-card">
                            <h2>Order status</h2>
                            <div class="customer-table-wrap">
                                <table class="customer-table">
                                    <tbody>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                @php $statusClass = $o->status === 'pending' ? 'pending' : ($o->status === 'delivered' || $o->status === 'completed' ? 'success' : 'default'); @endphp
                                                <span class="customer-badge {{ $statusClass }}">{{ ucfirst($o->status ?? 'pending') }}</span>
                                            </td>
                                        </tr>
                                        @if($o->payment_intent)
                                            <tr><th>Total</th><td>AED {{ $o->total }}</td></tr>
                                            <tr><th>Payment</th><td>@if($o->payment_status==1)<span class="customer-badge success">Paid</span>@endif</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div class="customer-card">
                            <h2>Tracking</h2>
                            @php $packages = \App\Models\OrderPackagesModel::where('order_id',$o->id)->get(); @endphp
                            @if($packages->isEmpty())
                                <div class="customer-empty"><p class="m-0">No tracking info yet — this is created once the courier confirms the booking.</p></div>
                            @else
                                <div class="customer-table-wrap">
                                    <table class="customer-table">
                                        <tbody>
                                            @foreach($packages as $package)
                                            <tr><th>AWB / Tracking</th><td>{{ $package->awb_number }}</td></tr>
                                            <tr><th>Status</th><td><span class="customer-badge success">{{ $package->awb_status }}</span></td></tr>
                                            <tr><th>Label</th><td><a href="{{ route('order.package.label', $package->id) }}" target="_blank" class="purple-theme-btn" style="padding:6px 16px;font-size:0.85rem;"><span>Download</span></a></td></tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="customer-card">
                            <h2>Order total</h2>
                            <div class="customer-table-wrap">
                                <table class="customer-table">
                                    <tbody>
                                        <tr><th>Subtotal</th><td>AED {{ $o->subtotal }}</td></tr>
                                        <tr><th>VAT</th><td>AED {{ $o->vat }}</td></tr>
                                        <tr><th>Total</th><td><strong>AED {{ $o->total }}</strong></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</div>
@endsection
