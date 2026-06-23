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
        
        // PASTIKAN BLOK ALIAS INI ADA DAN SUDAH TERSIMPAN:
        $middleware->alias([
            'cek_admin' => function ($request, $next) {
                if (!auth()->check() || auth()->user()->role !== 'admin') {
                    abort(403, 'Hanya Administrator Utama yang diizinkan mengakses halaman ini.');
                }
                return $next($request);
            },
            'cek_operator' => function ($request, $next) {
                if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'operator'])) {
                    abort(403, 'Akses ditolak. Halaman ini hanya untuk pengelola silsilah.');
                }
                return $next($request);
            }
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();