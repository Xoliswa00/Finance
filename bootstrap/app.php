<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Custom route middleware aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\CheckAdminRole::class,
        ]);

        // Append custom middleware to every web request
        $middleware->web(append: [
            \App\Http\Middleware\LogPageVisit::class,
            \App\Http\Middleware\LastSeen::class,
            \App\Http\Middleware\CheckSuspended::class,
            \App\Http\Middleware\ShareAnnouncement::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
