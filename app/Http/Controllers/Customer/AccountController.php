<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\UpdateProfileRequest;
use App\Models\OrderModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/** The logged-in customer's portal pages (behind the `customer` middleware). */
class AccountController extends Controller
{
    public function dashboard()
    {
        return view('customer.dashboard.index');
    }

    public function shipments()
    {
        return view('customer.shipmentsetting.index');
    }

    public function showShipment(string $id)
    {
        // Only the customer's own orders; anyone else's id is a 404.
        $order = OrderModel::where('customer_id', Auth::guard('customers')->id())->where('id', $id)->first() ?? abort(404);

        return view('customer.shipments.view')->with('o', $order);
    }

    public function billing()
    {
        return view('customer.ebilling.index');
    }

    public function settings()
    {
        return view('customer.setting.index');
    }

    public function updateSettings(UpdateProfileRequest $request)
    {
        $customer = Auth::guard('customers')->user();
        $customer->name = $request->name;
        $customer->company_name = $request->company_name;
        $customer->designation = $request->designation;
        $customer->phone = $request->phone;
        $customer->save();

        Session::flash('profile_msg', 'Profile updated successfully.');

        return redirect()->back();
    }

    // Custom Products page removed (2026-10-18) — was a static placeholder with no backend
    // (no table, no create/edit/delete). Its view is kept; rebuild fresh if the feature is needed.
}
