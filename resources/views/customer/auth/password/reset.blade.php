@extends('frontend.layouts.master')

@section('content')
<section class="tabing-sec">
    <div class="container">
        <div class="main-tabing">
            <div class="tab-nav"><ul class="list-unstyled d-flex align-items-center"><li>{{ $setup ? 'Set password' : 'Reset password' }}</li></ul></div>
            <div class="tab-conten-wrapper">
                <div class="tab-contents">
                    <h2 class="text-center">{{ $setup ? 'Choose your password' : 'Choose a new password' }}</h2>
                    <p class="text-center">At least 8 characters, including letters and numbers.</p>
                    @include('customer.auth.password.partials.messages')
                    <form class="form-wrapper" action="{{ route('customer.password.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        @if($setup)<input type="hidden" name="setup" value="1">@endif
                        <div class="row align-items-center d-flex justify-content-around">
                            <div class="col-lg-7">
                                <div class="input-wrapper align-items-center">
                                    <label class="text-left" for="email">Email:</label>
                                    <input type="email" class="w-70" id="email" name="email" value="{{ old('email', $email) }}" required autocomplete="username">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="input-wrapper align-items-center">
                                    <label class="text-left" for="password">New password:</label>
                                    <input type="password" class="w-70" id="password" name="password" required minlength="8" autocomplete="new-password" autofocus>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="input-wrapper align-items-center">
                                    <label class="text-left" for="password_confirmation">Confirm:</label>
                                    <input type="password" class="w-70" id="password_confirmation" name="password_confirmation" required minlength="8" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="submit-wrapper"><input type="submit" value="{{ $setup ? 'SET PASSWORD' : 'RESET PASSWORD' }}"></div>
                            </div>
                            <div class="col-lg-7 text-center mt-3"><a href="{{ route('customer.password.request') }}">Need a new link?</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
