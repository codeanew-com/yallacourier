
<style>
h8 {
 text-align: center;
line-height: 100px;

}

.cd-ship-group-heading h4 {
  margin: 20px 0 10px;
  padding-top: 15px;
  border-top: 1px solid rgba(255,255,255,0.25);
  color: #fff;
  font-weight: 700;
  text-transform: uppercase;
  font-size: 0.85em;
  letter-spacing: .04em;
}
.cd-ship-group-heading:first-of-type h4 { border-top: none; padding-top: 0; margin-top: 0; }
.cd-ship-back {
  display: inline-block;
  margin-left: 15px;
  color: #fff;
  font-weight: 600;
  text-decoration: underline;
  cursor: pointer;
}
</style>

<div class="form-wrapper">
    <div class="tabbing-wrapper">
        <div class="tab-links">
            <ul>
                <li data-tab="tab-01"><span><img src="{{ asset('front_assets/images/Parcels-icon2.svg') }}" /></span>Parcels</li>
                <li data-tab="tab-02"><span><img src="{{ asset('front_assets/images/Parcels-icon1.svg') }}" /></span>Parcels</li>
                <li data-tab="tab-03"><span><img src="{{ asset('front_assets/images/Parcels-icon2.svg') }}" /></span>Documents</li>
                <li data-tab="tab-04"><span><img src="{{ asset('front_assets/images/Parcels-icon1.svg') }}" /></span>Documents</li>
            </ul>
        </div>
        <div class="tabbing-content">
          <div class="tab-content" id="tab-01">
            <div class="content-box-wrapper">
              <h3>Shipping to where?</h3>
		
            </div>
            <form id="parcelsForm" class="banner-calculation-form" action="{{ route('front.shipment.request')}}" method="POST"> @csrf
                <input type="hidden" name="ship_type" value="1">
                <div class="cd-ship-step cd-ship-step-1 row no-gutters">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="input-wrapper">
                    <div class="inlinediv selectarrow customarrow">
                      <label>From:</label>
                      <select name="shipment_from" id="sender_state" required="required" style="font-weight: 600!important;">
                        <option value="Abu Dhabi" data-v="AZ">Abu Dhabi</option>
                        <option value="Dubai" data-v="DU" selected>Dubai</option>
                        <option value="Sharjah" data-v="SH">Sharjah</option>
                        <option value="Ajman" data-v="AJ">Ajman</option>
                        <option value="Umm Al Quwain" data-v="UQ">Umm Al Quwain</option>
                        <option value="Ras Al Khaimah" data-v="RK">Ras Al Khaimah</option>
                        <option value="Fujairah" data-v="FU">Fujairah</option>
                      </select>
                    </div>
                    <div>
                      <input type="text" name="shipment_from_1" class="shipment_from_1 autocomplete" placeholder="Enter your area" required="required">
                      <!--<select name="shipment_from_1" id="sender_city" required="required">-->
                      <!--</select>-->
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="input-wrapper">
                    <div class="inlinediv selectarrow customarrow">
                      <label>To:</label>
                      <select name="shipment_to" id="reciever_state" required="required" style="font-weight: 600!important;">
                        <option value="Abu Dhabi" data-v="AZ">Abu Dhabi</option>
                        <option value="Dubai" data-v="DU">Dubai</option>
                        <option value="Sharjah" data-v="SH">Sharjah</option>
                        <option value="Ajman" data-v="AJ">Ajman</option>
                        <option value="Umm Al Quwain" data-v="UQ">Umm Al Quwain</option>
                        <option value="Ras Al Khaimah" data-v="RK">Ras Al Khaimah</option>
                        <option value="Fujairah" data-v="FU">Fujairah</option>
                      </select>
                    </div>
                    <div>
                      <input type="text" name="shipment_to_1" class="shipment_to_1 autocomplete" placeholder="Enter your area" required="required">
                      <!--<select name="shipment_from_1" id="reciever_city" required="required">-->
                      <!--</select> -->
                    </div>
                  </div>
                </div>
                <div id="bookParcelDeliveryServices" class="col-lg-12 parcel-wrapper bookParcelDeliveryServices">
                  <div class="row no-gutters">
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                      <div class="input-wrapper">
                        <label>Length</label>
                        <input type="number" name="shipment_length[]" class="length_dom" required="required" value="20">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                      <div class="input-wrapper">
                        <label>Width</label>
                        <input type="number" name="shipment_width[]" class="width_dom" required="required" value="15">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                      <div class="input-wrapper">
                        <label>Height </label>
                        <input type="number" name="shipment_height[]" class="height_dom" required="required" value="10">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-4">
                      <div class="input-wrapper selectarrow">
                        <label>Quantity</label>
                        <select name="shipment_qty[]"> @for($i=1; $i <11; $i++) <option value="{{ $i }}">{{ $i }}</option> @endfor </select>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-4">
                      <div class="input-wrapper">
                        <label>Parcel Weight</label>
                        <input type="number" name="shipment_weight[]" required="required" value="1" step="any">
                        <span class="placeholder-text">kg</span>
                      </div>
                    </div>
                    <div class="col-lg-12" style="position:unset">
                      <span id="bookParcelDeliveryServicesRemoveBtn" class="remove-parcel" style="display: none;">
                        <i class="fa fa-minus"></i>
                      </span>
                    </div>
                  </div>
                </div>

				<div class="parcel-btns-wrapper d-flex flex-wrap justify-content-between w-100 mobilepositionparcel">
                  <div id="bookParcelDeliveryServicesBtn" class="add-parcel-btn">
                    <span class="parcel-btn-wrapper">
                      <i class="fa fa-plus"></i>Add another parcel </span>
                  </div>
                  <!--<div class="parcel-size-guide-btn-wrapper">-->
                  <!--    <a href="#parcelSizeGuide" class="parcel-size-guide-btn search-pop-btn">Not sure on parcel size ?</a>-->
                  <!--    <a href="#howItWorksPopup"  class="how-it-works-btn search-pop-btn">How It Works ?</a>-->
                  <!--</div>-->
                </div>
				<!--mobilepositionsizes-->
				<div class="about_sizes col-md-12 ">
                  <h4> Choose from the preset box sizes below</h4>
					<h4 style="font-size:1em; ">Dimentions auto populate above</h4>
                  <div class="boxe-sizes d-flex">
                    <div class="box-size-item dom_parcel" data-l="20" data-w="15" data-h="10">
                      <img src="{{ asset('front_assets/images/ExtraSmallbox.svg') }}" />
                      <h5> Extra Small</h5>
                      <p> 20 x 15 x 10cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip"> Approximately like a Smartphone box</span>
                      </div>
                    </div>
                    <div class="box-size-item dom_parcel" data-l="30" data-w="20" data-h="15">
                      <img src="{{ asset('front_assets/images/Smallbox.svg') }}" />
                      <h5>Small</h5>
                      <p> 30 x 20 x 15cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip"> Approximately like a iron box</span>
                      </div>
                    </div>
                    <div class="box-size-item dom_parcel" data-l="40" data-w="30" data-h="20">
                      <img src="{{ asset('front_assets/images/Mediumbox.svg') }}" />
                      <h5> Medium</h5>
                      <p> 40 x 30 x 20cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip"> Approximately like a shoe box </span>
                      </div>
                    </div>
                    <div class="box-size-item dom_parcel" data-l="45" data-w="30" data-h="20">
                      <img src="{{ asset('front_assets/images/largebox.svg') }}" />
                      <h5> Large</h5>
                      <p> 45 x 30 x 20cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip"> Approximately like microwave box</span>
                      </div>
                    </div>
                    <div class="box-size-item dom_parcel" data-l="50" data-w="40" data-h="25">
                      <img src="{{ asset('front_assets/images/ExtraLargebox.svg') }}" />
                      <h5> Extra Large</h5>
                      <p> 50 x 40 x 25cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip">Approximately like cabin luggage</span>
                      </div>
                    </div>
                    <div class="box-size-item dom_parcel" data-l="60" data-w="50" data-h="35">
                      <img src="{{ asset('front_assets/images/LuggageSizebox.svg') }}" />
                      <h5> Luggage Size</h5>
                      <p> 60 x 50 x 35cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip">Approximately like medium luggage</span>
                      </div>
                    </div>
                  </div>


                </div>
                <div class="col-lg-6 col-12">
                  <label>&nbsp;</label>
                  <div class="submit-wrapper">
                    <button type="button" class="cd-ship-continue">Continue <i class="fa fa-chevron-right"></i>
                    </button>
                  </div>
                </div>
                </div>
                <div class="cd-ship-step cd-ship-step-2 row no-gutters" style="display:none;">
                <div class="col-lg-12">
                  <div class="content-box-wrapper">
                    <h3>Your details</h3>
                    <a href="#" class="cd-ship-back">&larr; Back</a>
                  </div>
                </div>
                <div class="col-lg-12 cd-ship-group-heading">
                  <h4>Sender</h4>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender name</label>
                    <input type="text" name="sender_name" placeholder="Full name" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->name : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender phone</label>
                    <input type="tel" name="sender_phone" placeholder="Phone number" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->phone : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender email</label>
                    <input type="email" name="sender_email" placeholder="Email" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->email : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-12 cd-ship-group-heading">
                  <h4>Receiver</h4>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver name</label>
                    <input type="text" name="reciever_name" placeholder="Full name" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver phone</label>
                    <input type="tel" name="reciever_phone" placeholder="Phone number" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver email</label>
                    <input type="email" name="reciever_email" placeholder="Email" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <label>&nbsp;</label>
                  <div class="submit-wrapper">
                    <button type="submit">Book Shipment <i class="fa fa-chevron-right"></i>
                    </button>
                  </div>
                </div>
                </div>
            </form>
          </div>
          <div class="tab-content " id="tab-04">
            <div class="content-box-wrapper">
              <!--<h3>Compare and book parcel delivery services</h3>-->
              <h3>Where are you shipping to?</h3>
            </div>
            <form id="internationalDelivery" class="banner-calculation-form" action="{{ route('front.shipment.request')}}" method="POST"> @csrf
                <input type="hidden" name="ship_type" value="1">
                <div class="cd-ship-step cd-ship-step-1 row no-gutters">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="input-wrapper">
                    <div class="inlinediv selectarrow customarrow">
                      <label>From:</label>
                      <select name="shipment_from_country" id="shipment_from_country" required="required" style="font-weight: 600!important;">
                        <option value="AE" selected>United Arab Emirates</option>
                      </select>
                    </div>
                    <div>
                      <input type="text" name="shipment_from_city_map" id="shipment_from_city_map" class="autocomplete_intl_uae" placeholder="Enter City" required="required">
                      <input type="hidden" name="shipment_from_city" id="shipment_from_city" value="">
                      <!--<select name="shipment_from_city" id="shipment_from_city" required="required">-->
                      <!--</select>-->
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="input-wrapper">
                    <div class="inlinediv selectarrow customarrow">
                      <label>From:</label>
                      <select name="shipment_to_country" id="shipment_to_country" required="required" style="font-weight: 600!important;">
                        <option value="SA" selected>Kingdom Of Saudi Arabia</option>
                        <option value="QA">Qatar</option>
                        <option value="KW">Kuwait</option>
                        <option value="LB">Lebanon</option>
                        <option value="JO">Jordan</option>
                        <option value="OM">Oman</option>
                        <option value="BH">Bahrain</option>
                        <option value="00">Can't Find Country</option>
                        <!--<option value="GB">United Kingdom</option>-->
                        <!--<option value="DE">Germany</option>-->
                      </select>
                    </div>
                    <div>
                      <!--<select name="shipment_to_city" id="shipment_to_city" required="required">-->
                      <!--</select>-->
                      <input type="text" name="shipment_to_city_map" class="autocomplete_intl" placeholder="Enter City" required="required">
                      <input type="hidden" name="shipment_to_city" id="shipment_to_city" value="">
                    </div>
                  </div>
                </div>
                <div id="internationalDeliveryServices" class="col-lg-12 parcel-wrapper bookParcelDeliveryServices">
                  <div class="row no-gutters">
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                      <div class="input-wrapper">
                        <label>Length</label>
                        <input type="number" name="shipment_length[]" class="length_intl" required="required" value="20">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                      <div class="input-wrapper">
                        <label>Width</label>
                        <input type="number" name="shipment_width[]" class="width_intl" required="required" value="15">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                      <div class="input-wrapper">
                        <label>Height </label>
                        <input type="number" name="shipment_height[]" class="height_intl" required="required" value="10">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-4">
                      <div class="input-wrapper selectarrow">
                        <label>Quantity</label>
                        <select name="shipment_qty[]"> @for($i=1; $i <11; $i++) <option value="{{ $i }}">{{ $i }}</option> @endfor </select>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-4">
                      <div class="input-wrapper">
                        <label>Parcel Weight</label>
                        <input type="number" name="shipment_weight[]" required="required" value="1" step="any">
                        <span class="placeholder-text">kg</span>
                      </div>
                    </div>
                    <div class="col-lg-12" style="position:unset">
                      <span id="internationaldeliveryRemoveBtn" class="remove-parcel" style="display: none;">
                        <i class="fa fa-minus"></i>
                      </span>
                    </div>
                  </div>
                </div>

                <div class="parcel-btns-wrapper d-lg-flex d-md-flex d-none flex-wrap justify-content-between w-100">
                  <div id="internationaldeliveryBtn" class="add-parcel-btn">
                    <span class="parcel-btn-wrapper">
                      <i class="fa fa-plus"></i>Add another parcel </span>
                  </div>
