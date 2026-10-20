<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width" />
	<title>@yield('title')</title>
	<meta name="description" content="@yield('seo_description')" />
	<link rel="canonical" href="@yield('canonical')" />
	<meta name="robots" content="@yield('follow')">
	<link rel="stylesheet" type="text/css" href="{{asset('front_assets/style.css')}}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.6.0/build/css/intlTelInput.css">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.favicons')
	@stack('header_scripts')
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-EPKNP3GJEF"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-EPKNP3GJEF');
</script>	
</head>

@php
	// Customer account pages have their own header (logo + account nav tabs).
	// Showing the full site header too made every one of those pages look like
	// it had two headers stacked on top of each other — so it's skipped here.
	$isCustomerAccountPage = request()->is('customer/dashboard')
		|| request()->is('customer/shipment-setting')
		|| request()->is('customer/e-billing')
		|| request()->is('customer/setting')
		|| request()->is('customer/shipment/*');
@endphp
<body class="@if($isCustomerAccountPage) customer-account-body @endif">
	@unless($isCustomerAccountPage)
	<!-- #Header starts -->
	<header class="">
        <div id="top_bar">
    		<div class="container">
    			<!--<div class="top-bar"> -->
    			<!--	<div class="d-flex trakingrow justify-content-end align-items-center">-->
    			<!--		<div class="track-btn-holder">-->
    			<!--			<a href="#" class="trackbtn purple-theme-btn"><span>Track</span></a>-->
    			<!--		</div>-->
    			<!--		<div class="cartholder">-->
    			<!--			<figure class="cart-icon">-->
    			<!--				<img src="{{asset('front_assets/')}}/images/path74.png " alt="">-->
    			<!--			</figure>-->
    			<!--		</div>-->
    			<!--		@if(Auth::guard('customers')->check())-->
    			<!--		<a href="{{ url('/customer/dashboard')}}" class="accountholder">-->
    			<!--			<figure class="accountman"><img src="{{asset('front_assets/')}}/images/Group 18.svg" alt=""></figure>-->
    			<!--			My account-->
    			<!--		</a>-->
    			<!--		@else-->
    			<!--		<a href="{{ url('/customer/login')}}" class="accountholder">-->
    			<!--			<figure class="accountman"><img src="{{asset('front_assets/')}}/images/Group 18.svg" alt=""></figure>-->
    			<!--			My account-->
    			<!--		</a>-->
    			<!--		@endif-->
       <!--                 <a href="/business" class="purple-theme-btn" style="padding: 8px 20px; margin-top:-6px"><span>Register Business Account</span></a>-->
       <!-- 			</div> -->
    			<!--</div>-->
                <div class="row top-bar justify-content-center align-items-center"> 
    				<div class="d-flex trakingrow align-items-center">
    					<div>
    						<p style="margin: 0 ">Do you need a business account?</p>
    					</div>
    					<div>
    						<a href="/business" class="purple-theme-btn" style="padding: 8px 20px; "><span>Learn More</span></a>
    					</div>
        			</div> 
    			</div>
    		</div>
        </div>
		<div class="border-header">
			<div class="container">
				<div class="row logo-menu-row align-items-center">
					<div class="col-lg-4 col-md-3 col-4">
						<div class="logo-wrapper">
							<figure class="header-logo">
								<a href="{{ url('/')}}">
									<img src="{{asset('front_assets/')}}/./images/header-logo.svg" alt="" class="">
								</a>
							</figure>
						</div>
					</div>
					<div class="col-lg-8 col-md-9 col-8">
						<div class="menu-wrapper">
							<div class="header-nav d-flex justify-content-end">
								<nav class="pn d-lg-block d-md-block  d-none">
									<ul class="menu-parent-wrapper">
										<li><a href="{{ url('/')}}">Home</a></li>
										<li><a href="{{ url('/about') }}">About</a></li>
										<li><a href="{{ url('/dubai-parcel-delivery')}}">Services</a></li>
										<li><a href="{{ url('/our-couriers') }}">Couriers</a></li>
										<li><a href="{{ url('/shipping-made-simple')}}">Shipping & Guidelines</a></li>
										<li><a href="{{ url('/contact-us')}}">Contact Us</a></li>
										@php $page=\App\Models\PageModel::find(26); @endphp
										@if($page)
										<li><a href="{{ url('/'.$page->slug)}}">{{ $page->title }}</a></li>
										@endif
										{{-- Customer login/My account link disabled per owner request (2026-10-03) — not deleted, see master.blade.php history.
										<li>
                        					@if(Auth::guard('customers')->check())
                        					<a href="{{ url('/customer/dashboard')}}" class="accountholder">
                        						<!--<figure class="accountman"><img src="{{asset('front_assets/')}}/images/Group 18.svg" alt=""></figure>-->
                        						My account
                        					</a>
                        					@else
                        					<a href="{{ url('/customer/login')}}" class="accountholder">
                        						<!--<figure class="accountman"><img src="{{asset('front_assets/')}}/images/Group 18.svg" alt=""></figure>-->
                        						My account
                        					</a>
                        					@endif
										</li>
										--}}
									</ul>
								</nav>
								<div class="header-actions mobile-navbar-btn d-lg-none d-md-none  d-block">
								    <i class="fa fa-bars"></i>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</header>

    <!-- Background Overlay Start -->
    <div class="bg-overlay"></div>
    <!-- Background Overlay end -->

    <!-- Mobile Header Sidebar Start -->
    <div class="mobile-navbar">
        <div class="close-btn">
            <i class="fa fa-times" ></i>
        </div>
        <div class="mobile-navbar-wrapper">
            <a class="mobile-logo d-block" href="{{ url('/')}}">
				<img src="{{asset('front_assets/')}}/./images/header-logo.svg" alt="" class="">
			</a>
			<ul class="mobile-menu-wrapper">
				<li><a href="{{ url('/')}}">Home</a></li>
				<li><a href="{{ url('/about') }}">About</a></li>
				<li><a href="{{ url('/dubai-parcel-delivery')}}">Services</a></li>
				<li><a href="{{ url('/our-couriers') }}">Couriers</a></li>
				<li><a href="{{ url('/shipping-made-simple')}}">Shipping & Guidelines</a></li>
				<li><a href="{{ url('/contact-us')}}">Contact Us</a></li>
				<li><a href="{{ url('/luggage')}}">Luggage</a></li>
				{{-- Customer login/My account link disabled per owner request (2026-10-03) — not deleted, see master.blade.php history.
				<li>
					@if(Auth::guard('customers')->check())
					<a href="{{ url('/customer/dashboard')}}" class="accountholder">
						<!--<figure class="accountman"><img src="{{asset('front_assets/')}}/images/Group 18.svg" alt=""></figure>-->
						My account
					</a>
					@else
					<a href="{{ url('/customer/login')}}" class="accountholder">
						<!--<figure class="accountman"><img src="{{asset('front_assets/')}}/images/Group 18.svg" alt=""></figure>-->
						My account
					</a>
					@endif
				</li>
				--}}
			</ul>
        </div>
    </div>
    <!-- Mobile Header Sidebar End -->
    @endunless

	@yield('content')


    <!-- Prohibited Items Popup Start -->
    <section class="prohibited-items-popup">
        <div class="prohibited-items-popup-wrapper">
            <i class="fa fa-times prohibited-close-btn"></i>
            <div class="content-wrapper">
                <h3 class="main-title">UAE Prohibited Items List/Special Handing Items</h3>
                <div class="list-with-title">
                    <h4>Prohibited Items</h4>
                    <ul>
                        <li>Cigarettes/ Electronic Cigarettes / E-SHISHA</li>
                        <li>Sex Product & Toys</li>
                        <li>Alcoholic Drinks</li>
                        <li>Drugs - All kinds of Narcotic</li>
                        <li>Weapons</li>
                        <li>Food</li>
                        <li>Gambling tools, machineries and devices of all kinds.</li>
                        <li>Security camera " CCTV camera "</li>
                        <li>Any garments have logo for UAE government</li>
                        <li>Holy Quran</li>
                        <li>Quranic paintings / Oil Paintings</li>
                        <li>Fireworks</li>
                        <li>Products from Embargo Contries like Israel / Iran etc</li>
                        <li>Nylon fishing nets.</li>
                        <li>Live Swine</li>
                        <li>Used, reconditioned and inlaid tires.</li>
                        <li>Radiation and nuclear fallout contaminated substances.</li> 
                    </ul>
                </div>
                <div class="list-with-title">
                    <h4>Restricted Items 
                        <p class="h5">(Can be cleared only on Approvals from Ministry)</p>
                    </h4>
                    <ul>
                        <li>Live animals, plants, fertilizers and insecticides</li>
                        <li>Arms, ammunitions, explosives, and fireworks</li>
                        <li>Pharmaceutical products and Medical/ Surgical instruments and machines</li>
                        <li>Print materials, publications, and media products</li>
                        <li>Transmitters and radio equipment</li>
                        <li>Foodstuffs, personal care and cosmetic products</li>
                        <li>Nuclear energy-related</li> 
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Prohibited Items Popup End -->
    
    <!-- How Shipping Rates Calculated Popup Start -->
    <div class="how-shipping-rates-calculated-popup" id="howShippingRatesCalculated">
        <div class="how-shipping-rates-calculated-popup-wrapper">
            <div class="how-shipping-rates-calculated-popup-header">
                <h3 class="text-center">How shipping rates are calculated? </h3>
                <br>
                <h4 class="text-center"><span>Parcels delivery charges are priced based on 2 crucial factors:</span></h4>
                <i class="fa fa-times close-btn"></i>
            </div>
            <br>
            <div class="how-shipping-rates-calculated-popup-body">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-4 col-6">
                        <div class="img-wrapper">
                            <img class="w-100" src="{{ asset('front_assets/images/length-width-height.svg') }}" />
                        </div>
                    </div> 
                </div>
                <br><br>
                <h4 class="text-center">Either <span>Parcel weight</span> or <span>volumetric weight</span> including parcel dimensions,
                whatever is the greater of the two.</h4>
                <br>
                <p>For example if you ship an iPhone in a larger box than necessary the charges will be based
                on volumetric weight not “actual box weight”</p>
                <br>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-4 col-6">
                        <div class="img-wrapper">
                            <img class="w-100" src="{{ asset('front_assets/images/parcel-weight-1.svg') }}" />
                        </div>
                    </div> 
                    <div class="col-lg-4 col-md-4 col-6">
                        <div class="img-wrapper">
                            <img class="w-100" src="{{ asset('front_assets/images/parcel-weight-2.svg') }}" />
                        </div>
                    </div>
                </div>
                <br>
                <br>
                <p>The reason for this is the parcel will take up more room during transit on the chosen couriers
                van so they lose out on revenue from other clients packages.</p>
                <p>To avoid paying more than required it is very important that you select parcel size that is
                suitable for your item. </p>
                <br>
                <br>
                <h4 class="text-center">Calculate the length & girth of your parcel manually</h4>
                <br>
                <p><b>To calculate the girth of a package, follow these guidelines:</b></p>
                <br>
                <ul>
                    <li>Measure the three parcel dimensions in centimetres. Example: 50 cm (Length) x 40 cm
                    (Width) x 30 cm (Height).</li>
                    <li>Add the measurements of the two smallest dimensions together. Multiply the result by
                     two. This is the girth of your package. Example: 40 cm (Width) + 30 cm (Height) = 70
                     cm. 70 cm x 2 = 140 cm (Girth).</li>
                    <li>Now simply take the longest dimension and add this to the package girth. The result is
                     the combined length and girth of your parcel. Example: 50 cm (Length) + 140 cm (Girth)
                     = 190 cm (Combined Length and Girth)</li> 
                </ul>
            </div>
            <!--<div class="how-shipping-rates-calculated-popup-footer">-->
            <!--    <h4>That’s it it’s so simple</h4>-->
            <!--</div>-->
        </div>
    </div>
    <!-- How Shipping Rates Calculated Popup End -->
    
	@if($isCustomerAccountPage)
	<footer class="customer-footer">
		<div class="container customer-footer-inner">
			<p class="customer-footer-copyright">
				YALLA TRADING L.L.C (Trading as Yalla Shipping) 1591977.
				Yalla Shipping Copyright &copy; {{ date('Y') }} all rights reserved.
			</p>
			<a href="https://wa.me/971526607133" target="_blank" rel="noopener" class="customer-footer-whatsapp">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15" height="15" aria-hidden="true"><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222c0 39.1 10.2 77.3 29.6 110.9L4.8 480l116.1-30.4c32.3 17.6 68.6 26.9 105.9 26.9h.1c122.3 0 224.1-99.6 224.1-222c0-59.3-25.2-115-70.1-157.4zM223.9 438.9c-32.8 0-64.9-8.8-92.8-25.5l-6.7-4-69 18.1l18.4-67.3-4.3-6.9c-18.3-29.1-28-62.7-28-97.3c0-101 82.3-183.3 183.5-183.3c49 0 95.1 19.1 129.7 53.8c34.6 34.7 56.1 80.8 56 129.8c0 101.1-84.1 182.6-186.8 182.6zm101.2-135.2c-5.5-2.8-32.8-16.2-37.9-18s-8.9-2.8-12.6 2.8c-3.7 5.5-14.5 18-17.8 21.8c-3.3 3.7-6.6 4.2-12.1 1.4c-32.8-16.4-54.4-29.3-75.9-66.5c-5.7-9.9 5.7-9.2 16.3-30.6c1.8-3.7 .9-6.9-1.1-9.9c-2-2.8-8.9-21.5-13.9-34.4c-3.7-9.5-7.6-8.2-10.4-8.3c-2.7-.1-5.8-.1-8.9-.1c-9.3 0-18.9 2.7-21.5 7.9c-3.6 7.2-9.3 20.4-9.3 34.1c0 27.5 24.6 54.9 27.9 58.6c3.3 3.7 44.9 70.7 110.9 94.7c48.8 17.9 58.6 15.1 69.7 12.6c11.1-2.5 33.6-13.9 38.6-25.6c5-11.7 5-21.4 3.5-23.7c-1.5-2.3-5.7-3.5-11.2-6.3z"/></svg>
				<span>Need help? WhatsApp</span>
			</a>
		</div>
	</footer>
	@else
	<footer class="footer">
		<div class="container">
			<div class="row">

				<div class="col-lg-3 col-md-3">
					<div class="colfooter footcol1">
						<div class="logowrapper">
						    <img src="{{asset('front_assets/')}}/images/header-logo.svg" alt=""> 
						    <div class="footer-adress">
    						     <p >Yalla Courier Express <br>
                                    Pack & Ship <br>
                                    Mercato Mall <br>
                                    Jumeirah Beach Road – Jumeirah – Jumeirah 1 – Dubai</p>
    						    <p><a style="color: #100F0D;" href="mailto:help@yallacourier.com">help@yallacourier.com</a></p>
    						    <!--<p><a style="color: #100F0D;" href="tel:+971526607133">+971 52 660 7133 </a></p>-->
						    </div>
						</div>
						<img src="{{asset('front_assets/')}}/images/Group 295.svg" alt="" class="checkoutmethod">
					</div>
				</div>
                <div class="col-lg-3 col-md-3">
					<div class="colfooter footcol3">
						<div class="menu-wrapper">
							<span>Countries</span>
							<nav class="footmenu companyinfomenu">
								<ul>
								    @foreach(\App\Models\CountriesModel::get() as $country)
									<li><a href="{{ url('/country/'.$country->slug) }}">Courier from Dubai to {{ $country->title }} </a></li>
									@endforeach
									<!--<li><a href="{{ url('/country/lebanon') }}">Courier from Dubai to Lebanon</a></li>-->
									<!--<li><a href="{{ url('/country/jordan') }}">Courier from Dubai to Jordan </a></li>-->
									<!--<li><a href="{{ url('/country/oman') }}">Courier from Dubai to Oman </a></li>-->
         <!--                           <li><a href="{{ url('/country/bahrain') }}">Courier from Dubai to Bahrain  </a></li>-->
         <!--                           <li><a href="{{ url('/country/saudi-arabia') }}">Courier from Dubai to Saudi Arabia  </a></li>-->
         <!--                           <li><a href="{{ url('/country/qatar') }}">Courier from Dubai to Qatar </a></li>-->
								</ul>
							</nav>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3">
					<div class="colfooter footcol2">
						<div class="menu-wrapper">
							<span>Delivery Partners</span>
							<nav class="footmenu deliverypartnermenu">
								<ul>
									<li><a href="#">UPS</a></li>
									<li><a href="#">Careem</a></li>
									<li><a href="#">Naqel Express</a></li>
									<li><a href="#">Shippa Delivery</a></li>
									@php $page=\App\Models\PageModel::find(24); @endphp
									@if($page)<li><a href="{{ url($page->slug) }}">{{ $page->title }}</a></li> @endif
									@php $page=\App\Models\PageModel::find(25); @endphp
									@if($page)<li><a href="{{ url($page->slug) }}">{{ $page->title }}</a></li> @endif
								</ul>
							</nav>
						</div>
					</div>
				</div>
				<div class="col-lg-3 col-md-3">
					<div class="colfooter footcol3">
						<div class="menu-wrapper">
							<span>Company Information</span>
							<nav class="footmenu companyinfomenu">
								<ul>
									<li><a href="{{ url('/terms-and-condition') }}">Terms and conditions</a></li>
									<li><a href="{{ url('/privacy-policy') }}">Privacy policy</a></li>
									<li><a href="{{ url('/shipping-made-simple') }}">Shipping and guidelines</a></li>
									<li><a href="{{ url('/faq') }}">FAQ’s</a></li>
									@foreach(\App\Models\PageModel::where('show_in_footer',1)->where('status',1)->get() as $page)
									@if($page)<li><a href="{{ url($page->slug) }}">{{ $page->title }}</a></li> @endif
									@endforeach
								</ul>
							</nav>
						</div>
					</div>
				</div>
				<!--<div class="col-lg-3 col-md-3">-->
				<!--	<div class="colfooter footcol3">-->
				<!--		<div class="menu-wrapper">-->
				<!--			<span>Countires</span>-->
				<!--			<nav class="footmenu companyinfomenu">-->
				<!--				<ul>-->
				<!--					<li><a href="{{ url('/kuwait') }}">Kuwait </a></li>-->
				<!--					<li><a href="{{ url('/lebanon') }}">Lebanon</a></li>-->
				<!--					<li><a href="{{ url('/jordan') }}">Jordan </a></li>-->
				<!--					<li><a href="{{ url('/oman') }}">Oman </a></li>-->
    <!--                                <li><a href="{{ url('/bahrain') }}">Bahrain  </a></li>-->
				<!--				</ul>-->
				<!--			</nav>-->
				<!--		</div>-->
				<!--	</div>-->
				<!--</div>-->
			</div>

			<div class="row copyright">
				<div class="col-12">
					<hr>
					<div class="row">
					    <div class="col-lg-8 col-md-8 col-sm-8" >
					        <div class="content-box-wrapper">
        						<!--ALL SORTED ENTERPRISES PORTAL CO. LLC (Trading as Yalla Courier) 1157096.-->
        						YALLA TRADING L.L.C (Trading as Yalla Shipping) 1591977.
        						<br>
        Yalla Shipping Copyright © {{ date('Y') }} all rights reserved.
        					</div>
					    </div>
					    <div class="col-lg-4 col-md-4 col-sm-4">
					        <div class="social-links">
					            <ul class="d-flex justify-content-end m-0 p-0 list-unstyled">
					                <li>
					                    <a href="https://www.linkedin.com/company/yalla-courier/?viewAsMember=true">
					                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
					                            <path d="M100.3 448H7.4V148.9h92.9zM53.8 108.1C24.1 108.1 0 83.5 0 53.8a53.8 53.8 0 0 1 107.6 0c0 29.7-24.1 54.3-53.8 54.3zM447.9 448h-92.7V302.4c0-34.7-.7-79.2-48.3-79.2-48.3 0-55.7 37.7-55.7 76.7V448h-92.8V148.9h89.1v40.8h1.3c12.4-23.5 42.7-48.3 87.9-48.3 94 0 111.3 61.9 111.3 142.3V448z"/></svg>
					                    </a>
					                </li>
					               
					                <li>
					                    <a href="https://www.instagram.com/yallacourier/">
					                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
					                            <path d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"/></svg>
					                    </a>
					                </li>
					                
					            </ul>
					        </div>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	@endif
	<div class="bottom-to-top" ><button class="bottomicon" id="scrollToTopBtn"><img src="{{asset('front_assets/')}}/images/Group 298.svg"></button></div>
	<script src="{{asset('front_assets/')}}/js/theme-lib.js"></script>
	<script src="{{asset('front_assets/')}}/js/theme-fun.js"></script>
	@stack('scripts')
	<!--Search Scripts-->
	<!--Search Scripts-->
