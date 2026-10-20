<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AdminLoginOtp;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

/**
 * Staff (admin) sign-in, step 1: email + password.
 *
 * A correct password does not sign the admin in by itself: it emails a
 * one-time code and continues at LoginOtpController (step 2). The lockout
 * after repeated wrong passwords and the error messages come from laravel/ui.
 */
class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function login(Request $request)
    {
        if (! AdminLoginOtp::enabled()) {
            return $this->passwordOnlyLogin($request);
        }

        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Checks the password without signing in.
        if (! $this->guard()->validate($this->credentials($request))) {
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }

        $this->clearLoginAttempts($request);
        $request->session()->regenerate();

        $otp = app(AdminLoginOtp::class);
        $sent = $otp->start($this->guard()->getLastAttempted(), $request->boolean('remember'));

        return redirect()->route('login.otp')->with($sent
            ? ['status' => 'We emailed you a 6-digit sign-in code.']
            : ['otp_error' => 'We couldn’t send the sign-in code email. Try "Resend code", or contact the site administrator.']);
    }

    /** The original laravel/ui login, used only when ADMIN_LOGIN_OTP=false. */
    private function passwordOnlyLogin(Request $request)
    {
        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
