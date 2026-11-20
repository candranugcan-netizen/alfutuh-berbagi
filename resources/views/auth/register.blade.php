<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Daftar Donatur - Al Futuh Peduli</title>

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
            <h2 class="text-base font-extrabold text-slate-800">Daftar Akun Donatur</h2>
            <p class="text-xs text-slate-500">Simpan riwayat donasi & dapatkan laporan berkala</p>
        </div>

        <!-- Kartu Form Register -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xl shadow-teal-900/5 space-y-4">
            <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        placeholder="Contoh: Muhammad Ihsan"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-red-500" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        placeholder="nama@email.com"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        placeholder="Minimal 8 karakter"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="Ulangi password"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-500" />
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-black text-xs py-3 rounded-2xl shadow-md shadow-teal-600/20 active:scale-95 transition">
                    Daftar Sekarang
                </button>
            </form>

            <div class="text-center pt-2 border-t border-slate-50 text-xs text-slate-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-teal-600 hover:text-teal-700">Masuk di Sini</a>
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