<!--                   <div class="parcel-size-guide-btn-wrapper">
                    <a href="#parcelSizeGuide" class="parcel-size-guide-btn search-pop-btn">Not sure on parcel size ?</a>
                  </div> -->
                </div>

                <!--<div class="col-lg-6 col-12 d-lg-none d-block">-->
                <!--  <label>&nbsp;</label>-->
                <!--  <div class="submit-wrapper">-->
                <!--    <button type="submit">Get Rates <i class="fa fa-chevron-right"></i>-->
                <!--    </button>-->
                <!--  </div>-->
                <!--</div>                -->
                <div class="parcel-btns-wrapper d-lg-none d-md-none d-flex flex-wrap justify-content-between w-100">
                  <div id="internationaldeliveryBtn" class="add-parcel-btn">
                    <span class="parcel-btn-wrapper">
                      <i class="fa fa-plus"></i>Add another parcel </span>
                  </div>
<!--                   <div class="parcel-size-guide-btn-wrapper">
                    <a href="#parcelSizeGuide" class="parcel-size-guide-btn search-pop-btn">Not sure on parcel size ?</a>
                  </div> -->
                </div>
                <div class="about_sizes col-md-12">
                  <h4> Select your box size</h4>
                  <div class="boxe-sizes d-flex">
                    <div class="box-size-item intl_parcel" data-l="20" data-w="15" data-h="10">
                      <img src="{{ asset('front_assets/images/ExtraSmallbox.svg') }}" />
                      <h5> Extra Small</h5>
                      <p> 20 x 15 x 10cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip"> Approximately like a Smartphone box</span>
                      </div>
                    </div>
                    <div class="box-size-item intl_parcel" data-l="30" data-w="20" data-h="15">
                      <img src="{{ asset('front_assets/images/Smallbox.svg') }}" />
                      <h5>Small</h5>
                      <p> 30 x 20 x 15cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip"> Approximately like a iron box</span>
                      </div>
                    </div>
                    <div class="box-size-item intl_parcel" data-l="40" data-w="30" data-h="20">
                      <img src="{{ asset('front_assets/images/Mediumbox.svg') }}" />
                      <h5> Medium</h5>
                      <p> 40 x 30 x 20cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip"> Approximately like a shoe box </span>
                      </div>
                    </div>
                    <div class="box-size-item" data-l="45" data-w="30" data-h="20">
                      <img src="{{ asset('front_assets/images/largebox.svg') }}" />
                      <h5> Large</h5>
                      <p> 45 x 30 x 20cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip"> Approximately like microwave box</span>
                      </div>
                    </div>
                    <div class="box-size-item intl_parcel" data-l="50" data-w="40" data-h="25">
                      <img src="{{ asset('front_assets/images/ExtraLargebox.svg') }}" />
                      <h5> Extra Large</h5>
                      <p> 50 x 40 x 25cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip">Approximately like cabin luggage</span>
                      </div>
                    </div>
                    <div class="box-size-item intl_parcel" data-l="60" data-w="50" data-h="35">
                      <img src="{{ asset('front_assets/images/LuggageSizebox.svg') }}" />
                      <h5> Luggage Size</h5>
                      <p> 60 x 50 x 35cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip">Approximately like medium luggage</span>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6 col-12">
                  <label>&nbsp;</label>
                  <div class="submit-wrapper">
                    <button type="button" class="cd-ship-continue">Continue <i class="fa fa-chevron-right"></i>
                    </button>
                  </div>
                </div>
                </div>
                <div class="cd-ship-step cd-ship-step-2 row no-gutters" style="display:none;">
                <div class="col-lg-12">
                  <div class="content-box-wrapper">
                    <h3>Your details</h3>
                    <a href="#" class="cd-ship-back">&larr; Back</a>
                  </div>
                </div>
                <div class="col-lg-12 cd-ship-group-heading">
                  <h4>Sender</h4>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender name</label>
                    <input type="text" name="sender_name" placeholder="Full name" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->name : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender phone</label>
                    <input type="tel" name="sender_phone" placeholder="Phone number" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->phone : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender email</label>
                    <input type="email" name="sender_email" placeholder="Email" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->email : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-12 cd-ship-group-heading">
                  <h4>Receiver</h4>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver name</label>
                    <input type="text" name="reciever_name" placeholder="Full name" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver phone</label>
                    <input type="tel" name="reciever_phone" placeholder="Phone number" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver email</label>
                    <input type="email" name="reciever_email" placeholder="Email" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <label>&nbsp;</label>
                  <div class="submit-wrapper">
                    <button type="submit">Book Shipment <i class="fa fa-chevron-right"></i>
                    </button>
                  </div>
                </div>
                </div>
            </form>
          </div>
          <div class="tab-content" id="tab-03">
            <div class="content-box-wrapper">
              <h3>Compare and book document delivery services</h3>
            </div>

            <form id="documentDeliveryServicesForm1" class="banner-calculation-form" action="{{ route('front.shipment.request')}}" method="POST"> @csrf
                <input type="hidden" name="ship_type" value="0">
                <div class="cd-ship-step cd-ship-step-1 row no-gutters">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="input-wrapper">
                    <div class="inlinediv selectarrow customarrow">
                      <label>From:</label>
                      <select name="shipment_from" id="sender_state2" required="required" style="font-weight: 600!important;">
                        <option value="Abu Dhabi" data-v="AZ">Abu Dhabi</option>
                        <option value="Dubai" data-v="DU" selected>Dubai</option>
                        <option value="Sharjah" data-v="SH">Sharjah</option>
                        <option value="Ajman" data-v="AJ">Ajman</option>
                        <option value="Umm Al Quwain" data-v="UQ">Umm Al Quwain</option>
                        <option value="Ras Al Khaimah" data-v="RK">Ras Al Khaimah</option>
                        <option value="Fujairah" data-v="FU">Fujairah</option>
                      </select>
                    </div>
                    <div>
                      <input type="text" name="shipment_from_1" class="shipment_from_2 autocomplete1" placeholder="Enter your area" required="required">
                      <!--    <select name="shipment_from_1" id="sender_city1" required="required">-->
                      <!--</select>-->
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="input-wrapper">
                    <div class="inlinediv selectarrow customarrow">
                      <label>To:</label>
                      <select name="shipment_to" id="reciever_state2" required="required" style="font-weight: 600!important;">
                        <option value="Abu Dhabi" data-v="AZ">Abu Dhabi</option>
                        <option value="Dubai" data-v="DU">Dubai</option>
                        <option value="Sharjah" data-v="SH">Sharjah</option>
                        <option value="Ajman" data-v="AJ">Ajman</option>
                        <option value="Umm Al Quwain" data-v="UQ">Umm Al Quwain</option>
                        <option value="Ras Al Khaimah" data-v="RK">Ras Al Khaimah</option>
                        <option value="Fujairah" data-v="FU">Fujairah</option>
                      </select>
                    </div>
                    <div>
                      <input type="text" name="shipment_to_1" class="shipment_to_2 autocomplete1" placeholder="Enter your area" required="required">
                      <!--<select name="shipment_from_1" id="reciever_city1" required="required">-->
                      <!--</select> -->
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper selectarrow">
                    <label>Document Type</label>
                    <select name="document_type" id="documentType1">
                      <!--<option value="A4 envelope (21 x 29.7cm)">A4 envelope (21 x 29.7cm)</option>-->
                      <option value="Custom size">Custom size</option>
                    </select>
                  </div>
                </div>
                <div id="documentDeliveryServices1" class="col-lg-12 parcel-wrapper documentDeliveryServices1">
                  <div class="row no-gutters">
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                      <div class="input-wrapper">
                        <label>Length</label>
                        <input type="number" name="shipment_length[]" class="document_local_l" required="required" value="22">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                      <div class="input-wrapper">
                        <label>Width</label>
                        <input type="number" name="shipment_width[]" class="document_local_w" required="required" value="30">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                      <div class="input-wrapper">
                        <label>Height </label>
                        <input type="number" name="shipment_height[]" class="document_local_h" required="required" value="1">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-4">
                      <div class="input-wrapper selectarrow">
                        <label>Quantity</label>
                        <select name="shipment_qty[]"> @for($i=1; $i <11; $i++) <option value="{{ $i }}">{{ $i }}</option> @endfor </select>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-4">
                      <div class="input-wrapper">
                        <label> Weight</label>
                        <input type="number" name="shipment_weight[]" required="required" class="document_local_weight" value="0.5" step="any">
                        <span class="placeholder-text">kg</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12" style="position:unset">
                    <span id="documentDeliveryServicesRemoveBtn" class="remove-parcel" style="display: none;">
                      <i class="fa fa-minus"></i>
                    </span>
                  </div>
                </div>

				<div class="col-lg-12 col-12">
                  <div id="documentDeliveryServicesBtn1" class="add-parcel-btn">
                    <span class="parcel-btn-wrapper">
                      <i class="fa fa-plus"></i>Add another document</span>
                  </div>
                </div>
                <div class="about_sizes folders-env col-md-12">
                  <h4> Select your box size</h4>
                  <div class="boxe-sizes d-flex">
                    <div class="box-size-item document_local" data-l="30" data-w="24" data-h="1" data-weight="0.5">
                      <img src="{{ asset('front_assets/images/icon111.svg') }}" />
                      <h5> Envelope</h5>
                      <p> 30 x 24 x 1cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip"> Documents, Certificates Invoices, From & Passport</span>
                      </div>
                    </div>
                    <div class="box-size-item document_local" data-l="32" data-w="24" data-h="11" data-weight="1">
                      <img src="{{ asset('front_assets/images/icon222.svg') }}" />
                      <h5> Folder</h5>
                      <p> 32 x 24 x 11cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip">Booklets, Catalogs, Petition & Case Files</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <label>&nbsp;</label>
                  <div class="submit-wrapper">
                    <button type="button" class="cd-ship-continue">Continue <i class="fa fa-chevron-right"></i>
                    </button>
                  </div>
                </div>
                </div>
                <div class="cd-ship-step cd-ship-step-2 row no-gutters" style="display:none;">
                <div class="col-lg-12">
                  <div class="content-box-wrapper">
                    <h3>Your details</h3>
                    <a href="#" class="cd-ship-back">&larr; Back</a>
                  </div>
                </div>
                <div class="col-lg-12 cd-ship-group-heading">
                  <h4>Sender</h4>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender name</label>
                    <input type="text" name="sender_name" placeholder="Full name" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->name : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender phone</label>
                    <input type="tel" name="sender_phone" placeholder="Phone number" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->phone : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender email</label>
                    <input type="email" name="sender_email" placeholder="Email" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->email : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-12 cd-ship-group-heading">
                  <h4>Receiver</h4>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver name</label>
                    <input type="text" name="reciever_name" placeholder="Full name" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver phone</label>
                    <input type="tel" name="reciever_phone" placeholder="Phone number" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver email</label>
                    <input type="email" name="reciever_email" placeholder="Email" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <label>&nbsp;</label>
                  <div class="submit-wrapper">
                    <button type="submit">Book Shipment <i class="fa fa-chevron-right"></i>
                    </button>
                  </div>
                </div>
                </div>
            </form>
          </div>
          <div class="tab-content" id="tab-02">
            <div class="content-box-wrapper">
              <h3>Compare and book document delivery services</h3>
            </div>
            <form id="documentDeliveryServicesForm" class="banner-calculation-form" action="{{ route('front.shipment.request')}}" method="POST"> @csrf
                <input type="hidden" name="ship_type" value="0">
                <div class="cd-ship-step cd-ship-step-1 row no-gutters">
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="input-wrapper">
                    <div class="inlinediv selectarrow customarrow">
                      <label>From:</label>
                      <select name="shipment_from_country" id="shipment_from_country" required="required" style="font-weight: 600!important;">
                        <option value="AE" selected>United Arab Emirates</option>
                      </select>
                    </div>
                    <div>
                      <input type="text" name="shipment_from_city_map" id="shipment_from_city_map1" placeholder="Enter City" class="autocomplete_intl_uae2" required="required">
                      <input type="hidden" name="shipment_from_city" id="shipment_from_city1" value="">
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <div class="input-wrapper">
                    <div class="inlinediv selectarrow customarrow">
                      <label>To:</label>
                      <select name="shipment_to_country" id="shipment_to_country2" required="required" style="font-weight: 600!important;">
                        <option value="SA" selected>Kingdom Of Saudi Arabia</option>
                        <option value="QA">Qatar</option>
                        <option value="KW">Kuwait</option>
                        <option value="LB">Lebanon</option>
                        <option value="JO">Jordan</option>
                        <option value="OM">Oman</option>
                        <option value="BH">Bahrain</option>
                        <option value="00">Can't Find Country</option>
                        <!--<option value="GB">United Kingdom</option>-->
                        <!--<option value="DE">Germany</option>-->
                      </select>
                    </div>
                    <div>
                      <input type="text" name="shipment_to_city_map" class="autocomplete_intl2" placeholder="Enter City" required="required">
                      <input type="hidden" name="shipment_to_city" id="shipment_to_city1" value="">
                      <!--<select name="shipment_to_city" id="shipment_to_city1" class= required="required">-->
                      <!--</select>-->
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper selectarrow">
                    <label>Document Type</label>
                    <select name="document_type" id="documentType">
                      <!--<option value="A4 envelope (21 x 29.7cm)">A4 envelope (21 x 29.7cm)</option>-->
                      <option value="Custom size">Custom size</option>
                    </select>
                  </div>
                </div>
                <div id="documentDeliveryServices" class="col-lg-12 parcel-wrapper documentDeliveryServices">
                  <div class="row no-gutters">
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                      <div class="input-wrapper">
                        <label>Length</label>
                        <input type="number" name="shipment_length[]" class="document_intl_l" required="required" value="22">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-6">
                      <div class="input-wrapper">
                        <label>Width</label>
                        <input type="number" name="shipment_width[]" class="document_intl_w" required="required" value="30">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-2 col-md-4 col-sm-4 col-4">
                      <div class="input-wrapper">
                        <label>Height </label>
                        <input type="number" name="shipment_height[]" class="document_intl_h" required="required" value="1">
                        <span class="placeholder-text">cm</span>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-4">
                      <div class="input-wrapper selectarrow">
                        <label>Quantity</label>
                        <select name="shipment_qty[]"> @for($i=1; $i <11; $i++) <option value="{{ $i }}">{{ $i }}</option> @endfor </select>
                      </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-4">
                      <div class="input-wrapper">
                        <label> Weight</label>
                        <input type="number" name="shipment_weight[]" required="required" class="document_intl_weight" value="0.5" step="any">
                        <span class="placeholder-text">kg</span>
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-12" style="position:unset">
                    <span id="documentDeliveryServicesRemoveBtn" class="remove-parcel" style="display: none;">
                      <i class="fa fa-minus"></i>
                    </span>
                  </div>
                </div>
                <div class="col-lg-12 col-12">
                  <div id="documentDeliveryServicesBtn" class="add-parcel-btn">
                    <span class="parcel-btn-wrapper">
                      <i class="fa fa-plus"></i>Add another document </span>
                  </div>
                </div>
                <div class="about_sizes folders-env col-md-12">
                  <h4> Select your box size</h4>
                  <div class="boxe-sizes d-flex">
                    <div class="box-size-item document_intl" data-l="32" data-w="24" data-h="1" data-weight="0.5">
                      <img src="{{ asset('front_assets/images/icon111.svg') }}" />
                      <h5> Envelope</h5>
                      <p> 30 x 24 x 1cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip"> Documents, Certificates Invoices, From & Passport</span>
                      </div>
                    </div>
                    <div class="box-size-item document_intl" data-l="32" data-w="24" data-h="11" data-weight="1">
                      <img src="{{ asset('front_assets/images/icon222.svg') }}" />
                      <h5> Folder</h5>
                      <p> 32 x 24 x 11cm</p>
                      <div class="deliveryinfo">
                        <img src="{{ asset('front_assets/images/infoicon.png') }}">
                        <span class="deliveryinfo-tooltip">Booklets, Catalogs, Petition & Case Files</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <label>&nbsp;</label>
                  <div class="submit-wrapper">
                    <button type="button" class="cd-ship-continue">Continue <i class="fa fa-chevron-right"></i>
                    </button>
                  </div>
                </div>
                </div>
                <div class="cd-ship-step cd-ship-step-2 row no-gutters" style="display:none;">
                <div class="col-lg-12">
                  <div class="content-box-wrapper">
                    <h3>Your details</h3>
                    <a href="#" class="cd-ship-back">&larr; Back</a>
                  </div>
                </div>
                <div class="col-lg-12 cd-ship-group-heading">
                  <h4>Sender</h4>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender name</label>
                    <input type="text" name="sender_name" placeholder="Full name" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->name : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender phone</label>
                    <input type="tel" name="sender_phone" placeholder="Phone number" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->phone : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Sender email</label>
                    <input type="email" name="sender_email" placeholder="Email" value="{{ Auth::guard('customers')->check() ? Auth::guard('customers')->user()->email : '' }}" required="required">
                  </div>
                </div>
                <div class="col-lg-12 cd-ship-group-heading">
                  <h4>Receiver</h4>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver name</label>
                    <input type="text" name="reciever_name" placeholder="Full name" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver phone</label>
                    <input type="tel" name="reciever_phone" placeholder="Phone number" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <div class="input-wrapper">
                    <label>Receiver email</label>
                    <input type="email" name="reciever_email" placeholder="Email" required="required">
                  </div>
                </div>
                <div class="col-lg-6 col-12">
                  <label>&nbsp;</label>
                  <div class="submit-wrapper">
                    <button type="submit">Book Shipment <i class="fa fa-chevron-right"></i>
                    </button>
                  </div>
                </div>
                </div>
            </form>
          </div>
        </div>
    </div>
    <div class="parcel-size-guide-popup ps-pop" id="parcelSizeGuide">
        <div class="parcel-size-guide-popup-wrapper">
            <div class="parcel-size-guide-popup-header">
                <h3>Not sure on parcel size ?</h3>
                <p>See some of our popular parcel sizes below</p>
                <i class="fa fa-times close-btn"></i>
            </div>
            <div class="parcel-size-guide-popup-body">
                <div class="parcel-size-guide-popup-leftbox">
                    <h4>Box sizes</h4>
                    <ul class="box-sizes-list">
                        <li>
                            <span class="box-weight">5KG</span>
                            <span class="box-dimensions">40CM X 25CM X 25CM</span>
                        </li>
                        <li>
                            <span class="box-weight">10KG</span>
                            <span class="box-dimensions">40CM X 35CM X 35CM</span>
                        </li>
                        <li>
                            <span class="box-weight">15KG</span>
                            <span class="box-dimensions">45CM X 40CM X 40CM</span>
                        </li>
                        <li>
                            <span class="box-weight">25KG</span>
                            <span class="box-dimensions">50CM X 50CM X 50CM</span>
                        </li>
                    </ul>
                </div>
                <div class="parcel-size-guide-popup-rightbox">
                    <div class="box-imgbox">
                        <img class="w-100" src="{{ asset('front_assets/images/Box-New-01.svg') }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="how-it-works-popup" id="howItWorksPopup">
        <div class="how-it-works-popup-wrapper">
            <div class="how-it-works-popup-header">
                <h3>How it works</h3>
                <p>Once you have placed your package collection with Yalla Courier here are the next steps:</p>
                <i class="fa fa-times close-btn"></i>
            </div>
            <div class="how-it-works-popup-body">
                 <div class="row">
                    <div class="col-lg-4">
                        <div class="mainbox">
                            <div class="imgbox">
                                <img class="w-100" src="{{ asset('front_assets/images/hiw-pop1.svg') }}" />
                            </div>
                            <div class="contentbox">
                                <span class="hiw-count">1</span>
                                <p>Please have your parcel ready for
                                courier collection in suitable and
                                secure packaging provided by
                                yourself and make sure it’s within
                                the weight & dimensions you
                                selected.</p>
                            </div>
                        </div>
                    </div> 
                    <div class="col-lg-4">
                        <div class="mainbox">
                            <div class="imgbox">
                                <img class="w-100" src="{{ asset('front_assets/images/hiw-pop3.svg') }}" />
                            </div>
                            <div class="contentbox">
                                <span class="hiw-count">2</span>
                                <p>Yalla courier will collect your parcel
                                from your home, work or your
                                specified location same day if
                                within cut off time. You will be
                                updated along the way via
                                WhatsApp. </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="mainbox">
                            <div class="imgbox">
                                <img class="w-100" src="{{ asset('front_assets/images/hiw-pop2.svg') }}" />
                            </div>
                            <div class="contentbox">
                                <span class="hiw-count">3</span>
                                <p>“ YALLA” Your parcel will be
                                delivered to the receiver in the
                                allocated time.  </p>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
            <div class="how-it-works-popup-footer">
                <h4>That’s it it’s so simple</h4>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        // Two-step form: shipment details first, then sender/receiver contact
        // details. "Continue" validates only the visible step-1 fields (native
        // HTML5 validity) before revealing step 2.
        $(document).ready(function () {
            $(document).on('click', '.cd-ship-continue', function (e) {
                e.preventDefault();
                var $form = $(this).closest('form');
                var ok = true;
                $form.find('.cd-ship-step-1 [required]').each(function () {
                    if (!this.reportValidity()) { ok = false; }
                });
                if (!ok) { return; }
                $form.find('.cd-ship-step-1').hide();
                $form.find('.cd-ship-step-2').show();
            });
            $(document).on('click', '.cd-ship-back', function (e) {
                e.preventDefault();
                var $form = $(this).closest('form');
                $form.find('.cd-ship-step-2').hide();
                $form.find('.cd-ship-step-1').show();
            });
            // Pressing Enter inside a step-1 field would otherwise try to submit
            // the whole form while step-2's required fields are still hidden —
            // redirect it to "Continue" instead.
            $(document).on('keydown', '.cd-ship-step-1 input', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    $(this).closest('form').find('.cd-ship-continue').trigger('click');
                }
            });
        });
    </script>
    <script async
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}&libraries=places&callback=initAutocompletes">
    </script>
    <script>

        // Initialize Google Places Autocomplete for the UAE field
        function initAutocompleteUAE() {

            // const input = document.getElementById('autocomplete');

            const inputs = document.getElementsByClassName('autocomplete');
            for (let i = 0; i < inputs.length; i++) {

                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: 'ae' } // Restrict to UAE
                };
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    let city = '';
                    for (const component of place.address_components) {
                        let cc=component.long_name
                        $("#sender_state option").each(function() {
                            if($(this).text()==cc)
                            {
                                city = cc;
                            }
                        })
                    }

                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        if ($(input).attr('name') === 'shipment_from_1') {
                            
                            $("#sender_state option").each(function() {
                                if($(this).text()==city)
                                {
                                    $("#sender_state").val($(this).text());
                                }
                            });
                        }
                        if ($(input).attr('name') === 'shipment_to_1') {
                            
                            $("#reciever_state option").each(function() {
                                if($(this).text()==city)
                                {
                                    $("#reciever_state").val($(this).text());
                                }
                            }); 
                        }
                    } else {
                        console.log('No details available for the selected place.');
                    }

                });
            }
        }
        
        // Initialize Google Places Autocomplete for the UAE field
        function initAutocompleteUAEDocument() {

            // const input = document.getElementById('autocomplete');

            const inputs = document.getElementsByClassName('autocomplete1');
            for (let i = 0; i < inputs.length; i++) {

                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: 'ae' } // Restrict to UAE
                };
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    let city = '';
                    for (const component of place.address_components) {
                        let cc=component.long_name
                        $("#sender_state2 > option").each(function() {
                            if($(this).text()==cc)
                            {
                                city = cc;
                            }
                        })
                    }

                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        if ($(input).attr('name') === 'shipment_from_1') {
                        
                            $("#sender_state2 > option").each(function() {
                                if($(this).text()==city)
                                {
                                    $("#sender_state2").val($(this).text());
                                }
                            }); 
                        }
                        if ($(input).attr('name') === 'shipment_to_1') {
                            

                            $("#reciever_state2 > option").each(function() {
                                if($(this).text()==city)
                                {
                                    $("#reciever_state2").val($(this).text());
                                }
                            }); 
                        }
                    } else {
                        console.log('No details available for the selected place.');
                    }

                });
            }
        }
        
        // Initialize Google Places Autocomplete for the UAE Intl field
        function initAutocompleteUAEintl() {

            // const input = document.getElementById('autocomplete');

            const inputs = document.getElementsByClassName('autocomplete_intl_uae');
            for (let i = 0; i < inputs.length; i++) {

                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: 'ae' } // Restrict to UAE
                };
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    let city = '';
                    for (const component of place.address_components) {
                        if (component.types.includes('locality')) {
                            city = component.long_name;
                            break;
                        }
                    }

                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) 
                    {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        $("#shipment_from_city").val(city);
                    } 
                    else 
                    {
                        console.log('No details available for the selected place.');
                    }

                });
            }
        }
        
        // Initialize Google Places Autocomplete for the UAE Intl field
        function initAutocompleteUAEintl2() {

            // const input = document.getElementById('autocomplete');

            const inputs = document.getElementsByClassName('autocomplete_intl_uae2');
            for (let i = 0; i < inputs.length; i++) {

                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: 'ae' } // Restrict to UAE
                };
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                    const place = autocomplete.getPlace();
                    let city = '';
                    for (const component of place.address_components) {
                        if (component.types.includes('locality')) {
                            city = component.long_name;
                            break;
                        }
                    }

                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) 
                    {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        $("#shipment_from_city1").val(city);
                    } 
                    else 
                    {
                        console.log('No details available for the selected place.');
                    }

                });
            }
        }

        // $(document).ready(function() { 
        //     $("#shipment_to_country").on("change", function () {
        //         let code = $(this).val();
        //         $(".autocomplete_intl").val("");
        //         initAutocompleteIntl(code);
                
        //     });
        // });
        
        //  $(document).ready(function() { 
        //     $("#shipment_to_country2").on("change", function () {
        //         let code = $(this).val();
        //         $(".autocomplete_intl2").val("");
        //         initAutocompleteIntl1(code);
                
        //     });
        // });
        
        

        // Initialize Google Places Autocomplete for the International field
        function initAutocompleteIntl(countryCode = "SA") {

            console.log("Country Code", countryCode);

            // const input = document.getElementById('autocomplete_intl');
            const inputs = document.getElementsByClassName('autocomplete_intl');
            for (let i = 0; i < inputs.length; i++) {
                
                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: countryCode } // Restrict to International
                };
                
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                        const place = autocomplete.getPlace();
                        let city = '';
                        
                        for (const component of place.address_components) {
                            if (component.types.includes('locality')) {
                                city = component.long_name;
                                break;
                        }
                    }


                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        $("#shipment_to_city").val(city);
                    } else {
                        console.log('No details available for the selected place.');
                    }

                });
                
                 $(document).on('change','#shipment_to_country',function() {
                        const options = {
                            types: ['geocode', 'establishment'],
                            componentRestrictions: { country: $(this).find(":selected").val() } // Restrict to International
                        };
                        autocomplete.setOptions(options);
                  });
            }
        }
        
        // Initialize Google Places Autocomplete for the International field
        function initAutocompleteIntl1(countryCode = "SA") {

            console.log("Country Code", countryCode);

            // const input = document.getElementById('autocomplete_intl');
            const inputs = document.getElementsByClassName('autocomplete_intl2');
            for (let i = 0; i < inputs.length; i++) {
                
                let input = inputs[i];

                const options = {
                    types: ['geocode', 'establishment'],
                    componentRestrictions: { country: countryCode } // Restrict to International
                };
                
                const autocomplete = new google.maps.places.Autocomplete(input, options);
                autocomplete.addListener('place_changed', () => {
                        const place = autocomplete.getPlace();
                        let city = '';
                        
                        for (const component of place.address_components) {
                            if (component.types.includes('locality')) {
                                city = component.long_name;
                                break;
                        }
                    }


                    // Get the name of the place (can be the full address or just the name)
                    const placeName = place.name;

                    // Check if the place geometry exists (it should for most locations)
                    if (place.geometry) {
                        console.log(`Place selected: ${placeName}\nCity: ${city}\nLocation: ${place.geometry.location.lat()}, ${place.geometry.location.lng()}`);
                        // Set the corresponding hidden input field value with the place name
                        $("#shipment_to_city1").val(city);
                    } else {
                        console.log('No details available for the selected place.');
                    }

                });
                
                
                  $(document).on('change','#shipment_to_country2',function() {
                        const options = {
                            types: ['geocode', 'establishment'],
                            componentRestrictions: { country: $(this).find(":selected").val() } // Restrict to International
                        };
                        autocomplete.setOptions(options);
                  });
            }
        }

        // Initialize both autocompletes
        function initAutocompletes() {
            initAutocompleteUAE();
            initAutocompleteUAEDocument();
            initAutocompleteIntl();
            initAutocompleteUAEintl();
            initAutocompleteIntl1();
            initAutocompleteUAEintl2();
        }

    </script>
    <script>
        $(document).ready(function(){
            $("#reciever_state").change(function(){
                $(".shipment_to_1").val("");
            })
            $("#sender_state").change(function(){
                $(".shipment_from_1").val("");
            })
             $("#reciever_state2").change(function(){
                $(".shipment_to_2").val("");
            })
            $("#sender_state2").change(function(){
                $(".shipment_from_2").val("");
            })
            
            $("#shipment_to_country").change(function(){
                $(".autocomplete_intl").val("");
            })
             $("#shipment_to_country2").change(function(){
                $(".autocomplete_intl2").val("");
            })

        })
    </script>
@endpush