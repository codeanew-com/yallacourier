@extends('admin.layouts.master')
@section('title', $review ? 'Edit review' : 'New review')
@section('content')
@include('admin.partials.page-header', [
    'title' => $review ? 'Edit review' : 'New customer review',
    'crumbs' => ['Customer reviews' => route('admin-review.index'), ($review ? 'Edit' : 'New') => null],
])
@include('admin.partials.form-errors')
<form action="{{ $review ? route('admin-review.update', $review->id) : route('admin-review.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @if($review) @method('PATCH') @endif
    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="f-author_name">Author name</label>
                            <input type="text" class="form-control @error('author_name') is-invalid @enderror" id="f-author_name" name="author_name" value="{{ old('author_name', $review->author_name ?? '') }}" required maxlength="255" autofocus>
                            @error('author_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="f-author_designation">Role / company</label>
                            <input type="text" class="form-control @error('author_designation') is-invalid @enderror" id="f-author_designation" name="author_designation" value="{{ old('author_designation', $review->author_designation ?? '') }}" required maxlength="255" placeholder="e.g. Store owner, Dubai">
                            @error('author_designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label" for="f-review">Review</label>
                        <textarea name="review" id="f-review" class="form-control rich-text @error('review') is-invalid @enderror" rows="8">{{ old('review', $review->review ?? '') }}</textarea>
                        @error('review')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="f-author_image">Author photo</label>
                        <div class="d-flex align-items-center gap-3 mb-2">
                            <img id="imgPreview" src="{{ $image ? asset($image->path.'/'.$image->name) : '' }}" alt="" class="rounded-circle border" style="width:64px;height:64px;object-fit:cover;{{ $image ? '' : 'display:none;' }}">
                            <span class="small text-muted" id="imgNote">{{ $image ? 'Current photo. Choose a file to replace it.' : 'No photo yet.' }}</span>
                        </div>
                        <input type="file" class="form-control @error('author_image') is-invalid @enderror" id="f-author_image" name="author_image" accept="image/*" @unless($review) required @endunless>
                        @error('author_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">JPG, PNG, GIF, WebP or SVG, up to 4 MB.</div>
                    </div>
                    @include('admin.partials.radio-group', ['name' => 'status', 'label' => 'Status', 'options' => [1 => 'Published', 0 => 'Draft'], 'value' => old('status', $review->status ?? 1)])
                    @include('admin.partials.radio-group', ['name' => 'show_on_home', 'label' => 'Home page', 'options' => [1 => 'Show on home page', 0 => 'Do not show'], 'value' => old('show_on_home', $review->show_on_home ?? 1)])
                    <div class="adm-form-footer">
                        <a href="{{ route('admin-review.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">{{ $review ? 'Save changes' : 'Add review' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@include('admin.partials.rich-text')
@push('scripts')
<script>
    // Preview the chosen photo and warn about size before uploading.
    $('#f-author_image').on('change', function () {
        var file = this.files && this.files[0];
        if (!file) { return; }
        $('#imgPreview').attr('src', URL.createObjectURL(file)).show();
        $('#imgNote').text(file.name + ' (' + Math.round(file.size / 1024) + ' KB)' + (file.size > 4 * 1024 * 1024 ? ' is too large, max 4 MB' : ''))
            .toggleClass('text-danger', file.size > 4 * 1024 * 1024);
    });
</script>
@endpush
@endsection
