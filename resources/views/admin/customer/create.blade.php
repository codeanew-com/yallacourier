@extends('admin.layouts.master')
@section('title', 'New customer')
@section('content')
@include('admin.partials.page-header', [
    'title' => 'New customer account',
    'subtitle' => 'Customers can no longer sign up on the website, so accounts are created here.',
    'crumbs' => ['Customers' => route('admin.view.customer'), 'New' => null],
])
@include('admin.partials.form-errors')
<form method="post" action="{{ route('admin.customer.store') }}" autocomplete="off">
    @csrf
    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="adm-section-title">Contact details</div>
                    <div class="row">
                        @foreach([
                            ['name', 'Full name', 'text', 'required maxlength="255" autofocus'],
                            ['email', 'Email address', 'email', 'required maxlength="255"'],
                            ['phone', 'Phone', 'tel', 'maxlength="30" placeholder="+971 50 123 4567"'],
                            ['company_name', 'Company', 'text', 'maxlength="255"'],
                            ['designation', 'Designation / role', 'text', 'maxlength="255"'],
                        ] as [$key, $label, $type, $attrs])
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="f-{{ $key }}">{{ $label }}@if(str_contains($attrs, 'required')) <span class="text-danger" aria-hidden="true">*</span>@endif</label>
                                <input type="{{ $type }}" id="f-{{ $key }}" name="{{ $key }}" value="{{ old($key) }}" class="form-control @error($key) is-invalid @enderror" {!! $attrs !!}>
                                @error($key)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($key === 'email')<div class="form-text">The customer signs in with this address. It must not belong to another account.</div>@endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="adm-section-title">Password</div>
                    @foreach([
                        'invite' => ['Email a link to set their password', 'Recommended. The customer chooses their own password. The link is valid for 3 days.'],
                        'temporary' => ['Generate a temporary password', 'Shown to you once, to pass on securely. The customer must change it when they first sign in.'],
                    ] as $val => [$label, $help])
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="onboarding" id="onb-{{ $val }}" value="{{ $val }}" @checked(old('onboarding', 'invite') === $val)>
                            <label class="form-check-label" for="onb-{{ $val }}"><strong>{{ $label }}</strong><span class="d-block small text-muted">{{ $help }}</span></label>
                        </div>
                    @endforeach
                    <div class="adm-section-title">Initial status</div>
                    @include('admin.partials.radio-group', ['name' => 'account_status', 'label' => 'Account status', 'options' => ['active' => 'Active, can sign in', 'disabled' => 'Disabled for now'], 'value' => old('account_status', 'active')])
                    <p class="small text-muted mb-0">You’ll be recorded as the creator, and the action is added to the customer’s activity log.</p>
                    <div class="adm-form-footer">
                        <a href="{{ route('admin.view.customer') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">Create account</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
