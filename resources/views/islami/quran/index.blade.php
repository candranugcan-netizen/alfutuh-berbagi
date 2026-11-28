<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Al-Qur'an Digital & Tafsir - Al Futuh</title>

    <link rel="icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#2B5B84">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=manrope:500,600,700,800&family=amiri:400,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F7FAFC] text-slate-800 pb-16 min-h-screen"
      x-data="quranIndexApp()"
      x-init="init()">

    <!-- Top Header -->
    <header class="bg-white sticky top-0 z-40 border-b border-[#E2EEF6]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
                <a href="{{ route('islami.index') }}"
                   class="w-9 h-9 rounded-full bg-[#F0F6FA] hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] shrink-0 transition active:scale-95"
                   aria-label="Kembali ke Fitur Islami">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <div class="min-w-0">
                    <h1 class="font-extrabold text-base sm:text-lg text-[#2B5B84] leading-none truncate">Al-Qur'an Digital</h1>
                    <p class="text-[10px] font-bold text-slate-400 mt-0.5 truncate">Terjemah &amp; Tafsir Kemenag, Ibnu Katsir, As-Sa'di</p>
                </div>
            </div>

            <a href="{{ route('islami.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#2B5B84] hover:bg-[#E2EEF6] bg-[#F0F6FA] border border-[#D6E6F2] px-3.5 py-1.5 rounded-full transition shrink-0">
                <span>Fitur Islami</span>
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 pt-5 space-y-5">

        <!-- Hero & Pencarian -->
        <div class="bg-[#2B5B84] rounded-3xl p-5 sm:p-6 text-white border border-[#1E4363] space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <span class="inline-flex items-center gap-1.5 bg-white/15 text-sky-50 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                        114 Surat • 30 Juz
                    </span>
                    <h2 class="text-lg sm:text-xl font-extrabold mt-1.5">Baca Al-Qur'an &amp; Tadabbur Tafsir</h2>
                    <p class="text-xs text-sky-100/90 mt-0.5">Lengkap dengan murottal, terjemahan Indonesia, serta tafsir Kemenag RI, Ibnu Katsir, dan As-Sa'di.</p>
                </div>
            </div>

            <!-- Search & Filter -->
            <div class="flex flex-col sm:flex-row gap-2.5">
                <div class="relative flex-1">
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="11" cy="11" r="7" stroke-width="2"/>
                        <path d="m20 20-3.5-3.5" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input type="text"
                           x-model="search"
                           placeholder="Cari nama surat, arti, atau nomor (misal: Al-Kahfi, 18)..."
                           class="w-full pl-10 pr-9 py-2.5 rounded-2xl bg-white text-slate-800 placeholder-slate-400 text-xs sm:text-sm font-medium border-0 focus:ring-2 focus:ring-sky-300">
                    <button type="button" x-show="search.length > 0" @click="search = ''"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 text-xs font-bold">
                        ✕
                    </button>
                </div>

                <div class="flex items-center gap-1.5 bg-[#1E4363] p-1 rounded-2xl shrink-0">
                    <button type="button" @click="filterType = 'all'"
                            :class="filterType === 'all' ? 'bg-white text-[#2B5B84]' : 'text-sky-100 hover:text-white'"
                            class="px-3 py-1.5 rounded-xl text-xs font-extrabold transition">Semua</button>
                    <button type="button" @click="filterType = 'Mekah'"
                            :class="filterType === 'Mekah' ? 'bg-white text-[#2B5B84]' : 'text-sky-100 hover:text-white'"
                            class="px-3 py-1.5 rounded-xl text-xs font-extrabold transition">Makkiyah</button>
                    <button type="button" @click="filterType = 'Madinah'"
                            :class="filterType === 'Madinah' ? 'bg-white text-[#2B5B84]' : 'text-sky-100 hover:text-white'"
                            class="px-3 py-1.5 rounded-xl text-xs font-extrabold transition">Madaniyah</button>
                </div>
            </div>
        </div>

        <!-- Terakhir Dibaca -->
        <template x-if="lastRead">
            <a :href="'{{ url('/islami/quran') }}/' + lastRead.surah + '#ayat-' + lastRead.ayat"
               class="flex items-center justify-between gap-3 bg-white hover:bg-[#F0F6FA] border border-[#D6E6F2] rounded-2xl p-3.5 sm:p-4 transition active:scale-[0.99]">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-xl bg-[#F0F6FA] text-[#2B5B84] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-extrabold uppercase tracking-wider text-[#2B5B84]">Terakhir Dibaca</p>
                        <p class="text-xs sm:text-sm font-extrabold text-slate-800 truncate">
                            QS. <span x-text="lastRead.namaLatin"></span> : Ayat <span x-text="lastRead.ayat"></span>
                        </p>
                    </div>
                </div>
                <span class="text-xs font-extrabold text-[#2B5B84] bg-[#F0F6FA] px-3 py-1.5 rounded-full shrink-0">
                    Lanjutkan →
                </span>
            </a>
        </template>

        <!-- Loading State -->
        <div x-show="loading" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            <template x-for="i in 9" :key="i">
                <div class="bg-white rounded-2xl border border-[#E2EEF6] p-4 animate-pulse flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-slate-100"></div>
                        <div class="space-y-2">
                            <div class="h-3.5 w-28 bg-slate-100 rounded"></div>
                            <div class="h-2.5 w-20 bg-slate-100 rounded"></div>
                        </div>
                    </div>
                    <div class="h-6 w-14 bg-slate-100 rounded"></div>
                </div>
            </template>
        </div>

        <!-- Error State -->
        <div x-show="error && !loading" x-cloak class="bg-white rounded-3xl border border-rose-100 p-6 text-center space-y-3">
            <p class="text-sm font-bold text-slate-700" x-text="error"></p>
            <button type="button" @click="fetchSurahs(true)"
                    class="inline-flex items-center gap-1.5 bg-[#2B5B84] hover:bg-[#1E4363] text-white text-xs font-extrabold px-5 py-2.5 rounded-full transition">
                Coba Muat Ulang
            </button>
        </div>

        <!-- Grid 114 Surat -->
        <div x-show="!loading && !error" x-cloak class="space-y-3">
            <div class="flex items-center justify-between px-1">
                <p class="text-xs font-bold text-slate-500">
                    Menampilkan <span class="text-[#2B5B84] font-extrabold" x-text="filteredSurahs.length"></span> surat
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2.5 sm:gap-3">
                <template x-for="s in filteredSurahs" :key="s.nomor">
                    <a :href="'{{ url('/islami/quran') }}/' + s.nomor"
                       class="group bg-white hover:bg-[#F7FAFD] rounded-2xl border border-[#E2EEF6] hover:border-[#2B5B84] p-3.5 sm:p-4 flex items-center justify-between gap-3 transition active:scale-[0.99]">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl bg-[#F0F6FA] group-hover:bg-[#2B5B84] text-[#2B5B84] group-hover:text-white font-black text-xs flex items-center justify-center shrink-0 transition"
                                 x-text="s.nomor">
                            </div>
                            <div class="min-w-0">
                                <h3 class="text-sm font-extrabold text-slate-800 group-hover:text-[#2B5B84] truncate" x-text="s.namaLatin"></h3>
                                <p class="text-[11px] text-slate-500 truncate">
                                    <span x-text="s.arti"></span> • <span x-text="s.jumlahAyat"></span> Ayat
                                </p>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <p dir="rtl" class="text-lg font-bold text-[#2B5B84] leading-none" style="font-family: 'Amiri', serif;" x-text="s.nama"></p>
                            <span class="text-[9px] font-bold text-slate-400 uppercase" x-text="s.tempatTurun === 'Mekah' ? 'Makkiyah' : 'Madaniyah'"></span>
                        </div>
                    </a>
                </template>
            </div>

            <div x-show="filteredSurahs.length === 0" class="bg-white rounded-3xl border border-[#E2EEF6] p-8 text-center">
                <p class="text-sm font-bold text-slate-600">Surat tidak ditemukan.</p>
                <p class="text-xs text-slate-400 mt-1">Coba kata kunci lain atau reset filter pencarian.</p>
            </div>
        </div>

    </main>

    <script>
        function quranIndexApp() {
            return {
                surahs: [],
                loading: true,
                error: null,
                search: '',
                filterType: 'all',
                lastRead: null,

                init() {
                    try {
                        const saved = localStorage.getItem('alfutuh_quran_last_read');
                        if (saved) this.lastRead = JSON.parse(saved);
                    } catch (e) {}

                    this.fetchSurahs(false);
                },

                async fetchSurahs(forceRefresh = false) {
                    this.loading = true;
                    this.error = null;

                    const cacheKey = 'alfutuh_quran_surahs_v1';
                    if (!forceRefresh) {
                        try {
                            const cached = localStorage.getItem(cacheKey);
                            if (cached) {
                                const parsed = JSON.parse(cached);
                                if (parsed && Array.isArray(parsed.data) && (Date.now() - parsed.ts) < 7 * 86400 * 1000) {
                                    this.surahs = parsed.data;
                                    this.loading = false;
                                    return;
                                }
                            }
                        } catch (e) {}
                    }

                    try {
                        const res = await fetch('https://equran.id/api/v2/surat');
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        const json = await res.json();
                        if (!json || !Array.isArray(json.data)) throw new Error('Format data tidak valid');

                        this.surahs = json.data;
                        try {
                            localStorage.setItem(cacheKey, JSON.stringify({ ts: Date.now(), data: json.data }));
                        } catch (e) {}
                    } catch (err) {
                        this.error = 'Gagal memuat daftar surat Al-Qur\'an. Pastikan koneksi internet aktif.';
                    } finally {
                        this.loading = false;
                    }
                },

                get filteredSurahs() {
                    const q = this.search.trim().toLowerCase();
                    return this.surahs.filter(s => {
                        if (this.filterType !== 'all' && s.tempatTurun !== this.filterType) {
                            return false;
                        }
                        if (!q) return true;
                        return (
                            String(s.nomor) === q ||
                            (s.namaLatin && s.namaLatin.toLowerCase().includes(q)) ||
                            (s.arti && s.arti.toLowerCase().includes(q))
                        );
                    });
                }
            };
        }
    </script>
</body>
</html>
