<?php

/*
|--------------------------------------------------------------------------
| Public website routes
|--------------------------------------------------------------------------
| Guest-facing pages, shipment booking and the business form. Admin and
| customer-portal routes live in routes/admin.php and routes/customer.php,
| which bootstrap/app.php loads first. The /{slug?} CMS catch-all must stay
| the LAST route registered, or it swallows every single-segment URL.
*/

use App\Http\Controllers\Frontend\BusinessLeadController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ShipmentRequestController;
use App\Http\Controllers\OrderLabelController;
use Illuminate\Support\Facades\Route;

// Direct shipment booking (2026-10-19): one form, no courier comparison, no
// payment; an admin assigns a courier and prices it later. (The old Aramex /
// Posta Plus / Emirates Post / Skynet comparison and Stripe flow were removed.)
Route::post('/shipment/request', [ShipmentRequestController::class, 'store'])->name('front.shipment.request');
Route::get('/shipment/requested/{id}', [ShipmentRequestController::class, 'show'])->name('front.shipment.requested');

Route::get('/country/{slug}', [PageController::class, 'country'])->name('countrysingle');
Route::get('/get/hscode', [PageController::class, 'hsCodes']);
Route::get('/thank-you/{id}', [PageController::class, 'thankYou'])->name('front.thankyou');

Route::post('/submit-form', [BusinessLeadController::class, 'store'])->name('form.submit');
Route::get('/lead/thankyou', [PageController::class, 'leadThankYou'])->name('lead.thankyou');

// Shared by admins and customers: no route-level auth (two guards);
// OrderLabelController checks admin-or-owning-customer itself.
Route::get('/order-package/{package}/label', [OrderLabelController::class, 'download'])->name('order.package.label');

// CMS pages by slug ("/" = home). Keep last.
Route::get('/{slug?}', [PageController::class, 'show'])->name('home');
