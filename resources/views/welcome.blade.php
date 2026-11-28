<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Al Futuh - Berbagi Kebaikan, Menguatkan Umat</title>

    <!-- Favicon & PWA Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#155E4B">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Al Futuh">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=manrope:500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ mobileMenu: false }" class="font-sans antialiased bg-[#F8FAF8] text-slate-800 pb-24 md:pb-12 min-h-screen">

    <!-- Top Header -->
    <header class="bg-white sticky top-0 z-40 border-b border-slate-100 shadow-xs">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/icon-192.png') }}" alt="Al Futuh" class="w-10 h-10 object-contain rounded-xl">
                <div>
                    <h1 class="font-extrabold text-lg sm:text-xl text-[#155E4B] leading-none tracking-tight">Al Futuh</h1>
                    <p class="text-[9px] font-bold text-slate-400 mt-0.5 uppercase tracking-[0.2em]">Donasi &amp; Zakat</p>
                </div>
            </a>

            <!-- Desktop Navigation Menu -->
            <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600">
                <a href="{{ route('landing') }}" class="text-[#155E4B] hover:text-[#0E4436] transition">Beranda</a>
                <a href="{{ route('programs.index') }}" class="hover:text-[#155E4B] transition">Program</a>
                <a href="{{ route('donations.my-donations') }}" class="hover:text-[#155E4B] transition">Riwayat</a>
                <a href="{{ route('transparansi') }}" class="hover:text-[#155E4B] transition">Transparansi</a>
                <a href="{{ route('kabars.index') }}" class="hover:text-[#155E4B] transition">Kabar</a>
            </nav>

            <!-- Right Actions (Desktop) -->
            <div class="hidden md:flex items-center gap-3">
                @php
                    $quickOperasional = $operasionalProgram ?? (\App\Models\Program::where('slug', 'sedekah-operasional-dakwah-yayasan')
                        ->orWhere('nama', 'like', '%operasional%')
                        ->first() ?? ($featuredPrograms->first() ?? $programs->first()));
                    $donateUrl = $quickOperasional ? route('programs.show', $quickOperasional->slug) : route('programs.index');
                @endphp
                <a href="{{ $donateUrl }}" class="inline-flex items-center gap-1.5 bg-[#155E4B] hover:bg-[#0E4436] text-white text-xs font-bold px-4 py-2 rounded-full shadow-sm active:scale-95 transition">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Donasi Sekarang</span>
                </a>

                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="text-xs font-bold bg-[#EAF5EE] text-[#155E4B] px-3.5 py-2 rounded-full border border-[#D2E6DC] hover:bg-[#DCEEE5] transition">
                            Admin
                        </a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="text-xs font-bold text-slate-700 hover:text-[#155E4B] px-2 py-1 transition">
                            {{ Str::limit(Auth::user()->name, 12) }}
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] px-2 py-1 transition">
                        Masuk
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Menu Button -->
            <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-slate-700 hover:text-[#155E4B] rounded-xl focus:outline-none" aria-label="Menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileMenu" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileMenu" style="display: none;" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Mobile Drawer Navigation Dropdown -->
        <div x-show="mobileMenu" x-cloak @click.away="mobileMenu = false" class="md:hidden bg-white border-b border-slate-100 px-4 py-3 space-y-2 shadow-lg">
            <a href="{{ route('landing') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-[#155E4B] bg-[#F2F7F4]">Beranda</a>
            <a href="{{ route('programs.index') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Program Donasi</a>
            <a href="{{ route('donations.my-donations') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Riwayat Donasi</a>
            <a href="{{ route('transparansi') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Laporan Transparansi</a>
            <a href="{{ route('kabars.index') }}" class="block px-3 py-2 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50">Kabar Terbaru</a>
            <div class="pt-2 border-t border-slate-100 flex items-center justify-between">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="text-xs font-bold bg-[#155E4B] text-white px-4 py-2 rounded-full">Dashboard Admin</a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="text-xs font-bold text-[#155E4B]">Akun: {{ Auth::user()->name }}</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-600">Masuk</a>
                    <a href="{{ route('register') }}" class="text-xs font-bold bg-[#155E4B] text-white px-4 py-1.5 rounded-full">Daftar</a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 py-5 sm:py-6 space-y-6">

        <!-- HERO SECTION -->
        @php
            $featured = $operasionalProgram ?? ($featuredPrograms->first() ?? $programs->first());
            $heroUrl = $featured ? route('programs.show', $featured->slug) : route('programs.index');
            $heroDonateUrl = $heroUrl;
        @endphp

        <!-- DESKTOP HERO (Laptop View) -->
        <div class="hidden md:grid md:grid-cols-12 gap-8 bg-white rounded-3xl p-8 lg:p-10 border border-slate-100 shadow-sm items-center">
            <div class="md:col-span-6 space-y-5">
                <div class="inline-flex items-center gap-2 bg-[#F2F7F4] text-[#155E4B] px-3.5 py-1 rounded-full text-xs font-bold border border-[#D2E6DC]">
                    <span class="w-2 h-2 rounded-full bg-[#155E4B]"></span>
                    Al Futuh Berbagi
                </div>
                <h2 class="text-3xl lg:text-4xl font-extrabold text-[#155E4B] leading-tight tracking-tight">
                    Berbagi Kebaikan,<br>Menguatkan Umat
                </h2>
                <p class="text-sm text-slate-500 leading-relaxed max-w-md">
                    Salurkan donasi terbaik melalui Al Futuh untuk kemaslahatan bersama, dakwah, pendidikan santri, dan perawatan fasilitas ibadah.
                </p>
                <div class="pt-2 flex items-center gap-3">
                    <a href="{{ $heroDonateUrl }}" class="inline-flex items-center gap-2 bg-[#155E4B] hover:bg-[#0E4436] text-white font-bold text-sm px-7 py-3.5 rounded-full shadow-lg shadow-[#155E4B]/20 transition active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Donasi Sekarang</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="{{ $heroUrl }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] px-5 py-3.5 rounded-full hover:bg-slate-50 transition border border-transparent hover:border-slate-200">
                        Detail Program →
                    </a>
                </div>
            </div>
            <div class="md:col-span-6">
                <div class="relative rounded-3xl overflow-hidden shadow-md aspect-video border border-slate-100">
                    @if($featured && $featured->banner)
                        <img src="{{ asset('storage/' . $featured->banner) }}" alt="Al Futuh" class="w-full h-full object-cover">
                    @else
                        <img src="{{ asset('images/mosque-hero.svg') }}" alt="Masjid Al Futuh" class="w-full h-full object-cover">
                    @endif
                </div>
            </div>
        </div>

        <!-- MOBILE HERO (Screen 1 View) -->
        <div class="md:hidden bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
            <div class="relative h-48 sm:h-56 w-full bg-slate-100 overflow-hidden">
                @if($featured && $featured->banner)
                    <img src="{{ asset('storage/' . $featured->banner) }}" alt="{{ $featured->nama }}" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('images/mosque-hero.svg') }}" alt="Masjid Al Futuh" class="w-full h-full object-cover">
                @endif

                <div class="absolute -bottom-1 left-0 right-0 leading-none">
                    <svg viewBox="0 0 500 40" preserveAspectRatio="none" class="w-full h-8 text-white fill-current">
                        <path d="M0,0 C150,38 350,38 500,0 L500,40 L0,40 Z"></path>
                    </svg>
                </div>
            </div>

            <div class="p-5 pt-2 text-center space-y-3">
                <h2 class="text-xl sm:text-2xl font-extrabold text-[#155E4B] leading-tight tracking-tight">
                    Berbagi Kebaikan,<br>Menguatkan Umat
                </h2>
                <p class="text-xs text-slate-500">
                    Salurkan donasi terbaik melalui Al Futuh
                </p>

                <div class="pt-2">
                    <a href="{{ $heroDonateUrl }}" class="inline-flex items-center justify-center gap-2 w-full bg-[#155E4B] hover:bg-[#0E4436] text-white font-bold text-xs sm:text-sm px-6 py-3.5 rounded-full shadow-lg shadow-[#155E4B]/20 active:scale-95 transition">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        <span>Donasi Sekarang</span>
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- 4 CATEGORY CARDS (Masjid, Pendidikan, Sosial, Kemanusiaan) - Small, Bulat & Berjejer 4 -->
        <div class="grid grid-cols-4 gap-2 sm:gap-4 px-1">
            <!-- 1. Masjid -->
            <a href="{{ route('programs.index', ['kategori' => 'Masjid']) }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#F2F7F4] group-hover:bg-[#E8F1EC] border border-[#D2E6DC] flex items-center justify-center text-[#155E4B] group-hover:scale-105 transition shadow-2xs">
                    <x-program-icon category="masjid" class="w-5 h-5 sm:w-6 sm:h-6" />
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#155E4B] leading-tight">Masjid</span>
            </a>

            <!-- 2. Pendidikan -->
            <a href="{{ route('programs.index', ['kategori' => 'Pendidikan']) }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#F2F7F4] group-hover:bg-[#E8F1EC] border border-[#D2E6DC] flex items-center justify-center text-[#155E4B] group-hover:scale-105 transition shadow-2xs">
                    <x-program-icon category="pendidikan" class="w-5 h-5 sm:w-6 sm:h-6" />
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#155E4B] leading-tight">Pendidikan</span>
            </a>

            <!-- 3. Sosial -->
            <a href="{{ route('programs.index', ['kategori' => 'Sosial']) }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#F2F7F4] group-hover:bg-[#E8F1EC] border border-[#D2E6DC] flex items-center justify-center text-[#155E4B] group-hover:scale-105 transition shadow-2xs">
                    <x-program-icon category="sosial" class="w-5 h-5 sm:w-6 sm:h-6" />
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#155E4B] leading-tight">Sosial</span>
            </a>

            <!-- 4. Kemanusiaan -->
            <a href="{{ route('programs.index', ['kategori' => 'Kemanusiaan']) }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#F2F7F4] group-hover:bg-[#E8F1EC] border border-[#D2E6DC] flex items-center justify-center text-[#155E4B] group-hover:scale-105 transition shadow-2xs">
                    <x-program-icon category="kemanusiaan" class="w-5 h-5 sm:w-6 sm:h-6" />
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#155E4B] leading-tight">Kemanusiaan</span>
            </a>
        </div>

        <!-- NOTIFIKASI KHUSUS: SISA DONASI OPERASIONAL UMUM MENIPIS -->
        @if($operasionalProgram && in_array($operasionalProgram->status_sisa, ['critical', 'warning', 'empty']))
            @php
                $opSisa = $operasionalProgram->sisa_donasi;
                $opPct = $operasionalProgram->persentase_sisa;
                $isCritical = ($operasionalProgram->status_sisa === 'critical' || $operasionalProgram->status_sisa === 'empty');
            @endphp
            <div class="rounded-3xl p-4 sm:p-5 {{ $isCritical ? 'bg-gradient-to-r from-rose-50 via-red-50 to-amber-50 border-2 border-rose-300' : 'bg-gradient-to-r from-amber-50 via-yellow-50 to-orange-50 border-2 border-amber-300' }} shadow-sm">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3.5">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 rounded-2xl {{ $isCritical ? 'bg-rose-500 text-white animate-bounce' : 'bg-amber-500 text-white' }} flex items-center justify-center shrink-0 shadow-sm mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div class="space-y-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="text-[10px] font-black uppercase tracking-wider px-2.5 py-0.5 rounded-full {{ $isCritical ? 'bg-rose-600 text-white' : 'bg-amber-700 text-white' }}">
                                    Perhatian Donasi Operasional
                                </span>
                                <span class="text-xs font-black {{ $isCritical ? 'text-rose-700' : 'text-amber-800' }}">
                                    Sisa Dana Tinggal {{ $opPct }}% (Rp {{ number_format($opSisa, 0, ',', '.') }})
                                </span>
                            </div>
                            <h4 class="text-xs sm:text-sm font-extrabold text-slate-800 leading-snug">
                                Dana Operasional &amp; Dakwah Yayasan Sedang Menipis
                            </h4>
                            <p class="text-[11px] sm:text-xs text-slate-600 leading-relaxed max-w-2xl">
                                Donasi operasional umum digunakan langsung untuk membiayai kelangsungan santri TPA, Gerakan Berantas Buta Huruf Al-Qur'an (Gebraq), dan sarana dakwah. Mari salurkan sedekah terbaik Anda agar aktivitas keumatan tetap berjalan lancar.
                            </p>
                        </div>
                    </div>
                    <div class="shrink-0 self-end sm:self-center">
                        <a href="{{ route('programs.show', $operasionalProgram->slug) }}" class="inline-flex items-center justify-center gap-2 {{ $isCritical ? 'bg-rose-600 hover:bg-rose-700' : 'bg-amber-600 hover:bg-amber-700' }} text-white font-black text-xs py-2.5 px-5 rounded-full shadow-md active:scale-95 transition">
                            <span>Top Up Donasi Operasional</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- 1. BAGIAN PROGRAM UNGGULAN (BISA DIGESER KANAN-KIRI) -->
        <div x-data="{
                scrollLeft() { $refs.featuredScroll.scrollBy({ left: -320, behavior: 'smooth' }) },
                scrollRight() { $refs.featuredScroll.scrollBy({ left: 320, behavior: 'smooth' }) }
            }" class="space-y-3.5">
            <div class="flex items-center justify-between px-1">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#155E4B]"></span>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-800 tracking-tight">Program Unggulan</h3>
                    </div>
                    
                </div>
                <div class="flex items-center gap-2">
                    <!-- Tombol Navigasi Geser (Desktop) -->
                    <div class="hidden sm:flex items-center gap-1">
                        <button type="button" @click="scrollLeft()" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#155E4B] hover:border-[#155E4B] flex items-center justify-center transition active:scale-90 shadow-2xs" aria-label="Geser ke kiri">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" @click="scrollRight()" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#155E4B] hover:border-[#155E4B] flex items-center justify-center transition active:scale-90 shadow-2xs" aria-label="Geser ke kanan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                    <!-- Pintasan Halaman Penuh -->
                    <a href="{{ route('programs.index') }}" class="text-xs font-bold text-[#155E4B] hover:text-[#0E4436] inline-flex items-center gap-1 bg-[#EAF5EE] px-3.5 py-1.5 rounded-full border border-[#D2E6DC] transition active:scale-95 shadow-2xs">
                        <span>Lihat Semua</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>

            <!-- Kontainer Geser Kanan-Kiri Program Unggulan -->
            <div x-ref="featuredScroll" class="flex gap-3 sm:gap-3.5 overflow-x-auto pb-2.5 pt-1 scroll-smooth snap-x snap-mandatory scrollbar-none -mx-4 px-4 sm:mx-0 sm:px-0">
                @forelse($featuredPrograms as $item)
                    @php
                        $sisaDana = $item->sisa_donasi;
                        $pctSisa = $item->persentase_sisa;
                        $statusSisa = $item->status_sisa;
                        $isOperasional = $item->is_operasional;
                    @endphp
                    <a href="{{ route('programs.show', $item->slug) }}" class="w-[215px] sm:w-[245px] shrink-0 snap-start bg-white rounded-2xl border {{ ($isOperasional && in_array($statusSisa, ['critical', 'warning', 'empty'])) ? 'border-amber-300 ring-2 ring-amber-100 shadow-sm' : 'border-slate-100 shadow-xs' }} overflow-hidden hover:shadow-md transition flex flex-col justify-between group relative">
                        <div>
                            <div class="h-28 sm:h-32 w-full bg-slate-100 relative overflow-hidden">
                                @if($item->banner)
                                    <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <img src="{{ asset('images/mosque-hero.svg') }}" alt="{{ $item->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @endif
                                <div class="absolute top-2 left-2 flex items-center gap-1 flex-wrap">
                                    <span class="text-[9px] font-bold bg-white/95 backdrop-blur-md text-[#155E4B] px-2 py-0.5 rounded-full shadow-sm">
                                        {{ $item->kategori }}
                                    </span>
                                    <span class="text-[9px] font-extrabold bg-amber-400 text-amber-950 px-2 py-0.5 rounded-full shadow-sm inline-flex items-center gap-0.5">
                                        ⭐ Unggulan
                                    </span>
                                </div>

                                <!-- Badge Highlight Sisa Donasi di Pojok Gambar -->
                                <div class="absolute bottom-2 right-2">
                                    @if($statusSisa === 'critical' || $statusSisa === 'empty')
                                        <span class="inline-flex items-center gap-1 text-[9px] font-black bg-rose-600/95 text-white px-2 py-0.5 rounded-full shadow-md backdrop-blur-xs animate-pulse">
                                            <span class="w-1 h-1 rounded-full bg-white"></span>
                                            Sisa: {{ $pctSisa }}%
                                        </span>
                                    @elseif($statusSisa === 'warning')
                                        <span class="inline-flex items-center gap-1 text-[9px] font-black bg-amber-500/95 text-white px-2 py-0.5 rounded-full shadow-md backdrop-blur-xs">
                                            <span class="w-1 h-1 rounded-full bg-white"></span>
                                            Sisa: {{ $pctSisa }}%
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[9px] font-black bg-emerald-600/95 text-white px-2 py-0.5 rounded-full shadow-md backdrop-blur-xs">
                                            <span class="w-1 h-1 rounded-full bg-white"></span>
                                            Sisa: {{ $pctSisa }}%
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-3 space-y-2">
                                <h4 class="font-extrabold text-xs text-slate-800 line-clamp-2 group-hover:text-[#155E4B] transition leading-snug">
                                    {{ $item->nama }}
                                </h4>

                                <!-- Card Metrik: Total Donasi Terkumpul & Sisa Donasi Saat Ini -->
                                <div class="p-2 rounded-xl bg-[#F8FAF8] border border-slate-100 space-y-1">
                                    <div class="flex justify-between items-center text-[10px]">
                                        <span class="text-slate-400">Terkumpul</span>
                                        <span class="font-extrabold text-[#155E4B]">Rp {{ number_format($item->dana_terkumpul, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-[10px] pt-1 border-t border-slate-100">
                                        <span class="text-slate-500 font-semibold">Sisa Dana</span>
                                        @if($statusSisa === 'critical' || $statusSisa === 'empty')
                                            <span class="font-black text-rose-600">
                                                Rp {{ number_format($sisaDana, 0, ',', '.') }}
                                            </span>
                                        @elseif($statusSisa === 'warning')
                                            <span class="font-black text-amber-700">
                                                Rp {{ number_format($sisaDana, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="font-black text-emerald-700">
                                                Rp {{ number_format($sisaDana, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Progress Bar Sisa Dana Berwarna -->
                                <div class="space-y-1">
                                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        @if($statusSisa === 'critical' || $statusSisa === 'empty')
                                            <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ $pctSisa }}%"></div>
                                        @elseif($statusSisa === 'warning')
                                            <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $pctSisa }}%"></div>
                                        @else
                                            <div class="bg-emerald-600 h-1.5 rounded-full" style="width: {{ $pctSisa }}%"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="w-full p-6 text-center bg-white rounded-2xl border border-slate-100 text-slate-400 text-xs">
                        Belum ada program unggulan aktif.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 2. BAGIAN PROGRAM TERBARU (BISA DIGESER KANAN-KIRI, 3 PENGGALANGAN DANA TERBARU) -->
        <div x-data="{
                scrollLeft() { $refs.latestScroll.scrollBy({ left: -320, behavior: 'smooth' }) },
                scrollRight() { $refs.latestScroll.scrollBy({ left: 320, behavior: 'smooth' }) }
            }" class="space-y-3.5">
            <div class="flex items-center justify-between px-1">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-800 tracking-tight">Program Terbaru</h3>
                    </div>
                    
                </div>
                <div class="flex items-center gap-2">
                    <!-- Tombol Navigasi Geser (Desktop) -->
                    <div class="hidden sm:flex items-center gap-1">
                        <button type="button" @click="scrollLeft()" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#155E4B] hover:border-[#155E4B] flex items-center justify-center transition active:scale-90 shadow-2xs" aria-label="Geser ke kiri">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" @click="scrollRight()" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#155E4B] hover:border-[#155E4B] flex items-center justify-center transition active:scale-90 shadow-2xs" aria-label="Geser ke kanan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                    <!-- Pintasan Halaman Penuh -->
                    <a href="{{ route('programs.index') }}" class="text-xs font-bold text-[#155E4B] hover:text-[#0E4436] inline-flex items-center gap-1 bg-[#EAF5EE] px-3.5 py-1.5 rounded-full border border-[#D2E6DC] transition active:scale-95 shadow-2xs">
                        <span>Lihat Semua</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>

            <!-- Kontainer Geser Kanan-Kiri 3 Program Terbaru -->
            <div x-ref="latestScroll" class="flex gap-3 sm:gap-3.5 overflow-x-auto pb-2.5 pt-1 scroll-smooth snap-x snap-mandatory scrollbar-none -mx-4 px-4 sm:mx-0 sm:px-0">
                @forelse($latestPrograms as $item)
                    @php
                        $sisaDana = $item->sisa_donasi;
                        $pctSisa = $item->persentase_sisa;
                        $statusSisa = $item->status_sisa;
                        $isOperasional = $item->is_operasional;
                    @endphp
                    <a href="{{ route('programs.show', $item->slug) }}" class="w-[215px] sm:w-[245px] shrink-0 snap-start bg-white rounded-2xl border {{ ($isOperasional && in_array($statusSisa, ['critical', 'warning', 'empty'])) ? 'border-amber-300 ring-2 ring-amber-100 shadow-sm' : 'border-slate-100 shadow-xs' }} overflow-hidden hover:shadow-md transition flex flex-col justify-between group relative">
                        <div>
                            <div class="h-28 sm:h-32 w-full bg-slate-100 relative overflow-hidden">
                                @if($item->banner)
                                    <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <img src="{{ asset('images/mosque-hero.svg') }}" alt="{{ $item->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @endif
                                <div class="absolute top-2 left-2 flex items-center gap-1 flex-wrap">
                                    <span class="text-[9px] font-bold bg-white/95 backdrop-blur-md text-[#155E4B] px-2 py-0.5 rounded-full shadow-sm">
                                        {{ $item->kategori }}
                                    </span>
                                    <span class="text-[9px] font-extrabold bg-blue-500 text-white px-2 py-0.5 rounded-full shadow-sm inline-flex items-center gap-0.5">
                                        Baru
                                    </span>
                                </div>

                                <!-- Badge Highlight Sisa Donasi di Pojok Gambar -->
                                <div class="absolute bottom-2 right-2">
                                    @if($statusSisa === 'critical' || $statusSisa === 'empty')
                                        <span class="inline-flex items-center gap-1 text-[9px] font-black bg-rose-600/95 text-white px-2 py-0.5 rounded-full shadow-md backdrop-blur-xs animate-pulse">
                                            <span class="w-1 h-1 rounded-full bg-white"></span>
                                            Sisa: {{ $pctSisa }}%
                                        </span>
                                    @elseif($statusSisa === 'warning')
                                        <span class="inline-flex items-center gap-1 text-[9px] font-black bg-amber-500/95 text-white px-2 py-0.5 rounded-full shadow-md backdrop-blur-xs">
                                            <span class="w-1 h-1 rounded-full bg-white"></span>
                                            Sisa: {{ $pctSisa }}%
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[9px] font-black bg-emerald-600/95 text-white px-2 py-0.5 rounded-full shadow-md backdrop-blur-xs">
                                            <span class="w-1 h-1 rounded-full bg-white"></span>
                                            Sisa: {{ $pctSisa }}%
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="p-3 space-y-2">
                                <h4 class="font-extrabold text-xs text-slate-800 line-clamp-2 group-hover:text-[#155E4B] transition leading-snug">
                                    {{ $item->nama }}
                                </h4>

                                <!-- Card Metrik: Total Donasi Terkumpul & Sisa Donasi Saat Ini -->
                                <div class="p-2 rounded-xl bg-[#F8FAF8] border border-slate-100 space-y-1">
                                    <div class="flex justify-between items-center text-[10px]">
                                        <span class="text-slate-400">Terkumpul</span>
                                        <span class="font-extrabold text-[#155E4B]">Rp {{ number_format($item->dana_terkumpul, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-[10px] pt-1 border-t border-slate-100">
                                        <span class="text-slate-500 font-semibold">Sisa Dana</span>
                                        @if($statusSisa === 'critical' || $statusSisa === 'empty')
                                            <span class="font-black text-rose-600">
                                                Rp {{ number_format($sisaDana, 0, ',', '.') }}
                                            </span>
                                        @elseif($statusSisa === 'warning')
                                            <span class="font-black text-amber-700">
                                                Rp {{ number_format($sisaDana, 0, ',', '.') }}
                                            </span>
                                        @else
                                            <span class="font-black text-emerald-700">
                                                Rp {{ number_format($sisaDana, 0, ',', '.') }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <!-- Progress Bar Sisa Dana Berwarna -->
                                <div class="space-y-1">
                                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        @if($statusSisa === 'critical' || $statusSisa === 'empty')
                                            <div class="bg-rose-500 h-1.5 rounded-full" style="width: {{ $pctSisa }}%"></div>
                                        @elseif($statusSisa === 'warning')
                                            <div class="bg-amber-500 h-1.5 rounded-full" style="width: {{ $pctSisa }}%"></div>
                                        @else
                                            <div class="bg-emerald-600 h-1.5 rounded-full" style="width: {{ $pctSisa }}%"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="w-full p-6 text-center bg-white rounded-2xl border border-slate-100 text-slate-400 text-xs">
                        Belum ada program terbaru.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- 3. BAGIAN BERITA & KABAR TERBARU (GESER KE SAMPING, UKURAN SEPERTI CARD DONASI) -->
        <div x-data="{
                scrollLeft() { $refs.kabarScroll.scrollBy({ left: -260, behavior: 'smooth' }) },
                scrollRight() { $refs.kabarScroll.scrollBy({ left: 260, behavior: 'smooth' }) }
            }" class="space-y-3.5">
            <div class="flex items-center justify-between px-1">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-800 tracking-tight">Kabar &amp; Berita Terbaru</h3>
                    </div>
                    
                </div>
                <div class="flex items-center gap-2">
                    <!-- Tombol Navigasi Geser (Desktop) -->
                    <div class="hidden sm:flex items-center gap-1">
                        <button type="button" @click="scrollLeft()" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#155E4B] hover:border-[#155E4B] flex items-center justify-center transition active:scale-90 shadow-2xs" aria-label="Geser ke kiri">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                        <button type="button" @click="scrollRight()" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#155E4B] hover:border-[#155E4B] flex items-center justify-center transition active:scale-90 shadow-2xs" aria-label="Geser ke kanan">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>
                    <!-- Pintasan Halaman Penuh Berita -->
                    <a href="{{ route('kabars.index') }}" class="text-xs font-bold text-[#155E4B] hover:text-[#0E4436] inline-flex items-center gap-1 bg-[#EAF5EE] px-3.5 py-1.5 rounded-full border border-[#D2E6DC] transition active:scale-95 shadow-2xs">
                        <span>Lihat Semua</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>

            <!-- Kontainer Geser Kanan-Kiri Berita Terbaru -->
            <div x-ref="kabarScroll" class="flex gap-3 sm:gap-3.5 overflow-x-auto pb-2.5 pt-1 scroll-smooth snap-x snap-mandatory scrollbar-none -mx-4 px-4 sm:mx-0 sm:px-0">
                @forelse($kabars->take(4) as $kabar)
                    <a href="{{ route('kabars.show', $kabar->slug) }}" class="w-[215px] sm:w-[245px] shrink-0 snap-start bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-xs hover:shadow-md transition flex flex-col justify-between group">
                        <div>
                            <div class="h-28 sm:h-32 w-full bg-slate-100 relative overflow-hidden">
                                @if($kabar->foto)
                                    <img src="{{ asset('storage/' . $kabar->foto) }}" alt="{{ $kabar->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <img src="{{ asset('images/mosque-hero.svg') }}" alt="{{ $kabar->judul }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @endif
                                @if($kabar->program)
                                    <div class="absolute top-2 left-2 right-2">
                                        <span class="inline-block max-w-full truncate text-[9px] font-bold bg-white/95 backdrop-blur-md text-[#155E4B] px-2 py-0.5 rounded-full shadow-sm">
                                            {{ $kabar->program->nama }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <div class="p-3 space-y-1.5">
                                <span class="text-[9px] font-bold text-slate-400 block">
                                    📅 {{ $kabar->tanggal ? $kabar->tanggal->format('d M Y') : '-' }}
                                </span>
                                <h4 class="font-extrabold text-xs text-slate-800 leading-snug line-clamp-2 group-hover:text-[#155E4B] transition">
                                    {{ $kabar->judul }}
                                </h4>
                                <p class="text-[10px] text-slate-500 line-clamp-2 leading-relaxed">
                                    {{ $kabar->ringkasan ?: Str::limit(strip_tags($kabar->konten), 70) }}
                                </p>
                            </div>
                        </div>

                        <div class="p-3 pt-0">
                            <span class="text-[10px] font-extrabold text-[#155E4B] inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">
                                <span>Baca Selengkapnya</span>
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </span>
                        </div>
                    </a>
                @empty
                    <div class="w-full p-6 text-center bg-white rounded-2xl border border-slate-100 text-slate-400 text-xs">
                        Belum ada berita atau kabar terbaru yang diterbitkan.
                    </div>
                @endforelse
            </div>
        </div>

        <!-- DOA & DUKUNGAN DONATUR (KECIL & BISA DIGESER KE SAMPING) -->
        @if($recentDonations->isNotEmpty())
            <div x-data="{
                    scrollLeft() { $refs.doaScroll.scrollBy({ left: -280, behavior: 'smooth' }) },
                    scrollRight() { $refs.doaScroll.scrollBy({ left: 280, behavior: 'smooth' }) }
                }" class="space-y-3">
                <div class="flex items-center justify-between px-1">
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <h3 class="text-sm sm:text-base font-extrabold text-slate-800 tracking-tight">Doa &amp; Dukungan Donatur</h3>
                        </div>
                        <p class="text-[11px] text-slate-400">Untaian doa baik dari para muhsinin</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <!-- Tombol Navigasi Geser (Desktop) -->
                        <div class="hidden sm:flex items-center gap-1">
                            <button type="button" @click="scrollLeft()" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#155E4B] hover:border-[#155E4B] flex items-center justify-center transition active:scale-90 shadow-2xs" aria-label="Geser ke kiri">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button type="button" @click="scrollRight()" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-[#155E4B] hover:border-[#155E4B] flex items-center justify-center transition active:scale-90 shadow-2xs" aria-label="Geser ke kanan">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                        <a href="{{ route('donations.doa') }}" class="text-xs font-bold text-[#155E4B] hover:text-[#0E4436] inline-flex items-center gap-1 bg-[#EAF5EE] px-3.5 py-1.5 rounded-full border border-[#D2E6DC] transition active:scale-95 shadow-2xs">
                            <span>Lihat Semua</span>
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </a>
                    </div>
                </div>

                <div x-ref="doaScroll" class="flex gap-3 overflow-x-auto pb-2.5 pt-1 scroll-smooth snap-x snap-mandatory scrollbar-none -mx-4 px-4 sm:mx-0 sm:px-0">
                    @foreach($recentDonations as $d)
                        <div class="w-[225px] sm:w-[260px] shrink-0 snap-start p-3 bg-white rounded-2xl border border-slate-100 shadow-xs flex flex-col justify-between space-y-2">
                            <div class="space-y-1.5">
                                <div class="flex items-center justify-between gap-2 text-[10px]">
                                    <span class="font-extrabold text-slate-800 truncate">{{ $d->displayName }}</span>
                                    <span class="text-[9px] text-slate-400 shrink-0">{{ $d->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-[11px] text-slate-600 italic line-clamp-3 leading-relaxed">"{{ $d->doa }}"</p>
                            </div>
                            <p class="text-[9px] font-bold text-[#155E4B] truncate pt-1 border-t border-slate-50">
                                {{ $d->program->nama }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

    </main>

    <!-- Footer -->
    <footer class="max-w-5xl mx-auto px-4 sm:px-6 mt-10 text-center text-xs text-slate-400 space-y-2 border-t border-slate-100 pt-8 pb-4">
        <p class="font-bold text-slate-700 text-sm">Al Futuh</p>
        <p class="text-xs text-slate-500 font-semibold">Sub Yayasan dari Yayasan Tebar Dakwah Al Islamy</p>
        <p class="text-[11px] max-w-lg mx-auto text-slate-400">Klepu, Rejosari, Semin, Gunungkidul, Daerah Istimewa Yogyakarta • Izin Kemenkumham Nomor : AHU 0006697.AH.01.04</p>
        <p class="text-[11px] max-w-md mx-auto text-slate-400">Salurkan donasi terbaik untuk kemaslahatan bersama melalui platform digital terpercaya.</p>
        <p class="text-[10px] text-slate-400 pt-1">© {{ date('Y') }} Al Futuh Peduli. All rights reserved.</p>
    </footer>

    <!-- PWA MOBILE BOTTOM NAVIGATION BAR WITH BIG CENTER ACTION BUTTON -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-50 px-2 py-1.5 pb-[max(.5rem,env(safe-area-inset-bottom))] shadow-[0_-4px_20px_rgba(15,23,42,.08)]">
        <div class="flex justify-between items-end relative">
            <!-- 1. Beranda -->
            <a href="{{ route('landing') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-[#155E4B] font-extrabold">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 11.5 12 4l9 7.5M5 10v10h14V10M9 20v-6h6v6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Beranda</span>
            </a>

            <!-- 2. Program -->
            <a href="{{ route('programs.index') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#155E4B]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                </svg>
                <span>Program</span>
            </a>

            <!-- 3. TOMBOL BESAR DI TENGAH (AKSI CEPAT DONASI OPERASIONAL UMUM) -->
            @php
                $quickOperasional = $operasionalProgram ?? (\App\Models\Program::where('slug', 'sedekah-operasional-dakwah-yayasan')
                    ->orWhere('nama', 'like', '%operasional%')
                    ->first() ?? \App\Models\Program::where('is_active', true)->first());
                $quickDonateUrl = $quickOperasional ? route('programs.show', $quickOperasional->slug) : route('programs.index');
            @endphp
            <div class="flex-1 flex justify-center -mt-6">
                <a href="{{ $quickDonateUrl }}" class="group relative flex flex-col items-center focus:outline-none" aria-label="Aksi Cepat Donasi Operasional Umum">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#1c775e] to-[#155E4B] text-white flex flex-col items-center justify-center shadow-lg shadow-[#155E4B]/40 border-[3.5px] border-white group-active:scale-95 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <span class="text-[9px] font-black text-[#155E4B] tracking-tight mt-0.5">Donasi</span>
                </a>
            </div>

            <!-- 4. Riwayat -->
            <a href="{{ route('donations.my-donations') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#155E4B]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                    <path d="M12 7v5l3 3" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Riwayat</span>
            </a>

            <!-- 5. Akun -->
            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('dashboard') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#155E4B]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="3" stroke-width="1.8"/>
                            <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06A1.7 1.7 0 0 0 16.44 18a1.7 1.7 0 0 0-1 .6V19H13v-.4a1.7 1.7 0 0 0-1-.6 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9 15.44a1.7 1.7 0 0 0-.6-1H8v-2.44h.4A1.7 1.7 0 0 0 9 10.56a1.7 1.7 0 0 0-.34-1.88l-.06-.06L10.02 7.2l.06.06A1.7 1.7 0 0 0 12 7a1.7 1.7 0 0 0 1-.6V6h2.44v.4A1.7 1.7 0 0 0 16.44 7a1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06A1.7 1.7 0 0 0 19.4 10a1.7 1.7 0 0 0 .6 1h.4v2.44H20a1.7 1.7 0 0 0-.6 1Z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Admin</span>
                    </a>
                @else
                    <a href="{{ route('profile.edit') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#155E4B]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="8" r="4" stroke-width="1.8"/>
                            <path d="M4 20c1.5-4 4-6 8-6s6.5 2 8 6" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        <span>Akun</span>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#155E4B]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="8" r="4" stroke-width="1.8"/>
                        <path d="M4 20c1.5-4 4-6 8-6s6.5 2 8 6" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span>Akun</span>
                </a>
            @endauth
        </div>
    </div>

    <!-- FLOATING ACTION BUTTONS (PWA Install & WhatsApp) -->
    <x-pwa-install-floating />
    <x-whatsapp-floating />

    <!-- POP-UP PROMOSI DONASI OPERASIONAL UMUM -->
    <x-popup-operasional :program="$operasionalProgram ?? null" />

    <!-- Service Worker Registration & CSRF Auto-Refresh -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }

        // Auto-refresh token CSRF saat tab kembali aktif setelah ditinggal lama (proactive keep-alive)
        let lastWelcomeActive = Date.now();
        document.addEventListener('visibilitychange', function() {
            if (document.visibilityState === 'visible') {
                const elapsedMinutes = (Date.now() - lastWelcomeActive) / 60000;
                if (elapsedMinutes >= 15) {
                    fetch('{{ route('refresh-csrf') }}', {
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    })
                    .then(r => r.json())
                    .then(d => {
                        if (d.csrf_token) {
                            const meta = document.querySelector('meta[name="csrf-token"]');
                            if (meta) meta.setAttribute('content', d.csrf_token);
                            document.querySelectorAll('input[name="_token"]').forEach(el => {
                                el.value = d.csrf_token;
                            });
                        }
                    })
                    .catch(() => {});
                }
                lastWelcomeActive = Date.now();
            }
        });
    </script>
</body>
</html>
