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
        // Middleware alias
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
            'user' => \App\Http\Middleware\EnsureUserIsUser::class,
            'track.visitors' => \App\Http\Middleware\TrackVisitors::class,
        ]);

        // Jika ingin menjalankan middleware ini secara global (untuk semua request)
        // $middleware->append(\App\Http\Middleware\TrackVisitors::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
