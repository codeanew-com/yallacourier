@extends('frontend.layouts.master')

@section('content')

<section class="new-banner-sec lead-thank-you-page-banner">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-6 col-md-6"> 
        		<div class="contentbox">
        		    <h1 class="banner-title">Thank you for registering a business account</h1>
    			    <p class="banner-short-description">One of our specialists will be in touch shortly to discuss the shipping requirments and to outline Yall Courier’s delivery solutions.</p>
    			</div>
    		</div> 
			<div class="col-lg-6 col-md-6">
				<div class="imgbox"> 
					<img class="w-100" src="{{ asset('front_assets/images/lead-thankyou-banner-img.svg') }}" alt=""> 
				</div>
			</div>
		</div>
	</div>
</section> 

<section class="delivery-sec usessection our-courier-services-list-sec section_2 lead-benefits-sec">
	<div class="container"> 
		<div class="row justify-content-between"> 
			<div class="col-lg-5 col-md-6">
				<div class="delivery-details-img"> 
					<img src="{{ asset('front_assets/images/benefits-of-business-account.svg') }}" class="w-100" alt=""> 
				</div>
			</div>
			<div class="col-lg-6 col-md-6"> 
				<div class="delivery-detals-box">
				    <h2>What are the benefits of
                        a business account?</h2> 
					 <div class="content-box">
					     <ul>
					         <li>A dedicated, named account manager </li>
					         <li>A set collection time for large shippers</li>
					         <li>Flexible credit facilities (subject to credit rating)</li>
					         <li>Exclusive rates for large shippers</li> 
					     </ul>
					 </div>
				</div>
			</div> 
		</div>  
	</div>
</section>

<section class="delivery-sec  our-courier-services-list-sec section_3">
	<div class="container"> 
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper"> 
					<h2>Yalla Courier - The Smarter Way to Ship</h2>
				</div>
			</div>
		</div> 
		<div class="row justify-content-between">
			<div class="col-lg-6 col-md-6">
            	<div class="delivery-detals-box">
                		<h4>Compare delivery cost</h4>
                		<div class="content-box">
                			<p>&nbsp;Yalla Courier is the UAE’s cheapest way to ship with eBay and every
                				other major marketplace.</p>
                			<ul>
                				<li>Link unlimited marketplaces to import all your orders into one
                					easy-to-use dashboard</li>
                				<li>Bulk manage your deliveries with discounted shipping rates
                					exclusive to Yalla Courier</li>
                				<li>Manage your label process with our picking and packing tools</li>
                				<li>Update your customers by notifying marketplaces once you ship
                					your parcels</li>
                			</ul>
                		</div>
                	</div>
                </div> 
			<div class="col-lg-6 col-md-6">
				<div class="delivery-details-img">
					<img src="{{ asset('front_assets/images/compare-delivery-cost.svg') }}" class="w-100" alt=""> 
				</div>
			</div> 
		</div>  
	</div>
</section>

<section class="usessection worksection section_4">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper">
					<h2>Send More, Save More</h2>
				</div>
			</div>
		</div>
		<div class="row courieruses"> 
			<div class="col-lg-6 col-md-6 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper"> 
					<figure class="usesimage">
						<img src="{{ asset('front_assets/images/save-yalla-business-accont.svg') }}" alt="">
					</figure> 
					<div class="content-box-wrapper">
						<h4>Save up to 39% with a Yalla Courier  Business Account</h4>
						<div>
						    <p>If you send over 25 parcels a week, you could save up to 39% on the 
                                price of collection services – discounts will be automatically applied. 
                                That’s on top of our exclusive Yalla Courier shipping prices and 
                                discounts!</p>	
						</div>
					</div>
				</div>
			</div> 
			<div class="col-lg-6 col-md-6 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper"> 
					<figure class="usesimage">
						<img src="{{ asset('front_assets/images/get-vip-treatment.svg') }}" alt="">
					</figure> 
					<div class="content-box-wrapper">
                    	<h4>Get the VIP Treatment with Yalla Courier</h4>
                    	<div>
                    		<p>Send an average of 15 parcels a week and you’ll be invited to
                    			become a Yalla Courier VIP. As a VIP, you’ll get personalised
                    			customer service and help with claims from your dedicated account
                    			manager.</p>
                    	</div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</section>


<section class="usessection worksection section_5 pt-0">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper"> 
					<h2>Send More, Save More</h2>
				</div>
			</div>
		</div>
		<div class="row courieruses"> 
        	<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
        		<div class="useswrapper">
        			<figure class="usesimage">
        				<img src="{{asset('front_assets/images/lead-delivery.svg')}}" alt="">
        			</figure>
        			<div class="content-box-wrapper">
        				<h4>Delivery</h4>
        				<div>
        					<p>&nbsp;Increase customer satisfaction
        						with fast, accurate and reliable
        						delivery.</p>
        				</div>
        			</div>
        		</div>
        	</div> 
        	<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
        		<div class="useswrapper">
        			<figure class="usesimage">
        				<img src="{{asset('front_assets/images/fulfillment.svg')}}" alt="">
        			</figure>
        			<div class="content-box-wrapper">
        				<h4>Fulfillment</h4>
        				<div>
        					<p>&nbsp;Grow your business while we
        						handle your e-commerce
        						needs: store, pick, pack and
        						deliver.</p>
        				</div>
        			</div>
        		</div>
        	</div> 
        	<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
        		<div class="useswrapper">
        			<figure class="usesimage">
        				<img src="{{asset('front_assets/images/international.svg')}}" alt="">
        			</figure>
        			<div class="content-box-wrapper">
        				<h4>International</h4>
        				<div>
        					<p>&nbsp;Offer worldwide shipping
        						services and access
        						international markets.</p>
        				</div>
        			</div>
        		</div>
        	</div> 
        	<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
        		<div class="useswrapper">
        			<figure class="usesimage">
        				<img src="{{asset('front_assets/images/tracking.svg')}}" alt="">
        			</figure>
        			<div class="content-box-wrapper">
        				<h4>Tracking</h4>
        				<div>
        					<p>Say goodbye to “where my
        						order is?, delight your
        						customers with real-time
        						tracking.</p>
        				</div>
        			</div>
        		</div>
        	</div> 
        </div>
	</div>
</section>



@endsection