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
with Emirates Post
on Yalla Courier</h1>
					<p class="banner-short-description">Emirates Post and Yalla Courier working
together to send parcels from the UAE to UAE
or Internationally at great rates. With one click
fast booking from your smartphone anytime</p>
					<!--<ul class="banner-list">-->
					<!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Compare courier prices & pay less</span> </li>-->
					<!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Save time and money</span> </li>-->
					<!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>No sign up required</span> </li>-->
					<!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Upto 40% discount on shipping rates</span> </li>-->
					<!--</ul>-->
					<div class="rating-box">
						<img class="img-fluid banner-ratings d-block" src="{{ asset('front_assets/images/rating-stars.svg') }} " alt"Emirates Post Near Me" />
						<span class="rating-text">Over 47,000 parcels sent</span>
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-6">
				<div class="imgbox">
					<img class="w-100" src="{{ asset('front_assets/images/lp-epc1.svg') }}" alt="Emirates Post Near Me" />
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
						<img src="{{ asset('front_assets/images/lp-epc.svg') }}" alt="Emirates Post Near Me" class="text-center">
					</figure>
					<div class="content-box-wrapper text-center">
						<h2>Sending parcels with Emirates Post
</h2>
						<div>
							<p>Emirates Post offers an exceptional customer experience, with same day collection and reliable delivery. Whether you want to compare Emirates Post
prices, send a parcel, track a Emirates Post shipment, or find Emirates Post contact information for the country you’re shipping to, you can do it all with
Yalla Courier.</p>
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
					<img src="{{ asset('front_assets/images/ycd-icon1.svg') }}" alt="Emirates Post Near Me" style="width: 100px;height: 100px;text-align: center;display: block;margin: 25px auto;">
					<div class="content-box-wrapper">
						<h5>Package insurance available</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper">
					<img src="{{ asset('front_assets/images/ycd-icon2.svg') }}" alt="Emirates Post Parcel Delivery" style="width: 100px;height: 100px;text-align: center;display: block;margin: 25px auto;">
					<div class="content-box-wrapper">
						<h5>Collection or drop-off at a local shop anytime</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper">
					<img src="{{ asset('front_assets/images/ycd-icon3.svg') }}" alt="Emirates Post Near Me" style="width: 100px;height: 100px;text-align: center;display: block;margin: 25px auto;">
					<div class="content-box-wrapper">
						<h5>Track your parcel from door-to-door</h5>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper">
					<img src="{{ asset('front_assets/images/ycd-icon4.svg') }}" alt="Emirates Post Near Me" style="width: 100px;height: 100px;text-align: center;display: block;margin: 25px auto;">
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
			<h2>Fast cost efficient shipping with Emirates Post</h2>
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
						<h4>Emirates Post 2-day International delivery
from AED 119.00</h4> 
						<div class="content-box"> 
							<p>Using Emirates Post for international shipping offers several advantages: </p>
                            <p>
                            <b>Global Reach:</b> Emirates Post has a wide network that allows for shipping to
                            numerous countries worldwide, making it a reliable option for international
                            deliveries.
                            </p>
                            <p>
                            <b>Cost-Effective Options:</b> They provide a range of shipping services, including
                            economy and express options, allowing you to choose the most suitable and
                            cost-effective solution based on your needs.
                            </p>
                            <p>
                            <b>Tracking Services:</b> Emirates Post offers tracking for most international
                            shipments, giving you peace of mind and the ability to monitor your parcel’s
                            progress in real time.
                            </p>
                            <p>
                            <b>Customs Support:</b> They provide assistance with customs documentation and
                            clearance, helping to ensure that your package moves smoothly through
                            international borders.
                            </p>
                            <p>
                            <b>Insurance Options:</b> You can often opt for insurance coverage for valuable
                            items, providing extra security against loss or damage during transit.
                            Local Expertise: With a strong presence in the UAE, Emirates Post has local
                            knowledge that can help streamline the shipping process.
                            </p>
                            <p>
                            <b>Reliable Delivery Times:</b> While delivery times can vary by destination,
                            Emirates Post generally offers competitive delivery times, especially for their
                            express services.
                            </p>
                            <p>
                            <b>Sustainability Initiatives:</b> Emirates Post is increasingly focusing on
                            sustainability, which can be an important consideration for
                            environmentally-conscious shippers.
                            </p>
                            <p>
                            <b>Flexible Service Levels:</b> They offer various service levels, allowing you to
                            choose based on urgency and budget, from standard shipping to faster express
                            options.</p>
						</div>
					</div>
				</div> 
				<div class="col-lg-5 col-md-6">
					<div class="delivery-details-img">
						<img src="{{ asset('front_assets/images/courier-services-3.svg') }}" class="w-100" alt="Emirates Post Near Me">
					</div>
				</div> 
			</div>
			<div class="row  justify-content-between">
				<div class="col-lg-6 col-md-6"> 
					<div class="delivery-detals-box">
						<h4>Send parcels next day UAE-UAE with Emirates
