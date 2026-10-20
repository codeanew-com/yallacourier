@extends('admin.layouts.master')
@section('title', 'Edit '.$c->name)
@section('content')
@include('admin.partials.page-header', [
    'title' => 'Edit customer: '.e($c->name),
    'subtitle' => 'Changes are recorded in the customer’s activity log.',
    'crumbs' => ['Customers' => route('admin.view.customer'), $c->name => route('admin.single.customer', $c->id), 'Edit' => null],
])
@include('admin.partials.form-errors')
<form method="post" action="{{ route('admin.customer.update', $c->id) }}">
    @csrf
    @method('PATCH')
    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="adm-section-title">Contact details</div>
                    <div class="row">
                        @foreach([
                            ['name', 'Full name', 'text', 'col-md-6', 'required maxlength="255" autocomplete="off"'],
                            ['email', 'Email address', 'email', 'col-md-6', 'required maxlength="255" autocomplete="off"'],
                            ['phone', 'Phone', 'tel', 'col-md-6', 'maxlength="30" placeholder="+971 50 123 4567"'],
                        ] as [$key, $label, $type, $col, $attrs])
                            <div class="{{ $col }} mb-3">
                                <label class="form-label" for="f-{{ $key }}">{{ $label }}</label>
                                <input type="{{ $type }}" id="f-{{ $key }}" name="{{ $key }}" value="{{ old($key, $c->$key) }}" class="form-control @error($key) is-invalid @enderror" {!! $attrs !!}>
                                @error($key)<div class="invalid-feedback">{{ $message }}</div>@enderror
                                @if($key === 'email')<div class="form-text">Must be unique. Changing it resets email verification; the customer logs in with the new address.</div>@endif
                            </div>
                        @endforeach
                    </div>
                    <div class="adm-section-title">Business</div>
                    <div class="row">
                        @foreach([['company_name', 'Company'], ['designation', 'Designation / role']] as [$key, $label])
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="f-{{ $key }}">{{ $label }}</label>
                                <input type="text" id="f-{{ $key }}" name="{{ $key }}" value="{{ old($key, $c->$key) }}" maxlength="255" class="form-control @error($key) is-invalid @enderror">
                                @error($key)<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        @endforeach
                    </div>
                    <div class="adm-form-footer">
                        <a href="{{ route('admin.single.customer', $c->id) }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card mb-0">
                <div class="card-body small">
                    <div class="adm-section-title">Not editable here</div>
                    <p class="mb-2"><strong>Password:</strong> never shown or set by admins. The customer manages it.</p>
                    <p class="mb-2"><strong>Wallet balance (AED {{ number_format((float) $c->balance, 2) }}):</strong> changes only through wallet transactions, so the financial history stays consistent.</p>
                    <p class="mb-0"><strong>Account access:</strong> use Suspend / ban or Reactivate on the customer’s profile.</p>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
