<?php

/*
|--------------------------------------------------------------------------
| Admin (staff) routes
|--------------------------------------------------------------------------
| Staff sign in on the default `web` guard (laravel/ui login at /login); every
| back-office page lives under /admin and requires `auth`. Route *names* are
| kept exactly as the views and tests use them, so they are not prefixed
| uniformly (e.g. resources are "admin-pages.*", most others "admin.*").
|
| Loaded before routes/web.php (bootstrap/app.php) so the public /{slug}
| catch-all can never shadow /admin.
*/

use App\Http\Controllers\Admin\BusinessLeadController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\CourierController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PageMetaController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Auth\LoginOtpController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Staff login/logout (+ password confirm). Registration, password reset and
// email verification are switched off: admin accounts are created directly.
Auth::routes(['register' => false, 'reset' => false, 'verify' => false]);

// Login step 2: the 6-digit code emailed after a correct password (config auth.admin_otp).
Route::middleware('guest')->group(function () {
    Route::get('login/verify', [LoginOtpController::class, 'show'])->name('login.otp');
    Route::post('login/verify', [LoginOtpController::class, 'verify'])->name('login.otp.verify')->middleware('throttle:10,1');
    Route::post('login/verify/resend', [LoginOtpController::class, 'resend'])->name('login.otp.resend')->middleware('throttle:3,1');
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.home');

    // ->names(...) pins the resource route names to their historical values.
    Route::resource('pages', PageController::class)->names('admin-pages');
    Route::resource('faq', FaqController::class)->names('admin-faq');
    Route::resource('review', ReviewController::class)->names('admin-review');
    Route::resource('country', CountryController::class)->names('admin-country');
    Route::resource('couriers', CourierController::class)->names('admin-couriers');

    // Section content of the built-in pages.
    Route::get('page-meta/{id}', [PageMetaController::class, 'edit'])->name('admin.pagemeta');
    Route::post('page-meta-store', [PageMetaController::class, 'update'])->name('admin.pagemeta.store');

    // Orders. whereNumber('id') is required: without it POST /admin/order/{id}
    // also matched /admin/order/settle-courier and settlement never ran.
    Route::get('orders', [OrderController::class, 'index'])->name('admin.order.index');
    Route::get('order/{id}', [OrderController::class, 'show'])->name('admin.view.order')->whereNumber('id');
    Route::post('order/{id}', [OrderController::class, 'update'])->name('admin.order.update')->whereNumber('id');
    Route::post('order/settle-courier', [OrderController::class, 'settle'])->name('admin.settle.courier');
    Route::get('search/custom', [OrderController::class, 'search'])->name('admin.search.orders');
    Route::get('send-confirmation-emails/{id}', [OrderController::class, 'resendEmails'])->name('admin.sendemails');

    Route::get('topup-transactions', [TransactionController::class, 'topups'])->name('admin.view.transactions');
    Route::get('transactions', [TransactionController::class, 'index'])->name('admin.transactions');

    // Customer accounts: create, edit, suspend/ban/disable/reactivate, password help, end sessions.
    // Authorised per action by App\Policies\CustomerPolicy.
    Route::get('customers', [CustomerController::class, 'index'])->name('admin.view.customer');
    Route::get('view-customers/{id}', [CustomerController::class, 'show'])->name('admin.single.customer')->whereNumber('id');
    Route::get('customers/create', [CustomerController::class, 'create'])->name('admin.customer.create');
    Route::post('customers', [CustomerController::class, 'store'])->name('admin.customer.store')->middleware('throttle:20,1');
    Route::post('customers/{id}/password/reset-link', [CustomerController::class, 'sendPasswordReset'])->name('admin.customer.password.link')->whereNumber('id')->middleware('throttle:6,1');
    Route::post('customers/{id}/password/temporary', [CustomerController::class, 'temporaryPassword'])->name('admin.customer.password.temporary')->whereNumber('id')->middleware('throttle:6,1');
    Route::get('customers/{id}/edit', [CustomerController::class, 'edit'])->name('admin.customer.edit')->whereNumber('id');
    Route::patch('customers/{id}', [CustomerController::class, 'update'])->name('admin.customer.update')->whereNumber('id');
    Route::post('customers/{id}/status', [CustomerController::class, 'changeStatus'])->name('admin.customer.status')->whereNumber('id');
    Route::post('customers/{id}/sessions/revoke', [CustomerController::class, 'revokeSessions'])->name('admin.customer.sessions.revoke')->whereNumber('id');

    // Business leads inbox. Opening a lead marks it read.
    Route::get('business-leads', [BusinessLeadController::class, 'index'])->name('admin.businessleads');
    Route::post('business-leads/bulk', [BusinessLeadController::class, 'bulk'])->name('admin.businessleads.bulk');
    Route::get('business-leads/{lead}', [BusinessLeadController::class, 'show'])->name('admin.businessleads.show')->whereNumber('lead');
    Route::post('business-leads/{lead}/archive', [BusinessLeadController::class, 'archive'])->name('admin.businessleads.archive')->whereNumber('lead');
    Route::post('business-leads/{lead}/restore', [BusinessLeadController::class, 'restore'])->name('admin.businessleads.restore')->whereNumber('lead');
    Route::post('business-leads/{lead}/unread', [BusinessLeadController::class, 'markUnread'])->name('admin.businessleads.unread')->whereNumber('lead');
    Route::delete('business-leads/{lead}', [BusinessLeadController::class, 'destroy'])->name('admin.businessleads.destroy')->whereNumber('lead');

    // SEO files.
    Route::get('robots', [SeoController::class, 'editRobots'])->name('admin.robots');
    Route::post('edit-seo-txt-handle', [SeoController::class, 'updateRobots'])->name('admin.save.txtfile');
    Route::get('edit-seo-sitemap', [SeoController::class, 'editSitemap'])->name('admin.sitemap');
    Route::get('generate-sitemap', [SeoController::class, 'generateSitemap'])->name('admin.generate.sitemap');
    Route::post('save-sitemap', [SeoController::class, 'updateSitemap'])->name('admin.save.sitemap');
});
