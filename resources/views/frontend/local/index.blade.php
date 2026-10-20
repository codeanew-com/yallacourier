@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)

@section('content')
    
    <!--New Banner Section Start-->
    <section class="home-banner-sec new-banner-sec luggage">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6">
                    <div class="contentbox">
                        <h1 class="banner-title" >Send your parcel with great rates door to door</h1>
                        <h4 class="banner-title">UAE and International courier service</h4>
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

	<!-- Banner Section Starts -->
	<section class="banner-section extraban newcssbanner" id="banner">

		<div class="container">
			<div class="row">
				<div class="col-12">

					<div class="row">
						<div class="col-12"> 
								@include('frontend.searchcourier.index') 
							</div>
						</div>

				</div>
			</div>

		</div>
	</section>

	<!-- section 1 starts -->
	
	<!--	<section class="sectionadvertisement">-->
	<!--	<div class="container">-->
	<!--		<div class="row">-->
	<!--			<div class="col-12">-->
	<!--				<div class="content-wrapper">-->
	<!--					@if(\App\Models\FileModel::where('ref_point','section_one_image')->where('ref_id',$page->id)->count()==1)-->
	<!--					@php $file=\App\Models\FileModel::where('ref_point','section_one_image')->where('ref_id',$page->id)->first(); @endphp-->
	<!--						<figure>-->
	<!--							<img src="{{ asset($file->path.'/'.$file->name) }}" alt="" class="text-center">-->
	<!--						</figure>-->
	<!--					@endif-->
	<!--					<div class="content-box-wrapper text-center">-->
	<!--						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_heading')->first(); @endphp-->
	<!--						@if($meta)<h2>{{ $meta->value }}</h2> @endif-->
	<!--						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_text')->first(); @endphp-->
	<!--						@if($meta)<div>{{ $meta->value }}</div> @endif-->
	<!--					</div>-->
	<!--				</div>-->
	<!--			</div>-->
	<!--		</div>-->
	<!--	</div>-->
	<!--</section>-->

    <section class="sectionadvertisement newhowworkhome">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content-box-wrapper text-center">
                    <h3 class="lap-version">Yalla Courier in the News</h3>
                    <h2 class="mob-version">Yalla Courier in the News</h2>
                    
							<p>Click logo below to view more<a href="https://www.khaleejtimes.com/uae/uae-traffic-surge-in-demand-for-local-deliveries-even-10-min-drive-away-say-courier-firms?amp=1" target="_blank"></a></p>
																		 
						
						<a href="https://www.khaleejtimes.com/uae/uae-traffic-surge-in-demand-for-local-deliveries-even-10-min-drive-away-say-courier-firms?amp=1" target="_blank">
                        
                        <img src="{{ asset('front_assets/images/Khaleej-w.svg') }}" alt="Courier Service" class="text-center" width="400px" style="width: 250px !important;margin-top: 15px;">
                    </a>
						
					
                    
                    </div>
                </div>
            </div>
        </div>
    </section>

	<section class="sectionadvertisement newhowworkhome" style="padding-top: 50px;">
		<div class="container">
			<div class="row">
				<div class="col-12">
				    						<div class="content-box-wrapper text-center">
						<h2>How it works</h2>
						<div>Create your shipments in <b>5</b> easy steps</div>
						
						</div>
					<div class="content-wrapper mt-5">
					
							<figure class="d-none d-lg-block">
								<img src="{{ asset('front_assets/images/finalhowworkupdated.svg') }}" alt="" class="text-center">
							</figure>
							
														<figure class="d-block d-lg-none">
								<img src="{{ asset('front_assets/images/Asset 13.svg') }}" alt="" class="text-center">
							</figure>
			

					</div>
				</div>
			</div>
		</div>
	</section>
    
     
    
    <!--Shipping Routes Section Start -->
    <section class="shipping-routes-sec usessection">
        <div class="container">
            <div class="content-box-wrapper">
                <h2>Popular International Shipping Routes</h2>
            </div>
            <div class="shipping-routes-wrapper">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Qatar.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to Qatar</h6>
                                <p>Estimated transit time 2/5 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Saudi.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to Saudi</h6>
                                <p>Estimated transit time 2/5 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Oman.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to Oman</h6>
                                <p>Estimated transit time 2/5 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/kuwait.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to kuwait</h6>
                                <p>Estimated transit time 2/5 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Bahrain.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to Bahrain</h6>
                                <p>Estimated transit time 2/5 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Lebanon.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to Lebanon</h6>
                                <p>Estimated transit time 3/7 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Turkey.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to Turkey</h6>
                                <p>Estimated transit time 3/7 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Egypt.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to Egypt</h6>
                                <p>Estimated transit time 3/7 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/India.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to India</h6>
                                <p>Estimated transit time 3/7 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/pakistan.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to Pakistan</h6>
                                <p>Estimated transit time 3/7 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/uk.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to UK</h6>
                                <p>Estimated transit time 3/7 days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Germany.svg')  }}" />
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier to Germany</h6>
                                <p>Estimated transit time 3/7 days</p>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--Shipping Routes Section End -->
    
	<!-- section 2 starts -->
	<section class="usessection">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="content-box-wrapper">
					<!--@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_four_heading')->first(); @endphp-->
					<!--@if($meta) <h2> {{$meta->value}} </h2> @endif-->
					<h2>Why use Yalla Courier?</h2>
					</div>
				</div>
			</div>
			<div class="row courieruses">
			@for($i=1; $i<4; $i++)

				<div class="col-lg-4 col-md-4 col-sm-6 courierusesmainwrapper">
					<div class="useswrapper">
					@if(\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->count()==1)
					@php $file=\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
                        <img src="{{ asset($file->path.'/'.$file->name) }}" alt="" style="width: 100px; height: 100px; text-align: center; display: block; margin: 25px auto;">
					@endif
						<div class="content-box-wrapper">
							@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_title_'.$i)->first(); @endphp
							@if($meta)<h4>{{ $meta->value }}</h4> @endif
							@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_description_'.$i)->first(); @endphp
							@if($meta)<div>
								 {!! $meta->value !!} 
							</div>@endif
						</div>
					</div>
				</div>
			@endfor

			</div>
		</div>
	</section>

	<!-- section 3 starts -->
	<section class="discountbanner">
		@if(\App\Models\FileModel::where('ref_point','section_three_image')->where('ref_id',$page->id)->count()==1)
		@php $file=\App\Models\FileModel::where('ref_point','section_three_image')->where('ref_id',$page->id)->first(); @endphp
			<img src="{{ asset($file->path.'/'.$file->name) }}" alt="banner-img" class="banner-img">
		@endif
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-7 col-12">
					<div class="content-bx-wrapper">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_heading')->first(); @endphp
						@if($meta)<h2 style="    max-width: 88%;">{{ $meta->value }}</h2> @endif

						<div class="button-holder">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_cta_text')->first(); @endphp
						@php $meta1=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_cta_action')->first(); @endphp
							@if($meta && $meta1)<a href="{{ $meta1->value }}" class="purple-theme-btn"><span>{{ $meta->value }}</span></a> @endif
						</div>

					</div>
				</div>
			</div>
		</div>
	</section>

 <!--UAE parcel delivery made easy section start  -->

