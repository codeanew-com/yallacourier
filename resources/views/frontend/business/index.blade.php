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
                        <h1 class="banner-title" >Save on E-commece International Courier Services</h1>
                       
						<p class="banner-short-description">
Take advantage of our bulk discounted partner rates with all leading couriers in UAE. Because Yalla sends 1000s of parcels a year via their networks they give us a favorable rate versus a single shipper.
</p>
					
			
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
<section class="banner-section extraban banner_sec_2 innerpagebannerform" >

	<div class="container">
		<div class="row">
			<div class="col-12">

				<div class="row">
					<div class="col-12"> 
						<div class="form-wrapper">
							<div class="content-box-wrapper">
								<h3> Request a Yalla Business Account Now!</h3>
								<p style="color: #fff; text-align: center; margin-top:2rem ;"> Enter your details to open a Yalla Courier business account getting<br> access to exclusive delivery discounts throughout the UAE.</p>
							</div>
							<form class="banner-calculation-form" method="POST" action="{{ route('form.submit') }}">
								@csrf
								<h4 style="margin:2rem 0rem 1rem 0rem; color:#fff">Company Details</h4>
								<div class="row no-gutters">
									<div class="col-lg-3 col-md-6 col-sm-6">
										<div class="input-wrapper">
											<input type="text" name="first_name" placeholder="First Name" required>
										</div>

									</div>
									<div class="col-lg-3 col-md-6 col-sm-6">
										<div class="input-wrapper">
											<input type="text" name="last_name" placeholder="Last Name" required>
										</div>

									</div>
									<div class="col-lg-3 col-md-6 col-sm-6">
										<div class="input-wrapper">
											<input type="text" name="position" placeholder="Position" required>
										</div>

									</div>
									<div class="col-lg-3 col-md-6 col-sm-6">
										<div class="input-wrapper">
											<input type="text" name="company_name" placeholder="Company Name" required>
										</div>

									</div>
								</div>
								<div class="row no-gutters">
									<div class="col-lg-6 col-md-6 col-sm-6">
										<div class="input-wrapper">
											<input type="text" name="email" placeholder="Email Address" required>
										</div>
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6">
										<div class="input-wrapper">
											<input type="text" name="phone" placeholder="Phone Number" required>
										</div>
									</div>
								</div>
								<h4 style="margin:2rem 0rem 1rem 0rem; color:#fff">Delivery Information</h4>
								<div class="row align-items-end mt-3 no-gutters">
									<div class="col-lg-4 col-md-4 col-sm-4">
										<div class="input-wrapper selectarrow">
											<select name="number_of_parcel">
												<option value="">Parcels Per Month</option>
												<option value="1">7-10</option>
												<option value="2">10-12</option>
												<option value="3">20-50</option>
												<option value="4">50-100</option>
												<option value="5">100+</option>
											</select>
										</div>
									</div>
									<!--<div class="col-lg-6 col-md-4 col-sm-4" style="display:none">-->
									<!--	<div class="input-wrapper selectarrow">-->
									<!--		<select name="reason_for_switching_provider">-->
									<!--			<option value="">Reason For Switching Provider</option>-->
									<!--			<option value="1">Looking to save</option>-->
									<!--			<option value="2">Streamline shipping</option>-->
									<!--			<option value="3">Bad service</option>-->
									<!--			<option value="4">Currently deliver ourselves</option>-->
									<!--			<option value="5">New company</option>-->
									<!--		</select>-->
									<!--	</div>-->
									<!--</div>-->
									<div class="col-lg-4 col-md-4 col-sm-4">
										<div class="input-wrapper selectarrow">
											<select name="current_delivery_partner">
												<!--<option value="-1">Reason For Changing Provider</option>-->
                                                <option value="">Reason For Changing Provider</option>
												<option value="Looking to save">Looking to save</option>
												<option value="Streamline shipping">Streamline shipping</option>
												<option value="Bad service">Bad service</option>
												<option value="Currently deliver ourselves">Currently deliver ourselves</option>
												<option value="New company">New company</option>
											</select>
										</div>
									</div>
									<div class="col-lg-4 col-12">
										<div class="submit-wrapper" style="position: relative; top: -4px;">
											<input type="submit" value="REGISTER FOR AN ACCOUNT">
										</div>

									</div>
								</div>
							</form>
						</div> 
					</div>
				</div>

			</div>
		</div>

	</div>
