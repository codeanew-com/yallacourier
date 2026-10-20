<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Runs on every web request. If the logged-in customer has been suspended,
 * banned or disabled since they signed in, their session ends immediately, so
 * no page or endpoint that checks Auth::guard('customers') (dashboard, label
 * downloads, shipment booking, header) can still act as them.
 */
class EnforceCustomerAccountStatus
{
    public function handle(Request $request, Closure $next): Response
    {
        $guard = Auth::guard('customers');

        if ($guard->check()) {
            // Re-read the status so a change made by an admin applies at once,
            // even to a session that loaded the user earlier.
            $customer = $guard->user()->fresh();

            if (! $customer || $customer->isBlocked()) {
                $message = $customer ? $customer->blockedMessage() : 'Your account is no longer available.';
                $guard->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                if ($request->expectsJson()) {
                    return response()->json(['message' => $message], 403);
                }
                $request->session()->flash('msg', $message);

                return redirect()->route('customer.login');
            }

            // A temporary password issued by an admin must be replaced before anything else.
            if ($customer->must_change_password
                && ! $request->routeIs('customer.password.change', 'customer.password.change.update', 'frontend.customer.logout')) {
                if ($request->expectsJson()) {
                    return response()->json(['message' => 'You must change your temporary password first.'], 403);
                }

                return redirect()->route('customer.password.change');
            }
        }

        return $next($request);
    }
}
