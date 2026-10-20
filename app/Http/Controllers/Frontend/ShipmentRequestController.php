<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreShipmentRequest;
use App\Models\OrderModel;
use App\Services\Orders\ShipmentBookingService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

/**
 * Direct shipment booking (2026-10-19): the customer submits once, with no
 * courier comparison and no payment; an admin picks a courier later.
 */
class ShipmentRequestController extends Controller
{
    public function store(StoreShipmentRequest $request, ShipmentBookingService $booking)
    {
        $order = $booking->book($request->all(), Auth::guard('customers')->id() ?? 0);

        // Left over from the removed comparison flow; cleared so a stale search can't resurface.
        Session::forget('search_data');
        Session::forget('booking_details');

        return redirect()->route('front.shipment.requested', $order->id);
    }

    public function show(string $id)
    {
        return view('frontend.shipmentrequested.index')->with('order', OrderModel::findOrFail($id));
    }
}
