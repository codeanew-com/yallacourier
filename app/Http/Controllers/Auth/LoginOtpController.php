<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\ActivityLogger;
use App\Services\Auth\AdminLoginOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/** Staff (admin) sign-in, step 2: the 6-digit code emailed after a correct password. */
class LoginOtpController extends Controller
{
    public function __construct(private AdminLoginOtp $otp) {}

    public function show()
    {
        $user = $this->otp->pendingUser();
        if (! $user) {
            return redirect()->route('login');
        }

        return view('auth.otp', [
            'email' => $user->email,
            'resendWait' => $this->otp->resendWait(),
        ]);
    }

    public function verify(Request $request, ActivityLogger $activity)
    {
        $request->validate(['code' => ['required', 'digits:6']], [
            'code.digits' => 'Enter the 6-digit code from the email.',
        ]);

        [$result, $user, $remember] = $this->otp->verify($request->code);

        return match ($result) {
            'ok' => $this->signIn($request, $user, $remember, $activity),
            'invalid' => back()->withErrors(['code' => 'That code is not correct. '.$this->otp->attemptsLeft().' attempt(s) left.']),
            'locked' => redirect()->route('login')->withErrors(['email' => 'Too many wrong codes. Sign in again to get a new code.']),
            default => redirect()->route('login')->withErrors(['email' => 'Your sign-in code has expired. Sign in again to get a new one.']),
        };
    }

    public function resend()
    {
        $user = $this->otp->pendingUser();
        if (! $user) {
            return redirect()->route('login');
        }

        if (($wait = $this->otp->resendWait()) > 0) {
            return back()->with('otp_error', 'Please wait '.$wait.' seconds before requesting another code.');
        }

        return $this->otp->send($user)
            ? back()->with('status', 'A new code was emailed to you. Earlier codes no longer work.')
            : back()->with('otp_error', 'We couldn’t send the email. Please try again in a minute.');
    }

    private function signIn(Request $request, $user, bool $remember, ActivityLogger $activity)
    {
        Auth::guard('web')->login($user, $remember);
        $request->session()->regenerate();
        $activity->record('Admin '.$user->email.' signed in (email code verified) from '.$request->ip(), $user->id);

        return redirect()->intended('/admin');
    }
}
