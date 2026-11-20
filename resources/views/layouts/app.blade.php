<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Al Futuh Peduli') }} - Platform Donasi & Zakat</title>

        <!-- PWA Meta Tags -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#0D9488">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="Al Futuh">
        <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-800 pb-20 md:pb-8 min-h-screen">
        <div class="min-h-screen">
            @include('layouts.navigation')

            <!-- Header -->
            @if (isset($header))
                <header class="bg-white border-b border-slate-100 shadow-sm">
                    <div class="max-w-5xl mx-auto py-4 px-4 sm:px-6">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Notifikasi Pesan Sukses / Error / Info -->
            <div class="max-w-5xl mx-auto px-4 sm:px-6 pt-4">
                @if (session('success'))
                    <div class="bg-teal-50 border border-teal-200 text-teal-800 px-4 py-3 rounded-2xl flex items-center justify-between shadow-sm mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xl">✅</span>
                            <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl flex items-center justify-between shadow-sm mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xl">⚠️</span>
                            <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if (session('info'))
                    <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-2xl flex items-center justify-between shadow-sm mb-4">
                        <div class="flex items-center gap-2.5">
                            <span class="text-xl">ℹ️</span>
                            <span class="text-xs sm:text-sm font-semibold">{{ session('info') }}</span>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- PWA Service Worker Registration -->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js')
                        .then((reg) => console.log('Al Futuh PWA Service Worker Ready!', reg.scope))
                        .catch((err) => console.log('SW Registration Failed:', err));
                });
            }
        </script>
    </body>
</html>
