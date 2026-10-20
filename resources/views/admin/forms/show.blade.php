@extends('admin.layouts.master')
@section('title', 'Lead: '.$lead->fullName())
@section('content')
@php
    $tel = preg_replace('/[^0-9+]/', '', (string) $lead->phone);
    $wa = ltrim($tel, '+');
    $fields = [
        'Name' => $lead->fullName(),
        'Position' => $lead->position,
        'Company' => $lead->company_name,
        'Parcels per month' => $lead->number_of_parcel,
        'Current delivery partner' => $lead->current_delivery_partner,
        'Reason for switching provider' => $lead->reason_for_switching_provider,
    ];
@endphp
@include('admin.partials.page-header', [
    'title' => e($lead->fullName()),
    'subtitle' => e($lead->subject()).' · received '.e(optional($lead->created_at)->format('d M Y, H:i')).' ('.e(optional($lead->created_at)->diffForHumans()).')',
    'crumbs' => ['Business leads' => $backUrl, '#'.$lead->id => null],
    'actions' => '<a href="'.e($backUrl).'" class="btn btn-light"><i class="bx bx-arrow-back me-1"></i>Back to leads</a>',
])

<div class="row g-3">
    <div class="col-xl-8">
        <div class="card mb-0">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Enquiry details</h5>
                @if($lead->archived_at)
                    <span class="adm-pill adm-pill-neutral">Archived {{ $lead->archived_at->format('d M Y') }}</span>
                @else
                    <span class="adm-pill adm-pill-success">Read {{ optional($lead->read_at)->diffForHumans() }}</span>
                @endif
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    @foreach($fields as $label => $value)
                        @continue($value === null || $value === '')
                        <dt class="col-sm-4 text-muted fw-medium mb-2">{{ $label }}</dt>
                        <dd class="col-sm-8 mb-2" style="white-space:pre-line;">{{ $value }}</dd>
                    @endforeach
                    <dt class="col-sm-4 text-muted fw-medium mb-2">Submitted</dt>
                    <dd class="col-sm-8 mb-2">{{ optional($lead->created_at)->format('l, d F Y \a\t H:i') }}</dd>
                    <dt class="col-sm-4 text-muted fw-medium mb-0">Lead ID</dt>
                    <dd class="col-sm-8 mb-0">#{{ $lead->id }}</dd>
                </dl>
            </div>
        </div>
    </div>
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header"><h5>Contact</h5></div>
            <div class="card-body">
                <div class="mb-2"><i class="bx bx-envelope text-muted me-2"></i><a href="mailto:{{ $lead->email }}?subject={{ rawurlencode('Yalla Courier for '.$lead->company_name) }}">{{ $lead->email }}</a></div>
                <div class="mb-3"><i class="bx bx-phone text-muted me-2"></i><a href="tel:{{ $tel }}">{{ $lead->phone }}</a></div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="mailto:{{ $lead->email }}?subject={{ rawurlencode('Yalla Courier for '.$lead->company_name) }}" class="btn btn-primary btn-sm"><i class="bx bx-envelope me-1"></i>Email</a>
                    <a href="tel:{{ $tel }}" class="btn btn-light btn-sm"><i class="bx bx-phone me-1"></i>Call</a>
                    @if(strlen($wa) >= 9)
                        <a href="https://wa.me/{{ $wa }}" target="_blank" rel="noopener" class="btn btn-light btn-sm"><i class="bx bxl-whatsapp me-1"></i>WhatsApp</a>
                    @endif
                    <button type="button" class="btn btn-light btn-sm" data-copy="{{ $lead->fullName() }} · {{ $lead->company_name }} · {{ $lead->email }} · {{ $lead->phone }}"><i class="bx bx-copy me-1"></i>Copy details</button>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header"><h5>Actions</h5></div>
            <div class="card-body d-grid gap-2">
                @if($lead->archived_at)
                    <form method="post" action="{{ route('admin.businessleads.restore', $lead->id) }}">@csrf<button class="btn btn-light w-100"><i class="bx bx-undo me-1"></i>Restore to inbox</button></form>
                @else
                    <form method="post" action="{{ route('admin.businessleads.archive', $lead->id) }}">@csrf<button class="btn btn-light w-100"><i class="bx bx-archive-in me-1"></i>Archive (handled)</button></form>
                    <form method="post" action="{{ route('admin.businessleads.unread', $lead->id) }}">@csrf<button class="btn btn-light w-100"><i class="bx bx-envelope me-1"></i>Mark as unread</button></form>
                @endif
                <form method="post" action="{{ route('admin.businessleads.destroy', $lead->id) }}" data-confirm="Permanently delete the lead from {{ $lead->fullName() }}? This cannot be undone.{{ $lead->archived_at ? '' : ' Archive it instead if you may need it later.' }}">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-outline-danger w-100"><i class="bx bx-trash-alt me-1"></i>Delete permanently</button>
                </form>
            </div>
        </div>
        <div class="d-flex justify-content-between">
            @if($newer)<a href="{{ route('admin.businessleads.show', $newer) }}" class="btn btn-sm btn-light"><i class="bx bx-chevron-left"></i> Newer</a>@else<span></span>@endif
            @if($older)<a href="{{ route('admin.businessleads.show', $older) }}" class="btn btn-sm btn-light">Older <i class="bx bx-chevron-right"></i></a>@endif
        </div>
    </div>
</div>
@push('scripts')
<script>
    $('[data-copy]').on('click', function () {
        var $b = $(this);
        navigator.clipboard && navigator.clipboard.writeText($b.data('copy')).then(function () {
            var html = $b.html();
            $b.text('Copied');
            setTimeout(function () { $b.html(html); }, 1500);
        });
    });
</script>
@endpush
@endsection