<section class="parcel-sec usessection our-courier-services-sec">
    <div class="container ">
        <div class="sec-title text-center"> 
            <h2>Our Courier services</h2> 
        </div>
    </div>
</section>
 <!---- UAE parcel delivery made easy section end ---->
<!--{{-- delivery section start --}} --> 
<section class="delivery-sec usessection our-courier-services-list-sec ">
    <div class="container"> 
        <div class="row justify-content-between">
            <div class="col-lg-6 col-md-6"> 
                <div class="delivery-detals-box">
                    <h4>UAE Delivery from AED 12.90</h4> 
                    <div class="content-box"> 
                    <p>				
Send parcels in UAE or internationally with great rates every time. Create your shipment in 3 simple steps.
</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-1.svg
') }}" class="w-100" alt="">
                </div>
            </div> 
        </div> 
        <div class="row  justify-content-between">
            <div class="col-lg-6 col-md-6"> 
                <div class="delivery-detals-box">
                    <h4>International Delivery from AED 189.00</h4> 
                    <div class="content-box"> 
                    <p>Whether you need fast express delivery, or a cheap postal service that takes a
little longer to deliver, we’ve got you covered with reliable worldwide delivery
from the best global couriers.</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-2.svg') }}" class="w-100" alt="">
                </div>
            </div> 
        </div>
        <div class="row  justify-content-between">
            <div class="col-lg-6 col-md-6"> 
                <div class="delivery-detals-box">
                    <h4>Large Parcel Delivery from AED 39.00</h4> 
                    <div class="content-box"> 
                    <p>Shipping a large item, sending a heavy parcel, or need to transport a pallet of
