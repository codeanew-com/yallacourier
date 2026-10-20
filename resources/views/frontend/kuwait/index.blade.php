@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)

<style>
    /*section.banner-section .form-wrapper .tab-links ul li[data-tab=tab-01]{*/
    /*    display:none;*/
    /*}*/
    /*section.banner-section .form-wrapper .tab-links ul li[data-tab=tab-02]{*/
    /*    display:none;*/
    /*}*/
    /*section.banner-section .form-wrapper .tab-links ul li[data-tab=tab-04]{*/
    /*    background: #680895;*/
    /*}*/
    /*section.banner-section .form-wrapper .tab-content#tab-04{*/
    /*    display:block;*/
    /*}*/
    /*section.banner-section .form-wrapper .tab-content#tab-01,*/
    /*section.banner-section .form-wrapper .tab-content#tab-02 {*/
    /*    display:none;*/
    /*}*/
</style>

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
	
	
.my-button2 {
  padding: 17px 40px;
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
                        <h1 class="banner-title" >Send a Parcel To Kuwait By Courier upto 60% Cheaper Than DHL</h1>
                        <p class="banner-short-description">
Take advantage of our bulk discounted partner rates with all leading couriers in UAE. Because Yalla sends 1000s of parcels a year via their networks they give us a favorable rate versus a single shipper.
</p>
						<a href="https://wa.me/971526607133"><button class="my-button2">WhatsApp Us</button></a>
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
<section class="banner-section extraban landing_eban" id="banner">

	<div class="container">
		<div class="row">
			<div class="col-12">

		<iframe src="https://yallashipping.com/iframe-page/" style="border:none" height="800" width="100%" scrolling="no" title="Iframe Example"></iframe>


			</div>
		</div>

	</div>
</section>

<!-- section 1 starts -->
<section class="sectionadvertisement landing_eadv">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-wrapper">
					@if(\App\Models\FileModel::where('ref_point','section_one_image')->where('ref_id',$page->id)->count()==1)
					@php $file=\App\Models\FileModel::where('ref_point','section_one_image')->where('ref_id',$page->id)->first(); @endphp
					<figure>
						<img src="{{ asset($file->path.'/'.$file->name) }}" alt="Courier Delivery Service Kuwait" class="text-center">
					</figure>
					@endif
					<div class="content-box-wrapper text-center">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_heading')->first(); @endphp
						@if($meta)<h2>{{ $meta->value }}</h2> @endif
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_text')->first(); @endphp
						@if($meta)<div>{{ $meta->value }}</div> @endif
					</div>
				</div>
			</div>
		</div>
	</div>
</section>





<section class="usessection worksection deliversection">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper">
					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_two_heading')->first(); @endphp
					@if($meta)<h2>{{ $meta->value }}</h2> @endif
				</div>
			</div>
		</div>
		<div class="row courieruses">

			@for($i=1; $i<5; $i++)

			<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper">
					@if(\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->count()==1)
					@php $file=\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->first(); @endphp

					<img src="{{ asset($file->path.'/'.$file->name) }}" alt="Courier Service Kuwait" style="width: 100px;height: 100px;text-align: center;display: block;margin: 25px auto;">
					@endif
					<div class="content-box-wrapper">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_title_'.$i)->first(); @endphp
						@if($meta)<h5>{{ $meta->value }}</h5> @endif
					</div>
				</div>
			</div>
			@endfor

		</div>
	</div>
</section>


<!--UAE parcel delivery made easy section start  -->

<section class="parcel-sec usessection our-courier-services-sec landing_eparcel">
	<div class="container ">
		<div class="sec-title text-center"> 
			@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_heading')->first(); @endphp
			@if($meta)<h2>{{ $meta->value }}</h2> @endif
		</div>
	</div>
</section>
<!---- UAE parcel delivery made easy section end ---->
<!--{{-- delivery section start --}} --> 
<section class="delivery-sec usessection our-courier-services-list-sec landing_edelivery">
	<div class="container"> 
		@for($i=1; $i<6; $i++)
		<div class="row justify-content-between">
			<div class="col-lg-6 col-md-6"> 
				<div class="delivery-detals-box">
					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_3_title_'.$i)->first(); @endphp
					@if($meta)<h4>{{ $meta->value }}</h4> @endif

					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_3_text_'.$i)->first(); @endphp
					@if($meta)<div class="content-box">{{ $meta->value }}</div> @endif
				</div>
			</div> 
			<div class="col-lg-5 col-md-6">
				<div class="delivery-details-img">
					@if(\App\Models\FileModel::where('ref_point','section_3_image_'.$i)->where('ref_id',$page->id)->count()==1)
					@php $file=\App\Models\FileModel::where('ref_point','section_3_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
					<img src="{{ asset($file->path.'/'.$file->name) }}" class="w-100" alt="">
					@endif
				</div>
			</div> 
		</div> 
		@endfor
<!-- 			<div class="row  justify-content-between">
				<div class="col-lg-6 col-md-6"> 
					<div class="delivery-detals-box">
						<h4>International Delivery from AED 189</h4> 
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
						<h4>Large Parcel Delivery from AED 39</h4> 
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
			</div>  -->
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
							<img src="{{ asset($file->path.'/'.$file->name) }}" alt="International Shipping Kuwait">
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
	<section class="testimonialsection">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="content-box-wrapper text-center">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_five_heading')->first(); @endphp
						@if($meta)<h2>{{ $meta->value }}</h2>@endif
					</div>
				</div>
			</div>
			<div class="row testimonialsrow">
				<div class="col-12">
					<div class="testimonialwrapper">
						@foreach(\App\Models\ReviewModel::where('show_on_home',1)->where('status',1)->get() as $review)
						<div class="single-testimonials">
							<div class="topquotes">
								<img src="{{asset('front_assets/')}}/images/Group 237.svg" alt="International Shipping Kuwait" class="quotes">
								<img src="{{asset('front_assets/')}}/images/Group 238.svg" alt="International Shipping Kuwait" class="stars">
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
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_six_heading')->first(); @endphp
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
							@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_seven_heading')->first(); @endphp
							@if($meta)	<h2>{{$meta->value}}</h2> @endif
							@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_seven_text')->first(); @endphp
							@if($meta) {{$meta->value}} @endif
						</div>
						<div class="Logowrap">
							@for($i=1; $i<8; $i++)
								@if(\App\Models\FileModel::where('ref_point','section_7_image_'.$i)->where('ref_id',$page->id)->count()==1)
								@php $file=\App\Models\FileModel::where('ref_point','section_7_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
									<div class="singleimage"><div class="imgwrap"><img src="{{ asset($file->path.'/'.$file->name) }}"></div></div>
								@endif
							@endfor
							
						</div>
					</div>
				</div>
			</section>


			@endsection

			@push('scripts')
			<script>
				$(document).ready(function(){
					$("#shipment_from_country").change(function(){
						var dataString = "id="+$(this).find(":selected").val();
						$.ajax
						({
							type: "GET",
							url: "{{ url('/get/intcities')}}",
							data: dataString,
							success: function(html)
							{
								$("#shipment_from_city").html(html);

							}
						});
					});

				});
			</script>
			<script>
				$(document).ready(function(){
					$("#shipment_to_country").change(function(){
						var dataString = "id="+$(this).find(":selected").val();
						$.ajax
						({
							type: "GET",
							url: "{{ url('/get/intcities')}}",
							data: dataString,
							success: function(html)
							{
								$("#shipment_to_city").html(html);

							}
						});
					});

				});
			</script>
			<script>
				$(document).ready(function(){
					$("#sender_state").change(function(){
						var dataString = "id="+$(this).find(":selected").attr("data-v");
						$.ajax
						({
							type: "GET",
							url: "{{ url('/get/cities')}}",
							data: dataString,
							success: function(html)
							{
								$("#sender_city").html(html);

							}
						});
					});

				});
			</script>
			<script>
				$(document).ready(function(){
					$("#reciever_state").change(function(){
						var dataString = "id="+$(this).find(":selected").attr("data-v");

						$.ajax
						({
							type: "GET",
							url: "{{ url('/get/cities')}}",
							data: dataString,
							success: function(html)
							{
								$("#reciever_city").html(html);

							}
						});
					});

				});
			</script>
			<script>
				$(document).ready(function(){
					$("#sender_state1").change(function(){
						var dataString = "id="+$(this).find(":selected").attr("data-v");
						$.ajax
						({
							type: "GET",
							url: "{{ url('/get/cities')}}",
							data: dataString,
							success: function(html)
							{
								$("#sender_city1").html(html);

							}
						});
					});

				});
			</script>
			<script>
				$(document).ready(function(){
					$("#reciever_state1").change(function(){
						var dataString = "id="+$(this).find(":selected").attr("data-v");

						$.ajax
						({
							type: "GET",
							url: "{{ url('/get/cities')}}",
							data: dataString,
							success: function(html)
							{
								$("#reciever_city1").html(html);

							}
						});
					});

				});
			</script>
			@endpush