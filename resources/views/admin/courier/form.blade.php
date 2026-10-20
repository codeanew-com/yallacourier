@extends('admin.layouts.master')
@section('title', $courier ? 'Edit courier' : 'New courier')
@section('content')
@php
    $val = fn ($key, $default = 0) => old($key, $courier ? $courier->$key : $default);
    $num = function ($key, $label, $suffix, $help = null) use ($val) {
        return compact('key', 'label', 'suffix', 'help') + ['value' => $val($key)];
    };
    $groups = [
        'Domestic (within the UAE)' => [
            'rates' => [
                $num('comission', 'Commission: parcels', '%', 'Markup on the courier\'s price'),
                $num('comission_document', 'Commission: documents', '%'),
                $num('service_fee', 'Service fee', 'AED', 'Added to the customer total'),
                $num('over_head', 'Overhead', 'kg'),
            ],
            'days' => [$num('normal_days', 'Delivery time', 'days'), $num('non_normal_days', 'Extra days (after cut-off)', 'days')],
            'prefix' => '',
        ],
        'International' => [
            'rates' => [
                $num('comission_intl', 'Commission: parcels', '%'),
                $num('comission_document_intl', 'Commission: documents', '%'),
                $num('service_fee_intl', 'Service fee', 'AED'),
                $num('over_head_intl', 'Overhead', 'kg'),
            ],
            'days' => [$num('normal_days_intl', 'Delivery time', 'days'), $num('non_normal_days_intl', 'Extra days (after cut-off)', 'days'), $num('saudi_tax', 'Saudi Arabia tax', '%')],
            'prefix' => '_intl',
        ],
    ];
@endphp
@include('admin.partials.page-header', [
    'title' => $courier ? 'Edit courier: '.e($courier->name) : 'New courier',
    'subtitle' => 'These rates pre-fill commission and service fee when an admin prices an order.',
    'crumbs' => ['Couriers & rates' => route('admin-couriers.index'), ($courier ? 'Edit' : 'New') => null],
])
@include('admin.partials.form-errors')

<form action="{{ $courier ? route('admin-couriers.update', $courier->id) : route('admin-couriers.store') }}" method="POST">
    @csrf
    @if($courier) @method('PATCH') @endif
    <div class="card">
        <div class="card-body">
            <div class="adm-section-title">General</div>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label class="form-label" for="f-name">Courier name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="f-name" name="name" value="{{ old('name', $courier->name ?? '') }}" required maxlength="255" autofocus>
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-6 col-md-2 mb-3">
                    <label class="form-label" for="f-start_time">Pickups from</label>
                    <input type="time" class="form-control @error('start_time') is-invalid @enderror" id="f-start_time" name="start_time" value="{{ old('start_time', $courier->start_time ?? '09:00') }}" required>
                    @error('start_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-sm-6 col-md-2 mb-3">
                    <label class="form-label" for="f-end_time">Cut-off time</label>
                    <input type="time" class="form-control @error('end_time') is-invalid @enderror" id="f-end_time" name="end_time" value="{{ old('end_time', $courier->end_time ?? '16:00') }}" required>
                    @error('end_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-4">
                    @include('admin.partials.radio-group', ['name' => 'status', 'label' => 'Status', 'options' => [1 => 'Active', 0 => 'Inactive'], 'value' => old('status', $courier->status ?? 1)])
                </div>
            </div>

            <div class="row g-4">
                @foreach($groups as $title => $g)
                <div class="col-xl-6">
                    <div class="adm-section-title">{{ $title }}</div>
                    <div class="row">
                        @foreach(array_merge($g['rates'], $g['days']) as $f)
                        <div class="col-sm-6 mb-3">
                            <label class="form-label" for="f-{{ $f['key'] }}">{{ $f['label'] }}</label>
                            <div class="input-group">
                                <input type="number" min="0" step="1" inputmode="numeric" class="form-control @error($f['key']) is-invalid @enderror" id="f-{{ $f['key'] }}" name="{{ $f['key'] }}" value="{{ $f['value'] }}" required>
                                <span class="input-group-text">{{ $f['suffix'] }}</span>
                            </div>
                            @error($f['key'])<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            @if($f['help'])<div class="form-text">{{ $f['help'] }}</div>@endif
                        </div>
                        @endforeach
                    </div>
                    <div class="adm-next-step done small" aria-live="polite">
                        <i class="bx bx-calculator text-success" aria-hidden="true"></i>
                        <div data-example="{{ $g['prefix'] }}"></div>
                    </div>
                </div>
                @endforeach
            </div>

            <div class="adm-form-footer">
                <a href="{{ route('admin-couriers.index') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-primary">{{ $courier ? 'Save changes' : 'Add courier' }}</button>
            </div>
        </div>
    </div>
</form>
@push('scripts')
<script>
// Worked example so the admin can see what a rate means before saving
// (same maths as App\Services\Orders\OrderPricing).
$(function () {
    function n(id) { var v = parseFloat($('#f-' + id).val()); return isNaN(v) ? 0 : v; }
    function r2(x) { return (Math.round(x * 100) / 100).toFixed(2); }
    function update() {
        $('[data-example]').each(function () {
            var p = $(this).data('example') || '';
            var rate = n(p === '_intl' ? 'comission_intl' : 'comission'), fee = n('service_fee' + p);
            var base = 100, subtotal = base * (1 + rate / 100);
            $(this).html('Example parcel: courier charges <strong>AED ' + r2(base) + '</strong> → subtotal <strong>AED ' + r2(subtotal) + '</strong>, '
                + 'commission <strong>AED ' + r2(subtotal * rate / (100 + rate)) + '</strong>, service fee <strong>AED ' + r2(fee) + '</strong> (VAT is entered per order).');
        });
    }
    $('form').on('input', 'input[type=number]', update);
    update();
});
</script>
@endpush
@endsection
