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
    <meta name="theme-color" content="#2B5B84">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Al Futuh">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=manrope:500,600,700,800&family=amiri:400,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F7FAFC] text-slate-800 pb-24 md:pb-12 min-h-screen"
      x-data="{
          comingSoonModal: false,
          selectedFeature: ''
      }">

    <!-- Top Header (Flat & Biru Kalem) -->
    <header class="bg-white sticky top-0 z-40 border-b border-[#E2EEF6]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/icon-192.png') }}" alt="Al Futuh" class="w-10 h-10 object-contain rounded-xl">
                <div>
                    <h1 class="font-extrabold text-lg sm:text-xl text-[#2B5B84] leading-none tracking-tight">Al Futuh</h1>
                    <p class="text-[9px] font-bold text-[#155E4B] mt-0.5 uppercase tracking-[0.2em]">Fitur Islami</p>
                </div>
            </a>

            <!-- Desktop Navigation Menu -->
            <nav class="hidden md:flex items-center gap-6 text-xs font-bold text-slate-600">
                <a href="{{ route('landing') }}" class="hover:text-[#2B5B84] transition">Beranda</a>
                <a href="{{ route('islami.index') }}" class="text-[#2B5B84] hover:text-[#1E4363] transition">Fitur Islami</a>
                <a href="{{ route('programs.index') }}" class="hover:text-[#2B5B84] transition">Program</a>
                <a href="{{ route('donations.my-donations') }}" class="hover:text-[#2B5B84] transition">Riwayat</a>
                <a href="{{ route('transparansi') }}" class="hover:text-[#2B5B84] transition">Transparansi</a>
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

        <!-- 0. POP-UP NOTIF PENGEMBANGAN FITUR ISLAMI -->
        <div x-data="{
                showDevPopup: false,
                dontShowToday: false,
                init() {
                    const hideDate = localStorage.getItem('alfutuh_islami_popup_hide_date');
                    const todayStr = new Date().toISOString().slice(0, 10);
                    const seenSession = sessionStorage.getItem('alfutuh_islami_popup_seen');
                    if (hideDate === todayStr || seenSession) return;
                    setTimeout(() => { this.showDevPopup = true; }, 500);
                },
                closeDevPopup() {
                    this.showDevPopup = false;
                    sessionStorage.setItem('alfutuh_islami_popup_seen', 'true');
                    if (this.dontShowToday) {
                        localStorage.setItem('alfutuh_islami_popup_hide_date', new Date().toISOString().slice(0, 10));
                    }
                }
            }"
            x-show="showDevPopup"
            x-cloak
            @keydown.escape.window="closeDevPopup()"
            class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6">

            <!-- Backdrop -->
            <div x-show="showDevPopup"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="closeDevPopup()"
                 class="fixed inset-0 bg-slate-900/55 backdrop-blur-xs"></div>

            <!-- Modal Card -->
            <div x-show="showDevPopup"
                 x-transition:enter="ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                 class="relative z-10 bg-white rounded-3xl max-w-md w-full border border-amber-200 shadow-2xl overflow-hidden">

                <!-- Header Peringatan -->
                <div class="bg-amber-500 text-white p-5 relative">
                    <button type="button" @click="closeDevPopup()"
                            class="absolute top-3.5 right-3.5 w-8 h-8 rounded-full bg-black/20 hover:bg-black/35 text-white flex items-center justify-center transition"
                            aria-label="Tutup Pemberitahuan">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <div class="flex items-center gap-3 pr-8">
                        <div class="w-10 h-10 rounded-2xl bg-white/20 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-[10px] font-extrabold uppercase tracking-wider bg-white/20 px-2.5 py-0.5 rounded-full">
                                Dalam Pengembangan
                            </span>
                            <h2 class="text-base font-extrabold mt-1 leading-snug">Pemberitahuan Fitur Islami</h2>
                        </div>
                    </div>
                </div>

                <!-- Isi Pesan -->
                <div class="p-5 space-y-4">
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                        Halaman dan layanan Fitur Islami ini masih dalam tahap pengembangan. Kesalahan data maupun ketidaktepatan respons (termasuk pada fitur AI dan jadwal) masih mungkin terjadi.
                    </p>
                    <p class="text-xs text-slate-600 leading-relaxed bg-amber-50 border border-amber-100 rounded-2xl p-3">
                        Masukan, saran perbaikan, dan dukungan Anda sangat terbuka bagi tim pengembang. <strong>Apabila menemukan bug atau kesalahan pada sistem, silakan hubungi developer.</strong>
                    </p>

                    <label class="flex items-center gap-2 cursor-pointer select-none">
                        <input type="checkbox" x-model="dontShowToday" class="rounded border-slate-300 text-amber-500 focus:ring-amber-500">
                        <span class="text-xs text-slate-500 font-medium">Jangan tampilkan lagi hari ini</span>
                    </label>

                    <div class="flex flex-col sm:flex-row gap-2 pt-1">
                        <a href="https://wa.me/6285743377335"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="flex-1 inline-flex items-center justify-center gap-1.5 bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs px-4 py-2.5 rounded-full transition active:scale-95">
                            <span>Hubungi Developer</span>
                        </a>
                        <button type="button" @click="closeDevPopup()"
                                class="flex-1 inline-flex items-center justify-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-extrabold text-xs px-4 py-2.5 rounded-full transition active:scale-95">
                            Mengerti, Lanjutkan
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- 1. HERO: AYAT & HADITS HARIAN (OTOMATIS ACAK SETIAP HARI - BIRU KALEM) -->
        <div class="bg-[#2B5B84] rounded-3xl p-5 sm:p-7 text-white border border-[#1E4363]">
            <div class="space-y-4">
                <!-- Baris Atas: Label Tipe -->
                <div class="flex items-center justify-between gap-2">
                    <span class="inline-flex items-center gap-1.5 bg-white text-[#2B5B84] text-[10px] sm:text-xs font-extrabold px-3 py-1 rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#155E4B]"></span>
                        <span>{{ $dailyQuote['type'] }} Harian</span>
                    </span>
                    <span class="text-[10px] sm:text-xs font-bold text-sky-100">
                        {{ now()->translatedFormat('d M Y') }}
                    </span>
                </div>

                <!-- Teks Arab -->
                <p dir="rtl" class="text-right text-xl sm:text-2xl leading-loose font-bold text-white py-1"
                   style="font-family: 'Amiri', serif;">{{ $dailyQuote['arab'] }}</p>

                <!-- Terjemah & Sumber -->
                <div class="space-y-2 border-t border-sky-200/25 pt-3">
                    <p class="text-xs sm:text-sm text-sky-50 leading-relaxed italic">“{{ $dailyQuote['terjemah'] }}”</p>
                    <p class="text-[11px] font-extrabold text-sky-200">— {{ $dailyQuote['sumber'] }}</p>
                </div>
            </div>
        </div>

        <!-- 2. BANNER JADWAL SHOLAT (FLAT & COMPACT) -->
        <x-jadwal-sholat-card :show-islami-button="false" />

        <!-- 3. TOMBOL GRID FITUR ISLAMI (4 FITUR UTAMA - FLAT & BULAT) -->
        <div class="space-y-3">

            <div class="grid grid-cols-4 gap-x-2 gap-y-4 sm:gap-4 px-1">
                <!-- 1. Al-Qur'an -->
                <a href="{{ route('islami.quran.index') }}"
                   class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-13 h-13 sm:w-16 sm:h-16 rounded-full bg-[#F0F6FA] group-hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] group-hover:scale-105 transition p-3 sm:p-4">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.5c-2.5-2-6-2.5-9-2v13c3-.5 6.5 0 9 2m0-13c2.5-2 6-2.5 9-2v13c-3-.5-6.5 0-9 2m0-13v13"/>
                        </svg>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#2B5B84] leading-tight">Al-Qur'an</span>
                </a>

                <!-- 2. Hadits -->
                <a href="{{ route('islami.hadits.index') }}"
                   class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-13 h-13 sm:w-16 sm:h-16 rounded-full bg-[#F0F6FA] group-hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] group-hover:scale-105 transition p-3 sm:p-4">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2"/>
                        </svg>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#2B5B84] leading-tight">Hadits</span>
                </a>

                <!-- 3. Doa-Doa Shahih -->
                <button type="button" @click="selectedFeature = 'Doa-Doa Shahih'; comingSoonModal = true"
                        class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-13 h-13 sm:w-16 sm:h-16 rounded-full bg-[#F0F6FA] group-hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] group-hover:scale-105 transition p-3 sm:p-4">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#2B5B84] leading-tight">Doa Shahih</span>
                </button>

                <!-- 4. Kalkulator Zakat -->
                <a href="{{ route('islami.zakat.index') }}"
                   class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-13 h-13 sm:w-16 sm:h-16 rounded-full bg-[#F0F6FA] group-hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] group-hover:scale-105 transition p-3 sm:p-4">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="4" y="2" width="16" height="20" rx="2" stroke-width="1.8"/>
                            <path stroke-linecap="round" stroke-width="1.8" d="M8 6h8M8 10h2m4 0h2m-8 4h2m4 0h2m-8 4h2m4 0h2"/>
                        </svg>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#2B5B84] leading-tight">Kalkulator Zakat</span>
                </a>

                <!-- 5. Generator Khutbah Jumat AI -->
                <a href="{{ route('islami.khutbah.index') }}"
                   class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-13 h-13 sm:w-16 sm:h-16 rounded-full bg-[#F0F6FA] group-hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] group-hover:scale-105 transition p-3 sm:p-4">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#2B5B84] leading-tight">Khutbah AI</span>
                </a>

                <!-- 6. Generator Kultum & Ceramah AI -->
                <a href="{{ route('islami.kultum.index') }}"
                   class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-13 h-13 sm:w-16 sm:h-16 rounded-full bg-[#F0F6FA] group-hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] group-hover:scale-105 transition p-3 sm:p-4">
                        <svg class="w-6 h-6 sm:w-7 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                    </div>
                    <span class="text-[10px] sm:text-xs font-bold text-slate-700 group-hover:text-[#2B5B84] leading-tight">Kultum AI</span>
                </a>
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
            class="bg-white rounded-3xl border border-[#E2EEF6] p-4 sm:p-6 space-y-3.5">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-[#2B5B84]"></span>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-800 tracking-tight">Pengingat Puasa Sunnah</h3>
                </div>
                <span class="text-[10px] font-bold bg-[#F0F6FA] text-[#2B5B84] border border-[#D6E6F2] px-2.5 py-0.5 rounded-full">
                    Ibadah Sunnah
                </span>
            </div>

            <!-- Notifikasi Dinamis Jika Hari Ini / Besok Puasa Sunnah -->
            <template x-if="fastAlert">
                <div class="p-3 rounded-2xl bg-[#F0F6FA] border border-[#D6E6F2] text-[#1E4363] flex items-center gap-2.5 text-xs font-bold">
                    <span class="text-base shrink-0">🌙</span>
                    <span x-text="fastAlert"></span>
                </div>
            </template>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3">
                <div class="p-3.5 rounded-2xl bg-[#F7FAFC] border border-[#E2EEF6] space-y-1">
                    <span class="text-[10px] font-extrabold text-[#2B5B84] uppercase tracking-wider block">Rutin Mingguan</span>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-800">Puasa Senin &amp; Kamis</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Hari diangkatnya amal-amal seorang hamba kepada Allah Ta'ala.</p>
                </div>

                <div class="p-3.5 rounded-2xl bg-[#F7FAFC] border border-[#E2EEF6] space-y-1">
                    <span class="text-[10px] font-extrabold text-[#2B5B84] uppercase tracking-wider block">Rutin Bulanan</span>
                    <h4 class="font-extrabold text-xs sm:text-sm text-slate-800">Puasa Ayyamul Bidh</h4>
                    <p class="text-[11px] text-slate-500 leading-relaxed">Setiap tanggal 13, 14, dan 15 bulan Hijriah (seperti puasa sepanjang tahun).</p>
                </div>

                <div class="p-3.5 rounded-2xl bg-[#F7FAFC] border border-[#E2EEF6] space-y-1">
                    <span class="text-[10px] font-extrabold text-[#2B5B84] uppercase tracking-wider block">Tahunan Utama</span>
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
            class="bg-white rounded-3xl border border-[#E2EEF6] p-4 sm:p-6 space-y-4">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-[#155E4B]"></span>
                        <h3 class="text-sm sm:text-base font-extrabold text-slate-800 tracking-tight">Amalan Sunnah Harian</h3>
                    </div>
                    <p class="text-[11px] text-slate-500">Tandai amalan sunnah yang sudah Anda kerjakan hari ini</p>
                </div>
                <span class="text-xs font-black text-[#2B5B84] bg-[#F0F6FA] px-3 py-1 rounded-full border border-[#D6E6F2] shrink-0"
                      x-text="doneIds.length + '/' + totalItems + ' Selesai'"></span>
            </div>

            <!-- Progress Bar Harian (Flat) -->
            <div class="w-full bg-[#E2EEF6] rounded-full h-2 overflow-hidden">
                <div class="bg-[#2B5B84] h-2 rounded-full transition-all duration-300" :style="'width: ' + progress + '%'"></div>
            </div>

            <!-- Daftar Checklist -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5">
                @foreach($amalanSunnah as $amalan)
                    <button type="button" @click="toggle('{{ $amalan['id'] }}')"
                            :class="doneIds.includes('{{ $amalan['id'] }}') ? 'bg-[#F0F6FA] border-[#93C5FD]' : 'bg-[#F7FAFC] border-[#E2EEF6] hover:border-[#BFDBFE]'"
                            class="w-full text-left p-3 rounded-2xl border transition flex items-start gap-3 active:scale-[0.99]">
                        <div :class="doneIds.includes('{{ $amalan['id'] }}') ? 'bg-[#2B5B84] border-[#2B5B84] text-white' : 'bg-white border-slate-300 text-transparent'"
                             class="w-5 h-5 rounded-lg border flex items-center justify-center shrink-0 mt-0.5 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <h4 :class="doneIds.includes('{{ $amalan['id'] }}') ? 'text-[#1E4363] line-through' : 'text-slate-800'"
                                    class="font-extrabold text-xs leading-snug">
                                    {{ $amalan['judul'] }}
                                </h4>
                                <span class="text-[9px] font-bold text-slate-500 bg-white px-2 py-0.5 rounded-full border border-[#E2EEF6] shrink-0">
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
             class="bg-white rounded-3xl max-w-sm w-full p-6 text-center space-y-4 shadow-xl border border-[#E2EEF6]">
            <div class="w-14 h-14 mx-auto rounded-2xl bg-[#F0F6FA] text-[#2B5B84] border border-[#D6E6F2] flex items-center justify-center">
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
                    class="w-full bg-[#2B5B84] hover:bg-[#1E4363] text-white font-bold text-xs py-2.5 rounded-full transition active:scale-95">
                Mengerti
            </button>
        </div>
    </div>

    <!-- Footer -->
    <footer class="max-w-5xl mx-auto px-4 sm:px-6 mt-10 text-center text-xs text-slate-400 space-y-2 border-t border-[#E2EEF6] pt-8 pb-4">
        <p class="font-bold text-slate-700 text-sm">Al Futuh</p>
        <p class="text-xs text-slate-500 font-semibold">Sub Yayasan dari Yayasan Tebar Dakwah Al Islamy</p>
        <p class="text-[11px] max-w-lg mx-auto text-slate-400">Klepu, Rejosari, Semin, Gunungkidul, Daerah Istimewa Yogyakarta • Izin Kemenkumham Nomor : AHU 0006697.AH.01.04</p>
        <p class="text-[10px] text-slate-400 pt-1">© {{ date('Y') }} Al Futuh Peduli. All rights reserved.</p>
    </footer>

    <!-- PWA MOBILE BOTTOM NAVIGATION BAR -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-[#E2EEF6] z-50 px-2 py-1.5 pb-[max(.5rem,env(safe-area-inset-bottom))]">
        <div class="flex justify-between items-end relative">
            <a href="{{ route('landing') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#2B5B84]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M3 11.5 12 4l9 7.5M5 10v10h14V10M9 20v-6h6v6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ route('islami.index') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-[#2B5B84] font-extrabold">
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

            <a href="{{ route('donations.my-donations') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#2B5B84]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                    <path d="M12 7v5l3 3" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>Riwayat</span>
            </a>

            @auth
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('dashboard') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#2B5B84]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="12" r="3" stroke-width="1.8"/>
                            <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06A1.7 1.7 0 0 0 16.44 18a1.7 1.7 0 0 0-1 .6V19H13v-.4a1.7 1.7 0 0 0-1-.6 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9 15.44a1.7 1.7 0 0 0-.6-1H8v-2.44h.4A1.7 1.7 0 0 0 9 10.56a1.7 1.7 0 0 0-.34-1.88l-.06-.06L10.02 7.2l.06.06A1.7 1.7 0 0 0 12 7a1.7 1.7 0 0 0 1-.6V6h2.44v.4A1.7 1.7 0 0 0 16.44 7a1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06A1.7 1.7 0 0 0 19.4 10a1.7 1.7 0 0 0 .6 1h.4v2.44H20a1.7 1.7 0 0 0-.6 1Z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <span>Admin</span>
                    </a>
                @else
                    <a href="{{ route('profile.edit') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#2B5B84]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <circle cx="12" cy="8" r="4" stroke-width="1.8"/>
                            <path d="M4 20c1.5-4 4-6 8-6s6.5 2 8 6" stroke-width="1.8" stroke-linecap="round"/>
                        </svg>
                        <span>Akun</span>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] text-slate-400 font-medium hover:text-[#2B5B84]">
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
