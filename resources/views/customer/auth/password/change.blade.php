@extends('frontend.layouts.master')

@section('content')
<section class="tabing-sec">
    <div class="container">
        <div class="main-tabing">
            <div class="tab-nav"><ul class="list-unstyled d-flex align-items-center"><li>Change password</li></ul></div>
            <div class="tab-conten-wrapper">
                <div class="tab-contents">
                    <h2 class="text-center">{{ $forced ? 'Please choose your own password' : 'Change password' }}</h2>
                    @if($forced)
                        <p class="text-center">You signed in with a temporary password from our team. Replace it to continue.</p>
                    @endif
                    @include('customer.auth.password.partials.messages')
                    <form class="form-wrapper" action="{{ route('customer.password.change.update') }}" method="POST">
                        @csrf
                        <div class="row align-items-center d-flex justify-content-around">
                            <div class="col-lg-7">
                                <div class="input-wrapper align-items-center">
                                    <label class="text-left" for="current_password">{{ $forced ? 'Temporary password:' : 'Current password:' }}</label>
                                    <input type="password" class="w-70" id="current_password" name="current_password" required autocomplete="current-password" autofocus>
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="input-wrapper align-items-center">
                                    <label class="text-left" for="password">New password:</label>
                                    <input type="password" class="w-70" id="password" name="password" required minlength="8" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="input-wrapper align-items-center">
                                    <label class="text-left" for="password_confirmation">Confirm:</label>
                                    <input type="password" class="w-70" id="password_confirmation" name="password_confirmation" required minlength="8" autocomplete="new-password">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="submit-wrapper"><input type="submit" value="SAVE PASSWORD"></div>
                            </div>
                            <div class="col-lg-7 text-center mt-3"><a href="{{ route('frontend.customer.logout') }}">Sign out</a></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
