@php
    $st = $customer->effectiveStatus();
    [$cls, $label] = match ($st) {
        'suspended' => ['adm-pill-warning', 'Suspended'],
        'banned' => ['adm-pill-danger', 'Banned'],
        'disabled' => ['adm-pill-neutral', 'Disabled'],
        default => ['adm-pill-success', 'Active'],
    };
@endphp
<span class="adm-pill {{ $cls }}" @if($customer->status_reason && $st !== 'active') title="Reason: {{ $customer->status_reason }}" @endif>{{ $label }}@if($st === 'suspended' && $customer->suspended_until) until {{ $customer->suspended_until->format('d M') }}@endif</span>
