@extends('admin.layouts.master')
@section('title', 'Pages')
@section('content')
@include('admin.partials.page-header', [
    'title' => 'Pages',
    'subtitle' => $page->count().' website pages. Built-in pages can be edited but not deleted.',
    'crumbs' => ['Website content' => null, 'Pages' => null],
    'actions' => '<a href="'.e(route('admin-pages.create')).'" class="btn btn-primary"><i class="bx bx-plus me-1"></i>New page</a>',
])

@if($duplicateSlugs)
    <div class="alert alert-warning adm-flash" role="alert">
        <i class="bx bx-error" aria-hidden="true"></i>
        <div>Several pages share the same URL (<strong>{{ implode(', ', array_map(fn ($s) => '/'.$s, $duplicateSlugs)) }}</strong>), so only one of them can be reached. Give one of them a different slug.</div>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <table id="datatable" class="table table-hover align-middle w-100">
            <thead>
            <tr>
                <th>Page</th>
                <th>Status</th>
                <th>Search engines</th>
                <th>Footer</th>
                <th>Updated</th>
                <th class="text-end no-sort">Actions</th>
            </tr>
            </thead>
            <tbody>
                @foreach($page as $s)
                @php $isSystem = in_array((int) $s->id, $systemIds, true); @endphp
                <tr>
                    <td>
                        <a href="{{ route('admin-pages.edit', $s->id) }}" class="fw-semibold">{{ $s->title }}</a>
                        @if($isSystem)<span class="adm-pill adm-pill-neutral ms-1" title="Uses a dedicated website template">Built-in</span>@endif
                        <div class="small {{ in_array($s->slug, $duplicateSlugs, true) ? 'text-danger' : 'text-muted' }}">/{{ $s->slug }}</div>
                        @if($s->hasInvalidStoredCanonical())
                            <div class="small text-warning" title="Stored canonical: {{ $s->page_cron_url }}">
                                <i class="bx bx-error"></i> Saved canonical points off-site or to the wrong URL; the site uses {{ $s->canonicalUrl() }}. Open Settings and save to fix it.
                            </div>
                        @endif
                    </td>
                    <td data-order="{{ $s->status }}">@if($s->status==1)<span class="adm-pill adm-pill-success">Published</span>@else<span class="adm-pill adm-pill-neutral">Draft</span>@endif</td>
                    <td>@if(str_contains((string) $s->visibility, 'noindex'))<span class="adm-pill adm-pill-warning">Hidden</span>@else<span class="adm-pill adm-pill-info">Indexed</span>@endif</td>
                    <td>{{ $s->show_in_footer ? 'Yes' : '—' }}</td>
                    <td data-order="{{ optional($s->updated_at)->timestamp }}" class="small text-muted">{{ optional($s->updated_at)->diffForHumans() }}</td>
                    <td class="text-end text-nowrap">
                        <a target="_blank" rel="noopener" href="{{ url('/'.$s->slug) }}" class="btn btn-sm btn-light" title="View on website" aria-label="View {{ $s->title }} on website"><i class="bx bx-link-external"></i></a>
                        @if($s->has_meta==1)
                            <a href="{{ route('admin.pagemeta', $s->id) }}" class="btn btn-sm btn-light" title="Edit page sections"><i class="bx bx-layout me-1"></i>Sections</a>
                        @endif
                        <a href="{{ route('admin-pages.edit', $s->id) }}" class="btn btn-sm btn-light"><i class="bx bx-edit-alt me-1"></i>Settings</a>
                        @unless($isSystem)
                        <form action="{{ route('admin-pages.destroy', $s->id) }}" method="POST" class="d-inline" data-confirm="Delete the page &quot;{{ $s->title }}&quot;? Its URL will stop working.">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Delete {{ $s->title }}"><i class="bx bx-trash-alt"></i></button>
                        </form>
                        @endunless
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
