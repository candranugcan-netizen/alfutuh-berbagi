<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Masuk - Al Futuh Peduli</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0D9488">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm space-y-6">

        <!-- Header & Logo -->
        <div class="text-center space-y-2">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2 font-black text-2xl text-teal-700 tracking-tight">
                <span class="w-10 h-10 rounded-2xl bg-teal-600 text-white flex items-center justify-center text-xl shadow-md shadow-teal-600/20">🕌</span>
                <span>Al Futuh<span class="text-amber-500">.</span></span>
            </a>
            <h2 class="text-base font-extrabold text-slate-800">Masuk Akun</h2>
            <p class="text-xs text-slate-500">Masuk untuk melihat riwayat donasi atau kelola yayasan</p>
        </div>

        <!-- Kartu Form Login -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xl shadow-teal-900/5 space-y-4">

            <!-- Notifikasi Status Sesi -->
            <x-auth-session-status class="mb-3 text-xs text-teal-700 bg-teal-50 p-2.5 rounded-xl border border-teal-100" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        placeholder="admin@alfutuh.com atau email donatur"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5 text-xs text-red-500" />
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        placeholder="••••••••"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5 text-xs text-red-500" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center gap-2">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span class="text-xs font-semibold text-slate-600">Ingat Saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700">Lupa sandi?</a>
                    @endif
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-black text-xs py-3 rounded-2xl shadow-md shadow-teal-600/20 active:scale-95 transition">
                    Masuk Sekarang
                </button>
            </form>

            <div class="text-center pt-2 border-t border-slate-50 text-xs text-slate-500">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="font-bold text-teal-600 hover:text-teal-700">Daftar Akun Donatur</a>
            </div>
        </div>

        <div class="text-center">
            <a href="{{ route('landing') }}" class="text-xs font-bold text-slate-400 hover:text-slate-600">
                ← Kembali ke Halaman Donasi
            </a>
        </div>
    </div>
</body>
</html>
