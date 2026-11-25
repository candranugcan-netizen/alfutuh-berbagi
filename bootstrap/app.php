<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\EnsureUserIsAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // 1. Penanganan Sesi Habis / Token CSRF Mismatch (HTTP 419)
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Sesi formulir telah berakhir. Halaman akan disegarkan.',
                    'status' => 419,
                ], 419);
            }

            // Jika submit dari/di halaman login, arahkan ulang ke form login dengan membawa email dan flash message
            if ($request->is('login') || str_contains(url()->previous() ?? '', '/login')) {
                return redirect()->route('login')
                    ->withInput($request->only('email', 'remember'))
                    ->with('status', 'Sesi formulir diperbarui otomatis. Silakan masukkan kata sandi Anda kembali.');
            }

            // Kembalikan ke halaman sebelumnya dan pertahankan input form (agar donatur tidak kehilangan data isian)
            $previousUrl = url()->previous();
            if ($previousUrl && !str_contains($previousUrl, '/logout')) {
                return redirect()->to($previousUrl)
                    ->withInput($request->except(['_token', 'password', 'password_confirmation']))
                    ->with('info', 'Sesi pengiriman telah diperbarui otomatis demi keamanan. Data formulir Anda tersimpan, silakan kirim ulang formulir Anda.');
            }

            return redirect()->route('landing')
                ->with('info', 'Sesi halaman telah diperbarui demi keamanan.');
        });

        // 2. Penanganan Sesi Login Habis (HTTP 401 / AuthenticationException)
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->guest(route('login'))
                ->with('info', 'Sesi masuk Anda telah berakhir karena tidak ada aktivitas. Silakan masuk kembali untuk melanjutkan.');
        });
    })->create();
