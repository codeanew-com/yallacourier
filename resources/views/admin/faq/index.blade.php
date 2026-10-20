@extends('admin.layouts.master')
@section('title', 'FAQs')
@section('content')
@include('admin.partials.page-header', [
    'title' => 'FAQs',
    'subtitle' => $faq->count().' questions · '.$faq->where('show_on_home', 1)->count().' shown on the home page',
    'crumbs' => ['Website content' => null, 'FAQs' => null],
    'actions' => '<a href="'.e(route('admin-faq.create')).'" class="btn btn-primary"><i class="bx bx-plus me-1"></i>New FAQ</a>',
])
<div class="card">
    <div class="card-body">
        <table id="datatable" class="table table-hover align-middle w-100">
            <thead>
            <tr><th>Question</th><th>Status</th><th>Home page</th><th>Added</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @foreach($faq as $s)
                <tr>
                    <td style="white-space:normal;max-width:520px;"><a href="{{ route('admin-faq.edit', $s->id) }}" class="fw-semibold">{{ $s->question }}</a></td>
                    <td data-order="{{ $s->status }}">@if($s->status==1)<span class="adm-pill adm-pill-success">Published</span>@else<span class="adm-pill adm-pill-neutral">Draft</span>@endif</td>
                    <td>{{ $s->show_on_home ? 'Shown' : '—' }}</td>
                    <td data-order="{{ $s->created_at->timestamp }}" class="small text-muted">{{ $s->created_at->format('d M Y') }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin-faq.edit', $s->id) }}" class="btn btn-sm btn-light"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <form action="{{ route('admin-faq.destroy', $s->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Delete FAQ"><i class="bx bx-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