freight? We’ll help you find a specialist large and heavy courier for your
delivery.</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-3.svg') }}" class="w-100" alt="">
                </div>
            </div> 
        </div> 
        <div class="row  justify-content-between">
            <div class="col-lg-6 col-md-6"> 
                <div class="delivery-detals-box">
                    <h4>Don’t wait home all day, drop off anytime</h4> 
                    <div class="content-box"> 
                    <p>Use our convenient UAE drop-off service. Leave your parcel at any one of
thousands of local drop-shops across the UAE, through our delivery partners;
Fetchr, UPS, FedEx and Naqel Express.</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-4.svg') }}" class="w-100" alt="">
                </div>
            </div> 
        </div> 
        <div class="row  justify-content-between">
            <div class="col-lg-6 col-md-6"> 
                <div class="delivery-detals-box">
                    <h4>We have a service for every budget</h4> 
                    <div class="content-box"> 
                    <p>Our clever technology makes it easy to compare prices and delivery times for
different couriers and service levels, from express and timed delivery for
urgent shipments, to economy and super economy services for less time
sensitive shipment.</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-5.svg') }}" class="w-100" alt="">
                </div>
            </div> 
        </div> 
    </div>
</section>
 <!--{{-- delivery section end --}}-->

	<!-- section 4 starts -->
	<section class="usessection worksection">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="content-box-wrapper">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_four_heading')->first(); @endphp
						@if($meta)<h2>{{ $meta->value }}</h2> @endif
					</div>
				</div>
			</div>
			<div class="row courieruses">

			@for($i=1; $i<4; $i++)

				<div class="col-lg-4 col-md-4 col-sm-6 courierusesmainwrapper">
					<div class="useswrapper">
					@if(\App\Models\FileModel::where('ref_point','section_4_image_'.$i)->where('ref_id',$page->id)->count()==1)
					@php $file=\App\Models\FileModel::where('ref_point','section_4_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
						<figure class="usesimage">
							<img src="{{ asset($file->path.'/'.$file->name) }}" alt="">
						</figure>
					@endif
						<div class="content-box-wrapper">
							@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_title_'.$i)->first(); @endphp
							@if($meta)<h4>{{ $meta->value }}</h4> @endif
							@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_description_'.$i)->first(); @endphp
							@if($meta)<div>
								{!! $meta->value !!} 
							</div>@endif
						</div>
					</div>
				</div>
			@endfor

			</div>
		</div>
	</section>

	<!-- section 5 starts -->
	<section class="testimonialsection newchngetesthome">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="content-box-wrapper text-center">
					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_five_heading')->first(); @endphp
					@if($meta)<h2>{{ $meta->value }}</h2>@endif
					</div>
				</div>
			</div>
			
			<div class="trustpilot mt-4 text-center">	<img src="{{asset('front_assets/')}}/images/trustpilotupdated.svg" alt="" class="trustindex"></div>
			<div class="row testimonialsrow">
				<div class="col-12">
					<div class="testimonialwrapper">
						@foreach(\App\Models\ReviewModel::where('show_on_home',1)->where('status',1)->get() as $review)
						<div class="single-testimonials">
							<div class="topquotes">
								<img src="{{asset('front_assets/')}}/images/tpupdated.svg" alt="" class="quotes">
								<img src="{{asset('front_assets/')}}/images/starupdated.svg" alt="" class="stars">
							</div>
							<div class="middle-testimonial">
								<div class="content-box">
									{!! $review->review !!}
								</div>
							</div>
							<div class="bottom-testomnialperson">
								<!--<div class="image-testimonial">-->
								<!--@if(\App\Models\FileModel::where('ref_point','author_image')->where('ref_id',$review->id)->count()==1)-->
								<!--@php $file=\App\Models\FileModel::where('ref_point','author_image')->where('ref_id',$review->id)->first(); @endphp-->
								<!--	<img src="{{ asset($file->path.'/'.$file->name) }}" alt="">-->
								<!--@endif-->
								<!--</div>-->
								<div class="testimonialdetails">
									<div class="personname"><span>{{ $review->author_name }}</span> </div>
									{{ $review->author_designation }}
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
			</div>
		</div>
	</section>

	<!-- section 6 starts -->
	<section class="parcelbanner">
		<div class="container">
			<div class="row align-items-end">
				<div class="col-lg-6 col-md-6 col-sm-7">
					<div class="content-box-wrapper">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_six_heading')->first(); @endphp
						@if($meta) <h2>{{ $meta->value }}</h2> @endif
						<div class="button-holder">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_six_cta_text')->first(); @endphp
						@php $meta1=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_six_cta_link')->first(); @endphp
						@if($meta && $meta1)	<a href="{{ $meta1->value }}" class="green-theme-btn"><span>{{ $meta->value }}</span></a> @endif
						</div>
					</div>
				</div>
				@if(\App\Models\FileModel::where('ref_point','section_6_image')->where('ref_id',$page->id)->count()==1)
                @php $file=\App\Models\FileModel::where('ref_point','section_6_image')->where('ref_id',$page->id)->first(); @endphp
				<div class="col-lg-6 col-md-6 col-sm-5">
					<div class="image-wrapper">
						<figure class="phoneimage">
							<img class="img-fluid" src="{{ asset($file->path.'/'.$file->name) }}" alt="">
						</figure>
					</div>
				</div>
				@endif
			</div>
		</div>
	</section>

	<!-- section 7 starts -->
	<section class="faqsection">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="content-box-wrapper text-center">
					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_seven_heading')->first(); @endphp
					@if($meta)	<h2>{{$meta->value}}</h2> @endif
					</div>
					<div class="faq-wrapper">
						<div class="accordion">
							@foreach(\App\Models\FaqModel::where('show_on_home',1)->where('status',1)->get() as $faq)
							<div class="accordion__item">
								<div class="accordion__title">
									<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
									<h4 class="accordion__title-text">{{ $faq->question }}</h4>
								</div>
								<div class="accordion__content">
									{!! $faq->answer !!}
								</div>
							</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
	</section>
	
			<!-- section 8 starts -->
	<section class="faqsection logoclient pt-0">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="content-box-wrapper text-center">
<h2>Our Delivery Partners</h2>
						
Send your parcel with trusted delivery companies
					</div>
					<div class="Logowrap">
                        <div class="singleimage"><div class="imgwrap"><img src="{{asset('front_assets/')}}/images/ups.svg"></div></div>
                        <div class="singleimage"><div class="imgwrap"><img src="{{asset('front_assets/')}}/images/jt.svg"></div></div>
                        <div class="singleimage"><div class="imgwrap"><img src="{{asset('front_assets/')}}/images/shipa.svg"></div></div>
                      
                        <div class="singleimage"><div class="imgwrap"><img src="{{asset('front_assets/')}}/images/shyftd.svg"></div></div>
                        <div class="singleimage"><div class="imgwrap"><img src="{{asset('front_assets/')}}/images/aramex.svg"></div></div>
                        <div class="singleimage"><div class="imgwrap"><img src="{{asset('front_assets/')}}/images/posta.svg"></div></div>
					</div>
				</div>
			</div>
	</section>


@endsection
