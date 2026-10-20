@extends('frontend.layouts.master')
@section('title',$page->page_title)
@section('seo_description',$page->meta_description)
@section('canonical',$page->canonicalUrl())
@section('follow',$page->visibility)
@section('content')

<!-- {{-- innner banner section start --}} -->
    <section class="innerpagebanner"> 
        <img src="{{ asset('front_assets/images/banner-service.svg') }}" alt="banner-img" class="banner-img"> 
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="content-box-wrapper  text-center"> 
                        <h1>Terms & Condition</h1>
                    </div>
                </div>
            </div>
            
        </div> 
    </section>
     <!--{{-- innner banner section End --}} -->
    
    <!-- FAQs Section Start -->
    <section class="policies-sec terms-and-condition-sec usessection">
        <div class="container">
            <div class="policy-content-wrapper">
                <p><b>YALLA TRADING L.L.C (Trading as Yalla Shipping) 1591977  - TERMS AND CONDITIONS</b></p>
                <p>Where to find information about us and our services. You can find everything you need to know about us, Yalla Courier, and our services on our website before you order. We also confirm the key information to you in writing after you order, either by email or via your online account.</p>
                <p>When you send a parcel with us, you enter into a contract with us based on these terms and conditions, which set out our service obligations to you, your responsibilities, and some other items such as our liability to you.</p>
                <p>It is important then that you read all of these terms and conditions very carefully to understand how we will provide services to you. In particular, to help you we have noted some important points below (which you read alongside the rest of these terms and conditions):</p>
                <h3>Parcel Protection</h3>
                <ul>
                    <li>You have the opportunity to buy Parcel Protection during the ordering process. If you do not buy Parcel Protection, any compensation which you are entitled to under these terms and conditions is limited to the cost paid for our services only (clause 9.5).</li>
                    <li>Where you buy Parcel Protection, you have the option of buying:</li>
                    <li>Protection for loss or damage; or</li>
                    <li>Protection for loss only.</li> 
                </ul>
                <h3>Prohibited Items, No Protection Items, and Items Protected for Loss Only</h3>
                <ul>
                    <li>Our website contains lists of items that are Prohibited Items, Items Protected for Loss Only and No Protection Items. Those lists are available here (and may vary from time to time). You should check them in detail to see whether any items you send fall under these lists. Certain items may also require more detail from you before they can be sent using our services. </li>
                    <li>Prohibited Items - must not be sent with any of our services. If they are, we reserve the right to deal with any Prohibited Items at our sole discretion and are not liable in any way to you or the recipient of the package containing the Prohibited Item(s) (clauses 7.3 and 9.4.5). Prohibited Items do not benefit from Parcel Protection, regardless of whether Parcel Protection has been purchased.</li>
                    <li>No Protection Items - can be sent with our services, however will not benefit from Parcel Protection, regardless of whether Parcel Protection has been purchased. We do not accept any liability to you at all for such items (clause 9.4.6)</li>
                    <li>Items Protected for Loss Only - we do not accept liability to you for any damage to Items Protected for Loss Only (regardless of whether Parcel Protection for damage is purchased). Our liability in respect of loss is limited to either a) the cost paid for our services, or b) where you have purchased Parcel Protection, the lower of the value of Parcel Protection cover taken out for eligible items and the actual value of the item(s) at the date of loss (clause 9.6.1.2)</li> 
                </ul>
                <h3>The Extent of Our Liability</h3>
                <p>In addition to the above, we draw your attention particularly to clause 9 (Liability) and clause 9.3 (The Extent of our Liability) onwards.</p>
                <p>We don’t give business customers all the same rights as consumers. Where a term applies just to businesses or just to consumers, this is clearly stated below. You are a business customer if you are buying services wholly or mainly for use in connection with your trade, business, craft or profession, even if you are an individual.</p>
                <p>When you buy from us, you are also agreeing that:</p>
                <ul>
                    <li>Our services can vary from the Service Order in certain circumstances (clause 3.2).</li>
                    <li>We only accept orders when we have checked them (clause 3.4).</li>
                    <li>Sometimes we reject orders (clause 3.5).</li>
                    <li>We are not obliged to provide any equipment or labour for loading or unloading at your premises (clause 4.1).</li>
                    <li>Any special equipment for loading and unloading must be made available. If not, we are not responsible for resulting damage and you indemnify (i.e. compensate) us against any claims (clause 4.2).</li>
                    <li>We will attempt to deliver once and may deliver to an alternative address or safe location, or back to our premises (clause 5.1).</li>
                    <li>Consignments which are not delivered shall be returned to you at your cost (clause 5.2).</li>
                    <li>We may dispose of damaged Consignments (clause 5.3).</li>
                    <li>You shall assist and co-operate with us (clause 7.1).</li>
                    <li>We will not carry any illegal items, and you indemnify (i.e. compensate) us in relation to any related losses or damage (clause 7.2).</li>
                    <li>We will not carry certain items without agreement or any Prohibited Items (clause 7.3).</li>
                    <li>If you are a consumer and you bought online or over the telephone, you have a legal right to change your mind (clause 8.1).</li>
                    <li>If you are a business, either of us can end our contract (clause 8.7).</li>
                    <li>We do not compensate you for all losses caused by us or our services (clause 9).</li>
                    <li>You shall reimburse us for losses sustained arising from your default (clause 9.13.3).</li>
                    <li>There are special terms that apply to any items being sent internationally, including to the European Union or Northern Ireland (clause 10).</li>
                    <li>You will co-operate with us in the carrying out of our services (clause 11.1).</li>
                    <li>All items must be packed properly and sufficiently (clause 11.2).</li>
                    <li>We monitor any fraudulent use of our services, and can take action if we suspect any (clause 12.1 and clause 12.2).</li>
                    <li>Any claims must be made in accordance with our claims procedure (clause 13).</li>
                    <li>You shall compensate us for any claims from other parties or due to your own default (clause 14).</li>
                    <li>If you are a business customer with a business account, you must pay us within seven days of the relevant invoice being issued to you (clause 15.1).</li>
                    <li>If you are not a business customer with a business account, you must pay us within the timeframe set out in your order (clause 15.2).</li>
                    <li>If you are a business, you must pay interest on late payments (clause 15.4).</li>
                    <li>Our charges are based on your declaration of the size and weight of the items which you send, and we may add additional charges arising from any inaccurate declaration that you make (clause 15.5).</li>
                    <li>We may charge extra for delivery on public and bank holidays (clause 15.7).</li>
                    <li>Where applicable, VAT is payable on any sums due (clause 15.8).</li>
                    <li>We can stop trading with you if we suspect fraudulent activity, or where you have not paid our additional charges (clause 12.2 and clause 15.10).</li>
                    <li>We may offer ‘Prepay’ payment on account services (clause 16).</li>
                    <li>Special terms apply in respect of using our services to send pallets, purchasing Royal Mail and Whistl services (clause 17).</li>
                    <li>We use your personal data as set out in our Privacy Policy(clause 18)</li> 
                </ul>
                <p>These terms may have changed since you last reviewed them. Please refer to our web page here for the most up to date version.</p>
                <p>We offer a number of options for customer support. Details of how to contact us are contained here.</p>
                <h3>FULL TERMS AND CONDITIONS</h3>
                <p>Wherever a word is given a capital letter (for example ‘Agreement’ or ‘Consignment’), you should look at the Definitions section immediately below for a full explanation of what these words mean.</p>
                <h3>Standard Terms of Contract</h3>
                <p>1.  Definitions</p>
                <p>In these Terms and Conditions, where the following terms are used, they shall have the following meanings:</p>
                <table> 
                  <tr>
                    <td>“Agreement”</td>
                    <td>means these Terms and Conditions together with the Service Order.</td>
                  </tr>
                  <tr>
                    <td>“Collection Point”</td>
                    <td>means the address at which a Consignment is received or collected by us.</td>
                  </tr>
                  <tr>
                    <td>“Consignment”</td>
                    <td>means any item(s) which are, may be, or are intended to be, received by us from any sender at an address for us to carry and deliver to any recipient at any other address.</td>
                  </tr>
                  <tr>
                    <td>“Damaged Consignment”</td>
                    <td>means a Consignment that is no longer in the condition in which it was received by us, or which is or becomes a health and safety risk.</td>
                  </tr>
                  <tr>
                    <td>“Delivery Point”</td>
                    <td>means the address to which a Consignment is delivered by us.</td>
                  </tr>
                  <tr>
                    <td>“Excepted Risks”</td>
                    <td>has the meaning set out in clause 9.4.2.</td>
                  </tr>
                  <tr>
                    <td>“Items Protected for Loss Only”</td>
                    <td>such items as may be identified on our ‘Items Protected for Loss Only’ list as may be varied from time to time, and which is available on our website here.</td>
                  </tr>
                  <tr>
                    <td>“No Protection Items”</td>
                    <td>such items as may be identified on our ‘No Protection Items’ list as may be varied from time to time, and which is available on our website here.</td>
                  </tr>
                  <tr>
                    <td>“Out of Gauge”</td>
                    <td>means a Consignment which is outside of the weight and dimension ranges that we carry on a particular Service.</td>
                  </tr>
                  <tr>
                    <td>“Prepay”</td>
                    <td>has the meaning set out in clause 16.1;</td>
                  </tr>
                  <tr>
                    <td>“Prohibited Items”</td>
                    <td>such items as may be identified on our ‘Prohibited Items’ list as may be varied from time to time, and which is available on our website here.</td>
                  </tr>
                  <tr>
                    <td>“Returned to Sender”</td>
                    <td>a Consignment may be returned to sender (i.e. to us) if the recipient sends it back to us and:
                        <br>
                        (a)  you do not accept receipt of that Consignment;
                        <br>
                        (b)  you do not pay any outstanding charges; and/or
                        <br>
                        (c)  if the Consignment is delivered and is Out of Gauge, for which you nor the recipient pay the underpayment.
                    </td>
                  </tr>
                  <tr>
                    <td>“Service”, “our services”</td>
                    <td>means the service and carriage of a Consignment by us in accordance with the Service Order.</td>
                  </tr>
                  <tr>
                    <td>“Service Order”</td>
                    <td>means the summary of the order, which is displayed during the ordering process, and which is confirmed to you in the confirmation email that we send once we have accepted your order.</td>
                  </tr>
                  <tr>
                    <td>“Us, We or Our”</td>
                    <td>means Yalla Courier, together with its directors, employees any agents subcontractors or couriers acting on its behalf..</td>
                  </tr>
                  <tr>
                    <td>“You”</td>
                    <td>means the customer, who is contracted with us, as set out in the Service Order.</td>
                  </tr>
                </table>
                <br>
                <p>2.  If you are a business customer this is our entire agreement with you. If you are a business customer these terms, together with any Service Order constitute the entire agreement between us in relation to our services. You acknowledge that you have not relied on any statement, promise, representation, assurance or warranty made or given by us or on our behalf which is not set out in these terms and that you have no claim for innocent or negligent misrepresentation or negligent misstatement based on any statement in this Agreement.</p>
                <p>2.  If you are a business customer this is our entire agreement with you. If you are a business customer these terms, together with any Service Order constitute the entire agreement between us in relation to our services. You acknowledge that you have not relied on any statement, promise, representation, assurance or warranty made or given by us or on our behalf which is not set out in these terms and that you have no claim for innocent or negligent misrepresentation or negligent misstatement based on any statement in this Agreement.</p>
                <p>3.  Our services</p>
                <p>3.1  Our services and fees will be specified before we carry our services out.Our services and related fees shall be set out in the summary of your order (“Service Order”). The Service Order will be displayed during the ordering process and will be confirmed to you in a confirmation email that we send to your nominated email address once we have accepted your order. The Service Order will at a minimum set out:</p>
                <p>3.1.1  the services to be carried out; and</p>
                <p>3.1.2  the fees payable in respect of those services;</p>
                <p>3.2  Our services can vary from the Service Order in certain circumstances. We have the right to make any changes to a Service Order which are necessary to comply with any applicable law or safety requirement, which are necessary on account of your act or omission as detailed in clause 3.8, or which do not materially affect the nature or quality of our services and we shall notify you of any such changes.</p>
                <p>3.3  Any request by you for changes to the Service Order is subject to our consent. If you would like to make changes to the contents of the Service Order, you must tell us in writing immediately. If we agree to such changes, then we will write to you as soon as reasonably possible to confirm the effect (if any) of such changes on any fees and any other terms already agreed between us. Where you accept the effect of such changes (or where there is no effect), then we will provide you with an updated Service Order. </p>
                <p>3.4  We only accept orders when we've checked them. We contact you to confirm we've received your order and then we contact you again to confirm we've accepted it, at which point a contract will come into existence between you and us on the basis of these terms.</p>
                <p>3.5  Sometimes we reject orders. Sometimes we reject orders, including for example (but not limited to), because a service is unexpectedly unavailable, because (if applicable) a credit reference we have obtained is unsatisfactory, because we can't verify your age (where the services are age-restricted), because you are located outside the UAE or because the service was mis-priced by us or is no longer available. When this happens, we let you know as soon as possible and refund any sums you have paid.</p>
                <p>3.6  We shall provide our services with reasonable care and skill. We warrant that we will provide our services using reasonable care and skill. If we do not do so, you may require us to repeat or fix our services or, if that is not possible or not done in a reasonable time, obtain a reasonable reduction in the price from us.</p>
                <p>3.7  We're not responsible for delays outside our control. If the supply of our services is delayed by an event outside our control, such as (without limitation) an act of God, war, natural disaster, civil commotion, malicious damage, epidemic or pandemic, any law or any action taken by a government or public authority, accident, strike, lock out, labour dispute, weather conditions, traffic congestion, mechanical breakdown or obstruction of any public or private road or highway, we shall not be in breach of these terms or otherwise liable for any failure or delay in the performance of our obligations under these terms and/or our agreement with you (provided that, where the delay is caused by the mechanical breakdown of one of our vehicles, we shall use all commercially reasonable endeavours to provide a replacement vehicle with the minimum delay practicable). In the case of any delays outside our control, we shall contact you as soon as possible to let you know and do what we can to reduce the delay, and if the delay is likely to be substantial you can contact our customer support team to end the contract and receive a refund for any services you have paid for in advance, but not received.</p>
                <p>3.8  We’re not responsible for delays which you cause or contribute to. If you do (or omit to do) anything which prevents or delays us from carrying out our services or otherwise complying with our obligations under these terms and/or our agreement with you, including (without limitation) any delay, late delivery or missed delivery or failure to deliver caused by or contributed to insufficient labelling of a Consignment, subject to clause 9.10 (Losses we never limit or exclude) we shall:</p>
                <p>3.8.1  notify you in respect of any resulting delay as soon as possible;</p>
                <p>3.8.2  not be responsible for any resulting delay in the carrying out of our services; and</p>
                <p>3.8.3  if we determine it is necessary (in our own discretion), modify the Service Order (including any increased or additional fees payable in respect of our services) and/or any timetable for delivery of our services.</p>
                <p>4.  Loading and unloading</p>
                <p>4.1  We are not obliged to provide any equipment or labour for loading or unloading the Consignment. If collection or delivery of a Consignment takes place at your premises, we shall not be under any obligation to provide any equipment or labour which, apart from the driver collecting the Consignment, may be required for loading or unloading of a Consignment.</p>
                <p>4.2  Any Consignment requiring special equipment shall only be accepted if such equipment is made available. If not, and we agree to load or unload the Consignment anyway, we are not responsible for any resulting damage and you indemnify us against any resulting claims. Any Consignment (or part of a Consignment) requiring any special equipment for loading and unloading shall be accepted by us for transportation only on the understanding and condition that such special equipment will be made available at the Collection Point and the Delivery Point as required. Where such equipment is not available and if we agree to load or unload the Consignment (or part of the Consignment), we shall be under no liability or obligation of any kind to you for any damage caused (however it may be caused) during the loading or unloading of the Consignment. This includes any damage caused whether or not by our negligence and you shall agree to indemnify and hold us harmless against any claim or demand from any person arising out of our agreeing to load or unload the Consignment in these circumstances. </p>
                <p>5.  Collection and Deliveries</p>
                <p>5.1  We will attempt to deliver a Consignment once and are permitted to deliver to an alternative address or a safe location, or otherwise back to our premises. We will make one attempt to deliver a Consignment during normal working hours. If we cannot obtain a delivery receipt at the Delivery Point, you agree that we shall be authorised to attempt to:</p>
                <p>5.1.1  deliver the Consignment to, or obtain a delivery receipt from, an alternative address close to the Delivery Point; or</p>
                <p>5.1.2  deliver the Consignment to a safe location at the Delivery Point, and (if successful) we agree that we will leave at the Delivery Point details of the address or safe location to which we have delivered the Consignment.</p>
                <p>5.2  If the Consignment is not delivered, it shall be returned to you at your cost. If we are unable to deliver to the Delivery Point, a nearby address or a safe location, we shall return the Consignment to our premises and leave a request for the recipient of the Consignment to contact us to make alternative delivery arrangements to the Delivery Point. If the recipient does not contact us to arrange the alternative delivery within 7 days, we will return the Consignment to you at your cost (such cost to be discharged before delivery to you). Return information is captured from the collection address details listed in the service order.</p>
                <p>5.3  We may dispose of any Damaged Consignment. If we consider that the Consignment has become a Damaged Consignment and cannot be delivered because it is or in our reasonable opinion is likely to be unsafe, hazardous or harmful, we reserve the right to dispose of the Damaged Consignment immediately.</p>
                <p>6.  Sub-Contractors</p>
                <p>We may use sub-contractors. You agree that we may use another carrier in order to support our provision of our services to you (this will be at our own expense) and you agree that both we and such other carrier shall be entitled to the protection of all of the terms of this Agreement which exclude or limit liability for any losses or damage.</p>
                <p>7.  Your Obligations</p>
                <p>7.1  You shall assist and co-operate with us, providing us with accurate and complete information and materials, and safe access to the Collection Point or Delivery Point.</p>
                <p>You agree to:</p>
                <p>7.1.1  ensure that the information you supply in the Service Order is complete and accurate;</p>
                <p>7.1.2  co-operate with us in all matters relating to our provision of our services;</p>
                <p>7.1.3  provide us with access to your premises, office accommodation and other facilities as reasonably required by us if any of these are to be the Collection Point or Delivery Point and be responsible for ensuring that the premises are free of hazardous materials and do not pose a health and safety risk to us; and</p>
                <p>7.1.4  provide us with such information and materials as we may reasonably require in order to supply our services and ensure that such information is accurate in all material respects.</p>
                <p>7.2  We shall not carry any illegal items, and you indemnify us in relation to any related losses or damage. You agree that we shall not be required, and that you shall not cause us, to carry anything if it would be illegal or unlawful for us to do so (either in the UAE or any country to which a Consignment is to be delivered). You agree that should you do this, you will indemnify us against any losses and/or damage that we may suffer as a consequence.</p>
                <p>7.3  We will not carry certain items without agreement in writing. We will not carry any items on the Prohibited Item list. We may refuse Consignments which are not yours.</p>
                <p>7.3.1  You agree that we will not, without specific separate written agreement, carry: livestock; liquids; perishable goods; gases; pyrotechnics; arms; ammunition; corrosive; toxic; flammable; explosive; oxidising or radioactive materials. In addition, we will not carry any items which are on our Prohibited Items list.</p>
                <p>7.3.2  If any such items are sent, you agree that we may deal with or dispose of any such items at our sole discretion without being liable in any way to you or the recipient of the Consignment containing such items, and that we may charge you for any reasonable costs we incur in connection.</p>
                <p>7.3.3  We reserve the right to refuse to carry any parcels which are neither the property of, nor sent on behalf of, you.</p>
                <p>7.4  Receipts are conclusive evidence of delivery of a Consignment.</p>
                <p>You understand that:</p>
                <p>7.4.1  all Consignments shall be accepted at the Delivery Point and that the recipient shall give our driver an appropriate receipt and you agree that this receipt shall be conclusive evidence of delivery of the Consignment by us. This clause 7.4.1 shall not apply where such receipt is obtained as a result of fraud, collusion or dishonesty on the part of our driver; and</p>
                <p>7.4.2  if there is a strike by any employees of yours, or the employees of any person receiving delivery, then you agree that our representative shall not be asked to perform any additional duties or any duties of a strike-breaking nature.</p>
                <p>8.  Ending the contract</p>
                <p>8.1  If you are a consumer and you bought online or over the telephone, you have a legal right to change your mind and cancel our services within 14 days of our acceptance or your order and receive a refund of what you paid for it. This is subject to some conditions, as set out below.</p>
                <p>8.2  When you can’t change your mind. Once we have completed our services, you have lost your statutory right to cancel the services and receive a refund, even if the 14 day period is still running.</p>
                <p>8.3  You have to pay for services you received before you change your mind. If you cancel our services after we have started performing them, you must pay us for the services provided up until the time that you tell us you have changed your mind. You will also be responsible for collecting the Consignment from us or paying our reasonable costs of returning it to you.</p>
                <p>8.4  How to let us know that you wish to cancel. If you want to cancel our services in accordance with this clause 8, please let us know by doing one of the following:</p>
                <p>8.4.1  contact us via our Live Chat services <a target="_blank" href="https://www.parcel2go.com/help-centre">Here</a>. Please provide your name, address, order details, phone number and email address; or</p>
                <p>8.4.2  by completing the form <a  target="_blank" href="https://www.parcel2go.com/help-centre/parcels/question/collection/how-do-i-cancel-my-order-and-apply-for-a-refund">here</a>.</p>
                <p>8.5  When and how we refund you. Where you have changed your mind in accordance with this clause 8, we shall refund you in respect of cancelled services for which you are entitled to a refund pursuant to this Agreement within 14 days of you telling us you’ve changed your mind and wish to cancel this Agreement or any services. We refund you by the method you used for payment. We don't charge a fee for the refund.</p>
                <p>8.6  Where you have cancelled our services, you must not use any postage label printed. If you cancel our services after printing any postage/courier label that we may supply to you, you shall not use that label for any purpose other than secure disposal. In the event that the postage/courier label is used in respect of any Consignment, you agree to us automatically deducting any sums owed for the delivery of our services from you via your payment method.</p>
                <p>8.7  Where you are a business, either of us can terminate this Agreement in certain circumstances.</p>
                <p>Where you are a business, either of us can terminate this Agreement:</p>
                <p>8.7.1  by giving the other party no less than one month’s written notice of confirming the intention to terminate this Agreement; or</p>
                <p>8.7.2  immediately on written notice to the other party if the other party breaches any of its obligations under this Agreement or (in the case of an individual) becomes bankrupt or (in the case of a company) goes into liquidation other than for the purposes of reconstruction or amalgamation, or has an administrator or receiver appointed over any of its or his property or income or make any deed or arrangements with or for the benefit of his or its creditors.</p>
                <p>8.8  On termination you must pay all our outstanding invoices. On termination of this Agreement for any reason:</p>
                <p>8.8.1  you shall immediately pay to us all of our outstanding unpaid invoices and interest and, in respect of services supplied where the Consignment has been delivered but for which no invoice has been submitted, we shall submit an invoice, which shall be payable by you immediately on receipt;</p>
                <p>8.8.2  in respect of a Consignment which has already been paid for and which has been received but not yet delivered, then we shall deliver such Consignment in accordance with these Terms and Conditions;</p>
                <p>8.8.3  in respect of a Consignment which has not been paid for but which we have received but not delivered, we shall return the Consignment to you;</p>
                <p>8.8.4  the accrued rights, remedies, obligations and liabilities of the parties as at expiry or termination shall not be affected, including the right to claim damages in respect of any breach of this Agreement which existed at or before the date of termination or expiry; and</p>
                <p>8.8.5  clauses which expressly or by implication have effect after termination or expiry shall continue in full force and effect.</p>
                <p>9.  Liability</p>
                <p>YOUR ATTENTION IS DRAWN PARTICULARLY TO THIS CLAUSE AND THE LIMITS OF OUR LIABILITY WITHIN IT.</p>
                <p>9.1  The rationale to the limits of our liability in this clause. As a responsible business, we will perform our services in a professional manner with the appropriate level of skill and care. However, loss of or damage to a Consignment may still occur as a consequence of our handling of it and, in such circumstances, our liability shall be limited as set out in this clause 9.</p>
                <p>Our reasons for limiting our liability as we have are as follows:</p>
                <p>9.1.1  the value of a Consignment and the amount of potential loss to you that could arise if a Consignment is damaged or lost is not something which we can easily ascertain – this is something which is better known to you. In many cases, it cannot be known to us at all and can only be known to you;</p>
                <p>9.1.2  the potential amount of loss that might be caused or alleged to be caused to you is likely to be disproportionate to our charges for providing our services;</p>
                <p>9.1.3  it is not possible for us to obtain insurance for our full potential liability to all of our customers. Even if it were, such insurance would be much cheaper if taken out by you and, on that basis, it is more reasonable for you to take out such insurance from an independent third party rather than us doing so and passing on the costs to you.</p>
                <p>9.1.4  we wish to keep the costs of providing our services to you as low as possible;</p>
                <p>9.1.5  taking into account our low charges for providing our services, we wish to limit our liability for any damage or loss caused to you to a level which we consider reasonable and proportionate whilst affording you the opportunity to purchase additional insurance for eligible items in the form of Parcel Protection during the ordering process where the value of the Consignment dictates that the purchase of additional insurance would be advisable.</p>
                <p>9.2  How you can protect a Consignment - Parcel Protection</p>
                <p>9.2.1  Our liability for lost or Damaged Consignments is limited under this clause 9. However, during the order process, you can buy additional insurance in the form of Parcel Protection. Two types of Parcel Protection are offered during the order process as follows:</p>
                <p>•  Protection for loss or damage</p>
                <p>•  Protection for loss only</p>
                <p>The extent of Parcel Protection cover shall depend on which type of cover you choose. For example, if you purchase Parcel Protection for loss only, you are purchasing cover for the loss of an item only but not for any damage caused to the item in the carrying out of our services.</p>
                <p>9.2.2  Furthermore, and regardless of whether you have purchased Parcel Protection, please note that you may not be entitled to recover your losses under the Parcel Protection if the Consignment is not adequately packaged in accordance with clause 11.2, or if it is listed on the Prohibited Items, Items Protected for Loss Only and No Protection Items lists. Please see clauses 9.5 and 11.2 further below.</p>
                <p>9.2.3  Where you do not purchase Parcel Protection, you confirm that you accept the risks of not doing so.</p>
                <p>The Extent of our Liability</p>
                <p>9.3  We don't compensate you for all losses caused by us or our services. We shall only be liable for damage or loss caused to you if it is caused by our negligence, breach of duty or other wrongful act or omission, and only subject to the limitations set out within this clause 9 and clause 10 (International Carriage), and you making a claim in accordance with the provisions of clause 13 (Claims and Refunds).</p>
                <p>9.4  Liability which we exclude completely:</p>
                <p>9.4.1  Other than in respect of losses described in clause 9.10 (Losses we never limit or exclude), we shall not be liable to you at all, whether in contract, breach of statutory duty, tort (including negligence) or otherwise, and whether any Parcel Protection has been purchased or not:</p>
                <p>9.4.1.1  where there are any material discrepancies (meaning more than 10% difference) between the declared dimensions and/or weights in your order and the actual dimensions and/or weights of any Consignment;</p>
                <p>9.4.1.2  for any damage to items caused by our negligence, breach of duty, or other wrongful act or omission, which you have repaired, or you have arranged to be repaired, unless it is agreed by us that the repair work is to be carried out and that a repairer approved by us undertakes this work; or</p>
                <p>9.4.1.3  in respect of any:</p>
                <p>(a)  loss of or damage to items on the Prohibited Items list;</p>
                <p>(b)  damage to items on the Items Protected for Loss Only list; or</p>
                <p>(c)  loss of or damage to items on the No Protection Items list;</p>
                <p>and any losses or claims arising out of or in connection with such items unless otherwise stated by us.</p>
                <p>9.4.1.4  for any damage incurred to the packaging used for the Consignment;</p>
                <p>9.4.1.5  for any loss of profits, loss of sales or business, loss of agreements or contracts; loss of anticipated savings; loss of or damage to goodwill; or</p>
                <p>9.4.1.6  any special, indirect, consequential or pure economic loss, costs, damages, charges or expenses.</p>
                <p>9.4.2  Excepted Risks. We shall not, in any circumstances, be liable to you for any loss, damage, costs, expenses or other claims for compensation arising directly or indirectly as a result of any of the Excepted Risks. Excepted Risks are any of the following:</p>
                <p>9.4.2.1  war, invasion, act of foreign enemy, hostilities (whether war be declared or not), civil war, rebellion, revolution, insurrection or military or usurped power, or loot, sack or pillage in connection;</p>
                <p>9.4.2.2  ionising radiations or contamination by radioactivity from any nuclear fuel or from any nuclear waste from the combustion of nuclear fuel;</p>
                <p>9.4.2.3  radioactive, toxic, explosive or other hazardous properties of any explosive nuclear assembly or nuclear component of the same;</p>
                <p>9.4.2.4  pressure waves caused by aircraft and other aerial devices travelling at the speed of sound or faster; and/or</p>
                <p>9.4.2.5  the absence, failure or inadequacy of the packing or packaging used for a Consignment.</p>
                <p>9.4.3  Events which are outside our control. If at any time we are prevented or delayed from starting, carrying out or completing any of our services because of a strike, lock out, labour dispute, weather conditions, traffic congestion, mechanical breakdown or obstruction of any public or private road or highway or any other cause beyond our control, you shall have no claim for damages against us for any loss that you may suffer as a result provided that, where the delay is caused by the mechanical breakdown of one of our vehicles, we shall use all commercially reasonable endeavours to provide a replacement vehicle with the minimum delay practicable.</p>
                <p>9.4.4  Your delays. We shall not in be liable for any interruption in, delay to, or failure to carry out our services (including late delivery or missed delivery or failure to deliver) if you do (or omit to do) anything which prevent or delays us from carrying out our services or otherwise complying with our obligations under this Agreement, including any delays caused by or contributed to by your breach of clause 11.2 (including any deficient or ambiguous labelling of a Consignment).</p>
                <p>9.4.5  Prohibited Items. Items on the Prohibited Items list should not be sent with our services. They do not benefit from Parcel Protection regardless of whether you have purchased Parcel Protection. We do not accept any liability at all for such items.</p>
                <p>9.4.6  No Protection Items. Items on the No Protection Items list are carried without Parcel Protection for damage or loss and at your own risk regardless of whether you have purchased Parcel Protection. We do not accept any liability at all for such items.</p>
                <p>9.4.7  Items Protected for Loss Only. We do not accept any liability for damage to or damage caused by any of the items on the Items Protected for Loss Only list. In respect of any loss of any items on this list, our liability is limited in accordance with clause 9.5.</p>
                <p>9.4.8  Multiple packages. Where you have more than one discrete package within a Consignment, and you have not combined these within an outer box or packaging fully encompassing all the packages and any individual discrete package(s) comes apart in transit resulting in one or more of them being lost, then once the remaining parcel(s) are signed for by the recipient, you accept that you cannot make a claim for loss or partial loss of the Consignment and we shall not be liable whatsoever in respect of such loss.</p>
                <p>9.5  Liability which we limit – all cases: Subject to clauses 9.6, 9.8,  9.10 and 10, our total aggregate liability to you in contract, tort (including without limitation negligence or breach of statutory duty howsoever arising), misrepresentation, restitution or otherwise arising in connection with the performance or contemplated performance of this Agreement is limited to the cost paid for our services under this Agreement;</p>
                <p>9.6  Liability which we limit – Parcel Protection. Where you have purchased Parcel Protection in respect items that are eligible for Parcel Protection cover,subject to clauses 9.6, 9.8,  9.10 and 10, our total aggregate liability to you in contract, tort (including without limitation negligence or breach of statutory duty howsoever arising), misrepresentation, restitution or otherwise arising in connection with the performance or contemplated performance of this Agreement is limited in relation to the relevant type of Parcel Protection cover purchased as follows:</p>
                <p>9.6.1.1  Parcel Protection - Protection for loss or damage</p>
                <p>Our liability to you in respect of loss of or damage to a Consignment is limited to the lesser of: (i) the value of the Parcel Protection taken out; or (ii) the actual value of the Consignment at the date of loss of or damage to the Consignment (as applicable);</p>
                <p>Our liability to you in respect of loss of or damage to a Consignment is limited to the lesser of: (i) the value of the Parcel Protection taken out; or (ii) the actual value of the Consignment at the date of loss of or damage to the Consignment (as applicable);</p>
                <p>9.6.1.2  Parcel Protection - Protection for loss only</p>
                <p>Our liability to you in respect of loss of a Consignments limited to the lesser of: (i) the value of the Parcel Protection taken out; or (ii) the actual value of the Consignment at the date of its loss (as applicable). If you purchase Parcel Protection for loss only, you will not be protected, and we shall not be liable, for any losses that you suffer due to any damage caused to the Consignment other than for up to the cost that you have paid for our services in accordance with clause 9.5.</p>
                <p>9.7  Value of the Consignment claimed; Irrespective of the type of Parcel Protection cover that you purchase for eligible items, we will not be liable to repay you the market value of the Consignment as at the time it was purchased by you. Consignments by their nature are subject to depreciation. You must take out a “new for old” compensation policy should you wish to be compensated in this way.</p>
                <p>9.8  In order to ascertain the extent of our liability under this clause 9, we shall require proof of the value, dimensions and weight of the entire Consignment and any constituent part or parts and you must ensure that, prior to our collection of the Consignment, you have a record of these. For the avoidance of any doubt, and without affecting clause 9.4, we shall only be liable for the replacement value of the Consignment and not for any sums that would amount to profit on the Consignment or applicable value added tax (or like tax) on such profit.</p>
                <p>9.9  Ownership of the Consignment If a claim arises as a result of damage to the whole or part of a Consignment and if we settle the claim for a sum equal to or greater than the value of the Consignment (in circumstances where you have purchased Parcel Protection for loss or damage), then we shall be entitled to claim ownership of the Consignment and deal with it as we see fit. In this circumstance, you agree that title in the Consignment shall pass to us on the date of settlement of the claim. For the avoidance of any doubt, we shall be responsible for the cost of recovery of the Consignment.</p>
            </div>
        </div>
    </section>
    <!-- FAQs Section End -->
    

@endsection