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
                <h4 class="card-title mb-4">Page Meta</h4>
                <form action="{{ route('admin.pagemeta.store')}}" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="page_id" value="{{ $id }}">
                    @csrf
                    <div class="row"> 
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','banner_text')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Title</label>
                            <input type="text" name="page_meta[banner_text]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','banner_text_main')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Banner Text</label>
                            <input type="text" name="page_meta[banner_text_main]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Banner Background Image</label>
                            <input type="file" name="home_banner_background" class="form-control" value=""  placeholder="Select Image">
                            @if(\App\Models\FileModel::where('ref_point','home_banner_background')->where('ref_id',$id)->count()==1)
                                @php $file=\App\Models\FileModel::where('ref_point','home_banner_background')->where('ref_id',$id)->first(); @endphp
                                <div class="d-flex gap-3 mt-3">
                                    <img class="card-img img-fluid" style="max-width: 350px;" src="{{ asset($file->path.'/'.$file->name) }}" alt="" height="30">
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        @for($i=1; $i<3; $i++)
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_2_title_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section Two Title {{ $i }}</label>
                            <input type="text" name="page_meta[section_2_title_{{ $i }}]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_2_description_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Description</label>
                            <textarea name="page_meta[section_2_description_{{ $i }}]" class="form-control" rows="10"  placeholder="Please Enter Description">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Image {{ $i }}</label>
                            <input type="file" name="section_2_image_{{ $i }}" class="form-control" value=""  placeholder="Select Image">
                            @if(\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$id)->count()==1)
                                @php $file=\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$id)->first(); @endphp
                                <div class="d-flex gap-3 mt-3">
                                    <img class="card-img img-fluid" style="max-width: 350px;" src="{{ asset($file->path.'/'.$file->name) }}" alt="" height="30">
                                </div>
                            @endif
                        </div>
                        @endfor
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_three_heading')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 3 Heading</label>
                            <input type="text" name="page_meta[section_three_heading]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_3_description')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Description</label>
                            <textarea name="page_meta[section_3_description]" class="form-control" rows="10"  placeholder="Please Enter Description">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_three_formula')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 3 Formula</label>
                            <input type="text" name="page_meta[section_three_formula]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        @for($i=1; $i<4; $i++)
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_4_title_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 3 Sub Title {{ $i }}</label>
                            <input type="text" name="page_meta[section_4_title_{{ $i }}]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_4_description_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Description {{ $i }}</label>
                            <textarea name="page_meta[section_4_description_{{ $i }}]" class="form-control" rows="10"  placeholder="Please Enter Description">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>
                        @endfor
                        
                    </div>



                    <div class="row">
                        @for($i=1; $i<3; $i++)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Image {{ $i }}</label>
                            <input type="file" name="section_5_image_{{ $i }}" class="form-control" value=""  placeholder="Select Image">
                            @if(\App\Models\FileModel::where('ref_point','section_5_image_'.$i)->where('ref_id',$id)->count()==1)
                                @php $file=\App\Models\FileModel::where('ref_point','section_5_image_'.$i)->where('ref_id',$id)->first(); @endphp
                                <div class="d-flex gap-3 mt-3">
                                    <img class="card-img img-fluid" style="max-width: 350px;" src="{{ asset($file->path.'/'.$file->name) }}" alt="" height="30">
                                </div>
                            @endif
                        </div>
                        @endfor
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary w-md mt-5">{{__('save')}}</button>
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
@push('scripts')
<script>
    $(document).ready(function() {
        $("textarea").summernote({
            height: 150,
        });
    });
</script>
@endpush