Post from only AED 15.00</h4> 
						<div class="content-box"> 
							<p>If you hail from UAE, you’ll know what an amazing job Emirates Post do,
delivering across a huge landmass. Our Emirates Post service offers FastTrack
customs clearance and is great value if you’re not in a hurry. Delivery takes
around a week longer than most other couriers, but this is offset by the
reduced customs delays. If you’re sending a personal shipment, Emirates Post
is a great option.</p>
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
							<p>Emirates Post provides a range of worldwide shipping and freight services that
                            cater to various needs. Here are the key features and options available:
                            </p>
                            <p>
                            <b>1. International Shipping Services</b> <br>
                            Express Services: Fast delivery options for urgent shipments, typically reaching
                            destinations within a few days.<br>
                            Economy Services: More cost-effective solutions for non-urgent shipments,
                            which may take longer but are budget-friendly.
                            </p>
                            <p>
                            <b>2. Freight Services</b><br>
                            Air Freight: Ideal for time-sensitive goods, Emirates Post offers air freight
                            services for larger shipments.<br>
                            Sea Freight: Suitable for bulky items, sea freight is a more economical choice
                            for shipping larger volumes over longer distances.
                            </p>
                            <p>
                            <b>3. Tracking and Visibility</b><br>
                            Emirates Post provides tracking services for most international shipments,
                            allowing you to monitor the status of your packages in real time.
                            </p>
                            <p>
                            <b>4. Customs Clearance</b><br>
                            They assist with customs documentation and procedures, helping to ensure
                            that your shipments comply with international regulations.
                            </p>
                            <p>
                            <b>5. Insurance Options</b><br>
                            You can purchase insurance for valuable items, providing added protection
                            against loss or damage during transit.
                            </p>
                            <p>
                            <b>6. Packaging Services</b><br>
                            Emirates Post offers packaging solutions to ensure that your goods are
                            securely packed for international transport.
                            </p>
                            <p>
                            <b>7. Global Reach</b><br>
                            With a vast network of partners, Emirates Post can reach many countries
                            worldwide, making it a reliable choice for international shipping.
                            </p>
                            <p>
                            <b>8. Flexible Solutions</b><br>
                            They cater to various shipping needs, whether for personal packages, business
                            logistics, or bulk freight shipments.
                            </p>
                            <p>
                            <b>9. Sustainability Initiatives</b><br>
                            Emirates Post is committed to sustainability, implementing practices to
                            minimize environmental impact in their shipping operations.
                            </p>
                            <p>
                            <b>10. Customer Support</b><br>
                            Dedicated customer service is available to assist with inquiries, provide quotes,
                            and guide you through the shipping process.<br>
                            If you’re considering using Emirates Post for your shipping needs, their diverse
                            range of services and customer support can make the process smoother and
                            more efficient.</p>    
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
						<img src="{{ asset('front_assets/images/how-it-works-1.svg') }}" alt="Emirates Post Near Me">
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
						<img src="{{ asset('front_assets/images/how-it-works-2.svg') }}" alt="Emirates Post Near Me">
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
						<img src="{{ asset('front_assets/images/how-it-works-3.svg') }}" alt="Emirates Post Near Me">
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
							<img src="{{asset('front_assets/')}}/images/Group 237.svg" alt="Emirates Post Near Me" class="quotes">
							<img src="{{asset('front_assets/')}}/images/Group 238.svg" alt="Emirates Post Near Me" class="stars">
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
								<img src="{{ asset($file->path.'/'.$file->name) }}" alt="Emirates Post Near Me">
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
						<div class="imgwrap"><img src="{{ asset('front_assets/images/ups.svg') }}" alt"Emirates Post Near Me" ></div>
					</div> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/jt.svg') }}" alt"Emirates Post Courier Delivery"></div>
					</div> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/shipa.svg') }}" alt"Emirates Post Drop off"></div>
					</div> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/skynet.svg') }}" alt"Emirates Post local delivery"></div>
					</div> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/shyftd.svg') }}" alt"Emirates Post Near Me"></div>
					</div> 
                    <div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/aramex.svg') }}" alt"Emirates Post Express Delivery"></div>
					</div> 
					<div class="singleimage">
						<div class="imgwrap"><img src="{{ asset('front_assets/images/posta.svg') }}" alt"Emirates Post courier"></div>
					</div> 
				</div>
			</div>
		</div>
</section>


@endsection