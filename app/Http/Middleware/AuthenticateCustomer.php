<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * The `customer` route middleware: customer portal pages require a login on
 * the `customers` guard (admins use the default `web` guard and `auth`).
 */
class AuthenticateCustomer
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::guard('customers')->check()) {
            return redirect(route('customer.login'));
        }

        return $next($request);
    }
}
