@extends('frontend.layouts.master');

@section('content')

@push('header_scripts')
<link rel="stylesheet" href="{{ asset('front_assets/css/customer-dashboard.css') }}">
{{-- Wallet top-up disabled (2026-10-18) — Stripe.js/topup.js no longer needed on this page.
<script src="https://js.stripe.com/v3/"></script>
<script src="{{ asset('front_assets/js/topup.js')}}" defer></script>
--}}
@endpush

{{-- Wallet top-up disabled (2026-10-18) — li.load_amount no longer exists on this page.
<style>
    li.load_amount.active {
    background-color: #680895;
    color: white;
}
</style>
--}}
<style>
    .hidden {
      display: none;
    }
</style>

<div class="customer-area">

    <section class="customer-titlebar">
        <div class="container customer-titlebar-inner">
            <div class="customer-titlebar-branding">
                <img src="{{ asset('front_assets/images/header-logo.svg') }}" alt="Yalla Courier">
                <h1>eBilling</h1>
            </div>
            @include('customer.add-shipment-modal.index')
        </div>
    </section>

    <div class="container">
        <div class="customer-shell">
            @include('customer.nav.index')

            <main class="customer-content">

                <div class="customer-card">
                    <h2>My wallet</h2>
                    <div class="transcation-wrapper">
                        <div class="transcations-box">
                            <div class="img-box">
                                <img src="{{ asset('front_assets//images/aed.svg') }}" alt="">
                            </div>
                            <div class="transcations-details">
                                <h3>AED {{ Auth::guard('customers')->user()->balance }}</h3>
                            </div>
                        </div>
                        <div class="customer-topup-notice">
                            <h5>Wallet top-up is currently unavailable</h5>
                            <p>We are no longer providing wallet top-ups to customers. If you still have a balance in your wallet, please reach us on WhatsApp and we will refund you.</p>
                            <a href="https://wa.me/971526607133" target="_blank" rel="noopener" class="customer-topup-notice-whatsapp">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" width="15" height="15" aria-hidden="true"><path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222c0 39.1 10.2 77.3 29.6 110.9L4.8 480l116.1-30.4c32.3 17.6 68.6 26.9 105.9 26.9h.1c122.3 0 224.1-99.6 224.1-222c0-59.3-25.2-115-70.1-157.4zM223.9 438.9c-32.8 0-64.9-8.8-92.8-25.5l-6.7-4-69 18.1l18.4-67.3-4.3-6.9c-18.3-29.1-28-62.7-28-97.3c0-101 82.3-183.3 183.5-183.3c49 0 95.1 19.1 129.7 53.8c34.6 34.7 56.1 80.8 56 129.8c0 101.1-84.1 182.6-186.8 182.6zm101.2-135.2c-5.5-2.8-32.8-16.2-37.9-18s-8.9-2.8-12.6 2.8c-3.7 5.5-14.5 18-17.8 21.8c-3.3 3.7-6.6 4.2-12.1 1.4c-32.8-16.4-54.4-29.3-75.9-66.5c-5.7-9.9 5.7-9.2 16.3-30.6c1.8-3.7 .9-6.9-1.1-9.9c-2-2.8-8.9-21.5-13.9-34.4c-3.7-9.5-7.6-8.2-10.4-8.3c-2.7-.1-5.8-.1-8.9-.1c-9.3 0-18.9 2.7-21.5 7.9c-3.6 7.2-9.3 20.4-9.3 34.1c0 27.5 24.6 54.9 27.9 58.6c3.3 3.7 44.9 70.7 110.9 94.7c48.8 17.9 58.6 15.1 69.7 12.6c11.1-2.5 33.6-13.9 38.6-25.6c5-11.7 5-21.4 3.5-23.7c-1.5-2.3-5.7-3.5-11.2-6.3z"/></svg>
                                <span>Message us on WhatsApp</span>
                            </a>
                        </div>
                        {{-- Wallet top-up disabled (2026-10-18) — no longer offered to customers; refunds are handled via WhatsApp instead. Kept here, not deleted, in case it's re-enabled later.
                        @if(!Session::has('customer_topup'))
                        <form action="{{ route('customer.topup')}}" id="new_topup_form" method="POST">
                            @csrf
                            <input type="hidden" name="customer_id" value="{{ Auth::guard('customers')->user()->id }}">
                            <input type="hidden" name="amount_to_load" id="amount_to_load" value="25">
                        </form>
                        <div class="wallet-box">
                            <h5> Top up my wallet</h5>
                        </div>
                        <div class="wallet-top-up-box">
                            <h4>Wallet top-up</h4>
                        </div>
                        <div class="Connect-bank-account">
                            <h5>Connect your bank account now.</h5>
                            <h5>Instant transfer</h5>
                            <div class="connect-list d-flex align-items-center">
                                <ul class="list-unstyled">
                                    <li class="load_amount active" data-val="25">AED 25</li>
                                    <li class="load_amount" data-val="50">AED 50</li>
                                    <li class="load_amount" data-val="75">AED 75</li>
                                    <li class="load_amount" data-val="100">AED 100</li>
                                </ul>
                                or
                                <div class="list-input-box">
                                    <input type="text" class="list-input" id="new_amount_custom">
                                    <span>£</span>
                                </div>
                            </div>
                            <div class="button-box">
                                <a class="mt-3" id="take_me_to_payment">
                                    Take Me To Payment
                                </a>
                            </div>
                        </div>
                        @else
                        <form id="payment-form">
                            @php $total=0; $v=Session::get('customer_topup'); @endphp
                            <input type="hidden" name="total" value="{{ $v['amount_to_load'] }}" id="total">
                            <div id="payment-element">
                                <!--Stripe.js injects the Payment Element-->
                             </div>
                            <button id="submit">
                                <div class="spinner hidden" id="spinner"></div>
                                <span id="button-text">Pay now</span>
                            </button>
                            <div id="payment-message" class="hidden"></div>

                        </form>

                        @endif
                        --}}
                    </div>
                </div>

                <div class="customer-card">
                    <h2>My transactions</h2>
                    @php $topups = \App\Models\CustomerTopupModel::where('customer_id',Auth::guard('customers')->user()->id)->latest()->get(); @endphp
                    @if($topups->isEmpty())
                        <div class="customer-empty">
                            <p class="m-0">No top-ups yet.</p>
                        </div>
                    @else
                        <div class="customer-table-wrap">
                            <table class="customer-table">
                                <thead>
                                    <tr>
                                        <th>#ID</th>
                                        <th>Amount</th>
                                        <th>Reference</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($topups as $topup)
                                    <tr>
                                        <td>{{ $topup->id }}</td>
                                        <td>AED {{ number_format($topup->amount, 2) }}</td>
                                        <td>{{ $topup->payment_intent }}</td>
                                        <td><span class="customer-badge success">Loaded</span></td>
                                        <td>{{ $topup->created_at->diffForHumans() }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

            </main>
        </div>
    </div>
</div>
@endsection
@push('scripts')
{{-- Wallet top-up disabled (2026-10-18) — these handlers targeted the amount chips/pay button removed above. Kept here, not deleted, in case it's re-enabled later.
<script>
    $(document).ready(function(){
        $(".load_amount").click(function(){
            $(".load_amount").removeClass("active");
            $(this).addClass("active");
            $("#amount_to_load").val($(this).attr("data-val"));
        })
    })
</script>
<script>
    $(document).ready(function(){
        $("#new_amount_custom").on("input",function(){
            if($(this).val()!='')
            {
                $(".load_amount").removeClass("active");
                $("#amount_to_load").val($(this).val());
            }
            else
            {
                $(".load_amount").each(function( index ) {
                  if(index==0)
                  {
                      $(this).addClass("active");
                      $("#amount_to_load").val(25);
                  }
                });
            }
        })
    })
</script>
<script>
    $(document).ready(function(){
        $("#take_me_to_payment").click(function(){
            $("#new_topup_form").submit();
        })
    })
</script>
--}}
@endpush
