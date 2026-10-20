@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)

@section('content')

<style>

.my-button {
  background-color: #04AA6D; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}

	
.my-button1 {
  padding: 17px 40px;
  padding-botton: 20px;	
  border-radius: 10px;
  border: 0;
  background-color: #5c3081;
  letter-spacing: 1.5px;
  font-size: 15px;
  transition: all 0.3s ease;
  box-shadow: #3e1b51 0px 10px 0px 0px;
  color: hsl(0, 0%, 100%);
  cursor: pointer;
}

.my-button1:hover {
  box-shadow: #3e1b51 0px 7px 0px 0px;
}

.my-button1:active {
  background-color: #3e1b51;
  /*50, 168, 80*/
  box-shadow: #03a53b 0px 0px 0px 0px;
  transform: translateY(5px);
  transition: 200ms;
}
	
	
	
	
.my-button2 {
  padding: 17px 40px;
  padding-botton: 20px;	
  border-radius: 10px;
  border: 0;
  background-color: #01ca46;
  letter-spacing: 1.5px;
  font-size: 15px;
  transition: all 0.3s ease;
  box-shadow: #3e1b51 0px 10px 0px 0px;
  color: hsl(0, 0%, 100%);
  cursor: pointer;
}

.my-button2:hover {
  box-shadow: #03a53b 0px 7px 0px 0px;
}

.my-button2:active {
  background-color: #3e1b51;
  /*50, 168, 80*/
  box-shadow: #03a53b 0px 0px 0px 0px;
  transform: translateY(5px);
  transition: 200ms;
}


</style>
    
    <!--New Banner Section Start-->
    <section class="home-banner-sec new-banner-sec luggage">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6">
                    <div class="contentbox">
                        <h1 class="banner-title" >Save 60% on International Courier Services</h1>
                       
						<p class="banner-short-description">
Take advantage of our bulk discounted partner rates with all leading couriers in UAE. Because Yalla sends 1000s of parcels a year via their networks they give us a favorable rate versus a single shipper.
</p>
					
						
						<a href="https://yallashipping.com/international/"><button class="my-button1">Get a Quote</button></a>
						<br><br>
						
                        <!--<p class="banner-short-description">Send parcels from the UAE to UAE or-->
                        <!--Internationally at great rates. With one click fast-->
                        <!--booking from your smartphone anytime.</p>-->
                        <!--<ul class="banner-list">-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Compare courier prices & pay less</span> </li>-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Save time and money</span> </li>-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>No sign up required</span> </li>-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Upto 40% discount on shipping rates</span> </li>-->
                        <!--</ul>-->
                        
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
		
							
							
	<iframe src="https://yallashipping.com/iframe-page/" style="border:none" height="800" width="100%" scrolling="no" title="Iframe Example"></iframe>

							
							
							
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
								<img src="{{ asset('front_assets/images/finalhowworkupdated.svg') }}" alt="Local and international courier service" class="text-center">
							</figure>
							
														<figure class="d-block d-lg-none">
								<img src="{{ asset('front_assets/images/Asset 13.svg') }}" alt="best courier service in Dubai" class="text-center">
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
                <h2>Most Popular International Courier Services</h2>
            </div>
            <div class="shipping-routes-wrapper">
                <div class="row">
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="Courier service to Qatar"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="International delivery to Qatar"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Qatar.svg')  }}" alt="International courier to Qatar"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to Qatar</h6>
                                <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="International delivery to Saudi"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="International Shipping to Saudi"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Saudi.svg')  }}" alt="International courier to Saudi"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to Saudi</h6>
                                <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="International courier to Oman"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Courier Service to Oman"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Oman.svg')  }}" alt="International delivery to Oman"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to Oman</h6>
                                <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="International delivery to kuwait"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="International shipping to kuwait"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/kuwait.svg')  }}" alt="Courier Service to kuwait"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to kuwait</h6>
                                <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="Courier Service to Bahrain"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Courier Delivery to Bahrain"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Bahrain.svg')  }}" alt="International Shipping to Bahrain"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to Bahrain</h6>
                                <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="Courier delivery to Lebanon"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="International shipping to Lebanon"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Lebanon.svg')  }}" alt="Courier Service to Lebanon"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to Lebanon</h6>
                                <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="International courier to Turkey"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Courier Service to Turkey"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Turkey.svg')  }}" alt="Couerier Service to Turkey"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to Turkey</h6>
                               <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="Couerier Service to Egypt"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Couerier Service to Egypt"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Egypt.svg')  }}" alt="International shipping to Egypt"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to Egypt</h6>
                                <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="International shipping to India"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Courier Service to India"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/India.svg')  }}" alt="Courier Service to India"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to India</h6>
                                <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="International shipping to Germany"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Courier Service to Europe"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/pakistan.svg')  }}" alt="Courier Service to Germany"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to Pakistan</h6>
                                <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="Courier Service to United Kingdom"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Courier Service to UK"/>
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/uk.svg')  }}" alt="Courier Service to UK"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to UK</h6>
                                <p>Express delivery 2/3 working days</p>
                            </div>
                        </div> 
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                        <div class="shipping-route-box">
                            <div class="flags-box-wrapper">
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="Courier Service to Dubai"/>
                                </div>
                                <span class="flag-separator">
                                    <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                                </span>
                                <div class="flagbox ship-from">
                                    <img src="{{ asset('front_assets/images/Germany.svg')  }}" alt="Courier Service to Germany"/>
                                </div>
                            </div>
                            <div class="shipping-route-content">
                                <h6>Courier Service to Germany</h6>
                                <p>Express delivery 2/3 working days</p>
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
                        <img src="{{ asset($file->path.'/'.$file->name) }}" alt="International shipping from Dubai" style="width: 100px; height: 100px; text-align: center; display: block; margin: 25px auto;">
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
			<img src="{{ asset($file->path.'/'.$file->name) }}" alt="Courier Service Dubai" class="banner-img">
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
                    <h4>Local Courier Service within the UAE</h4> 
                    <div class="content-box"> 
                    <p>				
Whether you're sending parcels from Dubai to Abu Dhabi, Ajman, Deira or to Downtown Dubai Yalla courier provides a fast cost efficient reliable courier delivery service for you to enjoy. We have negotiated the very best rates with Fedex, UPS and Emirates post, simple choose your courier service and create your shipment in 3 simple steps.
</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-1.svg
') }}" class="w-100" alt="International delivery Dubai">
                </div>
            </div> 
        </div> 
        <div class="row  justify-content-between">
            <div class="col-lg-6 col-md-6"> 
                <div class="delivery-detals-box">
                    <h4>International Courier Service</h4> 
                    <div class="content-box"> 
                    <p>
Yalla Courier offers reliable international courier services, featuring both express and standard delivery options that are fully tracked and insured. This means that if you're sending high-value items, you can rest assured that your parcel is safe and secure throughout its journey. We pride ourselves on providing the best international shipping rates from the UAE to destinations worldwide, whether you opt for air, road, or sea shipping. Your satisfaction and peace of mind are our top priorities!
						</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-2.svg') }}" class="w-100" alt="Best courier service in Dubai">
                </div>
            </div> 
        </div>
        <div class="row  justify-content-between">
            <div class="col-lg-6 col-md-6"> 
                <div class="delivery-detals-box">
                    <h4>Large parcel courier service - best local and international shipping rates</h4> 
                    <div class="content-box"> 
                    <p>Yalla Courier specialises in large parcel delivery, offering competitive local and international shipping rates. Whether you're sending bulky items domestically or abroad, we ensure your parcels are handled with care and delivered efficiently. Choose our courier service to enjoy reliable service and peace of mind with our fully tracked and insured options. Choose us for your large parcel courier service needs!</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-3.svg') }}" class="w-100" alt="Courier service Dubai">
                </div>
            </div> 
        </div> 
        <div class="row  justify-content-between">
            <div class="col-lg-6 col-md-6"> 
                <div class="delivery-detals-box">
                    <h4>Pick up and drop off service available at Mercato Shopping Mall Dubai</h4> 
                    <div class="content-box"> 
                    <p>
						If you’re looking to avoid the wait for parcel pickup, Yalla Courier offers a convenient pack and ship service at Mercato Shopping Mall. Just bring your item to our kiosk, and we’ll handle everything for you! We’ll select the right box, securely package your item, weigh it, and ship it—all in one place. Plus, our local and international courier services ensure you receive the best discount delivery rates. Experience hassle-free shipping with us!
						
						</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-4.svg') }}" class="w-100" alt="same day delivery or standard next day courier service">
                </div>
            </div> 
        </div> 
        <div class="row  justify-content-between">
            <div class="col-lg-6 col-md-6"> 
                <div class="delivery-detals-box">
                    <h4>UAE Express same day delivery or standard next day courier service</h4> 
                    <div class="content-box"> 
                    <p>
