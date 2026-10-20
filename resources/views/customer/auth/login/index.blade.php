@extends('frontend.layouts.master')

@section('content')
<section class="tabing-sec ">
    <div class="container">
        <div class="main-tabing">
            <div class="tab-nav">
                <ul class="list-unstyled d-flex align-items-center">
                    <li>
                        Sign in
                    </li>
                    {{-- Registration removed per owner request (2026-10-18) — not deleted, see history.
                    <li>
                        Register
                    </li>
                    --}}
                </ul>
            </div>
            <div class="tab-conten-wrapper">

                <div class="tab-contents">
                    <h2 class="text-center">Sign in</h2>
                    @if(Session::has('msg'))
                    <p style="color: white;background: #680895;padding: 7px 4px 7px 6px;border-radius: 6px;font-size: 16px;font-weight: 700;">{{ Session::get('msg') }}</p>
                    @endif
                    <form class="form-wrapper" action="{{ route('customer.handle.login')}}" method="POST">
                        @csrf
                        <div class="row align-items-center d-flex justify-content-around">
                            <div class="col-lg-7">
                                <div class="input-wrapper  align-items-center">
                                    <label class="text-left">Email:</label>
                                    <input type="email" class="w-70" name="email" required="required" placeholder="Email!">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="input-wrapper  align-items-center">
                                    <label class="text-left">Password:</label>
                                    <input type="password" class="w-70" name="password" required="required" placeholder="*********">
                                </div>
                            </div>
                            <div class="col-lg-7 ">
                                <div class="submit-wrapper">
                                    <input type="submit" value="SIGIN IN">
                                </div>
                            </div>
                            <div class="col-lg-7 text-center mt-3">
                                <a href="{{ route('customer.password.request') }}">Forgot your password?</a>
                                {{-- Public registration is closed (2026-10-20): accounts are created by the Yalla Courier team. --}}
                                <p class="small mt-2 mb-0">Need an account? Our team sets up customer accounts. <a href="{{ url('/contact-us') }}">Contact us</a>.</p>
                            </div>
                        </div>
                    </form>
                </div>
                {{-- Registration form removed per owner request (2026-10-18) — not deleted, see history.
                <div class="tab-contents">
                    <h2 class="text-center">Register</h2>
                    <form class="form-wrapper" action="{{ route('customer.handle.register')}}" method="POST">
                        @csrf
                        <div class="row align-items-center  d-flex justify-content-around">
                            <div class="col-lg-7 ">
                                <div class="input-wrapper  align-items-center">
                                    <label class="text-left">Name:</label>
                                    <input type="text" class="w-70" name="name" required="required">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="input-wrapper  align-items-center">
                                    <label class="text-left">Email:</label>
                                    <input type="email" class="w-70" name="email" required="required">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="input-wrapper  align-items-center">
                                    <label class="text-left">Password:</label>
                                    <input type="password" class="w-70" name="password" required="required">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="submit-wrapper">
                                    <input type="submit" value="REGISTER">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                --}}
            </div>
        </div>
    </div>
</section>
@endsection