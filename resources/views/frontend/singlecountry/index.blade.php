@extends('frontend.layouts.master')
@section('content')

<!--New Banner Section Start-->
<section class="innerpagebanner">
	@if(\App\Models\FileModel::where('ref_point','landing_banner_background')->where('ref_id',$country->id)->count()==1)
	@php $file=\App\Models\FileModel::where('ref_point','landing_banner_background')->where('ref_id',$country->id)->first(); @endphp
	<img src="{{ asset($file->path.'/'.$file->name) }}" alt="banner-img" class="banner-img">
	@endif
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper  text-center">
					<h1>{{ $country->banner_title }}</h1>
				</div>
			</div>
		</div>
	</div>
</section>
<!--New Banner Section End-->

<!-- Banner Section Starts -->
<section class="banner-section extraban landing_eban" id="banner">

	<div class="container">
		<div class="row">
			<div class="col-12">
                @if($country->shipment_to_country=='QA')
				    @include('frontend.searchcourier.qatar')
				@endif
				@if($country->shipment_to_country=='SA')
				    @include('frontend.searchcourier.saudi-arabia')
				@endif
				@if($country->shipment_to_country=='KW')
				    @include('frontend.searchcourier.kuwait')
				@endif
				@if($country->shipment_to_country=='LB')
				    @include('frontend.searchcourier.lebanon')
				@endif
				@if($country->shipment_to_country=='JO')
				    @include('frontend.searchcourier.jordan')
				@endif
				@if($country->shipment_to_country=='OM')
				    @include('frontend.searchcourier.oman')
				@endif
				@if($country->shipment_to_country=='BH')
				    @include('frontend.searchcourier.bahrain')
				@endif
				<!--New Countries-->
				{{-- gb/de/in/pk/fr/ir used to be separate near-duplicate copies of this
				     form, each wired to the old Aramex/Posta/Skynet booking flow that was
				     removed 2026-10-19. They now share the one working form (same as
				     qatar/saudi-arabia/etc. above use their own small variants, which
				     don't reference the removed flow and were left as-is). --}}
				@if(in_array($country->shipment_to_country, ['GB','DE','IN','US','PK','FR','IR']))
				    @include('frontend.searchcourier.index')
				@endif
				

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
					@if(\App\Models\FileModel::where('ref_point','section_one_image')->where('ref_id',$country->id)->count()==1)
					@php $file=\App\Models\FileModel::where('ref_point','section_one_image')->where('ref_id',$country->id)->first(); @endphp
					<figure>
						<img src="{{ asset($file->path.'/'.$file->name) }}" alt="" class="text-center">
					</figure>
					@endif
					<div class="content-box-wrapper text-center">
						<h2>{{ $country->sec_one_title }}</h2>
						<div>{{ $country->sec_one_content }}</div> 
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
					<h2>{{ $country->sec_two_title }}</h2>
				</div>
			</div>
		</div>
		<div class="row courieruses">

		@php
		    // Fetch all relevant images in one query
		    $images = \App\Models\FileModel::where('ref_id', $country->id)
		                ->whereIn('ref_point', ['section_2_image_1', 'section_2_image_2', 'section_2_image_3', 'section_2_image_4'])
		                ->get()
		                ->keyBy('ref_point'); // Use keyBy to index by 'ref_point'
		@endphp


	    @for($i = 1; $i < 5; $i++)
	        <div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
	            <div class="useswrapper">
	                @if(isset($images['section_2_image_' . $i]))
	                    @php $file = $images['section_2_image_' . $i]; @endphp
	                    <img src="{{ asset($file->path . '/' . $file->name) }}" alt="" style="width: 100px; height: 100px; text-align: center; display: block; margin: 25px auto;">
	                @endif
	                <div class="content-box-wrapper">
	                    <h5>{{ $country->{'sec_two_subheading_' . $i} }}</h5>
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
			<h2>{{ $country->sec_three_title }}</h2>
		</div>
	</div>
</section>
<!---- UAE parcel delivery made easy section end ---->
<!--{{-- delivery section start --}} --> 
<section class="delivery-sec usessection our-courier-services-list-sec landing_edelivery">
	@php
	    $images = \App\Models\FileModel::where('ref_id', $country->id)
	                ->whereIn('ref_point', [
	                    'section_3_image_1', 
	                    'section_3_image_2', 
	                    'section_3_image_3', 
	                    'section_3_image_4', 
	                    'section_3_image_5'
	                ])
	                ->get()
	                ->keyBy('ref_point'); // Use keyBy to index images by 'ref_point'
	@endphp

	<div class="container"> 
	    @for($i = 1; $i < 6; $i++)
	        <div class="row justify-content-between">
	            <div class="col-lg-6 col-md-6"> 
	                <div class="delivery-detals-box">
	                    <h4>{{ $country->{'sec_three_subheading' . $i} }}</h4> 
	                    <div class="content-box">{{ $country->{'sec_three_content_' . $i} }}</div> 
	                </div>
	            </div> 
	            <div class="col-lg-5 col-md-6">
	                <div class="delivery-details-img">
	                    @if(isset($images['section_3_image_' . $i]))
	                        @php $file = $images['section_3_image_' . $i]; @endphp
	                        <img src="{{ asset($file->path . '/' . $file->name) }}" class="w-100" alt="">
	                    @endif
	                </div>
	            </div> 
	        </div> 
	    @endfor
	</div>
</section>
<!--{{-- delivery section end --}}-->

<!-- section 4 starts -->
<section class="usessection worksection">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper">
					<h2>{{ $country->sec_four_title }}</h2>
				</div>
			</div>
		</div>
		@php
		    // Fetch all relevant images for section 4 in one query
		    $images = \App\Models\FileModel::where('ref_id', $country->id)
		                ->whereIn('ref_point', [
		                    'section_4_image_1', 
		                    'section_4_image_2', 
		                    'section_4_image_3'
		                ])
		                ->get()
		                ->keyBy('ref_point'); // Use keyBy to index images by 'ref_point'
		@endphp

		<div class="row courieruses">
		    @for($i = 1; $i < 4; $i++)
		        <div class="col-lg-4 col-md-4 col-sm-6 courierusesmainwrapper">
		            <div class="useswrapper">
		                @if(isset($images['section_4_image_' . $i]))
		                    @php $file = $images['section_4_image_' . $i]; @endphp
		                    <figure class="usesimage">
		                        <img src="{{ asset($file->path . '/' . $file->name) }}" alt="">
		                    </figure>
		                @endif
		                <div class="content-box-wrapper">
		                    <h4>{{ $country->{'sec_four_subheading' . $i} }}</h4>
		                    <div>
		                        {{ $country->{'sec_four_content_' . $i} }}
		                    </div>
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
					<h2>{{ $country->sec_five_title }}</h2>
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
					<h2>{{ $country->sec_six_title }}</h2>
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
						<h2>{{ $country->sec_seven_title }}</h2>
						<div>{{ $country->sec_seven_content }}</div>
					</div>
					@php
					    $images = \App\Models\FileModel::where('ref_id', $country->id)
					                ->whereIn('ref_point', [
					                    'section_7_image_1', 
					                    'section_7_image_2', 
					                    'section_7_image_3', 
					                    'section_7_image_4', 
					                    'section_7_image_5', 
					                    'section_7_image_6', 
					                    'section_7_image_7'
					                ])
					                ->get()
					                ->keyBy('ref_point'); // Use keyBy to index images by 'ref_point'
					@endphp

					<div class="Logowrap">
					    @for($i = 1; $i < 8; $i++)
					        @if(isset($images['section_7_image_' . $i]))
					            @php $file = $images['section_7_image_' . $i]; @endphp
					            <div class="singleimage">
					                <div class="imgwrap">
					                    <img src="{{ asset($file->path . '/' . $file->name) }}">
					                </div>
					            </div>
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