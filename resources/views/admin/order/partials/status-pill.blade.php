@php
    $pillClass = match ($status ?? 'pending') {
        'pending' => 'adm-pill-warning',
        'processing' => 'adm-pill-info',
        'completed' => 'adm-pill-success',
        'delivered' => 'adm-pill-teal',
        'cancelled' => 'adm-pill-danger',
        default => 'adm-pill-neutral',
    };
@endphp
<span class="adm-pill {{ $pillClass }}">{{ ucfirst($status ?: 'pending') }}</span>
