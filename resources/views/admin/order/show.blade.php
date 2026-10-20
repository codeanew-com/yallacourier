@extends('admin.layouts.master')
@section('title', 'Order #'.$o->id)
@section('content')
@php
    $v = fn ($key) => $meta[$key] ?? '';
    $payable = (float) $o->courier_quote + (float) $o->courier_vat;

    // What should the admin do next? Ordered by how the shipment workflow runs.
    $nextStep = match (true) {
        $o->status === 'cancelled' => ['This order is cancelled. No further action is needed.', true],
        !$courier => ['Choose a courier for this shipment, then enter the courier\'s price as the subtotal.', false],
        (float) $o->subtotal <= 0 => ['Enter the subtotal (the courier price charged to the customer). The total, courier quote and commission are calculated for you.', false],
        $o->status === 'pending' => ['Book it with '.$courier->name.', then set the status to Processing.', false],
        $o->payment_status != 1 => ['Set Customer payment to Paid once you have received the payment.', false],
        $o->order_settled == 0 && $payable > 0 && in_array($o->status, ['completed', 'delivered'], true) => ['Courier payment of AED '.number_format($payable, 2).' is still outstanding. Settle it from the Orders list once paid.', false],
        default => ['Everything is up to date for this order.', true],
    };
@endphp

@include('admin.partials.page-header', [
    'title' => 'Order #'.$o->id,
    'crumbs' => ['Orders' => route('admin.order.index'), '#'.$o->id => null],
    'subtitle' => 'Created '.e($o->created_at->format('d M Y, H:i')).' ('.e($o->created_at->diffForHumans()).') · '
        .($isIntl ? 'International shipment' : 'Domestic (UAE) shipment')
        .($customer ? ' · Customer account: <a href="'.e(route('admin.single.customer', $customer->id)).'">'.e($customer->name).'</a>' : ' · Guest booking'),
    'actions' => '<a class="btn btn-light" href="'.e(route('admin.sendemails', $o->id)).'" data-confirm="Send the order confirmation and invoice emails to the sender and receiver again?"><i class="bx bx-envelope me-1"></i>Resend emails</a>'
        .'<button type="submit" form="orderForm" class="btn btn-primary"><i class="bx bx-save me-1"></i>Save changes</button>',
])

<div class="adm-next-step mb-3 {{ $nextStep[1] ? 'done' : '' }}" role="status">
    <i class="bx {{ $nextStep[1] ? 'bx-check-circle text-success' : 'bx-bulb text-warning' }}" aria-hidden="true"></i>
    <div><strong>{{ $nextStep[1] ? 'All set' : 'Next step' }}:</strong> {{ $nextStep[0] }}</div>
</div>

