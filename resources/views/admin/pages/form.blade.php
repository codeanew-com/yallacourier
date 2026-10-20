{{-- Shared create/edit form for CMS pages. $page is null when creating. --}}
@extends('admin.layouts.master')
@section('title', $page ? 'Edit page' : 'New page')
@section('content')
@php
    $val = fn ($key, $default = '') => old($key, $page ? $page->$key : $default);
@endphp
@include('admin.partials.page-header', [
    'title' => $page ? 'Edit page: '.e($page->title) : 'New page',
    'crumbs' => ['Pages' => route('admin-pages.index'), ($page ? 'Edit' : 'New') => null],
    'actions' => $page ? '<a href="'.e(url('/'.$page->slug)).'" target="_blank" rel="noopener" class="btn btn-light"><i class="bx bx-link-external me-1"></i>View page</a>' : '',
])

@include('admin.partials.form-errors')

<form action="{{ $page ? route('admin-pages.update', $page->id) : route('admin-pages.store') }}" method="POST" data-slug-form>
    @csrf
    @if($page) @method('PATCH') @endif
    <div class="row g-3">
        <div class="col-xl-8">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="adm-section-title">Page</div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="f-title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="f-title" name="title" value="{{ $val('title') }}" required maxlength="255" autofocus data-slug-source>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="f-slug">URL slug</label>
                            <div class="input-group">
                                <span class="input-group-text small">{{ rtrim(config('app.public_url'), '/') }}/</span>
                                <input type="text" class="form-control @error('slug') is-invalid @enderror" id="f-slug" name="slug" value="{{ $val('slug') }}" maxlength="255" data-slug-target @if($page) data-locked @endif>
                            </div>
                            @error('slug')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                            <div class="form-text">{{ $page ? 'Changing the slug changes the page URL — old links will stop working.' : 'Filled from the title automatically. Lowercase letters, numbers and dashes.' }}</div>
                        </div>
                    </div>

                    <div class="adm-section-title">Search engines (SEO)</div>
                    <div class="mb-3">
                        <label class="form-label" for="f-page_title">SEO title</label>
                        <input type="text" name="page_title" id="f-page_title" class="form-control @error('page_title') is-invalid @enderror" value="{{ $val('page_title') }}" maxlength="255" data-follow-title data-count="60">
                        @error('page_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Defaults to the page title. <span data-counter-for="f-page_title"></span></div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="f-meta_description">Meta description</label>
                        <textarea name="meta_description" id="f-meta_description" class="form-control @error('meta_description') is-invalid @enderror" rows="3" maxlength="255" required data-count="160">{{ strip_tags($val('meta_description')) }}</textarea>
                        @error('meta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Shown under the link in Google results. <span data-counter-for="f-meta_description"></span></div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label" for="f-page_cron_url">Canonical URL</label>
                        <input type="url" name="page_cron_url" id="f-page_cron_url" class="form-control @error('page_cron_url') is-invalid @enderror" value="{{ $val('page_cron_url') }}" maxlength="255" data-follow-slug="{{ rtrim(config('app.public_url'), '/') }}/">
                        @error('page_cron_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Defaults to this page's own URL.</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card mb-0">
                <div class="card-body">
                    <div class="adm-section-title">Publishing</div>
                    <div class="mb-3">
                        <span class="form-label d-block">Status</span>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status-1" name="status" value="1" @checked((string) $val('status', '1') === '1')>
                                <label class="form-check-label" for="status-1">Published</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="status-0" name="status" value="0" @checked((string) $val('status', '1') === '0')>
                                <label class="form-check-label" for="status-0">Draft</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="f-visibility">Search engine visibility</label>
                        <select name="visibility" id="f-visibility" class="form-select">
                            <option value="index,follow" @selected($val('visibility', 'index,follow') == 'index,follow')>Index &amp; follow (show in Google)</option>
                            <option value="noindex,nofollow" @selected($val('visibility', 'index,follow') == 'noindex,nofollow')>No index, no follow (hidden)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="f-has_meta">Editable page sections</label>
                        <select name="has_meta" id="f-has_meta" class="form-select">
                            <option value="1" @selected((string) $val('has_meta', '1') === '1')>Yes — page has its own content sections</option>
                            <option value="0" @selected((string) $val('has_meta', '1') === '0')>No</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label" for="f-show_in_footer">Show link in footer</label>
                        <select name="show_in_footer" id="f-show_in_footer" class="form-select">
                            <option value="0" @selected((string) $val('show_in_footer', '0') === '0')>No</option>
                            <option value="1" @selected((string) $val('show_in_footer', '0') === '1')>Yes</option>
                        </select>
                    </div>
                    <div class="adm-form-footer">
                        <a href="{{ route('admin-pages.index') }}" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">{{ $page ? 'Save changes' : 'Create page' }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@include('admin.partials.slug-script')
@endsection
