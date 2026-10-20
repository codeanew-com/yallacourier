@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)

@section('content')

<!--New Banner Section Start-->
<section class="home-banner-sec new-banner-sec ycd-banner-sec">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6 col-md-6">
				<div class="contentbox">
					<h1 class="banner-title">Send parcels
						with Aramex and save upto 40%
						</h1>
					<p class="banner-short-description">Take advantage of our bulk discounted Aramex rates on all shipping from UAE. Because Yalla sends 1000s of parcels a year via their networks they give us a favorable rate versus a single shipper.</p>
					<!--<ul class="banner-list">-->
					<!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Compare courier prices & pay less</span> </li>-->
					<!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Save time and money</span> </li>-->
					<!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>No sign up required</span> </li>-->
					<!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Upto 40% discount on shipping rates</span> </li>-->
					<!--</ul>-->
					<div class="rating-box">
						<img class="img-fluid banner-ratings d-block" src="{{ asset('front_assets/images/rating-stars.svg') }}" />
						<span class="rating-text">Over 47,000 parcels sent</span>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="imgbox">
					<img class="w-100" src="{{ asset('front_assets/images/ycd-banner2.svg') }}" />
				</div>
			</div>
		</div>
	</div>
</section>
<!--New Banner Section End-->

<!-- Search Form Section Start -->
<section class="banner-section extraban ycd-form-sec" id="banner">
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
<!-- Search Form Section End -->

<!-- Sending Parcel Section Start  -->
<section class="sectionadvertisement landing_eadv sending-parcel-sec">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-wrapper">
					<figure>
						<img src="{{ asset('front_assets/images/ycd-banner1.svg') }}" alt="" class="text-center">
					</figure>
					<div class="content-box-wrapper text-center">
						<h2>Sending parcels with Aramex</h2>
						<div>
							<p>Aramex offers an exceptional customer experience, with same day collection and reliable delivery. Whether you want to compare Aramexprices, send a
								parcel, track a Aramex shipment, or find Aramex contact information for the country you’re shipping to, you can do it all with Yalla Courier.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- Sending Parcel Section End  -->

<section class="usessection worksection deliversection yc-delivers-more-sec">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper">
					<h2>Yalla Courier delivers more</h2>
				</div>
			</div>
		</div>
		<div class="row courieruses">
			<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper">
					<img src="{{ asset('front_assets/images/ycd-icon1.svg') }}" alt="" style="width: 100px;height: 100px;text-align: center;display: block;margin: 25px auto;">
					<div class="content-box-wrapper">
						<h5>Package insurance available</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper">
					<img src="{{ asset('front_assets/images/ycd-icon2.svg') }}" alt="" style="width: 100px;height: 100px;text-align: center;display: block;margin: 25px auto;">
					<div class="content-box-wrapper">
						<h5>Collection or drop-off at a local shop anytime</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper">
					<img src="{{ asset('front_assets/images/ycd-icon3.svg') }}" alt="" style="width: 100px;height: 100px;text-align: center;display: block;margin: 25px auto;">
					<div class="content-box-wrapper">
						<h5>Track your parcel from door-to-door</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper">
					<img src="{{ asset('front_assets/images/ycd-icon4.svg') }}" alt="" style="width: 100px;height: 100px;text-align: center;display: block;margin: 25px auto;">
					<div class="content-box-wrapper">
						<h5>Send bulky or heavy items weighing up to 1,000kg</h5>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<!--UAE parcel delivery made easy section start  -->

<section class="parcel-sec usessection our-courier-services-sec landing_eparcel">
	<div class="container ">
		<div class="sec-title text-center">
			<h2>Ship cheaply with Aramex</h2>
		</div>
	</div>
