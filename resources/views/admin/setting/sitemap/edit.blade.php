@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('admin.generate.sitemap') }}" style="float: right;" class="btn btn-success" data-confirm="Rebuild sitemap.xml from all published, indexable pages? Manual edits below will be replaced.">Generate sitemap</a>
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <h4 class="card-title mb-4">Edit Sitemap</h4>
                <form action="{{ route('admin.save.sitemap')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label" for="validationCustom02">Content</label>
                            <textarea name="content" class="form-control" rows="50"  placeholder="Please Enter Content">{{ old('content', $content) }}</textarea>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-md mt-5">Save</button>
                    </div>
                </form>
            </div>
            <!-- end card body -->
        </div>
        <!-- end card -->
    </div>
    <!-- end col -->
</div>


@endsection