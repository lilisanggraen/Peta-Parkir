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
        // 1. Agar HTTPS di Railway terdeteksi dengan benar (Anti-mantul)
        $middleware->trustProxies(at: '*');

        // 2. Mengatur arah redirect otomatis
        $middleware->redirectTo(
            guests: '/admin/login-alias', // Jika belum login dan coba akses area admin
            users: '/admin/dashboard'      // Jika sudah login dan coba akses halaman login
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
