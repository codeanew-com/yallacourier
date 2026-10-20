<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use App\Models\OrderPackagesModel;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

/**
 * Shipping label (AWB) download — the one endpoint shared by both areas.
 * It has no route-level auth middleware because it must serve both the `web`
 * (admin) and `customers` guards; access is checked here instead.
 */
class OrderLabelController extends Controller
{
    public function download(int $package)
    {
        $package = OrderPackagesModel::findOrFail($package);
        $order = OrderModel::findOrFail($package->order_id);

        $isAdmin = Auth::guard('web')->check();
        $isOwningCustomer = Auth::guard('customers')->check() && Auth::guard('customers')->id() == $order->customer_id;

        if (! $isAdmin && ! $isOwningCustomer) {
            abort(403);
        }

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('private');

        if (! $package->awb_label || ! $disk->exists($package->awb_label)) {
            abort(404);
        }

        return $disk->download($package->awb_label);
    }
}
