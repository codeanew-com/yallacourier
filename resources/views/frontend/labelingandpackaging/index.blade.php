@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)

@section('content')
<!-- {{-- innner banner section start --}} -->
    <section class="innerpagebanner">
        <img src="{{ asset('front_assets/') }}/images/banner-service.svg" alt="banner-img" class="banner-img">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content-box-wrapper  text-center">
                    @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','banner_text')->first(); @endphp
                    @if($meta)<h1>{{ $meta->value }}</h1>@endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="banner-section innerpagebannerform" id="banner">
		<div class="container">
			<div class="row">
				<div class="col-12">

					<div class="row">
						<div class="col-12">
							<div class="form-wrapper">
								<div class="content-box-wrapper">
									<h3>Compare and book parcel delivery services</h3>
								</div>
								<form class="banner-calculation-form">
									<div class="row no-gutters">
										<div class="col-lg-3 col-md-6 col-sm-6">
											<div class="input-wrapper">
												<label>From:</label>
												<input type="text" placeholder="Enter Postcode*">
											</div>

										</div>
										<div class="col-lg-3 col-md-6 col-sm-6">
											<div class="input-wrapper">
												<label>To:</label>
												<input type="text" placeholder="Enter Postcode*">
											</div>

										</div>
										<div class="col-lg-3 col-md-6 col-sm-6">
											<div class="input-wrapper selectarrow">
												<label>Quantity</label>
												<select name="Quantity">
													<option value="volvo">1</option>
													<option value="saab">2</option>
													<option value="mercedes">3</option>
													<option value="audi">4</option>
												</select>
											</div>

										</div>
										<div class="col-lg-3 col-md-6 col-sm-6">
											<div class="input-wrapper"> <label>Weight</label>
												<input type="number"> <span class="placeholder-text">kg</span>
											</div>

										</div>
									</div>
									<div class="row align-items-end mt-3 no-gutters">
										<div class="col-lg-2 col-md-4 col-sm-4">
											<div class="input-wrapper">
												<label>Length</label>
												<input type="number"> <span class="placeholder-text">cm</span>
											</div>

										</div>
										<div class="col-lg-2 col-md-4 col-sm-4">
											<div class="input-wrapper">
												<label>Width</label>
												<input type="number"> <span class="placeholder-text">cm</span>
											</div>

										</div>
										<div class="col-lg-2 col-md-4 col-sm-4">

											<div class="input-wrapper">
												<label>Height </label>
												<input type="number"> <span class="placeholder-text">cm</span>
											</div>

										</div>
										<div class="col-lg-6 col-12">
											<div class="submit-wrapper">
												<input type="submit" value="GET A QUOTE">
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
    <!-- {{-- innner banner section End --}}

    {{-- Reliable shipping section start --}} -->
    <section class="usessection reliable-shipping">
        <div class="container">
            <div class="sec-tile text-center">
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_heading')->first(); @endphp
            @if($meta)<h2>{{ $meta->value }}</h2> @endif
            </div>
            @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_one_text')->first(); @endphp
            @if($meta)
            <div class="reliable-shipping-content">
                {{ $meta->value }}
            </div>
            @endif
        </div>
    </section>
    <!-- {{-- Reliable shipping section end --}}

    {{-- Packaging Criteria: section start --}} -->
    <section class="Packaging-Criteria usessection">
        <div class="container">
            <div class="sec-title text-center">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_title_1')->first(); @endphp
                @if($meta)<h2>{{ $meta->value }}</h2>@endif
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="reliable-shipping-list">
                        @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_2_description_1')->first(); @endphp
                        @if($meta) {!! $meta->value !!} @endif
                    </div>
                </div>
            </div>
        </div>
    </section>    
    <!-- {{-- Packaging Criteria: section End --}}
    {{-- Labeling Criteria --}} -->
    <section class="usessection labeling-criteria">
        <div class="container">
            <div class="sec-title text-center">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_title_1')->first(); @endphp
                @if($meta)<h2>{{ $meta->value }}</h2>@endif
            </div> 
            <div class="labeling-criteria-list-wrapper">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_4_description_1')->first(); @endphp
                @if($meta) {!! $meta->value !!} @endif
            </div> 
        </div>
    </section>
    <!-- {{-- Labeling Criteria --}} -->
@endsection