</section>

<section class="delivery-sec usessection our-courier-services-list-sec section_2">
	<div class="container"> 
		@for($i=1; $i<3; $i++)
		<div class="row justify-content-between">
			<div class="col-lg-6 col-md-6"> 
				<div class="delivery-detals-box">
					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_title_'.$i)->first(); @endphp
					@if($meta)<h2>{{ $meta->value }}</h2> @endif

					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_text_'.$i)->first(); @endphp
					@if($meta)<div class="content-box"><?php echo $meta->value ?></div> @endif
				</div>
			</div> 
			<div class="col-lg-5 col-md-6">
				<div class="delivery-details-img">
					@if(\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->count()==1)
					@php $file=\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
					<img src="{{ asset($file->path.'/'.$file->name) }}" class="w-100" alt="courier near me">
					@endif
				</div>
			</div> 
		</div> 
		@endfor
	</div>
</section>

<section class="delivery-sec usessection our-courier-services-list-sec section_3">
	<div class="container"> 
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper">
					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_three_heading')->first(); @endphp
					@if($meta)<h2>{{ $meta->value }}</h2> @endif
				</div>
			</div>
		</div>
		@for($i=1; $i<2; $i++)
		<div class="row justify-content-between">
			<div class="col-lg-6 col-md-6"> 
				<div class="delivery-detals-box">
					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_3_title_'.$i)->first(); @endphp
					@if($meta)<h4>{{ $meta->value }}</h4> @endif

					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_3_text_'.$i)->first(); @endphp
					@if($meta)<div class="content-box"><?php echo $meta->value ?></div> @endif
				</div>
			</div> 
			<div class="col-lg-6 col-md-6">
				<div class="delivery-details-img">
					@if(\App\Models\FileModel::where('ref_point','section_3_image_'.$i)->where('ref_id',$page->id)->count()==1)
					@php $file=\App\Models\FileModel::where('ref_point','section_3_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
					<img src="{{ asset($file->path.'/'.$file->name) }}" class="w-100" alt="courier near me">
					@endif
				</div>
			</div> 
		</div> 
		@endfor
	</div>
</section>

<section class="usessection worksection section_4">
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

			@for($i=1; $i<3; $i++)

			<div class="col-lg-6 col-md-6 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper">
					@if(\App\Models\FileModel::where('ref_point','section_4_image_'.$i)->where('ref_id',$page->id)->count()==1)
					@php $file=\App\Models\FileModel::where('ref_point','section_4_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
					<figure class="usesimage">
						<img src="{{ asset($file->path.'/'.$file->name) }}" alt="courier service Abu Dhabi">
					</figure>
					@endif
					<div class="content-box-wrapper">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_title_'.$i)->first(); @endphp
						@if($meta)<h4>{{ $meta->value }}</h4> @endif
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_text_'.$i)->first(); @endphp
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


<section class="usessection worksection section_5">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="content-box-wrapper">
					@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_five_heading')->first(); @endphp
					@if($meta)<h2>{{ $meta->value }}</h2> @endif
				</div>
			</div>
		</div>
		<div class="row courieruses">

			@for($i=1; $i<5; $i++)

			<div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
				<div class="useswrapper">
					@if(\App\Models\FileModel::where('ref_point','section_5_image_'.$i)->where('ref_id',$page->id)->count()==1)
					@php $file=\App\Models\FileModel::where('ref_point','section_5_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
					<figure class="usesimage">
						<img src="{{ asset($file->path.'/'.$file->name) }}" alt="courier service Abu Dhabi">
					</figure>
					@endif
					<div class="content-box-wrapper">
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_5_title_'.$i)->first(); @endphp
						@if($meta)<h4>{{ $meta->value }}</h4> @endif
						@php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_5_text_'.$i)->first(); @endphp
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



@endsection