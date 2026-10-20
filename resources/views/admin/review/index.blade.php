@extends('admin.layouts.master')
@section('title', 'Customer reviews')
@section('content')
@include('admin.partials.page-header', [
    'title' => 'Customer reviews',
    'subtitle' => $review->count().' reviews · '.$review->where('show_on_home', 1)->where('status', 1)->count().' live on the home page',
    'crumbs' => ['Website content' => null, 'Customer reviews' => null],
    'actions' => '<a href="'.e(route('admin-review.create')).'" class="btn btn-primary"><i class="bx bx-plus me-1"></i>New review</a>',
])
<div class="card">
    <div class="card-body">
        <table id="datatable" class="table table-hover align-middle w-100">
            <thead>
            <tr><th>Author</th><th>Review</th><th>Status</th><th>Home page</th><th class="text-end">Actions</th></tr>
            </thead>
            <tbody>
                @foreach($review as $s)
                @php $img = $images[$s->id] ?? null; @endphp
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            @if($img)
                                <img src="{{ asset($img->path.'/'.$img->name) }}" alt="" class="rounded-circle" style="width:36px;height:36px;object-fit:cover;">
                            @else
                                <span class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center" style="width:36px;height:36px;" aria-hidden="true">{{ strtoupper(mb_substr($s->author_name, 0, 1)) }}</span>
                            @endif
                            <div><a href="{{ route('admin-review.edit', $s->id) }}" class="fw-semibold">{{ $s->author_name }}</a><div class="small text-muted">{{ $s->author_designation }}</div></div>
                        </div>
                    </td>
                    <td class="small text-muted" style="white-space:normal;max-width:420px;">{{ \Illuminate\Support\Str::limit(strip_tags($s->review), 110) }}</td>
                    <td data-order="{{ $s->status }}">@if($s->status==1)<span class="adm-pill adm-pill-success">Published</span>@else<span class="adm-pill adm-pill-neutral">Draft</span>@endif</td>
                    <td>{{ $s->show_on_home ? 'Shown' : '—' }}</td>
                    <td class="text-end text-nowrap">
                        <a href="{{ route('admin-review.edit', $s->id) }}" class="btn btn-sm btn-light"><i class="bx bx-edit-alt me-1"></i>Edit</a>
                        <form action="{{ route('admin-review.destroy', $s->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit" aria-label="Delete review by {{ $s->author_name }}"><i class="bx bx-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
