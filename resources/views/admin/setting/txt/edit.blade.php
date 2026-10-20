@extends('admin.layouts.master')
@section('content')
<div class="row">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <h4 class="card-title mb-4">Edit Robots.txt</h4>
                <form action="{{ route('admin.save.txtfile')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label" for="validationCustom02">Content</label>
                            <textarea name="content" class="form-control" rows="10"  placeholder="Please Enter Content">{{ $content }}</textarea>
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