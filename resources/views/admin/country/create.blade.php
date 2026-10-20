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
                <h4 class="card-title mb-4">New country page</h4>
                <form action="{{ route('admin-country.store')}}" method="POST" enctype="multipart/form-data" data-slug-form>
                    @csrf
                    <div class="row"> 
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Country</label>
                            <select name="shipment_to_country" class="form-select" data-country-select>
                                <option value="SA">Kingdom Of Saudi Arabia</option>
                                <option value="QA">Qatar</option>
                                <option value="KW">Kuwait</option>
                                <option value="LB">Lebanon</option>
                                <option value="JO">Jordan</option>
                                <option value="OM">Oman</option>
                                <option value="BH">Bahrain</option>
                                <option value="GB">United Kingdom</option>
                                <option value="DE">Germany</option>
                                <option value="FR">France</option>
                                <option value="PK">Pakistan</option>
                                <option value="IN">India</option>
                                <option value="IR">Iran</option>
                                <option value="US">America</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}" class="form-control @error('title') is-invalid @enderror" placeholder="e.g. Ship to Qatar" data-slug-source>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" class="form-control @error('slug') is-invalid @enderror" placeholder="Filled from the title" data-slug-target><div class="form-text">Page URL: /country/<em>slug</em>. Filled from the title automatically.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Banner Title</label>
                            <input type="text" name="banner_title" value="{{ old('banner_title') }}" class="form-control @error('banner_title') is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Banner Background Image</label>
                            <input type="file" name="landing_banner_background" class="form-control" value=""  placeholder="Select Image">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 1 Heading</label>
                            <input type="text" name="sec_one_title" value="{{ old('sec_one_title') }}" class="form-control @error('sec_one_title') is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 1 Text</label>
                            <textarea name="sec_one_content" class="form-control" placeholder="Please Enter Title">{{ old('sec_one_content') }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 1 Image</label>
                            <input type="file" name="section_one_image" class="form-control" value=""  placeholder="Select Image">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="gridCheck" name="status" value="1" @if(old('status')==1) checked="checked" @endif >
                                <label class="form-check-label" for="gridCheck">
                                    Published
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="gridCheck" name="status" value="0" @if(old('status')==0) checked="checked" @endif >
                                <label class="form-check-label" for="gridCheck">
                                    Draft
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 2 Heading</label>
                            <input type="text" name="sec_two_title" value="{{ old('sec_two_title') }}" class="form-control @error('sec_two_title') is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                        @for($i=1; $i<5; $i++)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 2 Title {{ $i }}</label>
                            <input type="text" name="sec_two_subheading_{{ $i }}" value="{{ old('sec_two_subheading_'.$i) }}" class="form-control @error('sec_two_subheading_'.$i) is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Image {{ $i }}</label>
                            <input type="file" name="section_2_image_{{ $i }}" class="form-control" value=""  placeholder="Select Image">
                        </div>
                        @endfor
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 3 Heading</label>
                            <input type="text" name="sec_three_title" value="{{ old('sec_three_title') }}" class="form-control @error('sec_three_title') is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                        @for($i=1; $i<5; $i++)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 3 Title {{ $i }}</label>
                            <input type="text" name="sec_three_subheading_{{ $i }}" value="{{ old('sec_three_subheading_'.$i) }}" class="form-control @error('sec_three_subheading_'.$i) is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 3 Text {{ $i }}</label>
                            <input type="text" name="sec_three_content_{{ $i }}" value="{{ old('sec_three_content_'.$i) }}" class="form-control @error('sec_three_content_'.$i) is-invalid @enderror" placeholder="Please Enter Text">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Image {{ $i }}</label>
                            <input type="file" name="section_3_image_{{ $i }}" class="form-control" value=""  placeholder="Select Image">
                        </div>
                        @endfor
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 4 Heading</label>
                            <input type="text" name="sec_four_title" value="{{ old('sec_four_title') }}" class="form-control @error('sec_four_title') is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                        @for($i=1; $i<4; $i++)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 4 Title {{ $i }}</label>
                            <input type="text" name="sec_four_subheading_{{ $i }}" value="{{ old('sec_four_subheading_'.$i) }}" class="form-control @error('sec_four_subheading_'.$i) is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Description {{ $i }}</label>
                            <textarea name="sec_four_content_{{ $i }}" class="form-control" rows="10"  placeholder="Please Enter Description">{{ old('sec_four_content_'.$i) }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Image {{ $i }}</label>
                            <input type="file" name="section_4_image_{{ $i }}" class="form-control" value=""  placeholder="Select Image">
                        </div>
                        @endfor
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 5 Heading</label>
                            <input type="text" name="sec_five_title" value="{{ old('sec_five_title') }}" class="form-control @error('sec_five_title') is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 6 Heading</label>
                            <input type="text" name="sec_six_title" value="{{ old('sec_six_title') }}" class="form-control @error('sec_six_title') is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 7 Heading</label>
                            <input type="text" name="sec_seven_title" value="{{ old('sec_seven_title') }}" class="form-control @error('sec_seven_title') is-invalid @enderror" placeholder="Please Enter Title">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 7 Text</label>
                            <input type="text" name="sec_seven_content" value="{{ old('sec_seven_content') }}" class="form-control @error('sec_seven_content') is-invalid @enderror" placeholder="Please Enter Text">
                        </div>
                        @for($i=1; $i<8; $i++)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Image {{ $i }}</label>
                            <input type="file" name="section_7_image_{{ $i }}" class="form-control" value=""  placeholder="Select Image">
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

@include('admin.partials.slug-script')
@include('admin.country.partials.country-title-script')
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