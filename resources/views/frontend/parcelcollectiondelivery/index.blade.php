@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)
@section('content')

<!-- {{-- innner banner section start --}} -->
    


    <!--New Banner Section Start-->
    <section class="home-banner-sec new-banner-sec luggage">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6">
                    <div class="contentbox">
                        <h1 class="banner-title" >Send your parcels door to door from Abu Dhabi 26.00 AED</h1>
                        <h4 class="banner-title">Abu Dhabi and International courier service</h4>
                        <!--<p class="banner-short-description">Send parcels from the UAE to UAE or-->
                        <!--Internationally at great rates. With one click fast-->
                        <!--booking from your smartphone anytime.</p>-->
                        <!--<ul class="banner-list">-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Compare courier prices & pay less</span> </li>-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Save time and money</span> </li>-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>No sign up required</span> </li>-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Upto 40% discount on shipping rates</span> </li>-->
                        <!--</ul>-->
                        <div class="rating-box">
                            <img class="img-fluid banner-ratings d-block" src="{{ asset('front_assets/images/rating-stars.svg') }}" alt="Courier Service" />
                            <span class="rating-text"><b>Over 47,000 parcels sent</b></span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-6">
                    <div class="imgbox">
                        <img class="w-100" src="{{ asset('front_assets/images/finalbannerimage.png') }}" alt="International Courier" />
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--New Banner Section End-->
    
	<!-- Banner Section Starts -->
	<section class="banner-section topban d-none" id="banner">
		@if(\App\Models\FileModel::where('ref_point','home_banner_background')->where('ref_id',$page->id)->count()==1)
			@php $file=\App\Models\FileModel::where('ref_point','home_banner_background')->where('ref_id',$page->id)->first(); @endphp
			<img src="{{ asset($file->path.'/'.$file->name) }}" alt="DHL Near Me" class="banner-img">
		@endif
		<div class="container">
			<div class="row">
				<div class="col-6">
					<div class="content-box-wrapper">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','banner_text')->first(); @endphp
						@if($meta)<h1>{{ $meta->value }}</h1> @endif
					</div>

				</div>
			</div>

		</div>
	</section>






    <section class="banner-section innerpagebannerform" id="banner">
		<div class="container">
			<div class="row">
				<div class="col-12">

					<div class="row">
						<div class="col-12 parcel-collection-delivery">
                            @include('frontend.searchcourier.index') 
						</div>

					</div>
				</div>
			</div>

		</div>
	</section>
    <!-- {{-- innner banner section End --}}
    {{-- Parcel Collection and Delivery section start --}} -->
    <section class="parcel-collection usessection">
        <div class="container">
            <div class="sec-title text-center">
                <h2>@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_heading')->first(); @endphp
                    @if($meta) {{ $meta->value }} @endif
                </h2>
                <div class="parcel-collection-content-box">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_text')->first(); @endphp
                    @if($meta) {!! $meta->value !!} @endif
                </div>
            </div>
            <div class="parcel-delivery-logo d-flex justify-content-between align-items-center ">
                <div class="parcel-logo">
                    <img src="{{ asset('front_assets/images/parcel-delivery-1.svg') }}" class="w-100" alt="">
                </div>
                <div class="parcel-logo">
                    <img src="{{ asset('front_assets/images/parcel-delivery-2.svg') }}" class="w-100" alt="">
                </div>
                <div class="parcel-logo">
                    <img src="{{ asset('front_assets/images/parcel-delivery-3.svg') }}" class="w-100" alt="">
                </div>
                <div class="parcel-logo">
                    <img src="{{ asset('front_assets/images/parcel-delivery-4.svg') }}" class="w-100" alt="">
                </div>
                <div class="parcel-logo">
                    <img src="{{ asset('front_assets/images/parcel-delivery-5.svg') }}" class="w-100" alt="">
                </div>

            </div>
        </div>
    </section>
    <!-- {{-- Parcel Collection and Delivery section End --}}
    {{-- courires collection setion start --}} -->
    <section class="courier-collection usessection">
        <div class="container">
            <div class="sec-title text-center">
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_two_heading')->first(); @endphp
                <h2>@if($meta) {{ $meta->value }} @endif</h2>
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_two_short_description')->first(); @endphp
                <div class="collection-content-box">
                @if($meta) {{ $meta->value }} @endif
                </div>
            </div>
            <div class="courires-collection-list">
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_two_description')->first(); @endphp
            @if($meta) {!! $meta->value !!} @endif
            </div>
        </div>
    </section>
    <!-- {{-- courires collection setion start --}}
    {{-- Requesting a Collection Time section start --}} -->
    <section class="request-collection usessection">
        <div class="container">
            <div class="sec-title text-center">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_heading')->first(); @endphp
                <h2>@if($meta) {{ $meta->value }} @endif</h2>
            </div>
            <div class="request-content-box">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_description')->first(); @endphp
                @if($meta) {!! $meta->value !!} @endif
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <div class="request-collect-address-box">
                        <div class="box-title text-center">
                            <h4>  @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_heading_one')->first(); @endphp
                            @if($meta) {{ $meta->value }} @endif

                            </h4>
                        </div>
                        <div class="requesting-content-box">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_description_one')->first(); @endphp
                            @if($meta) {!! $meta->value !!} @endif
                        </div>

                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="request-collect-address-box">
                        <div class="box-title text-center">
                            <h4> @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_heading_two')->first(); @endphp
                            @if($meta) {{ $meta->value }} @endif
                            </h4>
                        </div>
                        <div class="requesting-content-box">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_description_two')->first(); @endphp
                            @if($meta) {!! $meta->value !!} @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- {{-- Requesting a Collection Time section End --}}
    {{-- Booking a Parcel Collection from abroad section start --}} -->
    <section class="booking-collection usessection">
        <div class="container">
            <div class="sec-title text-center">
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_four_heading')->first(); @endphp
                <h2>@if($meta) {{ $meta->value }} @endif</h2>
            </div>
            <div class="booking-collection-content-box">
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_four_decription')->first(); @endphp
            @if($meta) {!! $meta->value !!} @endif
            </div>
            @for($i=1; $i<2; $i++)
            <div class="yallaCourier-recommends-box">
                <h4>@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_title_'.$i)->first(); @endphp
                @if($meta) {{ $meta->value }} @endif</h4>
                <div class="couries-recommed-box">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_description_'.$i)->first(); @endphp
                @if($meta) {!! $meta->value !!} @endif
                </div>
            </div>
            @endfor

            <div class="failed-collection-box">

                @for($i=2; $i<5; $i++)
                <div class="failed-Collections-wrapper">
                    <h4>@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_title_'.$i)->first(); @endphp
                    @if($meta) {{ $meta->value }} @endif</h4>
                    <div class="faied-collection-content-box">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_description_'.$i)->first(); @endphp
                    @if($meta) {!! $meta->value !!} @endif
                    </div>
                </div>
                @endfor

            </div>
            <!-- {{-- box --}} -->
        </div>
    </section>
    <!-- {{-- Booking a Parcel Collection from abroad section End --}}
    {{-- Labels and Paperwork section start --}} -->
    <section class=" lable-paper-sec usessection">
        <div class="container">
            <div class="sec-title text-center">
                <h2>@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_five_heading')->first(); @endphp @if($meta) {{ $meta->value }} @endif </h2>

            </div>
            <div class="label-paper-content-box">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_five_decription')->first(); @endphp
                @if($meta) {!! $meta->value !!} @endif
            </div>
            <div class="row">
            @for($i=1; $i<4; $i++)
                <div class="col-lg-4">
                    <div class="affixing-labels-parcel-box">
                        <div class="affixing-labels-parcel-heading">
                            <h4>
                                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_5_title_'.$i)->first(); @endphp
                                @if($meta) {{ $meta->value }} @endif
                            </h4>

                        </div>
                        <div class="affixing-lables-content-box">
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_5_description_'.$i)->first(); @endphp
                            @if($meta) {!! $meta->value !!} @endif
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>
    <!-- {{-- Labels and Paperwork section End --}}
    {{-- Courier Delivery section start --}} -->
    <section class="courier-delivery usessection">
        <div class="container">
            <div class="sec-title text-center">
                <h2> @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_six_heading')->first(); @endphp
                @if($meta) {{ $meta->value }} @endif
                </h2>
            </div>
            <div class="courier-delivery-content-box">
                 @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_six_decription')->first(); @endphp
                 @if($meta) {!! $meta->value !!} @endif

            </div>
            <!-- {{-- box --}} -->

            <div class="uk-parcel-delivery-box">
            @for($i=1; $i<4; $i++)
                <div class="uk-parcel-delivery-wrapper">
                    <h4>@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_6_title_'.$i)->first(); @endphp
                    @if($meta) {{ $meta->value }} @endif
                    </h4>
                    <div class="uk-parcel-delivery-content-box">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_6_description_'.$i)->first(); @endphp
                    @if($meta) {!! $meta->value !!} @endif
                    </div>
                </div>
                @endfor
            </div>
            @for($i=4; $i<5; $i++)
            <div class="yallaCourier-recommends-box">
                <h4>@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_6_title_'.$i)->first(); @endphp
                @if($meta) {{ $meta->value }} @endif
                </h4>
                <div class="couries-recommed-box">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_6_description_'.$i)->first(); @endphp
                    @if($meta) {!! $meta->value !!} @endif
                </div>
            </div>
            @endfor
        </div>
    </section>
    <!-- {{-- Courier Delivery section End --}} -->
    <div class="delivery-tracking usessection">
        <div class="container">
            <div class="sec-title text-center">
                <h2>@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_seven_heading')->first(); @endphp @if($meta) {{ $meta->value }} @endif </h2>
            </div>
            <div class="delivery-tracking-content-box">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_seven_decription')->first(); @endphp
                @if($meta) {!! $meta->value !!} @endif
            </div>
            @for($i=1; $i<2; $i++)
            <div class="delivery-information-wrapper">
                <h4>@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_7_title_'.$i)->first(); @endphp
                @if($meta) {{ $meta->value }} @endif
                </h4>
                <div class="delivery-information-content-box">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_7_description_'.$i)->first(); @endphp
                @if($meta) {!! $meta->value !!} @endif
                </div>
            </div>
            @endfor
        </div>
    </div>
@endsection