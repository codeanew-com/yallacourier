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
                        <h1 class="banner-title" >Save 60% on International Courier Services</h1>
                        
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




    <!-- {{-- innner banner section End --}}
    
    
    {{-- UAE parcel delivery made easy section start --}} -->
    <section class="parcel-sec usessection">
        <div class="container ">
            <div class="sec-title text-center">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_heading')->first(); @endphp
                @if($meta)<h2>{{ $meta->value }}</h2>@endif
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_text')->first(); @endphp
                <div class="content-box">
                    @if($meta) {{ $meta->value }} @endif
                </div>
            </div>
        </div>
    </section>
    
    <!-- {{-- UAE parcel delivery made easy section end --}}
    {{-- delivery section start --}} -->
    <section class="delivery-sec usessection">
        <div class="container">
        @for($i=1; $i<4; $i++)
            <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-md-6">
                    <div class="delivery-detals-box">
                        @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_title_'.$i)->first(); @endphp
                        @if($meta)<h4>{{ $meta->value }}</h4>@endif
                        @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_description_'.$i)->first(); @endphp
                        @if($meta)<div class="content-box">{!! $meta->value !!}</div>@endif
                    </div>
                </div>
                @if(\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->count()==1)
                    @php $file=\App\Models\FileModel::where('ref_point','section_2_image_'.$i)->where('ref_id',$page->id)->first(); @endphp
                    <div class="col-lg-5 col-md-6">
                        <div class="delivery-details-img">
                            <img src="{{ asset($file->path.'/'.$file->name) }}" class="w-100" alt="">
                        </div>
                    </div>
                @endif
            </div>
        @endfor

        </div>
    </section>
    <!-- {{-- delivery section end --}}
    {{-- How it work section start --}} -->
    <section class="usessection worksection">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content-box-wrapper">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_four_heading')->first(); @endphp
                    @if($meta)<h2>{{ $meta->value }}</h2>@endif
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
                            @if($meta)<h4>{{ $meta->value }}</h4>@endif
                            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_description_'.$i)->first(); @endphp
                            @if($meta)<div>{!! $meta->value !!}</div>@endif
                        </div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </section>
    <!-- {{-- How it work section end --}} -->
@endsection