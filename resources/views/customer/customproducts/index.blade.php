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
                <h1>Custom products</h1>
            </div>
            @include('customer.add-shipment-modal.index')
        </div>
    </section>

    <div class="container">
        <div class="customer-shell">
            @include('customer.nav.index')

            <main class="customer-content">

                <div class="customer-card">
                    <h2>Products</h2>
                    <div class="customer-empty">
                        <p class="m-0">No custom products saved yet.</p>
                    </div>
                </div>

                <div class="customer-card">
                    <h2>Reasons for export</h2>
                    <ul class="list-unstyled" id="my-list" style="margin:0;">
                        @foreach(['Gift','InterCompany Data','Other','Personal belongings','Return','Repair','Sale','Sample'] as $reason)
                            <li style="padding:8px 0;border-bottom:1px solid var(--cd-border);">{{ $reason }}</li>
                        @endforeach
                    </ul>
                </div>

            </main>
        </div>
    </div>
</div>
@endsection
