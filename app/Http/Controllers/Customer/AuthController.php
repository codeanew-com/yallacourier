<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Customer sign-in on the `customers` guard. Public self-registration was
 * removed 2026-10-20: accounts are created only by admins
 * (Admin\CustomerController::store).
 */
class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('customer.auth.login.index');
    }

    public function login(LoginRequest $request)
    {
        $guard = Auth::guard('customers');

        if (! $guard->attempt(['email' => $request->email, 'password' => $request->password])) {
            Session::flash('msg', 'Invalid Username Or Password!');

            return redirect()->back();
        }

        $customer = $guard->user();
        // Credentials are right, but an admin may have blocked the account.
        // Checked only after a correct password so the status isn't revealed to guessers.
        if ($customer->isBlocked()) {
            $guard->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            Session::flash('msg', $customer->blockedMessage());

            return redirect()->back();
        }

        $request->session()->regenerate();
        $customer->forceFill(['last_login_at' => now(), 'last_login_ip' => $request->ip()])->saveQuietly();
        if ($customer->must_change_password) {
            return redirect()->route('customer.password.change');
        }

        return redirect(route('frontend.customer.dashboard.index'));
    }

    public function logout()
    {
        Auth::guard('customers')->logout();
        Session::flash('msg', 'Logout Successfully');

        return redirect(route('customer.login'));
    }
}
