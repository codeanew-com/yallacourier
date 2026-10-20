<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Wallet balance at checkout. Routes are disabled (see routes/customer.php)
 * together with the old payment flow; kept per the owner's request so the
 * feature can be restored.
 */
class WalletController extends Controller
{
    public function use()
    {
        if (Auth::guard('customers')->user()->balance > 0) {
            Session::put('utilize_wallet', 1);

            return redirect()->back();
        }

        abort(404);
    }

    public function remove()
    {
        Session::forget('utilize_wallet');

        return redirect()->back();
    }
}
