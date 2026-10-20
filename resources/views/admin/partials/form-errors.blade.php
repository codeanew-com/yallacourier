@if($errors->any())
    <div class="alert alert-danger adm-flash" role="alert">
        <i class="bx bx-error-circle" aria-hidden="true"></i>
        <div>
            <strong>Nothing was saved. Please fix {{ $errors->count() === 1 ? 'this' : 'these' }}:</strong>
            <ul class="mb-0 ps-3 mt-1">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    </div>
@endif
