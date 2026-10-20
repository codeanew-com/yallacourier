@extends('admin.layouts.master')
@section('title', $faq ? 'Edit FAQ' : 'New FAQ')
@section('content')
@include('admin.partials.page-header', [
    'title' => $faq ? 'Edit FAQ' : 'New FAQ',
    'crumbs' => ['FAQs' => route('admin-faq.index'), ($faq ? 'Edit' : 'New') => null],
])
@include('admin.partials.form-errors')
<form action="{{ $faq ? route('admin-faq.update', $faq->id) : route('admin-faq.store') }}" method="POST">
    @csrf
    @if($faq) @method('PATCH') @endif
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label" for="f-question">Question</label>
                <input type="text" class="form-control @error('question') is-invalid @enderror" id="f-question" name="question" value="{{ old('question', $faq->question ?? '') }}" required maxlength="1000" autofocus>
                @error('question')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label" for="f-answer">Answer</label>
                <textarea name="answer" id="f-answer" class="form-control rich-text @error('answer') is-invalid @enderror" rows="8">{{ old('answer', $faq->answer ?? '') }}</textarea>
                @error('answer')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="row">
                <div class="col-md-6">
                    @include('admin.partials.radio-group', ['name' => 'status', 'label' => 'Status', 'options' => [1 => 'Published', 0 => 'Draft'], 'value' => old('status', $faq->status ?? 1)])
                </div>
                <div class="col-md-6">
                    @include('admin.partials.radio-group', ['name' => 'show_on_home', 'label' => 'Home page', 'options' => [1 => 'Show on home page', 0 => 'FAQ page only'], 'value' => old('show_on_home', $faq->show_on_home ?? 0)])
                </div>
            </div>
            <div class="adm-form-footer">
                <a href="{{ route('admin-faq.index') }}" class="btn btn-light">Cancel</a>
                @unless($faq)
                    <button type="submit" name="after" value="new" class="btn btn-outline-primary">Save &amp; add another</button>
                @endunless
                <button type="submit" class="btn btn-primary">{{ $faq ? 'Save changes' : 'Add FAQ' }}</button>
            </div>
        </div>
    </div>
</form>
@include('admin.partials.rich-text')
@endsection