</section>
<!---- UAE parcel delivery made easy section end ---->
<!--{{-- delivery section start --}} -->
<section class="delivery-sec usessection our-courier-services-list-sec landing_edelivery">
	<div class="container"> 
	<div class="row  justify-content-between">
				<div class="col-lg-6 col-md-6"> 
					<div class="delivery-detals-box">
						<h4>Aramex 2-day International delivery from AED 119.00</h4> 
						<div class="content-box"> 
							<p>Aramex's 2-day international delivery service is designed for urgent shipments
                            that need to reach their destination quickly. Here are some key details about
                            this service: </p>
                            <p>
                            <b>Speed:</b> As the name suggests, this service aims to deliver parcels within two
                            business days, depending on the origin and destination. 
                            </p> 
                            <p>
                            <b>Coverage:</b> Check the specific countries and regions that are eligible for 2-day
                            delivery, as this service may not be available for all locations.
                            </p>
                            <p>
                            <b>Weight and Size Limits:</b> There are weight and size restrictions, so make sure
                            your parcel complies with these limits.
                            </p>
                            <p>
                            <b>Tracking:</b> You can track your shipment in real-time, allowing you to stay
                            updated on its status. 
                            </p>
                            <p>
                            <b>Customs Clearance:</b> Aramex handles customs procedures, but you'll need to
                            provide the necessary documentation for a smooth process.
                            </p>
                            <p>
                            <b>Cost:</b> The cost for 2-day international delivery may vary based on factors such
                            as weight, size, and destination. It's advisable to get a quote through their
                            website or customer service.
                            </p>
                            <p>
                            <b>Packaging:</b> Ensure that your parcel is securely packaged to withstand
                            international transit.</p>
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
						<h4>Send parcels next day UAE-UAE with Aramex from only AED 15.00</h4> 
						<div class="content-box"> 
							<p>If you hail from UAE, you’ll know what an amazing job Aramex do, delivering
                            across a huge landmass. Our Aramex service offers FastTrack customs
                            clearance and is great value if you’re not in a hurry. Delivery takes around a
                            week longer than most other couriers, but this is offset by the reduced
                            customs delays. If you’re sending a personal shipment, Aramex is a great
                            option.</p>
						</div>
					</div>
				</div> 
				<div class="col-lg-5 col-md-6">
					<div class="delivery-details-img">
						<img src="{{ asset('front_assets/images/Shipcheaply2.svg') }}" class="w-100" alt="">
					</div>
				</div> 
			</div> 
			<div class="row  justify-content-between">
				<div class="col-lg-6 col-md-6"> 
					<div class="delivery-detals-box">
						<h4>Send large parcels to wordwide from AED 210.00</h4> 
						<div class="content-box"> 
							<p>Sending large parcels worldwide with Aramex is a reliable option, as they offer
                                various services tailored for international shipping. Here are some key points to
                                consider:</p>
                            <p>
                            <b>Service Options:</b> Aramex provides several shipping options, including express
                            and economy services. Express services are faster but may be more expensive.
                            </p>
                            <p>
                            <b>Weight and Size Limits:</b> Check the maximum weight and size limits for
                            international parcels. This can vary by destination.
                            </p>
                            <p>
                            <b>Customs Clearance:</b> Aramex typically assists with customs clearance, but you
                            may need to provide necessary documentation (invoices, export licenses, etc.)
                            for smooth processing.
                            </p>
                            <p>
                            <b>Tracking:</b> Aramex offers tracking services, so you can monitor your parcel
                            throughout its journey.
                            </p>
                            <p>
                            <b>Insurance:</b> Consider purchasing additional insurance for valuable items, as this
                            can protect against loss or damage.
                            Packaging:</b> Properly packaging your items is crucial. Ensure they are secure to
                            prevent damage during transit.
                            </p>
                            <p>
                            <b>Cost:</b> Shipping costs can vary based on the weight, size, destination, and
                            selected service. It's a good idea to get a quote on the Aramex website or
                            through their customer service.
                            </p>
                            <p>
                            <b>Local Regulations:</b> Be aware of the import regulations of the destination
                            country, as some items may be restricted or require special permits.
                            If you have specific questions about the process or need assistance, feel free to
                            ask
                            </p>    
						</div>
					</div>
				</div> 
				<div class="col-lg-5 col-md-6">
					<div class="delivery-details-img">
						<img src="{{ asset('front_assets/images/Shipcheaply3.svg') }}" class="w-100" alt="">
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
				 <h2>How it works</h2>
				</div>
			</div>
		</div>
		<div class="row courieruses"> 
			<div class="col-lg-4 col-md-4 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper"> 
					<figure class="usesimage">
						<img src="{{ asset('front_assets/images/how-it-works-1.svg') }}" alt="">
					</figure> 
					<div class="content-box-wrapper">
						<h4>Compare delivery cost</h4>
					    <div>  
					        <p>Enter you delivery details specifying
                            pick up and drop-off, parcel weight and
                            dimensions – compare service and
                            price options.</p>
						</div> 
					</div>
				</div>
		    </div>  
			<div class="col-lg-4 col-md-4 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper"> 
					<figure class="usesimage">
						<img src="{{ asset('front_assets/images/how-it-works-2.svg') }}" alt="">
					</figure> 
					<div class="content-box-wrapper">
						<h4>Choose best delivery</h4>
					    <div>  
					        <p>From the comparison select the best
