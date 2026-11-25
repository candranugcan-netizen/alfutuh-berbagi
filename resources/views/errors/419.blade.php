<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Sesi Telah Berakhir - Al Futuh</title>

    <!-- Favicon & PWA Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <meta name="theme-color" content="#155E4B">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F8FAF8] text-slate-800 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full text-center space-y-6">
        
        <!-- Logo Al Futuh -->
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 mx-auto">
            <img src="{{ asset('images/icon-192.png') }}" alt="Al Futuh" class="w-12 h-12 object-contain rounded-2xl shadow-sm">
            <div class="text-left">
                <span class="font-extrabold text-xl text-[#155E4B] tracking-tight block leading-tight">Al Futuh</span>
                <span class="text-[10px] font-bold text-slate-400 block tracking-[0.2em] uppercase">Donasi &amp; Zakat</span>
            </div>
        </a>

        <!-- Main Card -->
        <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-100 shadow-sm space-y-5">
            <!-- Icon Sesi Habis -->
            <div class="w-20 h-20 rounded-3xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center mx-auto shadow-inner relative">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                    <path d="M12 7v5l3 3" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span class="absolute -bottom-1 -right-1 flex h-6 w-6">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-60"></span>
                    <span class="relative inline-flex rounded-full h-6 w-6 bg-amber-500 text-[10px] font-black text-white items-center justify-center border-2 border-white">!</span>
                </span>
            </div>

            <!-- Pesan Informasi Ramah -->
            <div class="space-y-2">
                <span class="inline-block px-3 py-1 bg-amber-50 text-amber-800 text-[10px] font-extrabold uppercase tracking-wider rounded-full border border-amber-200">
                    Keamanan Sesi Halaman
                </span>
                <h1 class="font-black text-xl sm:text-2xl text-slate-800 leading-snug">
                    Sesi Halaman Telah Berakhir
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 leading-relaxed max-w-sm mx-auto">
                    Demi melindungi keamanan data dan transaksi Anda, sistem menutup sesi formulir karena tidak ada aktivitas dalam waktu yang cukup lama.
                </p>
                <div class="p-3 bg-[#F2F7F4] rounded-2xl border border-[#D2E6DC] text-[11px] text-[#155E4B] font-semibold text-center mt-3">
                    💡 Jangan khawatir, Anda hanya perlu memuat ulang halaman untuk memperbarui sesi baru.
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="space-y-2.5 pt-2">
                <button type="button" id="btn-reload" onclick="hardReload();"
                    class="w-full flex items-center justify-center gap-2 bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs sm:text-sm py-3.5 px-6 rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span id="btn-text">Muat Ulang Halaman Sekarang</span>
                </button>

                <div class="flex items-center gap-2">
                    <a href="{{ route('login') }}"
                        class="flex-1 text-center bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold text-xs py-2.5 rounded-full border border-slate-200 transition active:scale-95">
                        🔑 Masuk Kembali
                    </a>
                    <a href="{{ url('/') }}"
                        class="flex-1 text-center bg-[#EAF5EE] hover:bg-[#DCEEE5] text-[#155E4B] font-bold text-xs py-2.5 rounded-full border border-[#D2E6DC] transition active:scale-95">
                        Ke Beranda
                    </a>
                </div>
            </div>

            <!-- Countdown Timer Otomatis -->
            <p class="text-[11px] text-slate-400 pt-1">
                Memuat ulang otomatis dalam <strong id="countdown-sec" class="text-slate-600 font-bold">5</strong> detik...
            </p>
        </div>

        <p class="text-[11px] text-slate-400">
            © {{ date('Y') }} Al Futuh Peduli • Amanah, Transparan, &amp; Terpercaya
        </p>
    </div>

    <!-- Script Hard-Reload yang Kebal Cache Mobile -->
    <script>
        function hardReload() {
            const btn = document.getElementById('btn-text');
            if (btn) btn.textContent = 'Memuat Sesi Baru...';

            // Bersihkan URL dari parameter lama jika ada, lalu tambahkan cache buster timestamp
            const url = new URL(window.location.href);
            url.searchParams.set('_t', Date.now());

            // Jika sebelumnya dari submit POST login atau form POST, arahkan langsung dengan GET
            window.location.replace(url.toString());
        }

        let seconds = 5;
        const countdownEl = document.getElementById('countdown-sec');
        const interval = setInterval(() => {
            seconds--;
            if (countdownEl) countdownEl.textContent = seconds;
            if (seconds <= 0) {
                clearInterval(interval);
                hardReload();
            }
        }, 1000);
    </script>
</body>
</html>
