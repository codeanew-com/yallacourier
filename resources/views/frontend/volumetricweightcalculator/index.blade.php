@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)
@section('content')
<!-- {{-- innner banner section start --}} -->
<section class="innerpagebanner">
    @if(\App\Models\FileModel::where('ref_point','home_banner_background')->where('ref_id',$page->id)->count()==1)
    @php $file=\App\Models\FileModel::where('ref_point','home_banner_background')->where('ref_id',$page->id)->first(); @endphp
    <img src="{{ asset($file->path.'/'.$file->name) }}" alt="banner-img" class="banner-img">
    @endif
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content-box-wrapper  text-center">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','banner_text')->first(); @endphp
                    @if($meta)<h1>{{ $meta->value }}</h1>@endif
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','banner_text_main')->first(); @endphp
                    <div class="content-box mt-4">
                     @if($meta)   {{ $meta->value }} @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- {{-- innner banner section End --}} -->
<section class="delivery-sec usessection">
    <div class="container">
    @for($i=1; $i<3; $i++)
        <div class="row align-items-center justify-content-between ">
            <div class="col-lg-6 col-md-6">
                <div class="delivery-detals-box">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_title_'.$i)->first(); @endphp
                    <h4>@if($meta) {{ $meta->value }} @endif
                    </h4>
                    <div class="content-box">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_description_'.$i)->first(); @endphp
                    @if($meta) {!! $meta->value !!} @endif
                    </div>
                </div>
            </div>
            <div class="col-lg-5 col-md-6">
            @if(\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->count()==1)
                @php $file=\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
                <div class="delivery-details-img">
                    <img src="{{ asset($file->path.'/'.$file->name) }}" class="w-100" alt="">
                </div>
            @endif
            </div>
        </div>
    @endfor

    </div>
</section>

<!-- {{-- delivery sec end --}}
    {{-- Calculate volumetric weight for courier delivery start --}} -->
<section class="volumetric-weight usessection">
    <div class="container">
        <div class="sec-title text-center">
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_heading')->first(); @endphp
            <h2>@if($meta) {{ $meta->value }} @endif</h2>
            <div class="volumertic-content text-center">
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_3_description')->first(); @endphp
            @if($meta) {!! $meta->value !!} @endif
            </div>
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_formula')->first(); @endphp
            <div class="btn-box">
               @if($meta) {{ $meta->value }} @endif
            </div>
        </div>
        <div class="row ">
        @for($i=1; $i<4; $i++)
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="multiply-the-dimensions-wrapper text-center">
                    <div class="multiply-count-box">
                        {{ $i }}
                    </div>
                    <div class="multiply-heading-box">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_title_'.$i)->first(); @endphp
                        <h4>@if($meta) {{ $meta->value }} @endif
                        </h4>
                    </div>
                    <div class="multiply-content-box">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_description_'.$i)->first(); @endphp
                    @if($meta) {!! $meta->value !!} @endif
                    </div>

                </div>
            </div>
        @endfor

        </div>

        <!-- {{-- box --}} -->
        <div class="row align-items-center">
        @for($i=1; $i<3; $i++)
            <div class="col-lg-6 col-6">
                <div class="multiply-img-box">
                @if(\App\Models\FileModel::where('ref_point','section_5_image_'.$i)->where('ref_id',$page->id)->count()==1)
                @php $file=\App\Models\FileModel::where('ref_point','section_5_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
                    <img src="{{ asset($file->path.'/'.$file->name) }}" class="w-100" alt="">
                @endif
                </div>
            </div>
        @endfor
        </div>
        <!-- {{-- box --}} -->
    </div>
</section>
<!-- {{-- Calculate volumetric weight for courier delivery End --}} -->
@endsection