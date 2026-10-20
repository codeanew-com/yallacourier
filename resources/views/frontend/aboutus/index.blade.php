@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)
@section('content')
<section class="innerpagebanner">
    @if(\App\Models\FileModel::where('ref_point','home_banner_background')->where('ref_id',$page->id)->count()==1)
    @php $file=\App\Models\FileModel::where('ref_point','home_banner_background')->where('ref_id',$page->id)->first(); @endphp
    <img src="{{ asset($file->path.'/'.$file->name) }}" alt="delivery near me" class="banner-img">
    @endif
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content-box-wrapper  text-center">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','banner_text')->first(); @endphp
                @if($meta)<h1>{{ $meta->value }}</h1> @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="aboutussection">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6">
                <div class="content-box-wrapper">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_heading')->first(); @endphp
                @if($meta) <h4>{{ $meta->value }}</h4> @endif
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_text')->first(); @endphp
                @if($meta)
                    <div>{!! $meta->value  !!}</div>
                @endif
                </div>
            </div>
            @if(\App\Models\FileModel::where('ref_point','section_one_image')->where('ref_id',$page->id)->count()==1)
            @php $file=\App\Models\FileModel::where('ref_point','section_one_image')->where('ref_id',$page->id)->first(); @endphp
            <div class="col-lg-6 col-md-6">
                <figure class="image-wrapper">
                    <img class="img-fluid" src="{{ asset($file->path.'/'.$file->name) }}" alt="delivery near me">
                </figure>
            </div>
            @endif
        </div>
    </div>
</section>




<!-- section 4 starts -->
<section class="usessection worksection abouthowitworks">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content-box-wrapper">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_two_heading')->first(); @endphp
                @if($meta)
                    <h2>{{ $meta->value }}</h2>
                @endif                
            </div>
            </div>
        </div>
        <div class="row courieruses">
        @for($i=1; $i<4; $i++)
            <div class="col-lg-4 col-md-4 col-sm-6 courierusesmainwrapper">
                <div class="useswrapper">
                    <figure class="usesimage">
                    @if(\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->count()==1)
                        @php $file=\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
                        <img src="{{ asset($file->path.'/'.$file->name) }}" alt="delivery near me">
                    @endif
                    </figure>
                    <div class="content-box-wrapper">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_two_heading')->first(); @endphp
                    @if($meta) <h4>{{ $meta->value }}</h4> @endif
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_description_'.$i)->first(); @endphp
                    @if($meta) <div>{!! $meta->value !!}</div> @endif
                    </div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</section>

<!-- section 3 starts -->
<section class="discountbanner aboutdiscountbanner">
    @if(\App\Models\FileModel::where('ref_point','section_three_image')->where('ref_id',$page->id)->count()==1)
    @php $file=\App\Models\FileModel::where('ref_point','section_three_image')->where('ref_id',$page->id)->first(); @endphp
    <img src="{{ asset($file->path.'/'.$file->name) }}" alt="delivery near me" class="banner-img">
    @endif
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-7 col-12">
                <div class="content-bx-wrapper">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_heading')->first(); @endphp
                    @if($meta)<h2>{{ $meta->value }}</h2> @endif

                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_cta_text')->first(); @endphp
                    @php $meta1=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_cta_action')->first(); @endphp
                    @if($meta && $meta1)
                    <div class="button-holder">
                        <a href="{{ $meta1->value }}" class="purple-theme-btn"><span>{{ $meta->value }}</span></a>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>

<!-- section 7 starts -->
<section class="faqsection aboutfaq">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="content-box-wrapper text-center">
                    <h2>Frequently Asked Questions</h2>
                </div>
                <div class="faq-wrapper">
                    <div class="accordion">
                        <div class="accordion__item">
                            <div class="accordion__title">
                                <div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
                                <h4 class="accordion__title-text">Can I have a tracking update?</h4>
                            </div>
                            <div class="accordion__content">
                                <p>Yes - login to your Yalla Courier portal using your email address and password,
                                    go to
                                    tracking update and check the location of your parcel.</p>
                            </div>
                        </div>

                        <div class="accordion__item">
                            <div class="accordion__title">
                                <div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
                                <h4 class="accordion__title-text">Can I deliver multiple packages in one order</h4>
                            </div>
                            <div class="accordion__content">
                                <p>Yes - login to your Yalla Courier portal using your email address and password,
                                    go to
                                    tracking update and check the location of your parcel.</p>
                            </div>
                        </div>

                        <div class="accordion__item">
                            <div class="accordion__title">
                                <div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
                                <h4 class="accordion__title-text">What discounts will I receive on my delivery</h4>
                            </div>
                            <div class="accordion__content">
                                <p>Yes - login to your Yalla Courier portal using your email address and password,
                                    go to
                                    tracking update and check the location of your parcel.</p>
                            </div>
                        </div>

                        <div class="accordion__item">
                            <div class="accordion__title">
                                <div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
                                <h4 class="accordion__title-text">Is Yalla Courier cheaper than other delivery
                                    companies</h4>
                            </div>
                            <div class="accordion__content">
                                <p>Yes - login to your Yalla Courier portal using your email address and password,
                                    go to
                                    tracking update and check the location of your parcel.</p>
                            </div>
                        </div>

                        <div class="accordion__item">
                            <div class="accordion__title">
                                <div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
                                <h4 class="accordion__title-text">How is the price of my parcel delivery calculated
                                </h4>
                            </div>
                            <div class="accordion__content">
                                <p>Yes - login to your Yalla Courier portal using your email address and password,
                                    go to
                                    tracking update and check the location of your parcel.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>


@endsection