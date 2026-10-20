<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Login - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.favicons')

    <!-- Bootstrap Css -->
    <link href="{{ asset('a_assets/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('a_assets/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('a_assets/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App js -->
    <script src="{{ asset('a_assets/assets/js/plugin.js')}}"></script>
</head>

<body>
    <style>
        .invalid-feedback {
            display: block !important;
            font-size: 13px;
        }
    </style>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary-subtle">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Welcome Back</h5>
                                        <p>Sign In To Continue!</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="auth-logo">
                                <a href="{{ url('/')}}" class="auth-logo-light">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ asset('front_assets/images/header-logo.svg')}}" alt="" height="25">
                                        </span>
                                    </div>
                                </a>

                                <a href="{{ url('/')}}" class="auth-logo-dark">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="{{ asset('front_assets/images/header-logo.svg')}}" alt="" height="25">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="username" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" class="form-control" placeholder="******" name="password" required autocomplete="current-password">
                                            <button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
                                        </div>
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember-check">
                                            Remember Me
                                        </label>
                                    </div>

                                    <div class="mt-3 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Login</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>© <script>
                                    document.write(new Date().getFullYear())
                                </script> Crafted With <i class="mdi mdi-heart text-danger"></i> By <a href="https://codeanew.com" target="_blank" rel="noopener">Codeanew</a></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- end account-pages -->

    <!-- JAVASCRIPT -->
    <script src="{{ asset('a_assets/assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/metismenu/metisMenu.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{ asset('a_assets/assets/libs/node-waves/waves.min.js')}}"></script>

    <!-- App js -->
    <script src="{{ asset('a_assets/assets/js/app.js')}}"></script>
</body>

</html>