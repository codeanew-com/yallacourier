<?php

namespace App\Providers;

use App\Models\CustomerModel;
use App\Policies\CustomerPolicy;
use App\View\Composers\AdminSidebarComposer;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        date_default_timezone_set('Asia/Dubai');

        // The admin theme is Bootstrap 5; the default Tailwind pagination markup
        // rendered unstyled there (and only the front-end-free admin uses links()).
        Paginator::useBootstrapFive();

        // CustomerModel doesn't follow the Model → ModelPolicy naming, so register it explicitly.
        Gate::policy(CustomerModel::class, CustomerPolicy::class);

        // Customer password policy (reset, first-time setup and change).
        Password::defaults(fn () => Password::min(8)->letters()->numbers());

        View::composer('admin.layouts.master', AdminSidebarComposer::class);
    }
}
