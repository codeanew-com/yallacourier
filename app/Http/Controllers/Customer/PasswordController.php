<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\ChangePasswordRequest;
use App\Http\Requests\Customer\ForgotPasswordRequest;
use App\Http\Requests\Customer\ResetPasswordRequest;
use App\Models\CustomerModel;
use App\Services\Customers\CustomerSessionRevoker;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Customer password self-service, built on Laravel's password brokers
 * (hashed, expiring, single-use tokens — config/auth.php "passwords"):
 *   - forgot password → emailed reset link
 *   - reset / first-time setup via that link
 *   - forced change after an admin issued a temporary password
 */
class PasswordController extends Controller
{
    /** Same answer whether or not the email exists, so the form can't be used to discover accounts. */
    private const GENERIC_SENT = 'If an account exists for that email, we’ve sent a link to reset the password. Check your inbox (and spam folder).';

    public function showForgot()
    {
        return view('customer.auth.password.forgot');
    }

    public function sendResetLink(ForgotPasswordRequest $request)
    {
        $status = Password::broker('customers')->sendResetLink(['email' => strtolower(trim($request->email))]);

        // Throttled requests get the same neutral reply (the broker allows one email per minute per account).
        if (! in_array($status, [Password::RESET_LINK_SENT, Password::INVALID_USER, Password::RESET_THROTTLED], true)) {
            return back()->withInput()->with('msg', 'We couldn’t send the email right now. Please try again in a few minutes.');
        }

        return back()->with('msg', self::GENERIC_SENT);
    }

    public function showReset(Request $request, string $token)
    {
        return view('customer.auth.password.reset', [
            'token' => $token,
            'email' => (string) $request->query('email', ''),
            'setup' => $request->boolean('setup'),
        ]);
    }

    public function reset(ResetPasswordRequest $request, CustomerSessionRevoker $revoker)
    {
        $broker = $request->boolean('setup') ? 'customer_setup' : 'customers';

        $status = Password::broker($broker)->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (CustomerModel $customer, string $password) use ($revoker) {
                $customer->forceFill([
                    'password' => $password, // hashed by the model's "hashed" cast
                    'remember_token' => Str::random(60),
                    'must_change_password' => false,
                    'password_changed_at' => now(),
                    // Using a link sent to the address proves the customer owns it.
                    'email_verified_at' => $customer->email_verified_at ?? now(),
                ])->save();
                // Any session opened with the old password ends.
                $revoker->revoke($customer);
                event(new PasswordReset($customer));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()->withInput($request->only('email'))->withErrors(['email' => match ($status) {
                Password::INVALID_TOKEN, Password::INVALID_USER => 'This link is invalid or has expired. Request a new one below.',
                default => 'Your password could not be reset. Please try again.',
            }]);
        }

        $customer = CustomerModel::where('email', $request->email)->first();
        $message = $request->boolean('setup') ? 'Your password is set. You can now sign in.' : 'Your password has been reset. You can now sign in.';
        if ($customer && $customer->isBlocked()) {
            $message .= ' '.$customer->blockedMessage();
        }

        return redirect()->route('customer.login')->with('msg', $message);
    }

    public function showChange()
    {
        return view('customer.auth.password.change', ['forced' => (bool) Auth::guard('customers')->user()->must_change_password]);
    }

    public function change(ChangePasswordRequest $request)
    {
        $customer = Auth::guard('customers')->user();

        if (! Hash::check($request->current_password, $customer->password)) {
            return back()->withErrors(['current_password' => 'The current password is not correct.']);
        }

        $customer->forceFill([
            'password' => $request->password,
            'must_change_password' => false,
            'password_changed_at' => now(),
        ])->save();
        $request->session()->regenerate();

        return redirect()->route('frontend.customer.dashboard.index');
    }
}
