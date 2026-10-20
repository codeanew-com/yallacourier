@extends('frontend.layouts.master')

@section('content')
<section class="tabing-sec">
    <div class="container">
        <div class="main-tabing">
            <div class="tab-nav"><ul class="list-unstyled d-flex align-items-center"><li>Forgot password</li></ul></div>
            <div class="tab-conten-wrapper">
                <div class="tab-contents">
                    <h2 class="text-center">Reset your password</h2>
                    <p class="text-center">Enter the email you sign in with and we’ll send you a link to choose a new password.</p>
                    @include('customer.auth.password.partials.messages')
                    <form class="form-wrapper" action="{{ route('customer.password.email') }}" method="POST">
                        @csrf
                        <div class="row align-items-center d-flex justify-content-around">
                            <div class="col-lg-7">
                                <div class="input-wrapper align-items-center">
                                    <label class="text-left" for="email">Email:</label>
                                    <input type="email" class="w-70" id="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="submit-wrapper"><input type="submit" value="SEND RESET LINK"></div>
                            </div>
                            <div class="col-lg-7 text-center mt-3"><a href="{{ route('customer.login') }}">Back to sign in</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
