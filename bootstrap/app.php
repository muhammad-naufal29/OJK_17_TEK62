<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Vercel menyediakan HTTPS di depan aplikasi lewat proxy.
        // Percayai semua proxy agar Laravel mengenali header X-Forwarded-Proto
        // sehingga seluruh URL & redirect yang dihasilkan tetap https://
        // (tanpa ini browser menandai form login & form lain "not secure").
        $middleware->trustProxies(at: '*');

        // Rute API tidak memiliki halaman login, jadi untuk request ke /api/*
        // kembalikan null agar ditangani sebagai respons 401 JSON
        // (bukan dialihkan ke route('login') yang tidak tersedia).
        $middleware->redirectGuestsTo(
            fn (Request $request) => $request->is('api/*') ? null : route('login'),
        );
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
