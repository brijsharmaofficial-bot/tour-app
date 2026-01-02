<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
             // Add this line to enable Sanctum's frontend middleware
             $middleware->alias([
                'EnsureFrontendRequestsAreStateful' => EnsureFrontendRequestsAreStateful::class,
                'role' => \App\Http\Middleware\RoleMiddleware::class,
            ]);
    
            // Add it to the global middleware stack
            $middleware->append(EnsureFrontendRequestsAreStateful::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
