<?php

use App\Http\Middleware\AuthenticateCustomer;
use App\Http\Middleware\EnforceCustomerAccountStatus;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // Order matters: routes/web.php ends with the public /{slug?} catch-all.
        web: [
            __DIR__.'/../routes/admin.php',
            __DIR__.'/../routes/customer.php',
            __DIR__.'/../routes/web.php',
        ],
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'customer' => AuthenticateCustomer::class,
        ]);
        // Suspended/banned/disabled customers lose access on their very next request.
        $middleware->web(append: [
            EnforceCustomerAccountStatus::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