If you're in a hurry, we offer fast and reliable same day collection and next-day delivery across the Dubai Courier Service with FedEx, UPD, Careem and Shipa Delivery. Our courier service also offers offer next day delivery across Dubai and the UAE for parcels up to 25kg. What's more they come with 3 free collection attempts and 3 free delivery attempts! How’s that for value? 
						
						</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-5.svg') }}" class="w-100" alt="International courier service">
                </div>
            </div> 
        </div> 
    </div>
</section>
 <!--{{-- delivery section end --}}-->




















 <!--UAE parcel delivery made easy section start  -->

<section class="parcel-sec usessection our-courier-services-sec">
    <div class="container ">
        <div class="sec-title text-center"> 
            <h2>About Yalla Courier</h2> 
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
                    <h4>Dubai's Local and International Courier Service</h4> 
                    <div class="content-box"> 
                    <p>				
Yalla Courier is working with leading couriers in the UAE such as Aramex, FedEx, Emirates Post only offer greatly discounts rates to businesses that send 50+ parcels per day so we felt we needed to change this. 
<br><br>
Yalla Courier has access to exclusive courier rates based on large volumes meaning even if you only send 1 parcel per month you pay the same as if you send 500 per month. YALLA. 
<br><br>
Whether you need fast express delivery, or a cheap postal service that takes a little longer to deliver, we’ve got you covered with reliable worldwide delivery from the best global couriers.
</p>
                    </div>
                </div>
            </div> 
            <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                    <img src="{{ asset('front_assets/images/courier-services-1.svg
') }}" class="w-100" alt="Courier service Dubai">
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
							<img src="{{ asset($file->path.'/'.$file->name) }}" alt="International Courier Service from Dubai">
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
			
			<div class="trustpilot mt-4 text-center">	<img src="{{asset('front_assets/')}}/images/trustpilotupdated.svg" alt="Parcel delivery service - Yalla Courier" class="trustindex"></div>
			<div class="row testimonialsrow">
				<div class="col-12">
					<div class="testimonialwrapper">
						@foreach(\App\Models\ReviewModel::where('show_on_home',1)->where('status',1)->get() as $review)
						<div class="single-testimonials">
							<div class="topquotes">
								<img src="{{asset('front_assets/')}}/images/tpupdated.svg" alt="Courier service Dubai" class="quotes">
								<img src="{{asset('front_assets/')}}/images/starupdated.svg" alt="Courier from Dubai" class="stars">
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
							<img class="img-fluid" src="{{ asset($file->path.'/'.$file->name) }}" alt="Internatioanl courier">
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
<h2>Our Courier Delivery Partners</h2>
						
Send your parcels with trusted courier delivery partners, whether you require international shipping or a local courier service. Our courier partners provide a trusted fully tracked delivery service. 
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
