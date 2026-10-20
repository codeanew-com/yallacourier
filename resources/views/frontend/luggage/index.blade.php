@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)


@section('content')


<script>
window.onload = function() {
    // similar behavior as clicking on a link
    window.location.href = "https://yallaluggage.com/";
}
</script>


<div class="luggage">

    <section class="home-banner-sec new-banner-sec ">
       <div class="container">
          <div class="row align-items-center">
             <div class="col-lg-5 col-md-6">
                <div class="contentbox">
                   <h1 class="banner-title">Fast & Affordable
 Luggage Shipping
 From the UAE
                   </h1>
                   <p class="banner-short-description">Worldwide Luggage & Clothing Delivery</p>
                   <div class="rating-box">
                      <img class="img-fluid banner-ratings d-block" src="{{ asset('front_assets/images/rating-stars.svg') }}" alt="Luggage Shipping" />
                      <span class="rating-text"><b> Over 19,000 Luggage Bags Sent</b></span>
                   </div>
                </div>
             </div>
             <div class="col-lg-7 col-md-6">
                <div class="imgbox">
                   <img class="w-100" src="{{ asset('front_assets/images/luggage/banner.svg') }}" />
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
                      {{-- Was its own near-duplicate form wired to the old courier-comparison
                           flow, removed 2026-10-19. Now shares the one working form. --}}
                      @include('frontend.searchcourier.index')
                   </div>
                </div>
             </div>
          </div>
       </div>
    </section>

    <section class="delivery-sec usessection our-courier-services-list-sec ">
       <div class="container">
          <div class="row justify-content-between align-items-center">
             <div class="col-lg-6 col-md-6">
                <div class="delivery-detals-box">
                   <h2> The lowest rates backed 
                      by the reliability of 
                      FedEx®, SkyNet and 
                      Aramex 
                   </h2>
                   <div class="content-box">
                      <p>Using technology to leverage existing 
                         logistics networks, we have built the first 
                         luggage shipping platform that is easy and 
                         affordable for everyone. Yalla Courier finds 
                         you the cheapest luggage shipping rates and 
                         then lets you choose what options you need, 
                         like doorstep pickup or additional coverage. 
                         That way you only pay for the options you 
                         use.
                      </p>
                   </div>
                </div>
             </div>
             <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                   <img src="{{ asset('front_assets/images/luggage/Asset 4.svg
                      ') }}" class="w-100" alt="">
                </div>
             </div>
          </div>
          <div class="row  justify-content-between align-items-center">
             <div class="col-lg-6 col-md-6">
                <div class="delivery-detals-box">
                   <h2> What can I ship?
                      Ship luggage, golf clubs, 
                      skis, or boxes 
                   </h2>
                   <div class="content-box">
                      <p>If you don’t haul your bags to the airport, you 
                         never worry about packing too much again. If 
                         you would otherwise check it, LugLess can 
                         help you send it. Ship golf clubs to the 
                         course, ship skis and snowboards to the 
                         mountain. We can even make it easier and 
                         cheaper to ship boxes, which is popular for 
                         shipping things to school.
                      </p>
                   </div>
                </div>
             </div>
             <div class="col-lg-5 col-md-6">
                <div class="delivery-details-img">
                   <img src="{{ asset('front_assets/images/luggage/Asset 5.svg') }}" class="w-100" alt="">
                </div>
             </div>
          </div>
       </div>
    </section>
    
    <section class="usessection" style="background: #7e38af;">
       <div class="container">
          <div class="row">
             <div class="col-12">
                <div class="content-box-wrapper">
                   <h2 style="color: #fff;"> The easiest way to ship luggage</h2>
                   <p style="color: #fff;">We can’t decide if the best part of using Yalla Courier is the price or the convenience. And frankly, we’re not sure the answer even matters.</p>
                </div>
             </div>
          </div>
          <div class="row courieruses">
             <div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
                <div class="useswrapper">
                   <figure class="usesimage">
                      <img src="{{ asset('front_assets/images/luggage/icon-1.svg')  }}" alt="Luggage Shipping Dubai">
                   </figure>
                   <div class="content-box-wrapper">
                      <h4 style="color: #fff;">Book</h4>
                      <div style="color: #fff;">
                         We’ll find the cheapest
                         FedEx or Skynet rates 
                         and send a shipping 
                         label right to your 
                         phone.
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
                <div class="useswrapper">
                   <figure class="usesimage">
                      <img src="{{ asset('front_assets/images/luggage/icon-2.svg')  }}" alt="Ship Luggage">
                   </figure>
                   <div class="content-box-wrapper">
                      <h4 style="color: #fff;">Ship</h4>
                      <div style="color: #fff;">
                         Bring your bags to our 
                         nearby carrier location in 
                         Mercato mall. There you 
                         can scan, print, and 
                         attach Shipping labels. 
                         Or even better we will 
                         collect from your home.
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
                <div class="useswrapper">
                   <figure class="usesimage">
                      <img src="{{ asset('front_assets/images/luggage/icon-3.svg')  }}" alt="Luggage Shipping">
                   </figure>
                   <div class="content-box-wrapper">
                      <h4 style="color: #fff;">Relax</h4>
                      <div style="color: #fff;">
                         Head to the airport on 
                         your travels with
                         just the bare essentials 
                         and enjoy traveling 
                         without the baggage. Or 
                         wait till your clothes 
                         arrive at your chosen 
                         location back home.
                      </div>
                   </div>
                </div>
             </div>
             <div class="col-lg-3 col-md-3 col-sm-6 courierusesmainwrapper">
                <div class="useswrapper">
                   <figure class="usesimage">
                      <img src="{{ asset('front_assets/images/luggage/icon-4.svg')  }}" alt="Luggage Shipping Abu Dhabi">
                   </figure>
                   <div class="content-box-wrapper">
                      <h4 style="color: #fff;">Voilà</h4>
                      <div style="color: #fff;">
                         Your luggage arrives at
                         your final destination, or
                         Choose to have it held at 
                         a nearby FedEx or 
                         Skynet location.
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </section>
  
    <section class="shipping-routes-sec usessection">
       <div class="container">
          <div class="content-box-wrapper">
             <h2>Popular International Shipping Routes</h2>
          </div>
          <div class="shipping-routes-wrapper">
             <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="Luggage Shipping Dubai" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Luggage Shipping Abu Dhabi" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Qatar.svg')  }}" alt="Send Luggage"  />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to Qatar</h6>
                         <p>Estimated transit time 2/5 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}"  alt="Luggage Shipping Dubai" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Ship Luggage" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Saudi.svg')  }}" alt="Send luggage" />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to Saudi</h6>
                         <p>Estimated transit time 2/5 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="Luggage Shipping Dubai" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Luggage Courier Service" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Oman.svg')  }}" alt="Luggage Courier"/>
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to Oman</h6>
                         <p>Estimated transit time 2/5 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="Luggage Shipping Dubai" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Luggage Shipping Dubai" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/kuwait.svg')  }}" alt="Luggage Shipping Dubai" />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to kuwait</h6>
                         <p>Estimated transit time 2/5 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" alt="Luggage Shipping Oman" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" alt="Luggage Shipping" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Bahrain.svg')  }}"alt="Luggage Courier"  />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to Bahrain</h6>
                         <p>Estimated transit time 2/5 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Lebanon.svg')  }}" />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to Lebanon</h6>
                         <p>Estimated transit time 3/7 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Turkey.svg')  }}" />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to Turkey</h6>
                         <p>Estimated transit time 3/7 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Egypt.svg')  }}" />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to Egypt</h6>
                         <p>Estimated transit time 3/7 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/India.svg')  }}" />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to India</h6>
                         <p>Estimated transit time 3/7 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/pakistan.svg')  }}" />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to Pakistan</h6>
                         <p>Estimated transit time 3/7 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/uk.svg')  }}" />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to UK</h6>
                         <p>Estimated transit time 3/7 days</p>
                      </div>
                   </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-6">
                   <div class="shipping-route-box">
                      <div class="flags-box-wrapper">
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Dubai_1.svg')  }}" />
                         </div>
                         <span class="flag-separator">
                         <img src="{{ asset('front_assets/images/arrow-icon.svg')  }}" />
                         </span>
                         <div class="flagbox ship-from">
                            <img src="{{ asset('front_assets/images/Germany.svg')  }}" />
                         </div>
                      </div>
                      <div class="shipping-route-content">
                         <h6>Dubai to Germany</h6>
                         <p>Estimated transit time 3/7 days</p>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </section>

    <section class="testimonialsection newchngetesthome">
       <div class="container">
          <div class="row">
             <div class="col-12">
                <h2 class="text-center"> What our customer have to say?</h2>
                <div class="content-box-wrapper text-center">
                   @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_five_heading')->first(); @endphp
                   @if($meta)
                   <h2>{{ $meta->value }}</h2>
                   @endif
                </div>
             </div>
          </div>
          <div class="trustpilot mt-4 text-center">    <img src="{{asset('front_assets/')}}/images/trustpilotupdated.svg" alt="" class="trustindex"></div>
          <div class="row testimonialsrow">
             <div class="col-12">
                <div class="testimonialwrapper">
                   @foreach(\App\Models\ReviewModel::where('show_on_home',1)->where('status',1)->get() as $review)
                   <div class="single-testimonials">
                      <div class="topquotes">
                         <img src="{{asset('front_assets/')}}/images/tpupdated.svg" alt="" class="quotes">
                         <img src="{{asset('front_assets/')}}/images/starupdated.svg" alt="" class="stars">
                      </div>
                      <div class="middle-testimonial">
                         <div class="content-box">
                            {!! $review->review !!}
                         </div>
                      </div>
                      <div class="bottom-testomnialperson">
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
    
    <section class="parcelbanner">
       <div class="container">
          <div class="row align-items-end">
             <div class="col-lg-6 col-md-6 col-sm-7">
                <div class="content-box-wrapper">
                   <h2>Get a quote for your parcel delivery today!</h2>
                   <div class="button-holder">
                      <a href="/uae-parcel-delivery" class="green-theme-btn"><span>GET A QUOTE?</span></a>
                   </div>
                </div>
             </div>
             <div class="col-lg-6 col-md-6 col-sm-5">
                <div class="image-wrapper">
                   <figure class="phoneimage">
                      <img class="img-fluid" src="{{ asset('front_assets/images/luggage/hand.svg')  }}" alt="">
                   </figure>
                </div>
             </div>
          </div>
       </div>
    </section>
    
    <section class="faqsection">
       <div class="container">
       <div class="row">
          <div class="col-12">
             <h2 class="text-center"> Frequently Asked Questions</h2>
             <div class="content-box-wrapper text-center">
                @php $meta=\App\Models\PageMetaModel::where('ref_id',$page->id)->where('ref_key','section_seven_heading')->first(); @endphp
                @if($meta)   
                <h2>{{$meta->value}}</h2>
                @endif
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

    <section class="faqsection logoclient pt-0">
       <div class="container">
          <div class="row">
             <div class="col-12">
                <div class="content-box-wrapper text-center">
                   <h2>Our Delivery Partners</h2>
                   Send your parcel with trusted delivery companies
                </div>
                <div class="Logowrap">
                   <div class="singleimage">
                      <div class="imgwrap"><img src="{{asset('front_assets/')}}/images/jt.svg"></div>
                   </div>
                   <div class="singleimage">
                      <div class="imgwrap"><img src="{{asset('front_assets/')}}/images/shipa.svg"></div>
                   </div>
                   <div class="singleimage">
                      <div class="imgwrap"><img src="{{asset('front_assets/')}}/images/skynet.svg"></div>
                   </div>
                   <div class="singleimage">
                      <div class="imgwrap"><img src="{{asset('front_assets/')}}/images/shyftd.svg"></div>
                   </div>
                   <div class="singleimage">
                      <div class="imgwrap"><img src="{{asset('front_assets/')}}/images/aramex.svg"></div>
                   </div>
                   <div class="singleimage">
                      <div class="imgwrap"><img src="{{asset('front_assets/')}}/images/posta.svg"></div>
                   </div>
                </div>
             </div>
          </div>
    </section>

</div>

@endsection
