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
                    $firstProg = $featuredPrograms->first() ?? $programs->first();
                    $donateUrl = $firstProg ? route('programs.show', $firstProg->slug) : route('programs.index');
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
            $featured = $featuredPrograms->first() ?? $programs->first();
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

        <!-- 4 CATEGORY CARDS (Masjid, Pendidikan, Sosial, Kemanusiaan) -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
            <!-- 1. Masjid -->
            <a href="{{ route('programs.index', ['kategori' => 'Masjid']) }}" class="group bg-[#F2F7F4] hover:bg-[#E8F1EC] p-4 sm:p-5 rounded-2xl border border-[#E2ECE6] text-center flex flex-col items-center justify-center transition active:scale-95">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-[#155E4B] group-hover:scale-110 transition mb-1.5">
                    <x-program-icon category="masjid" class="w-7 h-7" />
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-[#155E4B]">Masjid</span>
            </a>

            <!-- 2. Pendidikan -->
            <a href="{{ route('programs.index', ['kategori' => 'Pendidikan']) }}" class="group bg-[#F2F7F4] hover:bg-[#E8F1EC] p-4 sm:p-5 rounded-2xl border border-[#E2ECE6] text-center flex flex-col items-center justify-center transition active:scale-95">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-[#155E4B] group-hover:scale-110 transition mb-1.5">
                    <x-program-icon category="pendidikan" class="w-7 h-7" />
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-[#155E4B]">Pendidikan</span>
            </a>

            <!-- 3. Sosial -->
            <a href="{{ route('programs.index', ['kategori' => 'Sosial']) }}" class="group bg-[#F2F7F4] hover:bg-[#E8F1EC] p-4 sm:p-5 rounded-2xl border border-[#E2ECE6] text-center flex flex-col items-center justify-center transition active:scale-95">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-[#155E4B] group-hover:scale-110 transition mb-1.5">
                    <x-program-icon category="sosial" class="w-7 h-7" />
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-[#155E4B]">Sosial</span>
            </a>

            <!-- 4. Kemanusiaan -->
            <a href="{{ route('programs.index', ['kategori' => 'Kemanusiaan']) }}" class="group bg-[#F2F7F4] hover:bg-[#E8F1EC] p-4 sm:p-5 rounded-2xl border border-[#E2ECE6] text-center flex flex-col items-center justify-center transition active:scale-95">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-[#155E4B] group-hover:scale-110 transition mb-1.5">
                    <x-program-icon category="kemanusiaan" class="w-7 h-7" />
                </div>
                <span class="text-xs font-bold text-slate-800 group-hover:text-[#155E4B]">Kemanusiaan</span>
            </a>
        </div>

        <!-- PROGRAM UNGGULAN SECTION -->
        <div class="space-y-3.5">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-sm font-extrabold text-slate-800 tracking-tight">
                    Program Unggulan
                </h3>
                <a href="{{ route('programs.index') }}" class="text-xs font-bold text-[#155E4B] hover:text-[#0E4436] inline-flex items-center gap-1">
                    <span>Lihat Semua</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>

            <!-- Featured Campaign Card -->
            @if($featured)
                <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-sm hover:shadow-md transition">
                    <div class="flex flex-col sm:flex-row gap-4 items-center">
                        <div class="w-full sm:w-36 h-36 sm:h-32 rounded-2xl bg-slate-100 overflow-hidden shrink-0 relative">
                            @if($featured->banner)
                                <img src="{{ asset('storage/' . $featured->banner) }}" alt="{{ $featured->nama }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('images/mosque-hero.svg') }}" alt="{{ $featured->nama }}" class="w-full h-full object-cover">
                            @endif
                        </div>

                        <div class="flex-1 min-w-0 space-y-2 w-full">
                            <a href="{{ route('programs.show', $featured->slug) }}" class="font-extrabold text-sm sm:text-base text-slate-800 hover:text-[#155E4B] transition line-clamp-2 leading-snug">
                                {{ $featured->nama }}
                            </a>

                            <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                <div class="bg-[#155E4B] h-2 rounded-full" style="width: {{ $featured->persentase }}%"></div>
                            </div>

                            <p class="text-xs text-slate-500 flex items-center gap-1.5 flex-wrap">
                                <span>Rp {{ number_format($featured->dana_terkumpul, 0, ',', '.') }}</span>
                                <span>/</span>
                                @if($featured->target_dana > 0)
                                    <span>Target Rp {{ number_format($featured->target_dana, 0, ',', '.') }}</span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[#155E4B] font-bold">
                                        <x-infinity-icon class="w-3.5 h-3.5 text-[#155E4B]" />
                                        <span>Target Tidak Terbatas</span>
                                    </span>
                                @endif
                            </p>

                            <div class="pt-1">
                                <a href="{{ route('programs.show', $featured->slug) }}" class="inline-block bg-[#155E4B] hover:bg-[#0E4436] text-white text-xs font-bold px-5 py-2 rounded-full shadow-sm active:scale-95 transition">
                                    Lihat Program
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Grid of other active programs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 pt-1">
                @foreach($programs->skip(1)->take(3) as $item)
                    <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <div class="h-40 w-full bg-slate-100 relative overflow-hidden">
                                @if($item->banner)
                                    <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                @else
                                    <img src="{{ asset('images/mosque-hero.svg') }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                @endif
                                <div class="absolute top-3 left-3">
                                    <span class="text-[10px] font-bold bg-white/95 backdrop-blur-md text-[#155E4B] px-3 py-0.5 rounded-full shadow-sm">
                                        {{ $item->kategori }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-4 space-y-2.5">
                                <a href="{{ route('programs.show', $item->slug) }}" class="font-extrabold text-xs sm:text-sm text-slate-800 line-clamp-2 hover:text-[#155E4B] transition leading-snug">
                                    {{ $item->nama }}
                                </a>

                                <div class="space-y-1">
                                    <div class="w-full bg-slate-100 rounded-full h-1.5 overflow-hidden">
                                        <div class="bg-[#155E4B] h-1.5 rounded-full" style="width: {{ $item->persentase }}%"></div>
                                    </div>
                                    <div class="flex justify-between items-center text-[10px] text-slate-500">
                                        <span>Rp {{ number_format($item->dana_terkumpul, 0, ',', '.') }}</span>
                                        @if($item->target_dana > 0)
                                            <span>Target: Rp {{ number_format($item->target_dana, 0, ',', '.') }}</span>
                                        @else
                                            <span class="inline-flex items-center gap-1 font-bold text-[#155E4B]">
                                                <span>Target:</span>
                                                <x-infinity-icon class="w-3 h-3 text-[#155E4B]" />
                                                <span>Tak Terbatas</span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="p-4 pt-0">
                            <a href="{{ route('programs.show', $item->slug) }}" class="block w-full text-center bg-[#F2F7F4] hover:bg-[#155E4B] text-[#155E4B] hover:text-white font-bold text-xs py-2.5 rounded-full transition active:scale-95">
                                Lihat Program
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- TRANSPARANSI KAS & AMANAH DONATUR -->
        <div class="bg-[#155E4B] rounded-3xl p-5 sm:p-7 text-white shadow-sm space-y-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-teal-200">Transparansi Dana Al Futuh</h3>
                </div>
                <a href="{{ route('transparansi') }}" class="text-[11px] font-bold text-[#FFF] hover:underline">
                    Detail Penyaluran →
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10 col-span-2 sm:col-span-1">
                    <p class="text-[10px] text-teal-200 font-medium">Total Donasi Terverifikasi</p>
                    <p class="text-lg sm:text-xl font-black text-white mt-0.5">Rp {{ number_format($totalDonasiMasuk, 0, ',', '.') }}</p>
                    <p class="text-[9px] text-teal-300 mt-1">{{ $totalDonaturCount }} donatur berpartisipasi</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                    <p class="text-[10px] text-teal-200 font-medium">Total Disalurkan</p>
                    <p class="text-base sm:text-lg font-black text-[#FFF] mt-0.5">Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</p>
                    <p class="text-[9px] text-teal-300 mt-1">Amanah telah tersalur</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-4 rounded-2xl border border-white/10">
                    <p class="text-[10px] text-teal-200 font-medium">Saldo Kas Amanah</p>
                    <p class="text-base sm:text-lg font-black text-[#FFF] mt-0.5">Rp {{ number_format(max(0, $totalDonasiMasuk - $totalPenyaluran), 0, ',', '.') }}</p>
                    <p class="text-[9px] text-teal-300 mt-1">Siap disalurkan</p>
                </div>
            </div>
        </div>

        <!-- DOA & DUKUNGAN DONATUR -->
        @if($recentDonations->isNotEmpty())
            <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3.5">
                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#155E4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Doa &amp; Dukungan Donatur</span>
                </h3>
                <div class="space-y-2.5">
                    @foreach($recentDonations as $d)
                        <div class="p-3.5 bg-[#F8FAF8] rounded-2xl border border-slate-100 space-y-1">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="font-bold text-slate-800">{{ $d->displayName }}</span>
                                <span class="text-[10px] text-slate-400">{{ $d->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-600 italic">"{{ $d->doa }}"</p>
                            <p class="text-[9px] font-medium text-[#155E4B]">Berdonasi di {{ $d->program->nama }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- FEATURE BADGES -->
        <div class="pt-4 space-y-4 text-center">
            <div class="flex flex-wrap items-center justify-center gap-2 sm:gap-2.5 text-xs">
                <span class="inline-flex items-center gap-1.5 bg-[#F2F7F4] text-[#155E4B] border border-[#D2E6DC] px-4 py-1.5 rounded-full font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Amanah &amp; Transparan
                </span>
                <span class="inline-flex items-center gap-1.5 bg-[#F2F7F4] text-[#155E4B] border border-[#D2E6DC] px-4 py-1.5 rounded-full font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m13 2-8 12h7l-1 8 8-12h-7l1-8Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Akses Mudah di Semua Perangkat
                </span>
               
                <span class="inline-flex items-center gap-1.5 bg-[#F2F7F4] text-[#155E4B] border border-[#D2E6DC] px-4 py-1.5 rounded-full font-bold">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    Mari Berbagi untuk Kebaikan
                </span>
            </div>

            
        </div>

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

            <!-- 3. TOMBOL BESAR DI TENGAH (AKSI CEPAT DONASI) -->
            <div class="flex-1 flex justify-center -mt-6">
                <a href="{{ route('programs.index') }}" class="group relative flex flex-col items-center focus:outline-none" aria-label="Aksi Cepat Donasi">
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

    <!-- Service Worker Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</body>
</html>
