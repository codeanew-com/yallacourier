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
    <img src="{{ asset($file->path.'/'.$file->name) }}" alt="Courier delivery services" class="banner-img">
    @endif
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content-box-wrapper  text-center">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','banner_text')->first(); @endphp
                @if($meta)
                    <h1>{{ $meta->value }}</h1>
                @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- {{-- innner banner section End --}}

 Contact SECTION -->
<section class="contact-us-sec">
    <div class="container">
        <div class="row">
        @for($i=1; $i<4; $i++)
            <div class="col-lg-4 col-md-4 col-sm-6">
                <div class="content-box-wrapper">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_title_'.$i)->first(); @endphp
                @if($meta)<h4>{{ $meta->value}} </h4> @endif
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_description_'.$i)->first(); @endphp
                    <div class="content">
                        @if($meta) {!! $meta->value !!} @endif
                    </div>
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_cta_text_'.$i)->first(); @endphp
                    @php $meta1=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_cta_action_'.$i)->first(); @endphp
                    @if($meta && $meta1) 
                    <div class="button-holder">
                        <a href="{{ $meta1->value }}" class="purple-theme-btn"><span>{{ $meta->value }}</span></a>
                    </div>
                    @endif
                </div>
            </div>
        @endfor
        </div>
    </div>
</section>

@endsection