<?php

/*
|--------------------------------------------------------------------------
| Customer portal routes
|--------------------------------------------------------------------------
| Customers sign in on the `customers` guard. Portal pages use the `customer`
| middleware (App\Http\Middleware\AuthenticateCustomer); every web request also
| passes EnforceCustomerAccountStatus, which signs out blocked customers and
| forces a pending temporary-password change.
|
| Public registration is closed (2026-10-20): accounts are created in the admin.
*/

use App\Http\Controllers\Customer\AccountController;
use App\Http\Controllers\Customer\AuthController;
use App\Http\Controllers\Customer\PasswordController;
use Illuminate\Support\Facades\Route;

Route::prefix('customer')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('customer.login');
    Route::post('login', [AuthController::class, 'login'])->name('customer.handle.login')->middleware('throttle:5,1');
    Route::get('logout', [AuthController::class, 'logout'])->name('frontend.customer.logout');

    // Password recovery (public) and change (signed in).
    Route::get('forgot-password', [PasswordController::class, 'showForgot'])->name('customer.password.request');
    Route::post('forgot-password', [PasswordController::class, 'sendResetLink'])->name('customer.password.email')->middleware('throttle:5,1');
    Route::get('reset-password/{token}', [PasswordController::class, 'showReset'])->name('customer.password.reset');
    Route::post('reset-password', [PasswordController::class, 'reset'])->name('customer.password.update')->middleware('throttle:5,1');
    Route::get('change-password', [PasswordController::class, 'showChange'])->name('customer.password.change')->middleware('customer');
    Route::post('change-password', [PasswordController::class, 'change'])->name('customer.password.change.update')->middleware(['customer', 'throttle:5,1']);

    Route::middleware('customer')->group(function () {
        Route::get('dashboard', [AccountController::class, 'dashboard'])->name('frontend.customer.dashboard.index');
        Route::get('shipment-setting', [AccountController::class, 'shipments'])->name('frontend.customer.shipmentsetting.index');
        Route::get('shipment/{id}', [AccountController::class, 'showShipment'])->name('customer.view.order');
        Route::get('e-billing', [AccountController::class, 'billing'])->name('frontend.customer.ebilling.index');
        Route::get('setting', [AccountController::class, 'settings'])->name('frontend.customer.setting.index');
        Route::post('setting', [AccountController::class, 'updateSettings'])->name('frontend.customer.setting.update');
    });
});

// Wallet use at checkout — disabled with the customer payment flow (2026-10-03);
// App\Http\Controllers\Customer\WalletController is kept so it can be restored:
// Route::get('/utilize/wallet', [WalletController::class, 'use'])->name('front.checkout.wallet')->middleware('customer');
// Route::get('/remove/wallet', [WalletController::class, 'remove'])->name('front.checkout.removewallet')->middleware('customer');
