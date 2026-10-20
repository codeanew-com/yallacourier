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
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','banner_text_second')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Search Text</label>
                            <input type="text" name="page_meta[banner_text_second]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
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
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_one_heading')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 1 Heading</label>
                            <input type="text" name="page_meta[section_one_heading]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_one_text')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 1 Text</label>
                            <textarea name="page_meta[section_one_text]" class="form-control" placeholder="Please Enter Title">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_two_heading')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 2 Heading</label>
                            <input type="text" name="page_meta[section_two_heading]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_two_short_description')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 2 Short Description</label>
                            <input type="text" name="page_meta[section_two_short_description]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_two_description')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 2 Description</label>
                            <textarea name="page_meta[section_two_description]" class="form-control" placeholder="Please Enter Title">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_three_heading')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 3 Heading</label>
                            <input type="text" name="page_meta[section_three_heading]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_three_description')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 3 Description</label>
                            <textarea name="page_meta[section_three_description]" class="form-control" placeholder="Please Enter Title">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_three_heading_one')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 3 Heading (1)</label>
                            <input type="text" name="page_meta[section_three_heading_one]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_three_description_one')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 3 Description (1)</label>
                            <textarea name="page_meta[section_three_description_one]" class="form-control" placeholder="Please Enter Title">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_three_heading_two')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 3 Heading (2)</label>
                            <input type="text" name="page_meta[section_three_heading_two]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_three_description_two')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 3 Description (2)</label>
                            <textarea name="page_meta[section_three_description_two]" class="form-control" placeholder="Please Enter Title">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_four_heading')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 4 Heading</label>
                            <input type="text" name="page_meta[section_four_heading]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_four_decription')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 4 Description</label>
                            <textarea name="page_meta[section_four_decription]" class="form-control" placeholder="Please Enter Title">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>
                        @for($i=1; $i<5; $i++)
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_4_title_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 4 Title {{ $i }}</label>
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
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_five_heading')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 5 Heading</label>
                            <input type="text" name="page_meta[section_five_heading]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_five_decription')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 5 Description</label>
                            <textarea name="page_meta[section_five_decription]" class="form-control" placeholder="Please Enter Title">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>
                        @for($i=1; $i<4; $i++)
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_5_title_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 5 Title {{ $i }}</label>
                            <input type="text" name="page_meta[section_5_title_{{ $i }}]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_5_description_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Description {{ $i }}</label>
                            <textarea name="page_meta[section_5_description_{{ $i }}]" class="form-control" rows="10"  placeholder="Please Enter Description">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>
                        @endfor
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_six_heading')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 6 Heading</label>
                            <input type="text" name="page_meta[section_six_heading]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_six_decription')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 6 Description</label>
                            <textarea name="page_meta[section_six_decription]" class="form-control" placeholder="Please Enter Title">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>
                        @for($i=1; $i<5; $i++)
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_6_title_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 6 Title {{ $i }}</label>
                            <input type="text" name="page_meta[section_6_title_{{ $i }}]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_6_description_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Description {{ $i }}</label>
                            <textarea name="page_meta[section_6_description_{{ $i }}]" class="form-control" rows="10"  placeholder="Please Enter Description">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>
                        @endfor
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_seven_heading')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 7 Heading</label>
                            <input type="text" name="page_meta[section_seven_heading]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_seven_decription')->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 7 Description</label>
                            <textarea name="page_meta[section_seven_decription]" class="form-control" placeholder="Please Enter Title">@if($meta) {!! $meta->value !!} @endif</textarea>
                        </div>
                        @for($i=1; $i<2; $i++)
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_7_title_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Section 7 Title {{ $i }}</label>
                            <input type="text" name="page_meta[section_7_title_{{ $i }}]" class="form-control" @if($meta) value="{{$meta->value}}" @endif placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$id)->where('ref_key','section_7_description_'.$i)->first(); @endphp
                            <label class="form-label" for="validationCustom02">Description {{ $i }}</label>
                            <textarea name="page_meta[section_7_description_{{ $i }}]" class="form-control" rows="10"  placeholder="Please Enter Description">@if($meta) {!! $meta->value !!} @endif</textarea>
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