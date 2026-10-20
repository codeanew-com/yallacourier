@extends('admin.layouts.master')
@section('title', 'Temporary password')
@section('content')
@include('admin.partials.page-header', [
    'title' => $isNew ? 'Account created for '.e($c->name) : 'Temporary password for '.e($c->name),
    'crumbs' => ['Customers' => route('admin.view.customer'), $c->name => route('admin.single.customer', $c->id), 'Temporary password' => null],
])
<div class="row">
    <div class="col-xl-7">
        <div class="card">
            <div class="card-body">
                <div class="alert alert-warning adm-flash mb-3" role="alert">
                    <i class="bx bx-shield-quarter" aria-hidden="true"></i>
                    <div><strong>This password is shown only once.</strong> It isn’t stored in readable form and can’t be shown again. If it’s lost, issue a new one. Don’t refresh this page: that would create another password.</div>
                </div>
                <dl class="row mb-3">
                    <dt class="col-sm-4 text-muted fw-medium">Email (login)</dt>
                    <dd class="col-sm-8">{{ $c->email }}</dd>
                    <dt class="col-sm-4 text-muted fw-medium">Temporary password</dt>
                    <dd class="col-sm-8">
                        <div class="input-group" style="max-width:360px;">
                            <input type="text" class="form-control font-monospace fs-5" id="tempPassword" value="{{ $password }}" readonly aria-label="Temporary password" autocomplete="off" spellcheck="false">
                            <button class="btn btn-primary" type="button" id="copyTemp"><i class="bx bx-copy me-1"></i>Copy</button>
                        </div>
                    </dd>
                </dl>
                <ul class="small text-muted mb-3">
                    <li>Share it through a secure channel (phone call or in person). Avoid sending it in the same email as the login address.</li>
                    <li>{{ $c->name }} must choose a new password right after signing in.</li>
                    @unless($isNew)<li>Their previous password no longer works and any open sessions were ended.</li>@endunless
                </ul>
                <a href="{{ route('admin.single.customer', $c->id) }}" class="btn btn-light">Done, back to profile</a>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    $('#copyTemp').on('click', function () {
        var $b = $(this), v = $('#tempPassword').val();
        (navigator.clipboard ? navigator.clipboard.writeText(v) : Promise.reject()).then(function () {
            $b.html('<i class="bx bx-check me-1"></i>Copied');
        }, function () { $('#tempPassword').trigger('select'); document.execCommand('copy'); $b.text('Copied'); });
    });
</script>
@endpush
@endsection
