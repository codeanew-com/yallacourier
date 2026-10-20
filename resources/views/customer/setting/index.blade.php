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
                <h1>Profile</h1>
            </div>
            @include('customer.add-shipment-modal.index')
        </div>
    </section>

    <div class="container">
        <div class="customer-shell">
            @include('customer.nav.index')

            <main class="customer-content">
                <div class="customer-card">
                    <h2>Profile details</h2>

                    @if(Session::has('profile_msg'))
                        <div class="customer-badge success" style="margin-bottom: var(--cd-space-3);">{{ Session::get('profile_msg') }}</div>
                    @endif
                    @if(Session::has('msg'))
                        <div class="customer-badge" style="background:#fdecea;color:#b42318;margin-bottom: var(--cd-space-3);">{{ Session::get('msg') }}</div>
                    @endif

                    <form class="cd-profile-form" action="{{ route('frontend.customer.setting.update') }}" method="POST">
                        @csrf
                        <div class="cd-profile-field">
                            <label for="cd-profile-name">Full name</label>
                            <input type="text" id="cd-profile-name" name="name" value="{{ old('name', Auth::guard('customers')->user()->name) }}" required maxlength="255">
                        </div>
                        <div class="cd-profile-field">
                            <label for="cd-profile-email">Email</label>
                            <input type="email" id="cd-profile-email" value="{{ Auth::guard('customers')->user()->email }}" disabled>
                        </div>
                        <div class="cd-profile-field">
                            <label for="cd-profile-company">Company name</label>
                            <input type="text" id="cd-profile-company" name="company_name" value="{{ old('company_name', Auth::guard('customers')->user()->company_name) }}" maxlength="255">
                        </div>
                        <div class="cd-profile-field">
                            <label for="cd-profile-designation">Designation</label>
                            <input type="text" id="cd-profile-designation" name="designation" value="{{ old('designation', Auth::guard('customers')->user()->designation) }}" maxlength="255">
                        </div>
                        <div class="cd-profile-field">
                            <label for="cd-profile-phone">Phone number</label>
                            <input type="tel" id="cd-profile-phone" name="phone" value="{{ old('phone', Auth::guard('customers')->user()->phone) }}" maxlength="30">
                        </div>
                        <div class="cd-profile-field cd-profile-field-submit">
                            <button type="submit" class="purple-theme-btn"><span>Save changes</span></button>
                        </div>
                    </form>
                </div>
            </main>
        </div>
    </div>
</div>
@endsection
