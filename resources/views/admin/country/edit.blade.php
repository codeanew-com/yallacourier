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
                <h4 class="card-title mb-4">Edit country page: {{ $country->title }} <a href="{{ route('countrysingle', $country->slug) }}" target="_blank" rel="noopener" class="btn btn-sm btn-light ms-2"><i class="bx bx-link-external me-1"></i>View page</a></h4>
                <form action="{{ route('admin-country.update',$country->id)}}" method="POST" enctype="multipart/form-data" data-slug-form>
                    @csrf
                    {{ method_field('PATCH') }}
                    <div class="row"> 
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Country</label>
                            <select name="shipment_to_country" class="form-select">
                                <option @if($country->shipment_to_country=='SA') selected @endif value="SA">Kingdom Of Saudi Arabia</option>
                                <option @if($country->shipment_to_country=='QA') selected @endif value="QA">Qatar</option>
                                <option @if($country->shipment_to_country=='KW') selected @endif value="KW">Kuwait</option>
                                <option @if($country->shipment_to_country=='LB') selected @endif value="LB">Lebanon</option>
                                <option @if($country->shipment_to_country=='JO') selected @endif value="JO">Jordan</option>
                                <option @if($country->shipment_to_country=='OM') selected @endif value="OM">Oman</option>
                                <option @if($country->shipment_to_country=='BH') selected @endif value="BH">Bahrain</option>
                                <option @if($country->shipment_to_country=='GB') selected @endif value="GB">United Kingdom</option>
                                <option @if($country->shipment_to_country=='DE') selected @endif value="DE">Germany</option>
                                <option @if($country->shipment_to_country=='FR') selected @endif value="FR">France</option>
                                <option @if($country->shipment_to_country=='PK') selected @endif value="PK">Pakistan</option>
                                <option @if($country->shipment_to_country=='IN') selected @endif value="IN">India</option>
                                <option @if($country->shipment_to_country=='IR') selected @endif value="IR">Iran</option>
                                <option @if($country->shipment_to_country=='US') selected @endif value="US">America</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Title</label>
                            <input type="text" name="title" data-slug-source class="form-control" placeholder="Please Enter Title" value="{{ old('title', $country->title) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Slug</label>
                            <input type="text" name="slug" data-slug-target data-locked class="form-control" placeholder="Page URL slug" value="{{ old('slug', $country->slug) }}"><div class="form-text">Changing the slug changes the page URL (/country/<em>slug</em>); old links will stop working.</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Banner Title</label>
                            <input type="text" name="banner_title" class="form-control" placeholder="Please Enter Title" value="{{ old('banner_title', $country->banner_title) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Banner Background Image</label>
                            <input type="file" name="landing_banner_background" class="form-control" value=""  placeholder="Select Image">
                            @php $file=\App\Models\FileModel::where('ref_point','landing_banner_background')->where('ref_id',$country->id)->where('path', 'uploads/countries')->first(); @endphp
                            @if($file)
                            <div class="d-flex gap-3 mt-3">
                                <img class="card-img img-fluid" style="max-width: 150px;" src="{{ asset($file->path.'/'.$file->name) }}" alt="" height="30">
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 1 Heading</label>
                            <input type="text" name="sec_one_title" class="form-control" placeholder="Please Enter Title" value="{{ old('sec_one_title', $country->sec_one_title) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 1 Text</label>
                            <textarea name="sec_one_content" class="form-control" placeholder="Please Enter Title">{{$country->sec_one_content}}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 1 Image</label>
                            <input type="file" name="section_one_image" class="form-control" value=""  placeholder="Select Image">
                            @php $file=\App\Models\FileModel::where('ref_point','section_one_image')->where('ref_id',$country->id)->where('path', 'uploads/countries')->first(); @endphp
                            @if($file)
                            <div class="d-flex gap-3 mt-3">
                                <img class="card-img img-fluid" style="max-width: 150px;" src="{{ asset($file->path.'/'.$file->name) }}" alt="" height="30">
                            </div>
                            @endif
                        </div>
                        <div class="col-md-6 mb-3" style="display: flex;gap: 18px;margin-top: 1%;">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="gridCheck" name="status" value="1" @if($country->status==1) checked="checked" @endif >
                                <label class="form-check-label" for="gridCheck">
                                    Published
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" id="gridCheck" name="status" value="0" @if($country->status==0) checked="checked" @endif >
                                <label class="form-check-label" for="gridCheck">
                                    Draft
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 2 Heading</label>
                            <input type="text" name="sec_two_title" class="form-control" placeholder="Please Enter Title" value="{{ old('sec_two_title', $country->sec_two_title) }}">
                        </div>
                        @for($i=1; $i<5; $i++)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 2 Title {{ $i }}</label>
                            <input type="text" name="sec_two_subheading_{{ $i }}" class="form-control" placeholder="Please Enter Title" value="{{ $country->{'sec_two_subheading_' . $i} }}">

                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Image {{ $i }}</label>
                            <input type="file" name="section_2_image_{{ $i }}" class="form-control" value=""  placeholder="Select Image">
                            @php $file=\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$country->id)->where('path', 'uploads/countries')->first(); @endphp
                            @if($file)
                            <div class="d-flex gap-3 mt-3">
                                <img class="card-img img-fluid" style="max-width: 350px;" src="{{ asset($file->path.'/'.$file->name) }}" alt="" height="30">
                            </div>
                            @endif
                        </div>
                        @endfor
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 3 Heading</label>
                            <input type="text" name="sec_three_title" class="form-control" placeholder="Please Enter Title" value="{{ old('sec_three_title', $country->sec_three_title) }}">
                        </div>
                        @for($i=1; $i<5; $i++)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 3 Title {{ $i }}</label>
                            <input type="text" name="sec_three_subheading_{{ $i }}" class="form-control" placeholder="Please Enter Title" value="{{ $country->{'sec_three_subheading_' . $i} }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 3 Text {{ $i }}</label>
                            <input type="text" name="sec_three_content_{{ $i }}" class="form-control" placeholder="Please Enter Text" value="{{ $country->{'sec_three_content_' . $i} }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Image {{ $i }}</label>
                            <input type="file" name="section_3_image_{{ $i }}" class="form-control" value=""  placeholder="Select Image">
                            @php $file=\App\Models\FileModel::where('ref_point','section_3_image_'.$i)->where('ref_id',$country->id)->where('path', 'uploads/countries')->first(); @endphp
                            @if($file)
                            <div class="d-flex gap-3 mt-3">
                                <img class="card-img img-fluid" style="max-width: 350px;" src="{{ asset($file->path.'/'.$file->name) }}" alt="" height="30">
                            </div>
                            @endif
                        </div>
                        @endfor
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 4 Heading</label>
                            <input type="text" name="sec_four_title" class="form-control" placeholder="Please Enter Title" value="{{ old('sec_four_title', $country->sec_four_title) }}">
                        </div>
                        @for($i=1; $i<4; $i++)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 4 Title {{ $i }}</label>
                            <input type="text" name="sec_four_subheading_{{ $i }}" class="form-control" placeholder="Please Enter Title" value="{{ $country->{'sec_four_subheading_' . $i} }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Description {{ $i }}</label>
                            <textarea name="sec_four_content_{{ $i }}" class="form-control" rows="10"  placeholder="Please Enter Description">{{ $country->{'sec_four_content_' . $i} }}</textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Image {{ $i }}</label>
                            <input type="file" name="section_4_image_{{ $i }}" class="form-control" value=""  placeholder="Select Image">
                            @php $file=\App\Models\FileModel::where('ref_point','section_4_image_'.$i)->where('ref_id',$country->id)->where('path', 'uploads/countries')->first(); @endphp
                            @if($file)
                            <div class="d-flex gap-3 mt-3">
                                <img class="card-img img-fluid" style="max-width: 350px;" src="{{ asset($file->path.'/'.$file->name) }}" alt="" height="30">
                            </div>
                            @endif
                        </div>
                        @endfor
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 5 Heading</label>
                            <input type="text" name="sec_five_title" class="form-control" placeholder="Please Enter Title" value="{{ old('sec_five_title', $country->sec_five_title) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 6 Heading</label>
                            <input type="text" name="sec_six_title" class="form-control" placeholder="Please Enter Title" value="{{ old('sec_six_title', $country->sec_six_title) }}">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 7 Heading</label>
                            <input type="text" name="sec_seven_title" class="form-control" placeholder="Please Enter Title" value="{{ old('sec_seven_title', $country->sec_seven_title) }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Section 7 Text</label>
                            <input type="text" name="sec_seven_content" class="form-control" placeholder="Please Enter Text" value="{{ old('sec_seven_content', $country->sec_seven_content) }}">
                        </div>
                        @for($i=1; $i<8; $i++)
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="validationCustom02">Image {{ $i }}</label>
                            <input type="file" name="section_7_image_{{ $i }}" class="form-control" value=""  placeholder="Select Image">
                            
                            @php $file=\App\Models\FileModel::where('ref_point','section_7_image_'.$i)->where('ref_id',$country->id)->where('path', 'uploads/countries')->first(); @endphp
                            @if($file)
                                <div class="d-flex gap-3 mt-3">
                                    <img class="card-img img-fluid" style="max-width: 350px;" src="{{ asset($file->path.'/'.$file->name) }}" alt="" height="30">
                                </div>
                            @endif
                          
                        </div>
                        @endfor
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary w-md">Save</button>
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
@endsection
@push('scripts')
<script>
    $(document).ready(function(){
        $("textarea").summernote({
            height: 150,
        });
    });
</script>
@endpush
