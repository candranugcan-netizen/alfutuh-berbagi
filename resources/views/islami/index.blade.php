<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Fitur Islami - Al Futuh</title>

    <!-- Favicon & PWA Icons -->
    <link rel="icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#EA580C">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Al Futuh">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=manrope:500,600,700,800&family=amiri:400,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#FFFBF7] text-slate-800 pb-24 md:pb-12 min-h-screen"
      x-data="{
          comingSoonModal: false,
          selectedFeature: ''
      }">

    <!-- Top Header (Flat & Dominan Orange) -->
    <header class="bg-white sticky top-0 z-40 border-b border-orange-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/icon-192.png') }}" alt="Al Futuh" class="w-10 h-10 object-contain rounded-xl">
                <div>
                    <h1 class="font-extrabold text-lg sm:text-xl text-[#EA580C] leading-none tracking-tight">Al Futuh</h1>
                    <p class="text-[9px] font-bold text-[#155E4B] mt-0.5 uppercase tracking-[0.2em]">Fitur Islami</p>
                </div>
            </a>

            <!-- Desktop Navigation Menu -->
            <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600">
                <a href="{{ route('landing') }}" class="hover:text-[#EA580C] transition">Beranda</a>
                <a href="{{ route('islami.index') }}" class="text-[#EA580C] hover:text-[#C2410C] transition">Fitur Islami</a>
                <a href="{{ route('programs.index') }}" class="hover:text-[#EA580C] transition">Program</a>
                <a href="{{ route('donations.my-donations') }}" class="hover:text-[#EA580C] transition">Riwayat</a>
                <a href="{{ route('transparansi') }}" class="hover:text-[#EA580C] transition">Transparansi</a>
            </nav>

            <!-- Right Actions -->
            <div class="flex items-center gap-2">
                <a href="{{ route('landing') }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#155E4B] hover:bg-[#EAF5EE] bg-[#F2F7F4] border border-[#D2E6DC] px-3.5 py-1.5 sm:py-2 rounded-full transition active:scale-95">
                    <span>←</span>
                    <span>Beranda Donasi</span>
                </a>
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 pt-5 space-y-6">

        <!-- 1. HERO: AYAT & HADITS HARIAN (OTOMATIS ACAK SETIAP HARI) -->
        <div class="bg-[#EA580C] rounded-3xl p-5 sm:p-7 text-white border border-[#C2410C]">
            <div class="space-y-4">
                <!-- Baris Atas: Label Tipe -->
                <div class="flex items-center justify-between gap-2">
                    <span class="inline-flex items-center gap-1.5 bg-white text-[#EA580C] text-[10px] sm:text-xs font-extrabold px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#155E4B]"></span>
                        <span>{{ $dailyQuote['type'] }} Harian</span>
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold text-orange-100">
                        {{ now()->translatedFormat('d M Y') }}
                    </span>
                </div>

                <!-- Teks Arab -->
                <p dir="rtl" class="text-right text-xl sm:text-2xl leading-loose font-bold text-white py-1"
                   style="font-family: 'Amiri', serif;">{{ $dailyQuote['arab'] }}</p>

                <!-- Terjemah & Sumber -->
                <div class="space-y-2 border-t border-orange-400/50 pt-3">
                    <p class="text-xs sm:text-sm text-orange-50 leading-relaxed italic">“{{ $dailyQuote['terjemah'] }}”</p>
                    <p class="text-[11px] font-extrabold text-orange-100">— {{ $dailyQuote['sumber'] }}</p>
                </div>
            </div>
        </div>

        <!-- 2. BANNER JADWAL SHOLAT (FLAT) -->
        <x-jadwal-sholat-card :show-islami-button="false" />

        <!-- 3. TOMBOL GRID FITUR ISLAMI (4 FITUR UTAMA - FLAT & BULAT) -->
        <div class="space-y-3">
            <div class="flex items-center justify-between px-1">
                <div>
                    <h2 class="text-sm sm:text-base font-extrabold text-slate-800 tracking-tight">Menu Fitur Islami</h2>
                    
                </div>
            </div>

            <div class="grid grid-cols-4 gap-2 sm:gap-4 px-1">
                <!-- 1. Al-Qur'an -->
                <button type="button" @click="selectedFeature = 'Al-Qur\'an Digital'; comingSoonModal = true"
                        class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-13 h-13 sm:w-16 sm:h-16 rounded-full bg-[#FFF7ED] group-hover:bg-orange-100 border border-orange-200 flex items-center justify-center text-[#EA580C] group-hover:scale-105 transition p-3 sm:p-4">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.5c-2.5-2-6-2.5-9-2v13c3-.5 6.5 0 9 2m0-13c2.5-2 6-2.5 9-2v13c-3-.5-6.5 0-9 2m0-13v13"/>
                        </svg>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#EA580C] leading-tight">Al-Qur'an</span>
                </button>

                <!-- 2. Hadits -->
                <button type="button" @click="selectedFeature = 'Kumpulan Hadits Shahih'; comingSoonModal = true"
                        class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-13 h-13 sm:w-16 sm:h-16 rounded-full bg-[#FFF7ED] group-hover:bg-orange-100 border border-orange-200 flex items-center justify-center text-[#EA580C] group-hover:scale-105 transition p-3 sm:p-4">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                        </svg>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#EA580C] leading-tight">Hadits</span>
                </button>

                <!-- 3. Doa-Doa Shahih -->
                <button type="button" @click="selectedFeature = 'Doa-Doa Shahih'; comingSoonModal = true"
                        class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-13 h-13 sm:w-16 sm:h-16 rounded-full bg-[#FFF7ED] group-hover:bg-orange-100 border border-orange-200 flex items-center justify-center text-[#EA580C] group-hover:scale-105 transition p-3 sm:p-4">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#EA580C] leading-tight">Doa Shahih</span>
                </button>

                <!-- 4. Kalkulator Zakat -->
                <button type="button" @click="selectedFeature = 'Kalkulator Zakat'; comingSoonModal = true"
                        class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-13 h-13 sm:w-16 sm:h-16 rounded-full bg-[#FFF7ED] group-hover:bg-orange-100 border border-orange-200 flex items-center justify-center text-[#EA580C] group-hover:scale-105 transition p-3 sm:p-4">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="2" width="16" height="20" rx="2" stroke-width="1.8"/>
                            <path stroke-linecap="round" stroke-width="1.8" d="M8 6h8M8 10h2m4 0h2m-8 4h2m4 0h2m-8 4h2m4 0h2"/>
                        </svg>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#EA580C] leading-tight">Kalkulator Zakat</span>
                </button>
            </div>
        </div>

        <!-- 4. PENGINGAT PUASA SUNNAH (FLAT) -->
        <div x-data="{
                dayOfWeek: new Date().getDay(),
                hijriDay: null,
                hijriMonth: '',
                get fastAlert() {
                    if (this.dayOfWeek === 1) return 'Hari ini hari Senin — Disunnahkan melaksanakan Puasa Sunnah Senin!';
                    if (this.dayOfWeek === 4) return 'Hari ini hari Kamis — Disunnahkan melaksanakan Puasa Sunnah Kamis!';
                    if (this.dayOfWeek === 0) return 'Besok hari Senin — Niatkan diri untuk Puasa Sunnah Senin.';
                    if (this.dayOfWeek === 3) return 'Besok hari Kamis — Niatkan diri untuk Puasa Sunnah Kamis.';
                    if (this.hijriDay && [13, 14, 15].includes(this.hijriDay)) return `Hari ini tanggal ${this.hijriDay} ${this.hijriMonth} — Termasuk hari Puasa Ayyamul Bidh!`;
                    if (this.hijriDay === 12) return `Besok memasuki tanggal 13 ${this.hijriMonth} — Persiapkan niat Puasa Ayyamul Bidh.`;
                    return null;
                }
            }"
            @hijri-updated.window="hijriDay = $event.detail.day; hijriMonth = $event.detail.month"
            class="bg-white rounded-3xl border border-orange-100 p-4 sm:p-6 space-y-3.5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#EA580C]"></span>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-800 tracking-tight">Pengingat Puasa Sunnah</h3>
                </div>
                <span class="text-[10px] font-bold bg-[#FFF7ED] text-[#EA580C] border border-orange-200 px-2.5 py-0.5 rounded-full">
                    Ibadah Sunnah
                </span>
            </div>

            <!-- Notifikasi Dinamis Jika Hari Ini / Besok Puasa Sunnah -->
            <template x-if="fastAlert">
                <div class="p-3 rounded-2xl bg-[#FFF7ED] border border-orange-200 text-[#9A3412] flex items-center gap-2.5 text-xs font-bold">
                    <span class="text-base shrink-0">🌙</span>
                    <span x-text="fastAlert"></span>
                </div>
            </template>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3">
                <div class="p-3.5 rounded-2xl bg-[#FFFBF7] border border-orange-100 space-y-1">
                    <span class="text-[10px] font-extrabold text-[#EA580C] uppercase tracking-wider block">Rutin Mingguan</span>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-800">Puasa Senin &amp; Kamis</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Hari diangkatnya amal-amal hamba kepada Allah SWT.</p>
                </div>

                <div class="p-3.5 rounded-2xl bg-[#FFFBF7] border border-orange-100 space-y-1">
                    <span class="text-[10px] font-extrabold text-[#EA580C] uppercase tracking-wider block">Rutin Bulanan</span>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-800">Puasa Ayyamul Bidh</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Setiap tanggal 13, 14, dan 15 bulan Hijriah (seperti puasa sepanjang tahun).</p>
                </div>

                <div class="p-3.5 rounded-2xl bg-[#FFFBF7] border border-orange-100 space-y-1">
                    <span class="text-[10px] font-extrabold text-[#EA580C] uppercase tracking-wider block">Tahunan Utama</span>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-800">Arafah, Asyura &amp; Syawal</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Puasa sunnah dengan keutamaan penghapus dosa setahun lalu &amp; akan datang.</p>
                </div>
            </div>
        </div>

        <!-- 5. AMALAN SUNNAH HARIAN (CHECKLIST INTERAKTIF - FLAT) -->
        <div x-data="{
                todayKey: 'alfutuh_amalan_' + new Date().toISOString().slice(0, 10),
                doneIds: [],
                totalItems: {{ count($amalanSunnah) }},
                init() {
                    const saved = localStorage.getItem(this.todayKey);
                    if (saved) {
                        try { this.doneIds = JSON.parse(saved); } catch (e) {}
                    }
                },
                toggle(id) {
                    if (this.doneIds.includes(id)) {
                        this.doneIds = this.doneIds.filter(i => i !== id);
                    } else {
                        this.doneIds.push(id);
                    }
                    localStorage.setItem(this.todayKey, JSON.stringify(this.doneIds));
                },
                get progress() {
                    return this.totalItems > 0 ? Math.round((this.doneIds.length / this.totalItems) * 100) : 0;
                }
            }"
            class="bg-white rounded-3xl border border-orange-100 p-4 sm:p-6 space-y-4">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#155E4B]"></span>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-800 tracking-tight">Amalan Sunnah Harian</h3>
                    </div>
                    <p class="text-[11px] text-slate-500">Tandai amalan sunnah yang sudah Anda kerjakan hari ini</p>
                </div>
                <span class="text-xs font-black text-[#EA580C] bg-[#FFF7ED] px-3 py-1 rounded-full border border-orange-200 shrink-0"
                      x-text="doneIds.length + '/' + totalItems + ' Selesai'"></span>
            </div>

            <!-- Progress Bar Harian (Flat) -->
            <div class="w-full bg-orange-100 rounded-full h-2 overflow-hidden">
                <div class="bg-[#EA580C] h-2 rounded-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
            </div>

            <!-- Daftar Checklist -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                @foreach($amalanSunnah as $amalan)
                    <button type="button" @click="toggle('{{ $amalan['id'] }}')"
                            :class="doneIds.includes('{{ $amalan['id'] }}') ? 'bg-[#FFF7ED] border-orange-300' : 'bg-[#FFFBF7] border-orange-100 hover:border-orange-200'"
                            class="w-full text-left p-3 rounded-2xl border transition flex items-start gap-3 active:scale-[0.99]">
                        <div :class="doneIds.includes('{{ $amalan['id'] }}') ? 'bg-[#EA580C] border-[#EA580C] text-white' : 'bg-white border-slate-300 text-transparent'"
                             class="w-5 h-5 rounded-lg border flex items-center justify-center shrink-0 mt-0.5 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <h4 :class="doneIds.includes('{{ $amalan['id'] }}') ? 'text-[#C2410C] line-through' : 'text-slate-800'"
                                    class="font-extrabold text-xs leading-snug">
                                    {{ $amalan['judul'] }}
                                </h4>
                                <span class="text-[9px] font-bold text-slate-500 bg-white px-2 py-0.5 rounded-full border border-orange-100 shrink-0">
                                    {{ $amalan['waktu'] }}
                                </span>
                            </div>
                            <p class="text-[10px] text-slate-500 mt-0.5 leading-relaxed">{{ $amalan['keterangan'] }}</p>
                        </div>
                    </button>
                @endforeach
            </div>
        </div>

    </main>

    <!-- MODAL INFO PENGEMBANGAN BERTAHAP -->
    <div x-show="comingSoonModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/50"
         style="display: none;">
        <div @click.away="comingSoonModal = false"
             class="bg-white rounded-3xl max-w-sm w-full p-6 text-center space-y-4 shadow-xl border border-orange-100">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-[#FFF7ED] text-[#EA580C] border border-orange-200 flex items-center justify-center">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z"/>
                </svg>
            </div>
            <div class="space-y-1.5">
                <h4 class="font-extrabold text-base text-slate-800" x-text="selectedFeature"></h4>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Fitur ini sedang dalam tahap pengembangan bertahap untuk memberikan pengalaman ibadah terbaik bagi Anda.
                </p>
            </div>
            <button type="button" @click="comingSoonModal = false"
                    class="w-full bg-[#EA580C] hover:bg-[#C2410C] text-white font-bold text-xs py-2.5 rounded-full transition active:scale-95">
                Mengerti
            </button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="max-w-5xl mx-auto px-4 sm:px-6 mt-10 text-center text-xs text-slate-400 space-y-2 border-t border-orange-100 pt-8 pb-4">
        <p class="font-bold text-slate-700 text-sm">Al Futuh</p>
        <p class="text-xs text-slate-500 font-semibold">Sub Yayasan dari Yayasan Tebar Dakwah Al Islamy</p>
        <p class="text-[11px] max-w-lg mx-auto text-slate-400">Klepu, Rejosari, Semin, Gunungkidul, Daerah Istimewa Yogyakarta • Izin Kemenkumham Nomor : AHU 0006697.AH.01.04</p>
        <p class="text-[10px] text-slate-400 pt-1">© {{ date('Y') }} Al Futuh Peduli. All rights reserved.</p>
    </footer>

    <!-- PWA MOBILE BOTTOM NAVIGATION BAR -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-orange-100 z-50 px-2 py-1.5 pb-[max(.5rem,env(safe-area-inset-bottom))]">
        <div class="flex justify-between items-end relative">
            <a href="{{ route('landing') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#EA580C]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 11.5 12 4l9 7.5M5 10v10h14V10M9 20v-6h6v6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ route('islami.index') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-[#EA580C] font-extrabold">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.5c-2.5-2-6-2.5-9-2v13c3-.5 6.5 0 9 2m0-13c2.5-2 6-2.5 9-2v13c-3-.5-6.5 0-9 2m0-13v13"/>
                </svg>
                <span>Islami</span>
            </a>

            @php
                $quickOperasional = \App\Models\Program::where('slug', 'sedekah-operasional-dakwah-yayasan')
                    ->orWhere('nama', 'like', '%operasional%')
                    ->first() ?? \App\Models\Program::where('is_active', true)->first();
                $quickDonateUrl = $quickOperasional ? route('programs.show', $quickOperasional->slug) : route('programs.index');
            @endphp
            <div class="flex-1 flex justify-center -mt-6">
                <a href="{{ $quickDonateUrl }}" class="group relative flex flex-col items-center focus:outline-none" aria-label="Aksi Cepat Donasi">
                    <div class="w-14 h-14 rounded-full bg-[#155E4B] text-white flex flex-col items-center justify-center shadow-md border-[3.5px] border-white group-active:scale-95 transition-transform duration-200">
                        <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </div>
                    <span class="text-[9px] font-black text-[#155E4B] tracking-tight mt-0.5">Donasi</span>
                </a>
            </div>

            <a href="{{ route('donations.my-donations') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#EA580C]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                    <path d="M12 7v5l3 3" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Riwayat</span>
            </a>

            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('dashboard') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#EA580C]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="3" stroke-width="1.8"/>
                            <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06A1.7 1.7 0 0 0 16.44 18a1.7 1.7 0 0 0-1 .6V19H13v-.4a1.7 1.7 0 0 0-1-.6 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9 15.44a1.7 1.7 0 0 0-.6-1H8v-2.44h.4A1.7 1.7 0 0 0 9 10.56a1.7 1.7 0 0 0-.34-1.88l-.06-.06L10.02 7.2l.06.06A1.7 1.7 0 0 0 12 7a1.7 1.7 0 0 0 1-.6V6h2.44v.4A1.7 1.7 0 0 0 16.44 7a1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06A1.7 1.7 0 0 0 19.4 10a1.7 1.7 0 0 0 .6 1h.4v2.44H20a1.7 1.7 0 0 0-.6 1Z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Admin</span>
                    </a>
                @else
                    <a href="{{ route('profile.edit') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#EA580C]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="8" r="4" stroke-width="1.8"/>
                            <path d="M4 20c1.5-4 4-6 8-6s6.5 2 8 6" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        <span>Akun</span>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#EA580C]">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="8" r="4" stroke-width="1.8"/>
                        <path d="M4 20c1.5-4 4-6 8-6s6.5 2 8 6" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span>Akun</span>
                </a>
            @endauth
        </div>
    </div>

</body>
</html>
