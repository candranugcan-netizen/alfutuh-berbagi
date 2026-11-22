<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Daftar Donatur - Al Futuh Peduli</title>

    <!-- Favicon & PWA Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#155E4B">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=manrope:500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-[#F8FAF8] text-slate-800 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-sm space-y-6">

        <!-- Header & Logo -->
        <div class="text-center space-y-2">
            <a href="{{ route('landing') }}" class="inline-flex items-center gap-2.5">
                <img src="{{ asset('images/icon-192.png') }}" alt="Al Futuh" class="w-12 h-12 object-contain rounded-2xl shadow-xs">
                <div class="text-left">
                    <span class="font-extrabold text-xl text-[#155E4B] tracking-tight block leading-tight">Al Futuh</span>
                    <span class="text-[9px] font-bold text-slate-400 block tracking-[0.2em] uppercase">Donasi &amp; Zakat</span>
                </div>
            </a>
            <h2 class="text-base font-extrabold text-slate-800 pt-2">Daftar Akun Donatur</h2>
            <p class="text-xs text-slate-500">Simpan riwayat donasi &amp; dapatkan laporan kegiatan yayasan</p>
        </div>

        <!-- Kartu Form Register -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-xl shadow-slate-900/5 space-y-4">
            <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
                @csrf

                <!-- Name -->
                <div>
                    <label for="name" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                        placeholder="Contoh: Fulan atau Fulanah"
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    <x-input-error :messages="$errors->get('name')" class="mt-1 text-xs text-rose-500" />
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                        placeholder="nama@email.com"
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-500" />
                </div>

                <!-- Password -->
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Password</label>
                    <div class="relative">
                        <input id="password" :type="showPassword ? 'text' : 'password'" name="password" required autocomplete="new-password"
                            placeholder="Minimal 8 karakter"
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3 pr-10">
                        <button type="button" @click="showPassword = !showPassword" class="absolute right-3.5 top-3 text-slate-400 hover:text-slate-600 focus:outline-none" title="Lihat/Sembunyikan Password">
                            <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="3" stroke-width="1.8"/>
                            </svg>
                            <svg x-show="showPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-500" />
                </div>

                <!-- Confirm Password -->
                <div x-data="{ showConfirmPassword: false }">
                    <label for="password_confirmation" class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Konfirmasi Password</label>
                    <div class="relative">
                        <input id="password_confirmation" :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi password"
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3 pr-10">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute right-3.5 top-3 text-slate-400 hover:text-slate-600 focus:outline-none" title="Lihat/Sembunyikan Password">
                            <svg x-show="!showConfirmPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                                <circle cx="12" cy="12" r="3" stroke-width="1.8"/>
                            </svg>
                            <svg x-show="showConfirmPassword" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-rose-500" />
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-3.5 rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition">
                    Daftar Sekarang
                </button>
            </form>

            <div class="text-center pt-2 border-t border-slate-50 text-xs text-slate-500">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="font-bold text-[#155E4B] hover:text-[#0E4436]">Masuk di Sini</a>
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
