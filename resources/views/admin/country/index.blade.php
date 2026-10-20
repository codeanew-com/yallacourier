@extends('admin.layouts.master')
@section('title', 'Country pages')
@section('content')
@include('admin.partials.page-header', [
    'title' => 'Country pages',
    'subtitle' => 'Landing pages for shipping destinations, served at /country/{slug}.',
    'crumbs' => ['Website content' => null, 'Country pages' => null],
    'actions' => '<a href="'.e(route('admin-country.create')).'" class="btn btn-primary"><i class="bx bx-plus me-1"></i>New country page</a>',
])
<div class="card">
    <div class="card-body">
        <table id="datatable" class="table table-hover align-middle w-100">
            <thead>
            <tr><th>Page</th><th>Destination</th><th>Status</th><th>Updated</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @foreach($country as $c)
                <tr>
                    <td><a href="{{ route('admin-country.edit', $c->id) }}" class="fw-semibold">{{ $c->title }}</a><div class="small text-muted">/country/{{ $c->slug }}</div></td>
                    <td>{{ $c->shipment_to_country }}</td>
                    <td data-order="{{ $c->status }}">@if($c->status==1)<span class="adm-pill adm-pill-success">Published</span>@else<span class="adm-pill adm-pill-neutral">Draft</span>@endif</td>
                    <td data-order="{{ optional($c->updated_at)->timestamp }}" class="small text-muted">{{ optional($c->updated_at)->diffForHumans() }}</td>
                    <td class="text-end text-nowrap">
                        <a target="_blank" rel="noopener" href="{{ route('countrysingle', $c->slug) }}" class="btn btn-sm btn-light" aria-label="View {{ $c->title }} on website"><i class="bx bx-link-external"></i></a>
                        <a href="{{ route('admin-country.edit', $c->id) }}" class="btn btn-sm btn-light"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <form action="{{ route('admin-country.destroy', $c->id) }}" method="POST" class="d-inline" data-confirm="Delete the country page &quot;{{ $c->title }}&quot;? Its URL will stop working.">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Delete {{ $c->title }}"><i class="bx bx-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
