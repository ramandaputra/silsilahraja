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
        
        // ALIAS MIDDLEWARE UNTUK ROLE: superadmin & admin
        $middleware->alias([
            'cek_superadmin' => function ($request, $next) {
                if (!auth()->check() || auth()->user()->role !== 'superadmin') {
                    abort(403, 'Hanya Superadmin yang diizinkan mengakses halaman ini.');
                }
                return $next($request);
            },
            'cek_admin' => function ($request, $next) {
                if (!auth()->check() || !in_array(auth()->user()->role, ['superadmin', 'admin'])) {
                    abort(403, 'Akses ditolak. Halaman ini hanya untuk Administrator.');
                }
                return $next($request);
            },
            // Fallback alias jika masih ada route/pemanggilan cek_operator
            'cek_operator' => function ($request, $next) {
                if (!auth()->check() || !in_array(auth()->user()->role, ['superadmin', 'admin'])) {
                    abort(403, 'Akses ditolak. Halaman ini hanya untuk Administrator.');
                }
                return $next($request);
            }
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();