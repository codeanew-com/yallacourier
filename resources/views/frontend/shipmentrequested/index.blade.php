@extends('frontend.layouts.master')

@section('title', 'Shipment request received')

@section('content')

<section class="new-banner-sec lead-thank-you-page-banner">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-8 col-md-10">
				<div class="contentbox">
					<h1 class="banner-title">Thanks — we've got your shipment request</h1>
					<p class="banner-short-description">
						Request <strong>#{{ $order->id }}</strong> has been received. One of our team will review the details,
						arrange the best courier for your route, and confirm pricing with you shortly — no payment is needed right now.
					</p>
					@if(Auth::guard('customers')->check())
						<a href="{{ route('customer.view.order', $order->id) }}" class="purple-theme-btn"><span>View this shipment</span></a>
						<a href="{{ route('frontend.customer.shipmentsetting.index') }}" class="purple-theme-btn" style="margin-left:12px;"><span>My shipments</span></a>
					@else
						<a href="{{ url('/') }}" class="purple-theme-btn"><span>Back to homepage</span></a>
					@endif
				</div>
			</div>
		</div>
	</div>
</section>

@endsection