<script>
    $(document).ready(function(){
        $(".intl_parcel").click(function(){
            $(".length_intl").val($(this).attr("data-l"));
            $(".width_intl").val($(this).attr("data-w"));
            $(".height_intl").val($(this).attr("data-h"));
        });
        $(".dom_parcel").click(function(){
            $(".length_dom").val($(this).attr("data-l"));
            $(".width_dom").val($(this).attr("data-w"));
            $(".height_dom").val($(this).attr("data-h"));
            $(".weight_dom").val($(this).attr("data-weight"));
        });
        $(".dom_parcel_intl").click(function(){
            $(".length_dom_intl").val($(this).attr("data-l"));
            $(".width_dom_intl").val($(this).attr("data-w"));
            $(".height_dom_intl").val($(this).attr("data-h"));
            $(".weight_dom_intl").val($(this).attr("data-weight"));
        });
        
         $(".dom1_parcel").click(function(){
            $(".length_dom").val($(this).attr("data-l"));
            $(".length_dom").attr("readonly","readonly");
            $(".width_dom").val($(this).attr("data-w"));
            $(".width_dom").attr("readonly","readonly");
            $(".height_dom").val($(this).attr("data-h"));
            $(".height_dom").attr("readonly","readonly");
            $(".weight_dom").val($(this).attr("data-weight"));
            $(".weight_dom").attr("readonly","readonly");
        });
        $(".dom1_parcel_intl").click(function(){
            $(".length_dom_intl").val($(this).attr("data-l"));
            $(".length_dom_intl").attr("readonly","readonly");
            $(".width_dom_intl").val($(this).attr("data-w"));
            $(".width_dom_intl").attr("readonly","readonly");
            $(".height_dom_intl").val($(this).attr("data-h"));
            $(".height_dom_intl").attr("readonly","readonly");
            $(".weight_dom_intl").val($(this).attr("data-weight"));
            $(".weight_dom_intl").attr("readonly","readonly");
        });
        $(".document_local").click(function(){
            $(".document_local_l").val($(this).attr("data-l"));
            $(".document_local_w").val($(this).attr("data-w"));
            $(".document_local_h").val($(this).attr("data-h"));
            $(".document_local_weight").val($(this).attr("data-weight"));
        });
        $(".document_intl").click(function(){
            $(".document_intl_l").val($(this).attr("data-l"));
            $(".document_intl_w").val($(this).attr("data-w"));
            $(".document_intl_h").val($(this).attr("data-h"));
            $(".document_intl_weight").val($(this).attr("data-weight"));
        });
        
    })
</script>
</body>

</html>