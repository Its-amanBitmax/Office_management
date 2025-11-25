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

        // Custom middleware aliases
        $middleware->alias([
            'admin'     => \App\Http\Middleware\AdminMiddleware::class,
            'employee'  => \App\Http\Middleware\EmployeeMiddleware::class,
        ]);

        // 🔥 Add CSRF excluded patterns (Laravel 10 compatible)
        $middleware->appendToGroup('web', \App\Http\Middleware\VerifyCsrfToken::class);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
