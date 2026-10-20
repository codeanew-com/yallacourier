<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Sign-in code - Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @include('partials.favicons')

    <link href="{{ asset('a_assets/assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('a_assets/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('a_assets/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{ asset('a_assets/assets/js/plugin.js')}}"></script>
</head>

<body>
    <style>
        .invalid-feedback { display: block !important; font-size: 13px; }
        .otp-input { font-size: 28px; letter-spacing: 12px; text-align: center; font-variant-numeric: tabular-nums; }
    </style>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary-subtle">
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Check your email</h5>
                                        <p class="mb-0">We sent a 6-digit code to <strong>{{ $email }}</strong>.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-4">
                            @if (session('status'))
                                <div class="alert alert-success" role="status">{{ session('status') }}</div>
                            @endif
                            @if (session('otp_error'))
                                <div class="alert alert-danger" role="alert">{{ session('otp_error') }}</div>
                            @endif

                            <form method="POST" action="{{ route('login.otp.verify') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="code" class="form-label">Sign-in code</label>
                                    <input id="code" type="text" name="code" class="form-control otp-input" inputmode="numeric" pattern="[0-9]{6}" maxlength="6"
                                           autocomplete="one-time-code" required autofocus placeholder="000000">
                                    @error('code')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                    @enderror
                                    <div class="form-text">The code expires in {{ config('auth.admin_otp.expire') }} minutes.</div>
                                </div>
                                <div class="d-grid">
                                    <button class="btn btn-primary waves-effect waves-light" type="submit">Verify and sign in</button>
                                </div>
                            </form>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <form method="POST" action="{{ route('login.otp.resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0" id="resend" @if ($resendWait > 0) disabled data-wait="{{ $resendWait }}" @endif>
                                        Resend code<span id="resend-wait">@if ($resendWait > 0) ({{ $resendWait }}s)@endif</span>
                                    </button>
                                </form>
                                <a href="{{ route('login') }}">Use a different account</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('resend');
            var label = document.getElementById('resend-wait');
            var wait = parseInt(btn.getAttribute('data-wait') || '0', 10);
            if (!wait) return;
            var t = setInterval(function () {
                wait--;
                if (wait <= 0) { clearInterval(t); btn.disabled = false; label.textContent = ''; return; }
                label.textContent = ' (' + wait + 's)';
            }, 1000);
        })();
    </script>
</body>

</html>