service at the very best discounted
prices, with discounts of 20% – 30% off
delivery services.</p>
						</div> 
					</div>
				</div>
		    </div>  
			<div class="col-lg-4 col-md-4 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper"> 
					<figure class="usesimage">
						<img src="{{ asset('front_assets/images/how-it-works-3.svg') }}" alt="">
					</figure> 
					<div class="content-box-wrapper">
						<h4>Send your parcels</h4>
					    <div>  
					        <p>Simply choose your preferred delivery option
                            and we’ll do the rest. Take advantage of our
                            re-time tracking so you can confirm your
                            parcel delivery time.</p>
						</div> 
					</div>
				</div>
		    </div>  
	    </div>
	</div>
</section>

<!-- section 5 starts -->
<section class="testimonialsection">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper text-center">
					<h2>What our customer have to say?</h2>
				</div>
			</div>
		</div>
		<div class="row testimonialsrow">
			<div class="col-12">
				<div class="testimonialwrapper">
					@foreach(\App\Models\ReviewModel::where('show_on_home',1)->where('status',1)->get() as $review)
					<div class="single-testimonials">
						<div class="topquotes">
							<img src="{{asset('front_assets/')}}/images/Group 237.svg" alt="" class="quotes">
							<img src="{{asset('front_assets/')}}/images/Group 238.svg" alt="" class="stars">
						</div>
						<div class="middle-testimonial">
							<div class="content-box">
								{!! $review->review !!}
							</div>
						</div>
						<div class="bottom-testomnialperson">
							<div class="image-testimonial">
								@if(\App\Models\FileModel::where('ref_point','author_image')->where('ref_id',$review->id)->count()==1)
								@php $file=\App\Models\FileModel::where('ref_point','author_image')->where('ref_id',$review->id)->first(); @endphp
								<img src="{{ asset($file->path.'/'.$file->name) }}" alt="">
								@endif
							</div>
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


<!-- section 7 starts -->
<section class="faqsection">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper text-center">
					  <h2>Frequently Asked Questions</h2>
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
    				<p>
                        Send your parcel with trusted delivery companies
					</p>
				</div>
				<div class="Logowrap"> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/ups.svg') }}"></div>
					</div> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/jt.svg') }}"></div>
					</div> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/shipa.svg') }}"></div>
					</div> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/skynet.svg') }}"></div>
					</div> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/shyftd.svg') }}"></div>
					</div> 
                    <div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/aramex.svg') }}"></div>
					</div> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/posta.svg') }}"></div>
					</div> 
				</div>
			</div>
		</div>
</section>


@endsection