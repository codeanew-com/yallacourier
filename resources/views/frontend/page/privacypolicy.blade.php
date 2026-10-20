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
                        <h1>Privacy Policy</h1>
                    </div>
                </div>
            </div>
            
        </div> 
    </section>
     <!--{{-- innner banner section End --}} -->
     
    <!-- Privacy Policy Section Start -->
    <section class="policies-sec privacy-policy-sec usessection">
        <div class="container">
            <div class="policy-content-wrapper">
                <h3>Who are we?</h3>
                <p>This is the privacy policy of YALLA TRADING L.L.C (Trading as Yalla Shipping) 1591977. </p>
                <p>This privacy policy replaces all previous versions and applies from the date published.</p>
                <h3>Who Does this Privacy Policy apply to?</h3>
                <p>This privacy policy applies to:</p>
                <ul>
                    <li>Employees of YALLA TRADING L.L.C (Trading as Yalla Shipping) 1591977</li>
                    <li>Customers</li>
                    <li>Prospective customers</li>
                    <li>Individuals that use our websites</li>
                    <li>Former customers</li>
                    <li>Nominated users or individuals acting under a power of attorney.</li>
                </ul>
                    <p>Our services are not intended for children, unless we expressly state otherwise, and we do not knowingly collect or process personal data relating to children or anyone below the age of 18 years.</p>
                    <p>It is important that the personal data we hold about you is accurate and current. It is your responsibility to keep us up to date if you make any changes to your personal data by updating your account details.</p>
                    <h3>What Information do we collect?</h3>
                    <p>Personal data is any information that can identify a natural person. We may collect, use, store and transfer different categories of personal data to enable us to deliver our services, as follows:</p>
                    <ul>
                        <li>Data about your Identity: including first name, last name, title.</li>
                        <li>Data about a recipient’s identity: including first name, last name, title, delivery address, email address and mobile number;</li>
                        <li>Data about your contact details: including correspondence/billing address, email address, landline telephone number and mobile phone number;</li>
                        <li>Financial data: payment card info, which is captured and stored by our payment provider;</li>
                        <li>Data relating to a transaction: including services purchased, net revenue spent, (split by service), claims made/paid/rejected, including amount. Refunds and amounts, times/dates of payment and VAT status;</li>
                        <li>Technical data including IP address, your login data, browser type and version, location, browser plug-in types and versions, online chat logs and other information on the devices you use to access our services;</li>
                        <li>Data about your YallaCourier profile including your Account username and password, your interests, preferences, feedback and survey responses;</li>
                        <li>Data relating to marketing and communications choices including what method a customer would like to receive marketing and how frequently.</li>
                    </ul>
                    <h3>How do we collect information?</h3>
                    <p><b>Information you give us</b></p>
                    <ul>
                        <li>When you place an order with us for any of our services online, we will need certain information to process your order;</li>
                        <li>When you contact us to discuss your services, we may ask for certain information to be able to confirm your identity, check our records and answer your questions quickly and accurately;</li>
                        <li>If you take part in any surveys we may ask for information about you, which we will make clear to you at the time and for the purpose we will be using this information.</li>
                        <li>If you apply for a job, we may collect information about your criminal record by obtaining a DBS check through an approved agency and view information you have shared publicly, including on social media.</li> 
                    </ul>
                    <h3>Information we automatically collect</h3>
                    <p><b>We will automatically collect information:</b></p>
                    <ul>
                        <li>when you use our services; and</li>
                        <li>when you visit our website or use our mobile application, we may collect and process information about your usage of these by using “cookies” and other similar technologies to help us make improvements to the websites and to the services we make available.</li>
                        <li>when you download or use mobile applications created by us and, where applicable, have requested or consented to location services, we may receive information about your location and your mobile device, including a unique identifier for your device. We may use this information to provide you with location-based services, such as search results, and other personalised content. Most mobile devices allow you to turn off location services. Our mobile application does not collect precise information about the location of your mobile device.</li>
                    </ul>
                    <h3>Information we receive from other sources</h3>
                    <p>We may receive personal data about you from third parties and other entities, publicly available sources and/or partners of Yalla Courier in the following categories:</p>
                    <ul>
                        <li>Companies contracted by us to help us provide services to you;</li>
                        <li>Marketing or market research organisation’s;</li>
                        <li>Credit reference agencies or fraud prevention agencies.</li>
                        <li>Recruitment Companies if you apply for a job with us</li> 
                    </ul>
                    <h3>How do we use information?</h3> 
                    <p>The information we collect and receive helps us to better understand what you need from us and to improve the provision of our services to you.</p>
                    <p>We use the information collected for example to:</p>
                    <ul>
                        <li>Verify your identity when you use our services or contact us;</li>
                        <li>Process your enquiries, orders or applications, for example when assessing an application, we may use automated decision-making systems;</li>
                        <li>Carry out credit checks and to manage your accounts</li>
                        <li>Monitor, record, store and use any telephone, e-mail or other electronic communications with you for training purposes, so that we can check any instructions given to us and to improve the quality of our customer service, and in order to meet our legal and regulatory obligations;</li>
                        <li>Where you have agreed, provide you with information about other Yalla Courier services, offers or products which you may be interested in;</li>
                        <li>To tell you about changes to our websites, services or terms and conditions;</li>
                        <li>Carry out any personal data and/or marketing analysis, profiling or create statistical or testing information to help us personalised the services we offer you and to understand our users/customers better, understand what our users/customers want and how they use our products and services;</li>
                        <li>We’ll use your data to meet the legitimate interests of our business in a way which might reasonably be expected (for example, when you abandon your session or basket before completing your checkout, we will send you email notifications.</li>
                        <li>With your consent, or whenever you order with us and do not choose to opt-out of receiving marketing communications (based on legitimate interest), we will use your personal data and order details to send you personalised marketing via email, text, and through our contact centre’s about relevant products and services including special offers, promotions, services, competitions and so on. You are free to opt out of hearing from us by any of these channels at any time, if you wish to change how we use your data, please see the ‘Your Rights’ section below.</li>
                        <li>Sometimes we will send communications which are either required by law or necessary to inform you about your order or changes to the service we provide, for example order confirmation or changes to terms and conditions. These service messages will not include marketing or promotional content.</li>
                        <li>We may occasionally send you surveys and feedback requests to help improve our services. These messages will not include any marketing or promotional content and do not require prior consent when sent by email or text message. We have a legitimate interest to do so as this helps make our products or services more relevant to you.</li>
                        <li>To display the relevant content to you on our websites or app, we will use your data relating to your preferred couriers and services and so on. We do so based on your consent to receive app notifications and/or for our website to place cookies or similar technology on your device. For example, we might display a list of services you’ve recently looked at or offer you recommendations based on your order history and any other data you’ve shared with us.</li>
                        <li>When you are opted into email communication, we assume the permission to use your email address to contact you extends to its use within other third-party advertising platforms, including but not limited to Google & Facebook. You may see banner advertisements or other forms of sponsored content and personalised search engine results because of this type of advertising. You can review the partner's privacy policies, which include details of how to opt out of advertising within each platform, by following the links below:</li>
                    </ul>
                        <p>Google: <a href="https://policies.google.com/technologies/ads?hl=en-US" target="_blank">https://policies.google.com/technologies/ads?hl=en-US</a></p>
                        <p>Facebook: <a href="https://www.facebook.com/help/568137493302217">https://www.facebook.com/help/568137493302217</a></p>
                        <ul>
                            <li>To administer any of our prize draws or competitions which you enter, based on your consent given at the time of entering.</li>
                            <li>Recover any monies you may owe to us for using our services;</li>
                            <li>Analyse our services with the aim of improving them;</li>
                            <li>Prevent or detect a crime, fraud or misuse of, or damage to our website, and to investigate where we believe any of these have occurred; and</li>
                            <li>Monitor network traffic from time to time for the purposes of backup and problem solving, for example our automated system may monitor email subjects to help with spam and malware detection.</li>
                        </ul>
                        <p>Your data may also be used for other purposes for which you give your specific permission or, in very limited circumstances, when required by law.</p>
                        <p>We may supplement the information directly collected by us with data from third parties (for example socio-demographic data, credit reference agencies and fraud prevention agencies etc.) to further improve our data quality as well as the services or products we offer customers.</p>
                        <p>If you choose to pay for your goods with a credit or debit card, we will store an encrypted reference to your card known as a ‘token’. This helps us to keep your data secure by enabling further payments to be processed without us storing your sensitive card details. This allows you to use your card in the future without re-adding your details, and we may use this to charge your card for any surcharges charged to Yalla Courier by the courier. The reasons for these charges include, but are not limited to, a customer under-declaring the weight or size of their parcel, or for any packaging that a courier states is unsuitable” (in accordance with our terms and conditions).</p>
                        <h3>Who will we share your data with?</h3>
                        <ul>
                            <li>Third party suppliers who help Yalla Courier to perform our services;</li>
                            <li>Professional advisors;</li>
                            <li>Law enforcement agencies;</li>
                            <li>Other companies as part of the process of selling one or more of our businesses or part of those businesses;</li>
                        </ul>
                        <p>Where we share your information with third parties they are required to follow our express instructions in respect of the use of your personal information and they must comply with all applicable UK data protection laws to protect your information and keep it secure.</p>
                        <h3>Protecting information</h3>
                        <p>We take protecting your data seriously, and will do our utmost to employ appropriate organisational and technical security measures to protect you against unauthorised disclosure or processing.</p>
                        <p>Unfortunately we cannot guarantee the security of transmitting information via the internet. We have tried to create a secure and reliable website and mobile application for our users in line with industry standards. However, we have no responsibility or liability for the security of personal information transmitted via the internet.</p>
                        <p>Links from our website may take you to external websites which are not covered by this policy. We recommend that you check their privacy policies before submitting any personal information to such sites. We will not be responsible for the content, function or information collection policies of these external websites.</p>
                        <h3>Why do we process your data?</h3>
                        <p>We process each type of personal data for one the following reasons:</p>
                        <ul>
                            <li>We need to process the data under our contract with you for our services;</li>
                            <li>We have a legitimate interest as a business in processing your data;</li>
                            <li>We have a legal obligation to process the data; or</li>
                            <li>We have your consent (which you can withdraw at any time).</li>
                        </ul>
                        <p>If you don’t provide us with the data we need then we will not be able to offer our services to you.</p>
                        <h3>Transfers of data outside of the United Kingdom</h3>
                        <p>From time to time the third parties we share our data with may be outside of the United Kingdom in countries that do not always have the same standard of data protection laws as the UK. However, we will have a contract in place to ensure that your information is adequately protected, and we will remain bound by our obligations under applicable UK data protection laws even when your personal information is processed outside of the UK. The sorts of measures we use to protect your data in this instance are security reviews of the organizations, contractual model clauses approved for use by the European Commission or other approved transfer mechanisms.</p>
                        <h3>How long do we hold your information for?</h3>
                        <p>Unless there is a specific regulatory or legal requirement for us to keep your information longer, we will keep your information for as long as it is necessary for the purpose for which it was collected.</p>
                        <p>To determine the appropriate retention period for personal data, we consider the amount, nature, and sensitivity of the personal data, the potential risk of harm from unauthorised use or disclosure of your personal data, the purposes for which we process your personal data and whether we can achieve those purposes through other means, and the applicable legal requirements.</p>
                        <h3>Your Rights</h3>
                        <p>As a data subject you have a number of personal rights under data protection laws in relation to your personal data. These are:</p>
                        <ul>
                            <li>Subject access requests - You have a right to access personal data that we hold as a data controller.</li>
                            <li>Right to be forgotten - In certain circumstances you have a right to request that your personal data be erased from the systems within our control.</li>
                            <li>Rectification - You have a right to correct your personal data that we hold as a data controller</li>
                            <li>Withdraw consent - Where we have offered you the right to consent to giving us your data, for instance with your marketing preferences, you have the right to withdraw your consent at any time.</li>
                            <li>Objection and restriction of processing - In certain circumstances, you have a right to object to or request we restrict our processing of your personal data.</li>
                            <li>Right to port – You have a right to receive certain information about you in a machine readable format.</li>
                        </ul>
                        <h3>Complaints</h3>
                        <p>If you would like to make a complaint about our use of the personal data you should contact our Data Protection Officer at the details above. If we have not resolved your complaint, you can contact the UK data protection regulator, the Information Commissioner’s Office (ICO) (www.ico.org.uk). We would, however, appreciate the chance to deal with your concerns before you approach the ICO so please contact us in the first instance.</p>
                        <p>We may update this privacy policy from time to time. The revised policy will be posted to this page.</p>
                        <p><b>This policy was last updated on 22 April 2024</b></p>
            </div> 
        </div>
    </section>    

@endsection