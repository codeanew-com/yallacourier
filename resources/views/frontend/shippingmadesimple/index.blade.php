@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)

@section('content')


    <!--New Banner Section Start-->
    <section class="home-banner-sec new-banner-sec luggage">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-6">
                    <div class="contentbox">
                        <h1 class="banner-title" >Send your parcels door to door in UAE upto 60% discount</h1>
                       
						<p class="banner-short-description">
Take advantage of our bulk discounted partner rates with all leading couriers in UAE. Because Yalla sends 1000s of parcels a year via their networks they give us a favorable rate versus a single shipper.
</p>
						
                        <!--<p class="banner-short-description">Send parcels from the UAE to UAE or-->
                        <!--Internationally at great rates. With one click fast-->
                        <!--booking from your smartphone anytime.</p>-->
                        <!--<ul class="banner-list">-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Compare courier prices & pay less</span> </li>-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Save time and money</span> </li>-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>No sign up required</span> </li>-->
                        <!--    <li><img class="banner-list-icon" src="{{ asset('front_assets/images/banner-list-icon.svg') }}" /> <span>Upto 40% discount on shipping rates</span> </li>-->
                        <!--</ul>-->
                        <div class="rating-box">
                            <img class="img-fluid banner-ratings d-block" src="{{ asset('front_assets/images/rating-stars.svg') }}" alt="Courier Service" />
                            <span class="rating-text"><b>Over 47,000 parcels sent</b></span>
                        </div>
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




    <section class="banner-section inner-banner-form-sec" id="banner">
		<div class="container">
			<div class="row">
				<div class="col-12">
				
					
					<iframe src="https://yallashipping.com/iframe-page/" style="border:none" height="800" width="100%" scrolling="no" title="Iframe Example"></iframe>
					
					
				</div>
			</div>

		</div>
	</section>
    <!-- {{-- innner banner section End --}}
    {{-- Calculate girth  section start --}} -->
    <section class=" calculate-grith-sec usessection">
        <div class="container">
            <div class="sec-title text-center">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_heading')->first(); @endphp
                @if($meta)<h2>{{ $meta->value }}</h2>@endif
            </div>
            <div class="calculate-content">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_text')->first(); @endphp
                @if($meta) {!! $meta->value !!} @endif
            </div>
            <div class="calculate-box-lenght text-center">
            @if(\App\Models\FileModel::where('ref_point','section_1_image')->where('ref_id',$page->id)->count()==1)
            @php $file=\App\Models\FileModel::where('ref_point','section_1_image')->where('ref_id',$page->id)->first(); @endphp
                <img src="{{ asset($file->path.'/'.$file->name) }}" alt="" class="w-100">
            @endif
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_second_heading')->first(); @endphp
            @if($meta)   <h4 class="fc-middle">{{ $meta->value }}</h4> @endif
            </div>
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_second_text')->first(); @endphp
            @if($meta)
            <div class="calculate-box-content text-center d-none">
                {!! $meta->value !!}
            </div>
            @endif

            <div class="row d-none">
                <div class="col-12">
                    <div class="form-wrapper">
                        <div class="content-box-wrapper">
                            <h3>Package Length + Girth Calculator</h3>
                        </div>
                        <form class="calculation-form">

                            <div class="row align-flex-end mt-3 justify-content-center">
                                <div class="col-lg-6 col-md-4 col-sm-4">
                                    <div class="input-wrapper">
                                        <label>Length :</label>
                                        <input type="number"> <span class="placeholder-text">cm</span>
                                    </div>

                                </div>
                                <div class="col-lg-6 col-md-4 col-sm-4">
                                    <div class="input-wrapper">
                                        <label>Width :</label>
                                        <input type="number"> <span class="placeholder-text">cm</span>
                                    </div>

                                </div>
                                <div class="col-lg-6 col-md-4 col-sm-4"> 
                                    <div class="input-wrapper">
                                        <label>Height :</label>
                                        <input type="number"> <span class="placeholder-text">cm</span>
                                    </div> 
                                </div>
                                <div class="col-lg-3 col-12">
                                    <div class="submit-wrapper">
                                        <input type="submit" value="RESET">
                                    </div>

                                </div>
                                <div class="col-lg-3 col-12">
                                    <div class="submit-wrapper">
                                        <input type="submit" value="GET A QUOTE"  style="background-color: #A6E207;">
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="from-icon">
                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="input-wrapper input-wrapper-bottom justify-content-center align-items-center">
                                        <label>Girth Weight:</label>
                                        <input type="number"> <span class="placeholder-text">cm</span>
                                    </div>
                                    <!-- <div class="input-wrapper-bottom justify-content-center align-items-center">
                                        <label>Height:</label>
                                        <input type="number"> <span class="placeholder-text">cm</span>
                                    </div> -->

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </section>
    <!-- {{-- Calculate girth  section End --}}

    {{-- Calculate the length section start --}} -->
    <section class="parcel-manually usessection">
        <div class="container">
            <div class="sec-title text-center">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_title_1')->first(); @endphp
                @if($meta)<h2>{{ $meta->value }}</h2>@endif
            </div>
            <div class="parcel-manually-content">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_description_1')->first(); @endphp
                @if($meta) {!! $meta->value !!} @endif
            </div>

        </div>
    </section>
    <!-- {{-- Calculate the length section End --}} -->
@endsection