{{-- Single place that renders the Session::flash('msg'/'class') feedback every
     admin controller already sets, so individual views don't repeat it. --}}
@if(Session::has('msg'))
    @php
        $flashClass = Session::get('class', 'alert-info');
        $flashIcon = match (true) {
            str_contains($flashClass, 'success') => 'bx-check-circle',
            str_contains($flashClass, 'danger') => 'bx-error-circle',
            str_contains($flashClass, 'warning') => 'bx-error',
            default => 'bx-info-circle',
        };
    @endphp
    <div class="alert {{ $flashClass }} alert-dismissible fade show adm-flash" role="{{ str_contains($flashClass, 'danger') ? 'alert' : 'status' }}" @if(str_contains($flashClass, 'success')) data-autodismiss @endif>
        <i class="bx {{ $flashIcon }}" aria-hidden="true"></i>
        <div class="flex-grow-1">{{ Session::get('msg') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show adm-flash" role="status" data-autodismiss>
        <i class="bx bx-check-circle" aria-hidden="true"></i>
        <div class="flex-grow-1">{{ session('success') }}</div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
