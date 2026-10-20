@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)

@section('content')
<!-- {{-- innner banner section start --}} -->
    <section class="innerpagebanner">
    @if(\App\Models\FileModel::where('ref_point','banner_background')->where('ref_id',$page->id)->count()==1)
    @php $file=\App\Models\FileModel::where('ref_point','banner_background')->where('ref_id',$page->id)->first(); @endphp
        <img src="{{ asset($file->path.'/'.$file->name) }}" alt="banner-img" class="banner-img">
    @endif
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content-box-wrapper  text-center">
                        @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','banner_text')->first(); @endphp
                        @if($meta)<h1>{{ $meta->value }}</h1>@endif
                    </div>
                </div>
            </div>
            
        </div>
        @if(\App\Models\FileModel::where('ref_point','section_1_image')->where('ref_id',$page->id)->count()==1)
            @php $file=\App\Models\FileModel::where('ref_point','section_1_image')->where('ref_id',$page->id)->first(); @endphp
        <img src="{{ asset($file->path.'/'.$file->name) }}" class="courires-img" alt="">
        @endif
    </section>
    <!-- {{-- innner banner section End --}}
    {{-- courires partner section start --}} -->
    <section class="usessection courires-section">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-6 col-md-6">
                    <div class="courires-partner-details-box">
                        <div class="img-wrap"> <img src="{{asset('front_assets/')}}/images/001 1.png" class="w-100" alt=""></div>
                       
                        <div class="courires-partner-content-box">
                            J&T Express takes express services and international logistics as its core business. J&T Express is committed to creating integrated quality experiences for its customers globally by providing logistics solutions suited for a variety of scenarios.
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="courires-partner-details-box">
                        <div class="img-wrap"> <img src="{{asset('front_assets/')}}/images/ups.svg" class="w-100" alt=""></div>
                        <div class="courires-partner-content-box">
                            Ship Fast & Easy with UPS — UPS is Faster Than The Rest & Offers Industry-Leading Money Back Guarantee in Europe. UPS Offers a Range of Parcel Delivery Services to Meet Your Needs.
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="courires-partner-details-box">
                        <div class="img-wrap"> <img src="{{asset('front_assets/')}}/images/002 1.png" class="w-100" alt=""></div>
                        <div class="courires-partner-content-box">
                            We can ship anything from a letter to a grand piano, by air or road, to and from almost any location in the World! We offer varying transit times to match the requirements of our customers.
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="courires-partner-details-box">
                         <div class="img-wrap"> <img src="{{asset('front_assets/')}}/images/003.png" class="w-100" alt=""></div>
                        <div class="courires-partner-content-box">
                          Shyft started off as a luggage delivery and airline check-in experiment. With COVID19, we had to rapidly experiment with new services to cater to a changed world.<br><br>

Our vision is to have one single app & platform that can help people and businesses move things smartly and at a low price.
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="courires-partner-details-box">
                        <div class="img-wrap"> <img src="{{asset('front_assets/')}}/images/004.png" class="w-100" alt=""></div>
                        <div class="courires-partner-content-box">
                            FedExand UPS operate 7.5 tonne vehicles as standard and so offer same day collection in many urban areas, even for large parcels. 
                        </div>
                    </div>
                </div>
                                <div class="col-lg-6 col-md-6">
                    <div class="courires-partner-details-box">
                        <div class="img-wrap"> <img src="{{asset('front_assets/')}}/images/005.png" class="w-100" alt=""></div>
                        <div class="courires-partner-content-box">
                            Greener freight logistics that helps your bottom line, the environment and community. Customizable solutions you can trust to fit the demands of your customers. Reliable logistics solutions to meet the ever-changing market needs of your business.
                        </div>
                    </div>
                </div>
                                                <div class="col-lg-6 col-md-6">
                    <div class="courires-partner-details-box">
                        <div class="img-wrap"> <img src="{{asset('front_assets/')}}/images/006.png" class="w-100" alt=""></div>
                        <div class="courires-partner-content-box">
                            PostaPlus was founded in 2005 and has since enjoyed balanced growth; evolving from a simple domestic courier company into a leading regional provider of global business, logistics and shipping solutions. We are a friendly and highly skilled team of specialists brought together by our desire to create a borderless world that curtails the barriers of trade for a seamless and convenient flow of parcels.
                        </div>
                    </div>
                </div>
                                                <div class="col-lg-6 col-md-6">
                    <div class="courires-partner-details-box">
                        <div class="img-wrap"> <img src="https://yallacourier.com/front_assets/images/naqel-express-logo-vector-removebg-preview.png" class="w-100" alt=""></div>
                        <div class="courires-partner-content-box">
                            NAQEL was founded in 2005 and has since enjoyed balanced growth; evolving from a simple domestic courier company into a leading regional provider of global business, logistics and shipping solutions. We are a friendly and highly skilled team of specialists brought together by our desire to create a borderless world that curtails the barriers of trade for a seamless and convenient flow of parcels.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- {{-- courires partner section End --}}
    {{-- How it work section start --}} -->
    <section class="usessection worksection">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_four_heading')->first(); @endphp
                    <div class="content-box-wrapper">
                      @if($meta)  <h2>{{ $meta->value }}</h2> @endif
                    </div>
                </div>
            </div>
            <div class="row courieruses">
            @for($i=1; $i<4; $i++)
                
                <div class="col-lg-4 courierusesmainwrapper">
                    <div class="useswrapper">
                        <figure class="usesimage">
                        @if(\App\Models\FileModel::where('ref_point','section_4_image_'.$i)->where('ref_id',$page->id)->count()==1)
                            @php $file=\App\Models\FileModel::where('ref_point','section_4_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
                            <img src="{{ asset($file->path.'/'.$file->name) }}" alt="">
                        @endif
                        </figure>
                        <div class="content-box-wrapper">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_title_'.$i)->first(); @endphp
                           @if($meta) <h4>{{ $meta->value }}</h4> @endif
                           @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_description_'.$i)->first(); @endphp
                           @if($meta)
                            <div>
                                {!! $meta->value !!}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endfor
            </div>
        </div>
    </section>

    <!-- {{-- How it work section end --}} -->
@endsection