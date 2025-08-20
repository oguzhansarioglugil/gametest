<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        // Add CSRF exceptions for API routes
        $middleware->validateCsrfTokens(except: [
            'api/*',
            '/api/analyze-system',
            '/api/test-single-game'
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
