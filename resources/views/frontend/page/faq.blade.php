@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)
@section('content')

<!-- {{-- innner banner section start --}} -->
    <section class="innerpagebanner"> 
        <img src="{{ asset('front_assets/images/banner-service.svg') }}" alt="banner-img" class="banner-img"> 
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content-box-wrapper  text-center"> 
                        <h1>FAQs</h1>
                    </div>
                </div>
            </div> 
        </div> 
    </section>
 <!--{{-- innner banner section End --}}-->

<!-- Faq Section Start -->
<section class="faqsection faq-page-sec">
	<div class="container">
		<div class="row">
			<div class="col-12"> 
				<div class="faq-wrapper">
					<div class="accordion"> 
					
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">How do I track my parcel to delivery?</h4>
							</div>
							<div class="accordion__content"> 
							<p>Parcel tracking is very important as you will want to know that your parcel has arrived with the recipient safely. This is why we work with delivery companies you can trust and who offer full tracking to delivery. When you book a courier service with Yalla Courier, there is no compromise on quality, we reflect all the tracking events the courier has, so you receive the same level of service but pay considerably less than booking direct. </p>
							<p>It doesn't matter if your sending from Dubai to Abu Dhabi with a domestic courier or Dubai to Qatar with an international courier all of our delivery services are tracked to delivery. </p>
							</div>
						</div> 
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">How do I track my parcel? </h4>
							</div>
							<div class="accordion__content"> 
							<p>You can track all Yalla Courier orders using our simple tracking tool. All you need to do is enter a full-length tracking number which we provide whenever you make a booking. All PM tracking numbers begin with PM_*******_*******.  </p>
							</div>
						</div>
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">What is my Yalla Courier tracking number?</h4>
							</div>
							<div class="accordion__content"> 
							<p>You can locate the PM tracking number from the shipping labels we provide too, or at any time from your Yalla Courier account. Just log in, go to My Account and you can view all of your orders there. You can also track your parcel from My Account.   </p>
							<p>Still can't locate it? Search your email and find the email order confirmation of your booking. We can also help via Live Chat or email if you are having any problems tracking your parcel, just reach out to us via the Contact Us tab.  </p>
							<p><b>Tracking for Drop Off services </b></p>
							<p>Not everyone has a courier come to collect their parcel, many of our customers prefer to Drop Off. There are several benefits to this type of service and of course, you will be able to track the parcel to its delivery. Whether you drop off at a designated chosen locker or at a Pickup shop you should be provided with a receipt when you hand the box over, so keep hold of this or take a quick photo of it on your phone for your records. </p>
							</div>
						</div>
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">How do I send a parcel with Yalla Courier ?</h4>
							</div>
							<div class="accordion__content"> 
							<p><b>Do you need to send a parcel but don’t fancy a long queue?</b></p>
							<p>Well, you’re in the right place. Yalla Courier can help you send your parcel quickly and affordably in just a few clicks.  </p>
							<p>Sending a parcel online may seem daunting at first, but it’s actually very simple, and so is our booking process. If you’re comfortable to dive straight in, use the quick quote form on this page or click ‘Send a parcel’ to get started. </p> 
							<p>If this is your first time sending a parcel online, then keep reading because this page will tell you everything you need to know.  </p>
							</div>
						</div>
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">How does Yalla Courier work?</h4>
							</div>
							<div class="accordion__content"> 
							<p>When you book with us, it's you who selects which of our many partner carriers get to handle your item. Book online and either drop your parcel at a local store, Post Office or depot, or we can collect it from your home or work. It's that simple! </p> 
							</div>
						</div>
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">How is Yalla Courier so cost effective?</h4>
							</div>
							<div class="accordion__content"> 
							<p>As we group together all of our customers orders and book them through one account with our courier partners, this creates "buying power" discounts which we are then able to pass on to you! </p> 
							</div>
						</div>
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">Why Use Yalla Courier?</h4>
							</div>
							<div class="accordion__content"> 
    							<p>Thousands of individual customers, businesses, eBay, Amazon, and other marketplace sellers save money every day by using Yalla Courier. Anybody can sign up and start benefiting from our great discounts right away and below are some of the other reasons why our customers choose Yalla Courier:</p> 
    							<ul>
    							    <li>Choose from many reputable courier companies to ship your parcel</li>
    							    <li>Book parcel delivery within the UAE or to over 240 international destinations</li>
    							    <li>Choose from collection & drop-off services</li>
    							    <li>Over 10,000 verified reviews. </li>
    							    <li>Manage all your parcel deliveries in one place</li> 
    							</ul>
    							<p><b>A (short) history of Yalla Courier</b></p>
    							<p>Yalla Courier  was born in 2022 with the dream of bringing cost effective parcel delivery to the masses. 2 years on and we are well established in the UAE and growing fast in the USA too, taking hundreds of thousands of bookings and saving our customers millions of pounds and dollars every year.</p>
    							<p>We’re fast becoming the best way to send a parcel anywhere in the World, but we’re still evolving. Our group aim is to become a one stop shop for e-commerce services too. We've already launched an accessible fulfilments & warehouse service and a free e-commerce platform too. Find out more about these below...</p>
							</div>
						</div>
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">What couriers can I book?</h4>
							</div>
							<div class="accordion__content"> 
    							<p>Finding a cheap courier is quick and easy with Yalla Courier </p> 
    							<p>In seconds, our price comparison service compares quotes from multiple courier companies, helping you find and book the cheapest courier service available.</p>
    							<p>With a wide range of next day, same day, UAE and international services to choose from, you're guaranteed to find a courier service that suits your needs and budget.</p>
    							<p>Choose from our extensive list of courier companies below for more details!</p>
    							<div class="couriers-logo-wrapper">
    							    <p><b>Courier Companies</b></p>
    							    <div class="row">
    							        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
    							            <div class="logobox">
    							                <img src="{{asset('front_assets/')}}/images/ups.svg" />
    							            </div>
    							        </div>
    							        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
    							            <div class="logobox">
    							                <img src="{{asset('front_assets/')}}/images/jt.svg" />
    							            </div>
    							        </div>
    							        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
    							            <div class="logobox">
    							                <img src="{{asset('front_assets/')}}/images/shipa.svg" />
    							            </div>
    							        </div>
    							        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
    							            <div class="logobox">
    							                <img src="{{asset('front_assets/')}}/images/skynet.svg" />
    							            </div>
    							        </div>
    							        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
    							            <div class="logobox">
    							                <img src="{{asset('front_assets/')}}/images/shyftd.svg" />
    							            </div>
    							        </div>
    							        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
    							            <div class="logobox">
    							                <img src="{{asset('front_assets/')}}/images/aramex.svg" />
    							            </div>
    							        </div>
    							        <div class="col-lg-4 col-md-4 col-sm-6 col-6">
    							            <div class="logobox">
    							                <img src="{{asset('front_assets/')}}/images/posta.svg" />
    							            </div>
    							        </div>
        							</div>
    							</div>
							</div>
						</div> 
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">Do you offer extended liability?</h4>
							</div>
							<div class="accordion__content"> 
							<p><b>What sort of insurance cover do you offer?</b></p>
							<p>Yalla Courier offer extended liability as opposed to insurance on a variety of our courier services. We give customers who book parcel delivery on our website the opportunity to extend the liability for their items they want to have delivered via courier. </p> 
							</div>
						</div> 
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">Send a parcel today - book early or Drop Off</h4>
							</div>
							<div class="accordion__content">  
							<p>Wakey, wakey rise and shine, make sure you are on the ball if you want a Same Day parcel collection, you need to place the order bright and early to get your parcel collected the Same Day as you place the order. </p> 
							</div>
						</div> 
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">Can I see how much I can save with Yalla Courier ?</h4>
							</div>
							<div class="accordion__content">  
							<p>There are many ways to send a parcel and if you're looking for a cheaper price than what you've been quoted at the Post Office, Yalla Courier can help. We work closely with a number of established and trusted couriers, including Aramex, and receive discounted rates, which we pass on to our customers.  That means you can benefit from huge savings just by getting a quote through our courier quote tool. </p> 
							</div>
						</div> 
						
						<div class="accordion__item">
							<div class="accordion__title">
								<div class="accordion__arrow"><span class="accordion__arrow-item "></span></div>
								<h4 class="accordion__title-text">Why use Yalla Courier?</h4>
							</div>
							<div class="accordion__content">  
    							<p>Compare, book and send parcels using discounted parcel delivery services. Save time & money with Yalla Courier. </p> 
    							<ul>
    							    <li>Choose from many reputable courier companies to ship your parcel</li>
    							    <li>Book parcel delivery within the UAE or to over 240 international destinations</li>
    							    <li>Choose from collection & drop-off services</li>
    							    <li>Over 10,000 verified reviews. </li>
    							    <li>Manage all your parcel deliveries in one place</li> 
    							</ul>
							</div>
						</div> 
					</div>
				</div>
			</div>
		</div>
</section>

<!-- Faq Section End -->
    

@endsection