@if($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0 ps-3">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif

<form method="post" action="{{ route('admin.order.update', $o->id) }}" id="orderForm">
@csrf
<div class="row g-3">
    {{-- ============ Left: shipment details ============ --}}
    <div class="col-xl-8">
        <div class="row g-3">
            <div class="col-lg-6">
                <div class="card h-100 mb-0">
                    <div class="card-header d-flex align-items-center gap-2"><i class="bx bx-upload text-primary"></i><h5>Sender</h5></div>
                    <div class="card-body">
                        <div class="row">
                            @include('admin.order.partials.field', ['key' => 'sender_name', 'label' => 'Name', 'value' => $v('sender_name'), 'col' => 'col-12', 'attrs' => 'autocomplete="off"'])
                            @include('admin.order.partials.field', ['key' => 'sender_phone', 'label' => 'Phone', 'value' => $v('sender_phone'), 'type' => 'tel'])
                            @include('admin.order.partials.field', ['key' => 'sender_email', 'label' => 'Email', 'value' => $v('sender_email'), 'type' => 'email'])
                            @include('admin.order.partials.field', ['key' => 'sender_country', 'label' => 'Country', 'value' => $v('sender_country'), 'attrs' => 'data-country'])
                            @include('admin.order.partials.field', ['key' => 'sender_state', 'label' => 'Emirate / State', 'value' => $v('sender_state')])
                            @include('admin.order.partials.field', ['key' => 'sender_city', 'label' => 'City', 'value' => $v('sender_city')])
                            @include('admin.order.partials.field', ['key' => 'sender_area', 'label' => 'Area', 'value' => $v('sender_area')])
                            @include('admin.order.partials.field', ['key' => 'sender_address', 'label' => 'Pickup address', 'value' => $v('sender_address'), 'col' => 'col-12'])
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 mb-0">
                    <div class="card-header d-flex align-items-center gap-2"><i class="bx bx-download text-success"></i><h5>Receiver</h5></div>
                    <div class="card-body">
                        <div class="row">
                            @include('admin.order.partials.field', ['key' => 'reciever_name', 'label' => 'Name', 'value' => $v('reciever_name'), 'col' => 'col-12', 'attrs' => 'autocomplete="off"'])
                            @include('admin.order.partials.field', ['key' => 'reciever_phone', 'label' => 'Phone', 'value' => $v('reciever_phone'), 'type' => 'tel'])
                            @include('admin.order.partials.field', ['key' => 'reciever_email', 'label' => 'Email', 'value' => $v('reciever_email'), 'type' => 'email'])
                            @include('admin.order.partials.field', ['key' => 'reciever_country', 'label' => 'Country', 'value' => $v('reciever_country'), 'attrs' => 'data-country'])
                            @include('admin.order.partials.field', ['key' => 'reciever_state', 'label' => 'Emirate / State', 'value' => $v('reciever_state')])
                            @include('admin.order.partials.field', ['key' => 'reciever_city', 'label' => 'City', 'value' => $v('reciever_city')])
                            @include('admin.order.partials.field', ['key' => 'reciever_area', 'label' => 'Area', 'value' => $v('reciever_area')])
                            @include('admin.order.partials.field', ['key' => 'searchdeladd', 'label' => 'Delivery address', 'value' => $v('searchdeladd'), 'col' => 'col-12'])
                            @include('admin.order.partials.field', ['key' => 'delivery_type', 'label' => 'Delivery type', 'value' => $v('delivery_type'), 'col' => 'col-12'])
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card mb-0">
                    <div class="card-header d-flex align-items-center gap-2"><i class="bx bx-box text-primary"></i><h5>Contents &amp; packages</h5></div>
                    <div class="card-body">
                        <div class="row">
                            @include('admin.order.partials.field', ['key' => 'box_contents', 'label' => 'Contents of shipment', 'value' => $v('box_contents'), 'col' => 'col-md-8'])
                            <div class="col-md-4 mb-3">
                                <label class="form-label" for="f-declared_value">Declared value</label>
                                <div class="input-group">
                                    <span class="input-group-text">AED</span>
                                    <input type="number" step="0.01" min="0" inputmode="decimal" id="f-declared_value" name="declared_value" value="{{ old('declared_value', $v('declared_value')) }}" class="form-control @error('declared_value') is-invalid @enderror">
                                </div>
                                @error('declared_value')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        @if($dimensions->isEmpty())
                            <p class="text-muted mb-0">No package dimensions were recorded for this order.</p>
                        @else
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" id="packagesTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Qty</th>
                                        <th>Length (cm)</th>
                                        <th>Width (cm)</th>
                                        <th>Height (cm)</th>
                                        <th>Weight / piece (kg)</th>
                                        <th class="text-end">Line weight</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dimensions as $i => $dim)
                                    <tr>
                                        <td class="text-muted">{{ $i + 1 }}<input type="hidden" name="dimension_id[]" value="{{ $dim->id }}"></td>
                                        @foreach(['qty' => 1, 'length' => 0, 'width' => 0, 'height' => 0, 'weight' => 0] as $f => $min)
                                        <td style="min-width:90px;">
                                            <input type="number" step="1" min="{{ $min }}" inputmode="numeric" class="form-control form-control-sm dim-{{ $f }} @error('dimension_'.$f.'.'.$i) is-invalid @enderror"
                                                   name="dimension_{{ $f }}[]" value="{{ old('dimension_'.$f.'.'.$i, $dim->$f) }}" aria-label="Package {{ $i + 1 }} {{ $f }}">
                                        </td>
                                        @endforeach
                                        <td class="text-end text-nowrap line-weight"></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" class="text-end fw-semibold">Total: <span id="pkgPieces"></span> piece(s)</th>
                                        <th class="text-end fw-semibold text-nowrap"><span id="pkgWeight"></span> kg</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="form-text">Sizes and weights are stored as whole numbers.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card mb-0">
                    <div class="card-header d-flex align-items-center gap-2"><i class="bx bx-map-pin text-primary"></i><h5>Tracking &amp; labels</h5></div>
                    <div class="card-body">
                        @if($packages->isEmpty())
                            <p class="text-muted mb-0">No AWB has been generated for this order yet. Book it with the courier and the tracking number and label will appear here.</p>
                        @else
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead><tr><th>AWB / tracking</th><th>Status</th><th class="text-end">Label</th></tr></thead>
                                    <tbody>
                                    @foreach($packages as $package)
                                        <tr>
                                            <td class="fw-semibold">{{ $package->awb_number }}</td>
                                            <td><span class="adm-pill adm-pill-info">{{ $package->awb_status }}</span></td>
                                            <td class="text-end"><a href="{{ route('order.package.label', $package->id) }}" target="_blank" rel="noopener" class="btn btn-sm btn-light"><i class="bx bx-download me-1"></i>Download</a></td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============ Right: workflow + money ============ --}}
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header"><h5>Workflow</h5></div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="f-status">Order status</label>
                    <select class="form-select @error('status') is-invalid @enderror" id="f-status" name="status">
                        @foreach($statuses as $st)
                            <option value="{{ $st }}" @selected(old('status', $o->status) == $st)>{{ ucfirst($st) }}</option>
                        @endforeach
                    </select>
                    @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <label class="form-label" for="f-courier">Courier</label>
                    <select class="form-select @error('courier') is-invalid @enderror" id="f-courier" name="courier">
                        <option value="0" @selected(old('courier', $o->courier) == 0)>— Not assigned —</option>
                        @foreach($couriers as $c)
                            <option value="{{ $c->id }}" @selected(old('courier', $o->courier) == $c->id)>{{ $c->name }}{{ $c->status ? '' : ' (inactive)' }}</option>
                        @endforeach
                    </select>
                    @error('courier')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text" id="courierHint"></div>
                </div>
                <div class="mb-0">
                    <label class="form-label" for="f-payment">Customer payment</label>
                    <select class="form-select" id="f-payment" name="payment_status">
                        <option value="0" @selected(old('payment_status', $o->payment_status) != 1)>Unpaid</option>
                        <option value="1" @selected(old('payment_status', $o->payment_status) == 1)>Paid</option>
                    </select>
                    <div class="form-text">Set this once you've received payment (cash or otherwise). Online payment is no longer collected.</div>
                    @if($o->payment_intent)
                        <div class="form-text">Online payment reference ({{ $o->payment_from ?: 'Stripe' }}): <code>{{ $o->payment_intent }}</code></div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center"><h5>Pricing</h5><span class="small text-muted">AED</span></div>
            <div class="card-body">
                <div class="adm-section-title">Charged to the customer</div>
                <div class="mb-3">
                    <label class="form-label" for="f-subtotal">Subtotal</label>
                    <input type="number" step="0.01" min="0" inputmode="decimal" class="form-control money @error('subtotal') is-invalid @enderror" id="f-subtotal" name="subtotal" value="{{ old('subtotal', $o->subtotal) }}" required>
                    @error('subtotal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">The courier price including Yalla Courier's commission.</div>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="f-vat">VAT</label>
                        <span class="small"><button type="button" class="adm-link-btn" data-fill="vat" data-mode="commission">{{ \App\Services\Orders\OrderPricing::VAT_RATE }}% of commission</button> · <button type="button" class="adm-link-btn" data-fill="vat" data-mode="zero">None</button></span>
                    </div>
                    <input type="number" step="0.01" min="0" inputmode="decimal" class="form-control money @error('vat') is-invalid @enderror" id="f-vat" name="vat" value="{{ old('vat', $o->vat) }}" required>
                    @error('vat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="f-service_fee">Service fee</label>
                        <button type="button" class="adm-link-btn" id="useDefaultFee" hidden>Use courier default</button>
                    </div>
                    <input type="number" step="0.01" min="0" inputmode="decimal" class="form-control money @error('service_fee') is-invalid @enderror" id="f-service_fee" name="service_fee" value="{{ old('service_fee', $o->service_fee) }}" required>
                    @error('service_fee')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-1">
                    <label class="form-label" for="f-total">Total payable <span class="adm-auto-badge">Auto</span></label>
                    <input type="text" class="form-control form-control-lg adm-computed" id="f-total" value="{{ number_format($o->total, 2, '.', '') }}" readonly aria-describedby="totalHelp" tabindex="-1">
                    <div class="form-text" id="totalHelp">Subtotal + VAT + service fee, rounded to 2 decimals. Recalculated on the server when you save.</div>
                </div>

                <div class="adm-section-title">Courier side (internal)</div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label mb-0" for="f-courier_quote">Courier quote</label>
                        <div class="form-check form-switch mb-0 small">
                            <input class="form-check-input" type="checkbox" role="switch" id="quoteSame" name="quote_same_as_subtotal" value="1" @checked(old('_token') ? old('quote_same_as_subtotal') : $quoteSameAsSubtotal)>
                            <label class="form-check-label" for="quoteSame">Same as subtotal</label>
                        </div>
                    </div>
                    <input type="number" step="0.01" min="0" inputmode="decimal" class="form-control money mt-1 @error('courier_quote') is-invalid @enderror" id="f-courier_quote" name="courier_quote" value="{{ old('courier_quote', $o->courier_quote) }}">
                    @error('courier_quote')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label" for="f-courier_vat">Courier VAT</label>
                        <span class="small"><button type="button" class="adm-link-btn" data-fill="courier_vat" data-mode="quote">{{ \App\Services\Orders\OrderPricing::VAT_RATE }}% of quote</button> · <button type="button" class="adm-link-btn" data-fill="courier_vat" data-mode="vat">Same as VAT</button> · <button type="button" class="adm-link-btn" data-fill="courier_vat" data-mode="zero">None</button></span>
                    </div>
                    <input type="number" step="0.01" min="0" inputmode="decimal" class="form-control money @error('courier_vat') is-invalid @enderror" id="f-courier_vat" name="courier_vat" value="{{ old('courier_vat', $o->courier_vat) }}" required>
                    @error('courier_vat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="form-label mb-0" for="f-comission">Commission <span class="adm-auto-badge" id="commissionAutoBadge">Auto</span></label>
                        <div class="form-check form-switch mb-0 small">
                            <input class="form-check-input" type="checkbox" role="switch" id="commissionAuto" @checked(old('commission_mode', $commissionAuto ? 'auto' : 'manual') === 'auto')>
                            <label class="form-check-label" for="commissionAuto">From courier rate</label>
                        </div>
                    </div>
                    <input type="hidden" name="commission_mode" id="commissionMode" value="{{ old('commission_mode', $commissionAuto ? 'auto' : 'manual') }}">
                    <input type="number" step="0.01" min="0" inputmode="decimal" class="form-control money mt-1 @error('comission') is-invalid @enderror" id="f-comission" name="comission" value="{{ old('comission', $o->comission) }}">
                    @error('comission')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="d-flex flex-wrap gap-3 mt-1 small" id="commissionBasisWrap">
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="radio" name="commission_basis" id="basisParcel" value="parcel" @checked(old('commission_basis', $isDocument ? 'document' : 'parcel') === 'parcel')>
                            <label class="form-check-label" for="basisParcel">Parcel rate</label>
                        </div>
                        <div class="form-check mb-0">
                            <input class="form-check-input" type="radio" name="commission_basis" id="basisDocument" value="document" @checked(old('commission_basis', $isDocument ? 'document' : 'parcel') === 'document')>
                            <label class="form-check-label" for="basisDocument">Document rate</label>
                        </div>
                    </div>
                    <div class="form-text" id="commissionHelp"></div>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="f-over_head">Overhead</label>
                    <input type="number" step="0.01" min="0" inputmode="decimal" class="form-control money @error('over_head') is-invalid @enderror" id="f-over_head" name="over_head" value="{{ old('over_head', $o->over_head) }}" required>
                    @error('over_head')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="adm-section-title">Summary</div>
                <div class="adm-summary-row"><span>Customer pays</span><span class="adm-summary-value" id="sumTotal"></span></div>
                <div class="adm-summary-row"><span>Owed to courier <small class="text-muted">(quote + courier VAT)</small></span><span class="adm-summary-value" id="sumPayable"></span></div>
                <div class="adm-summary-row"><span>Profit <small class="text-muted">(commission + fee + overhead)</small></span><span class="adm-summary-value text-success" id="sumProfit"></span></div>
                <div class="adm-summary-row">
                    <span>Courier settlement</span>
                    <span>
                        @if($o->order_settled > 0)
                            <span class="adm-pill adm-pill-success">Paid AED {{ number_format($o->order_settled, 2) }}</span>
                        @else
                            <span class="adm-pill adm-pill-neutral">Not settled</span>
                        @endif
                    </span>
                </div>
                <div class="form-text">Courier payments are settled in bulk from the <a href="{{ route('admin.order.index', ['settled' => 'no']) }}">Orders list</a>.</div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5>Activity</h5></div>
            <div class="card-body">
                @if($activity->isEmpty())
                    <p class="text-muted small mb-0">No admin changes recorded yet. Every save from now on is logged here.</p>
                @else
                    <ul class="adm-timeline">
                        @foreach($activity as $log)
                            <li>
                                <div>{{ \Illuminate\Support\Str::after($log->mess, ': ') }}</div>
                                <div class="adm-time">{{ $admins[$log->added_by] ?? ($log->added_by ? 'Admin' : 'System') }} · {{ $log->created_at?->format('d M Y, H:i') }}</div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="card mt-3">
    <div class="card-body py-0">
        <div class="adm-form-footer mt-0">
            <span class="me-auto align-self-center small text-muted" id="dirtyNote" hidden><i class="bx bx-info-circle"></i> You have unsaved changes.</span>
            <a href="{{ route('admin.order.index') }}" class="btn btn-light">Back to orders</a>
            <button type="submit" class="btn btn-primary"><i class="bx bx-save me-1"></i>Save changes</button>
        </div>
    </div>
</div>
</form>

@include('admin.order.partials.pricing-script')
@endsection
