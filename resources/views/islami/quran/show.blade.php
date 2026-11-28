<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Baca Al-Qur'an & Tafsir - Al Futuh</title>

    <link rel="icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#2B5B84">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=manrope:500,600,700,800&family=amiri:400,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F7FAFC] text-slate-800 pb-20 min-h-screen"
      x-data="quranShowApp({{ $nomor }})"
      x-init="init()">

    <!-- Top Sticky Header -->
    <header class="bg-white sticky top-0 z-40 border-b border-[#E2EEF6]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2.5 min-w-0">
                <a href="{{ route('islami.quran.index') }}"
                   class="w-9 h-9 rounded-full bg-[#F0F6FA] hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] shrink-0 transition active:scale-95"
                   aria-label="Kembali ke Daftar Surat">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <div class="min-w-0">
                    <h1 class="font-extrabold text-sm sm:text-base text-[#2B5B84] leading-tight truncate"
                        x-text="surah ? (surah.nomor + '. ' + surah.namaLatin) : 'Memuat Surat...'"></h1>
                    <p class="text-[10px] font-bold text-slate-400 truncate"
                       x-text="surah ? (surah.arti + ' • ' + surah.jumlahAyat + ' Ayat') : 'Al-Qur\'an Digital & Tafsir'"></p>
                </div>
            </div>

            <!-- Tombol Pengaturan Tampilan -->
            <div class="relative flex items-center gap-1.5">
                <button type="button" @click="settingsOpen = !settingsOpen"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-[#2B5B84] bg-[#F0F6FA] hover:bg-[#E2EEF6] border border-[#D6E6F2] px-3 py-1.5 rounded-full transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    <span class="hidden sm:inline">Tampilan</span>
                </button>

                <!-- Dropdown Pengaturan -->
                <div x-show="settingsOpen" @click.away="settingsOpen = false" x-cloak
                     class="absolute right-0 top-11 w-64 bg-white rounded-2xl border border-[#E2EEF6] shadow-lg p-4 space-y-3 z-50">
                    <p class="text-xs font-extrabold text-[#2B5B84]">Pengaturan Baca</p>

                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-xs font-semibold text-slate-700">Tampilkan Latin</span>
                        <input type="checkbox" x-model="showLatin" @change="savePrefs()" class="rounded text-[#2B5B84] focus:ring-[#2B5B84]">
                    </label>

                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-xs font-semibold text-slate-700">Tampilkan Terjemah</span>
                        <input type="checkbox" x-model="showTranslation" @change="savePrefs()" class="rounded text-[#2B5B84] focus:ring-[#2B5B84]">
                    </label>

                    <div class="space-y-1.5 pt-1 border-t border-slate-100">
                        <span class="text-[11px] font-bold text-slate-500">Ukuran Teks Arab</span>
                        <div class="grid grid-cols-3 gap-1.5">
                            <button type="button" @click="arabSize = 'normal'; savePrefs()"
                                    :class="arabSize === 'normal' ? 'bg-[#2B5B84] text-white' : 'bg-[#F0F6FA] text-slate-700'"
                                    class="py-1.5 rounded-xl text-[11px] font-bold transition">Sedang</button>
                            <button type="button" @click="arabSize = 'large'; savePrefs()"
                                    :class="arabSize === 'large' ? 'bg-[#2B5B84] text-white' : 'bg-[#F0F6FA] text-slate-700'"
                                    class="py-1.5 rounded-xl text-[11px] font-bold transition">Besar</button>
                            <button type="button" @click="arabSize = 'xlarge'; savePrefs()"
                                    :class="arabSize === 'xlarge' ? 'bg-[#2B5B84] text-white' : 'bg-[#F0F6FA] text-slate-700'"
                                    class="py-1.5 rounded-xl text-[11px] font-bold transition">Jumbo</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 pt-5 space-y-5">

        <!-- Loading State -->
        <div x-show="loading" class="space-y-4">
            <div class="bg-[#2B5B84] rounded-3xl p-6 h-36 animate-pulse"></div>
            <template x-for="i in 4" :key="i">
                <div class="bg-white rounded-3xl border border-[#E2EEF6] p-5 space-y-3 animate-pulse">
                    <div class="h-6 bg-slate-100 rounded w-3/4 ml-auto"></div>
                    <div class="h-3 bg-slate-100 rounded w-full"></div>
                    <div class="h-3 bg-slate-100 rounded w-2/3"></div>
                </div>
            </template>
        </div>

        <!-- Error State -->
        <div x-show="error && !loading" x-cloak class="bg-white rounded-3xl border border-rose-100 p-6 text-center space-y-3">
            <p class="text-sm font-bold text-slate-700" x-text="error"></p>
            <button type="button" @click="fetchSurah()"
                    class="inline-flex items-center gap-1.5 bg-[#2B5B84] hover:bg-[#1E4363] text-white text-xs font-extrabold px-5 py-2.5 rounded-full transition">
                Coba Muat Ulang
            </button>
        </div>

        <!-- Surah Content -->
        <template x-if="surah && !loading">
            <div class="space-y-4 sm:space-y-5">

                <!-- Banner Header Surat -->
                <div class="bg-[#2B5B84] rounded-3xl p-5 sm:p-6 text-white border border-[#1E4363] space-y-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="space-y-1">
                            <span class="inline-flex items-center gap-1.5 bg-white/15 text-sky-50 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                <span x-text="surah.tempatTurun === 'Mekah' ? 'Makkiyah' : 'Madaniyah'"></span> • <span x-text="surah.jumlahAyat"></span> Ayat
                            </span>
                            <h2 class="text-xl sm:text-2xl font-extrabold" x-text="surah.namaLatin"></h2>
                            <p class="text-xs sm:text-sm text-sky-100" x-text="surah.arti"></p>
                        </div>
                        <p dir="rtl" class="text-3xl sm:text-4xl font-bold text-white shrink-0 leading-none pt-1"
                           style="font-family: 'Amiri', serif;" x-text="surah.nama"></p>
                    </div>

                    <!-- Audio Full Surat & Navigasi -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 pt-3 border-t border-white/15">
                        <button type="button" @click="toggleFullAudio()"
                                class="inline-flex items-center justify-center gap-2 bg-white text-[#2B5B84] hover:bg-sky-50 font-extrabold text-xs px-4 py-2 rounded-full transition active:scale-95">
                            <svg x-show="!playingFull" class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                            <svg x-show="playingFull" x-cloak class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                            <span x-text="playingFull ? 'Jeda Murottal Surat' : 'Putar Murottal Full Surat'"></span>
                        </button>

                        <div class="flex items-center justify-between sm:justify-end gap-2">
                            <template x-if="surah.suratSebelumnya">
                                <a :href="'{{ url('/islami/quran') }}/' + surah.suratSebelumnya.nomor"
                                   class="text-[11px] font-bold bg-white/15 hover:bg-white/25 text-white px-3.5 py-1.5 rounded-full transition">
                                    ← <span x-text="surah.suratSebelumnya.namaLatin"></span>
                                </a>
                            </template>
                            <template x-if="surah.suratSelanjutnya">
                                <a :href="'{{ url('/islami/quran') }}/' + surah.suratSelanjutnya.nomor"
                                   class="text-[11px] font-bold bg-white/15 hover:bg-white/25 text-white px-3.5 py-1.5 rounded-full transition">
                                    <span x-text="surah.suratSelanjutnya.namaLatin"></span> →
                                </a>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Bismillah (kecuali Al-Fatihah & At-Taubah) -->
                <div x-show="surah.nomor !== 1 && surah.nomor !== 9"
                     class="bg-white rounded-2xl border border-[#E2EEF6] py-4 px-5 text-center">
                    <p dir="rtl" class="text-2xl sm:text-3xl font-bold text-[#2B5B84]" style="font-family: 'Amiri', serif;">
                        بِسْمِ اللّٰهِ الرَّحْمٰنِ الرَّحِيْمِ
                    </p>
                </div>

                <!-- Daftar Ayat -->
                <div class="space-y-3 sm:space-y-4">
                    <template x-for="ayat in surah.ayat" :key="ayat.nomorAyat">
                        <div :id="'ayat-' + ayat.nomorAyat"
                             :class="lastReadAyat === ayat.nomorAyat ? 'border-[#2B5B84] ring-1 ring-[#2B5B84]/20' : 'border-[#E2EEF6]'"
                             class="bg-white rounded-3xl border p-4 sm:p-6 space-y-4 scroll-mt-20 transition">

                            <!-- Baris Aksi Ayat -->
                            <div class="flex items-center justify-between gap-2 pb-2.5 border-b border-slate-100">
                                <span class="inline-flex items-center justify-center min-w-[2.2rem] h-8 px-2.5 rounded-xl bg-[#F0F6FA] text-[#2B5B84] font-black text-xs"
                                      x-text="surah.nomor + ':' + ayat.nomorAyat"></span>

                                <div class="flex items-center gap-1.5">
                                    <!-- Audio Ayat -->
                                    <button type="button" @click="toggleAyatAudio(ayat)"
                                            :class="playingAyat === ayat.nomorAyat ? 'bg-[#2B5B84] text-white' : 'bg-[#F0F6FA] text-[#2B5B84] hover:bg-[#E2EEF6]'"
                                            class="w-8 h-8 rounded-full flex items-center justify-center transition active:scale-95"
                                            title="Putar Audio Ayat">
                                        <svg x-show="playingAyat !== ayat.nomorAyat" class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                        <svg x-show="playingAyat === ayat.nomorAyat" x-cloak class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z"/></svg>
                                    </button>

                                    <!-- Tandai Terakhir Dibaca -->
                                    <button type="button" @click="bookmarkAyat(ayat.nomorAyat)"
                                            :class="lastReadAyat === ayat.nomorAyat ? 'bg-[#155E4B] text-white' : 'bg-[#F0F6FA] text-slate-600 hover:bg-[#E2EEF6]'"
                                            class="w-8 h-8 rounded-full flex items-center justify-center transition active:scale-95"
                                            title="Tandai Terakhir Dibaca">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                        </svg>
                                    </button>

                                    <!-- Tombol Buka Tafsir -->
                                    <button type="button" @click="openTafsir(ayat.nomorAyat)"
                                            class="inline-flex items-center gap-1.5 bg-[#2B5B84] hover:bg-[#1E4363] text-white text-[11px] font-extrabold px-3.5 py-1.5 rounded-full transition active:scale-95">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                        </svg>
                                        <span>Tafsir</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Teks Arab -->
                            <p dir="rtl"
                               :class="arabSizeClass"
                               class="text-right font-bold text-slate-900 leading-[2.2] py-1"
                               style="font-family: 'Amiri', serif;"
                               x-text="ayat.teksArab"></p>

                            <!-- Transliterasi Latin -->
                            <p x-show="showLatin"
                               class="text-xs sm:text-sm font-semibold text-[#2B5B84] leading-relaxed"
                               x-text="ayat.teksLatin"></p>

                            <!-- Terjemahan Indonesia -->
                            <p x-show="showTranslation"
                               class="text-xs sm:text-sm text-slate-600 leading-relaxed"
                               x-text="ayat.teksIndonesia"></p>
                        </div>
                    </template>
                </div>

                <!-- Navigasi Bawah Surat -->
                <div class="flex items-center justify-between gap-3 pt-2">
                    <template x-if="surah.suratSebelumnya">
                        <a :href="'{{ url('/islami/quran') }}/' + surah.suratSebelumnya.nomor"
                           class="flex-1 bg-white hover:bg-[#F0F6FA] border border-[#E2EEF6] rounded-2xl p-3.5 text-left transition">
                            <span class="text-[10px] font-bold text-slate-400 block">Surat Sebelumnya</span>
                            <span class="text-xs sm:text-sm font-extrabold text-[#2B5B84]" x-text="'← ' + surah.suratSebelumnya.namaLatin"></span>
                        </a>
                    </template>
                    <template x-if="surah.suratSelanjutnya">
                        <a :href="'{{ url('/islami/quran') }}/' + surah.suratSelanjutnya.nomor"
                           class="flex-1 bg-white hover:bg-[#F0F6FA] border border-[#E2EEF6] rounded-2xl p-3.5 text-right transition">
                            <span class="text-[10px] font-bold text-slate-400 block">Surat Berikutnya</span>
                            <span class="text-xs sm:text-sm font-extrabold text-[#2B5B84]" x-text="surah.suratSelanjutnya.namaLatin + ' →'"></span>
                        </a>
                    </template>
                </div>

            </div>
        </template>
    </main>

    <!-- MODAL / DRAWER TAFSIR MULTI-KITAB -->
    <div x-show="tafsirOpen" x-cloak
         class="fixed inset-0 z-50 flex items-end sm:items-center justify-center bg-slate-900/50 p-0 sm:p-4"
         @keydown.escape.window="tafsirOpen = false">

        <div class="bg-white w-full sm:max-w-2xl rounded-t-3xl sm:rounded-3xl border border-[#E2EEF6] shadow-2xl flex flex-col max-h-[90vh]"
             @click.away="tafsirOpen = false">

            <!-- Modal Header -->
            <div class="p-4 sm:p-5 border-b border-[#E2EEF6] flex items-center justify-between gap-3 shrink-0">
                <div class="min-w-0">
                    <p class="text-[10px] font-extrabold uppercase tracking-wider text-[#2B5B84]">Tafsir Al-Qur'an</p>
                    <h3 class="text-sm sm:text-base font-extrabold text-slate-800 truncate">
                        QS. <span x-text="surah?.namaLatin"></span> : Ayat <span x-text="activeAyat"></span>
                    </h3>
                </div>

                <div class="flex items-center gap-1.5 shrink-0">
                    <button type="button" @click="stepTafsirAyat(-1)" :disabled="activeAyat <= 1"
                            class="w-8 h-8 rounded-full bg-[#F0F6FA] hover:bg-[#E2EEF6] disabled:opacity-40 text-[#2B5B84] flex items-center justify-center text-xs font-bold transition"
                            title="Ayat Sebelumnya">←</button>
                    <button type="button" @click="stepTafsirAyat(1)" :disabled="!surah || activeAyat >= surah.jumlahAyat"
                            class="w-8 h-8 rounded-full bg-[#F0F6FA] hover:bg-[#E2EEF6] disabled:opacity-40 text-[#2B5B84] flex items-center justify-center text-xs font-bold transition"
                            title="Ayat Berikutnya">→</button>
                    <button type="button" @click="tafsirOpen = false"
                            class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center text-xs font-bold ml-1 transition">
                        ✕
                    </button>
                </div>
            </div>

            <!-- Tabs Kitab Tafsir -->
            <div class="px-4 sm:px-5 pt-3 pb-2 border-b border-slate-100 bg-[#F7FAFC] shrink-0 space-y-2.5">
                <div class="grid grid-cols-3 gap-1.5 bg-white p-1 rounded-2xl border border-[#E2EEF6]">
                    <button type="button" @click="switchTafsirTab('kemenag')"
                            :class="tafsirTab === 'kemenag' ? 'bg-[#2B5B84] text-white' : 'text-slate-600 hover:text-[#2B5B84]'"
                            class="py-2 px-2 rounded-xl text-[11px] sm:text-xs font-extrabold transition truncate">
                        Kemenag RI
                    </button>
                    <button type="button" @click="switchTafsirTab('ibnu_katsir')"
                            :class="tafsirTab === 'ibnu_katsir' ? 'bg-[#2B5B84] text-white' : 'text-slate-600 hover:text-[#2B5B84]'"
                            class="py-2 px-2 rounded-xl text-[11px] sm:text-xs font-extrabold transition truncate">
                        Ibnu Katsir
                    </button>
                    <button type="button" @click="switchTafsirTab('as_sadi')"
                            :class="tafsirTab === 'as_sadi' ? 'bg-[#2B5B84] text-white' : 'text-slate-600 hover:text-[#2B5B84]'"
                            class="py-2 px-2 rounded-xl text-[11px] sm:text-xs font-extrabold transition truncate">
                        As-Sa'di
                    </button>
                </div>

                <!-- Pilihan Bahasa Khusus Ibnu Katsir & As-Sa'di -->
                <div x-show="tafsirTab === 'ibnu_katsir'" class="flex items-center justify-between text-[11px]">
                    <span class="font-bold text-slate-500">Bahasa Tafsir Ibnu Katsir:</span>
                    <div class="flex items-center gap-1">
                        <button type="button" @click="ibnKathirLang = 'ar'; loadCurrentTafsir()"
                                :class="ibnKathirLang === 'ar' ? 'bg-[#2B5B84] text-white' : 'bg-white text-slate-600 border border-[#E2EEF6]'"
                                class="px-2.5 py-1 rounded-lg font-bold transition">Arab</button>
                        <button type="button" @click="ibnKathirLang = 'en'; loadCurrentTafsir()"
                                :class="ibnKathirLang === 'en' ? 'bg-[#2B5B84] text-white' : 'bg-white text-slate-600 border border-[#E2EEF6]'"
                                class="px-2.5 py-1 rounded-lg font-bold transition">Inggris</button>
                    </div>
                </div>

                <div x-show="tafsirTab === 'as_sadi'" class="flex items-center justify-between text-[11px]">
                    <span class="font-bold text-slate-500">Bahasa Tafsir As-Sa'di:</span>
                    <div class="flex items-center gap-1">
                        <button type="button" @click="sadiLang = 'id'; loadCurrentTafsir()"
                                :class="sadiLang === 'id' ? 'bg-[#2B5B84] text-white' : 'bg-white text-slate-600 border border-[#E2EEF6]'"
                                class="px-2.5 py-1 rounded-lg font-bold transition">Indonesia</button>
                        <button type="button" @click="sadiLang = 'ar'; loadCurrentTafsir()"
                                :class="sadiLang === 'ar' ? 'bg-[#2B5B84] text-white' : 'bg-white text-slate-600 border border-[#E2EEF6]'"
                                class="px-2.5 py-1 rounded-lg font-bold transition">Arab</button>
                    </div>
                </div>
            </div>

            <!-- Isi Tafsir (Scrollable) -->
            <div class="p-4 sm:p-6 overflow-y-auto space-y-4 flex-1">
                <!-- Ringkasan Ayat -->
                <template x-if="currentAyatObj">
                    <div class="bg-[#F0F6FA] rounded-2xl p-3.5 border border-[#D6E6F2] space-y-2">
                        <p dir="rtl" class="text-right text-lg sm:text-xl font-bold text-[#2B5B84] leading-loose"
                           style="font-family: 'Amiri', serif;" x-text="currentAyatObj.teksArab"></p>
                        <p class="text-xs text-slate-600 leading-relaxed" x-text="currentAyatObj.teksIndonesia"></p>
                    </div>
                </template>

                <!-- Loading Tafsir -->
                <div x-show="tafsirLoading" class="py-8 text-center space-y-2">
                    <div class="w-7 h-7 border-2 border-[#2B5B84] border-t-transparent rounded-full animate-spin mx-auto"></div>
                    <p class="text-xs font-bold text-slate-500">Memuat teks tafsir...</p>
                </div>

                <!-- Error Tafsir -->
                <div x-show="tafsirError && !tafsirLoading" class="bg-rose-50 border border-rose-100 rounded-2xl p-4 text-center space-y-2">
                    <p class="text-xs font-bold text-rose-700" x-text="tafsirError"></p>
                    <button type="button" @click="loadCurrentTafsir()" class="text-xs font-extrabold text-[#2B5B84] hover:underline">
                        Coba Muat Ulang
                    </button>
                </div>

                <!-- Teks Tafsir -->
                <div x-show="!tafsirLoading && !tafsirError" class="space-y-2">
                    <div :dir="isRtlTafsir ? 'rtl' : 'ltr'"
                         :class="isRtlTafsir ? 'text-right text-lg leading-[2.1]' : 'text-left text-xs sm:text-sm leading-relaxed'"
                         :style="isRtlTafsir ? 'font-family: Amiri, serif;' : ''"
                         class="text-slate-700 whitespace-pre-line"
                         x-text="tafsirText">
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Audio Element -->
    <audio x-ref="audioPlayer" @ended="onAudioEnded()" class="hidden"></audio>

    <script>
        function quranShowApp(surahNumber) {
            return {
                surahNumber,
                surah: null,
                loading: true,
                error: null,

                // Preferensi tampilan
                settingsOpen: false,
                showLatin: true,
                showTranslation: true,
                arabSize: 'large',
                lastReadAyat: null,

                // Audio
                playingFull: false,
                playingAyat: null,

                // Tafsir
                tafsirOpen: false,
                tafsirTab: 'kemenag',
                ibnKathirLang: 'ar',
                sadiLang: 'id',
                activeAyat: 1,
                tafsirLoading: false,
                tafsirError: null,
                tafsirText: '',
                tafsirCache: {},

                init() {
                    try {
                        const prefs = JSON.parse(localStorage.getItem('alfutuh_quran_prefs') || '{}');
                        if (typeof prefs.showLatin === 'boolean') this.showLatin = prefs.showLatin;
                        if (typeof prefs.showTranslation === 'boolean') this.showTranslation = prefs.showTranslation;
                        if (prefs.arabSize) this.arabSize = prefs.arabSize;

                        const lastRead = JSON.parse(localStorage.getItem('alfutuh_quran_last_read') || 'null');
                        if (lastRead && lastRead.surah === this.surahNumber) {
                            this.lastReadAyat = lastRead.ayat;
                        }
                    } catch (e) {}

                    this.fetchSurah();
                },

                savePrefs() {
                    try {
                        localStorage.setItem('alfutuh_quran_prefs', JSON.stringify({
                            showLatin: this.showLatin,
                            showTranslation: this.showTranslation,
                            arabSize: this.arabSize,
                        }));
                    } catch (e) {}
                },

                get arabSizeClass() {
                    if (this.arabSize === 'normal') return 'text-2xl sm:text-3xl';
                    if (this.arabSize === 'xlarge') return 'text-4xl sm:text-5xl';
                    return 'text-3xl sm:text-4xl';
                },

                get currentAyatObj() {
                    if (!this.surah || !this.surah.ayat) return null;
                    return this.surah.ayat.find(a => a.nomorAyat === this.activeAyat) || null;
                },

                get isRtlTafsir() {
                    if (this.tafsirTab === 'ibnu_katsir' && this.ibnKathirLang === 'ar') return true;
                    if (this.tafsirTab === 'as_sadi' && this.sadiLang === 'ar') return true;
                    return false;
                },

                async fetchSurah() {
                    this.loading = true;
                    this.error = null;
                    try {
                        const res = await fetch('https://equran.id/api/v2/surat/' + this.surahNumber);
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        const json = await res.json();
                        if (!json || !json.data) throw new Error('Format tidak valid');
                        this.surah = json.data;

                        this.$nextTick(() => {
                            if (window.location.hash && window.location.hash.startsWith('#ayat-')) {
                                const el = document.querySelector(window.location.hash);
                                if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                        });
                    } catch (err) {
                        this.error = 'Gagal memuat surat. Pastikan koneksi internet aktif.';
                    } finally {
                        this.loading = false;
                    }
                },

                bookmarkAyat(nomorAyat) {
                    this.lastReadAyat = nomorAyat;
                    try {
                        localStorage.setItem('alfutuh_quran_last_read', JSON.stringify({
                            surah: this.surah.nomor,
                            namaLatin: this.surah.namaLatin,
                            ayat: nomorAyat,
                            ts: Date.now()
                        }));
                    } catch (e) {}
                },

                pickAudioUrl(audioObj) {
                    if (!audioObj) return null;
                    return audioObj['05'] || audioObj['01'] || Object.values(audioObj)[0] || null;
                },

                toggleFullAudio() {
                    const player = this.$refs.audioPlayer;
                    if (this.playingFull) {
                        player.pause();
                        this.playingFull = false;
                        return;
                    }
                    const url = this.pickAudioUrl(this.surah?.audioFull);
                    if (!url) return;
                    this.playingAyat = null;
                    player.src = url;
                    player.play();
                    this.playingFull = true;
                },

                toggleAyatAudio(ayat) {
                    const player = this.$refs.audioPlayer;
                    if (this.playingAyat === ayat.nomorAyat) {
                        player.pause();
                        this.playingAyat = null;
                        return;
                    }
                    const url = this.pickAudioUrl(ayat.audio);
                    if (!url) return;
                    this.playingFull = false;
                    player.src = url;
                    player.play();
                    this.playingAyat = ayat.nomorAyat;
                },

                onAudioEnded() {
                    this.playingFull = false;
                    this.playingAyat = null;
                },

                openTafsir(nomorAyat) {
                    this.activeAyat = nomorAyat;
                    this.tafsirOpen = true;
                    this.loadCurrentTafsir();
                },

                stepTafsirAyat(delta) {
                    const next = this.activeAyat + delta;
                    if (!this.surah || next < 1 || next > this.surah.jumlahAyat) return;
                    this.activeAyat = next;
                    this.loadCurrentTafsir();
                },

                switchTafsirTab(tab) {
                    this.tafsirTab = tab;
                    this.loadCurrentTafsir();
                },

                cleanText(raw) {
                    if (!raw) return '';
                    // Strip HTML tags safely and normalize spacing
                    const tmp = document.createElement('div');
                    tmp.innerHTML = String(raw).replace(/<br\s*\/?>/gi, '\n').replace(/<\/p>/gi, '\n\n');
                    return (tmp.textContent || tmp.innerText || '').trim();
                },

                async loadCurrentTafsir() {
                    this.tafsirLoading = true;
                    this.tafsirError = null;
                    this.tafsirText = '';

                    try {
                        if (this.tafsirTab === 'kemenag') {
                            const data = await this.fetchCached('kemenag', async () => {
                                const res = await fetch('https://equran.id/api/v2/tafsir/' + this.surahNumber);
                                if (!res.ok) throw new Error('HTTP ' + res.status);
                                const json = await res.json();
                                return json?.data?.tafsir || [];
                            });
                            const found = data.find(item => Number(item.ayat) === Number(this.activeAyat));
                            this.tafsirText = found ? this.cleanText(found.teks) : 'Tafsir Kemenag RI untuk ayat ini belum tersedia.';
                        } else if (this.tafsirTab === 'ibnu_katsir') {
                            const slug = this.ibnKathirLang === 'en' ? 'en-tafisr-ibn-kathir' : 'ar-tafsir-ibn-kathir';
                            const data = await this.fetchCached('ik_' + this.ibnKathirLang, async () => {
                                const res = await fetch(`https://cdn.jsdelivr.net/gh/spa5k/tafsir_api@1/tafsir/${slug}/${this.surahNumber}.json`);
                                if (!res.ok) throw new Error('HTTP ' + res.status);
                                const json = await res.json();
                                return Array.isArray(json) ? json : (json?.ayahs || []);
                            });
                            const found = data.find(item => Number(item.ayah) === Number(this.activeAyat));
                            this.tafsirText = found ? this.cleanText(found.text) : 'Tafsir Ibnu Katsir untuk ayat ini belum tersedia.';
                        } else if (this.tafsirTab === 'as_sadi') {
                            const slug = this.sadiLang === 'id' ? 'id-tafsir-as-saadi' : 'ar-tafseer-al-saddi';
                            const data = await this.fetchCached('sadi_' + this.sadiLang, async () => {
                                const res = await fetch(`https://cdn.jsdelivr.net/gh/spa5k/tafsir_api@1/tafsir/${slug}/${this.surahNumber}.json`);
                                if (!res.ok) throw new Error('HTTP ' + res.status);
                                const json = await res.json();
                                return Array.isArray(json) ? json : (json?.ayahs || []);
                            });
                            const found = data.find(item => Number(item.ayah) === Number(this.activeAyat));
                            this.tafsirText = found ? this.cleanText(found.text) : 'Tafsir As-Sa\'di untuk ayat ini belum tersedia pada bahasa yang dipilih. Silakan coba ganti ke bahasa Arab.';
                        }
                    } catch (err) {
                        this.tafsirError = 'Gagal memuat tafsir. Pastikan koneksi internet aktif atau coba bahasa lain.';
                    } finally {
                        this.tafsirLoading = false;
                    }
                },

                async fetchCached(key, fetcher) {
                    if (this.tafsirCache[key]) return this.tafsirCache[key];
                    const data = await fetcher();
                    this.tafsirCache[key] = data;
                    return data;
                }
            };
        }
    </script>
</body>
</html>
