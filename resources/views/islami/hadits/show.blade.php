<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>{{ $bookInfo['nama'] }} - Hadits Al Futuh</title>

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
      x-data="haditsShowApp(@js($bookInfo))"
      x-init="init()">

    <!-- Top Sticky Header -->
    <header class="bg-white sticky top-0 z-40 border-b border-[#E2EEF6]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-2">
            <div class="flex items-center gap-2.5 min-w-0">
                <a href="{{ route('islami.hadits.index') }}"
                   class="w-9 h-9 rounded-full bg-[#F0F6FA] hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] shrink-0 transition active:scale-95"
                   aria-label="Kembali ke Daftar Kitab">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <div class="min-w-0">
                    <h1 class="font-extrabold text-sm sm:text-base text-[#2B5B84] leading-tight truncate">{{ $bookInfo['nama'] }}</h1>
                    <p class="text-[10px] font-bold text-slate-400 truncate">
                        Halaman <span x-text="page"></span> • Arab &amp; Terjemah Indonesia
                    </p>
                </div>
            </div>

            <!-- Pengaturan Tampilan -->
            <div class="relative">
                <button type="button" @click="settingsOpen = !settingsOpen"
                        class="inline-flex items-center gap-1.5 text-xs font-bold text-[#2B5B84] bg-[#F0F6FA] hover:bg-[#E2EEF6] border border-[#D6E6F2] px-3 py-1.5 rounded-full transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                    <span class="hidden sm:inline">Tampilan</span>
                </button>

                <div x-show="settingsOpen" @click.away="settingsOpen = false" x-cloak
                     class="absolute right-0 top-11 w-64 bg-white rounded-2xl border border-[#E2EEF6] shadow-lg p-4 space-y-3 z-50">
                    <p class="text-xs font-extrabold text-[#2B5B84]">Pengaturan Baca</p>

                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-xs font-semibold text-slate-700">Tampilkan Teks Arab</span>
                        <input type="checkbox" x-model="showArab" @change="savePrefs()" class="rounded text-[#2B5B84] focus:ring-[#2B5B84]">
                    </label>

                    <label class="flex items-center justify-between cursor-pointer">
                        <span class="text-xs font-semibold text-slate-700">Tampilkan Terjemah ID</span>
                        <input type="checkbox" x-model="showIndo" @change="savePrefs()" class="rounded text-[#2B5B84] focus:ring-[#2B5B84]">
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

        <!-- Banner Kitab & Loncat Nomor Hadits -->
        <div class="bg-[#2B5B84] rounded-3xl p-5 sm:p-6 text-white border border-[#1E4363] space-y-4">
            <div class="flex items-start justify-between gap-4">
                <div class="space-y-1">
                    <span class="inline-flex items-center gap-1.5 bg-white/15 text-sky-50 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                        {{ $bookInfo['kategori'] }} • <span x-text="totalAvailable.toLocaleString('id-ID')"></span> Hadits
                    </span>
                    <h2 class="text-xl sm:text-2xl font-extrabold">{{ $bookInfo['nama'] }}</h2>
                    <p class="text-xs text-sky-100/90">{{ $bookInfo['imam'] }}</p>
                </div>
                <p dir="rtl" class="text-2xl sm:text-3xl font-bold text-white shrink-0 leading-none pt-1"
                   style="font-family: 'Amiri', serif;">{{ $bookInfo['arab'] }}</p>
            </div>

            <!-- Cari di seluruh kitab & Loncat ke Nomor Hadits -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 pt-2 border-t border-white/15">
                <div class="relative">
                    <input type="text"
                           x-model="keyword"
                           @input="page = 1"
                           placeholder="Cari kata di seluruh kitab..."
                           class="w-full px-3.5 py-2 rounded-2xl bg-white text-slate-800 placeholder-slate-400 text-xs font-medium border-0 focus:ring-2 focus:ring-sky-300">
                </div>

                <form @submit.prevent="jumpToNumber()" class="flex items-center gap-1.5">
                    <input type="number"
                           x-model="jumpNumber"
                           min="1"
                           :max="totalAvailable"
                           placeholder="Loncat ke No. Hadits (misal: 50)"
                           class="w-full px-3.5 py-2 rounded-2xl bg-white text-slate-800 placeholder-slate-400 text-xs font-medium border-0 focus:ring-2 focus:ring-sky-300">
                    <button type="submit"
                            class="bg-white text-[#2B5B84] hover:bg-sky-50 font-extrabold text-xs px-4 py-2 rounded-2xl shrink-0 transition active:scale-95">
                        Buka
                    </button>
                </form>
            </div>
        </div>

        <!-- Navigasi Paginasi Atas -->
        <div class="flex items-center justify-between gap-2 bg-white rounded-2xl border border-[#E2EEF6] px-4 py-2.5">
            <button type="button" @click="changePage(page - 1)" :disabled="page <= 1 || loading"
                    class="text-xs font-extrabold text-[#2B5B84] disabled:opacity-40 hover:underline">
                ← Sebelumnya
            </button>
            <span class="text-xs font-bold text-slate-600">
                Hadits <span class="text-[#2B5B84] font-extrabold" x-text="rangeStart + ' - ' + rangeEnd"></span>
                <span class="text-slate-400">dari <span x-text="totalFiltered.toLocaleString('id-ID')"></span></span>
            </span>
            <button type="button" @click="changePage(page + 1)" :disabled="rangeEnd >= totalFiltered || loading"
                    class="text-xs font-extrabold text-[#2B5B84] disabled:opacity-40 hover:underline">
                Berikutnya →
            </button>
        </div>

        <!-- Loading State -->
        <div x-show="loading" class="space-y-4">
            <template x-for="i in 4" :key="i">
                <div class="bg-white rounded-3xl border border-[#E2EEF6] p-5 space-y-3 animate-pulse">
                    <div class="h-4 bg-slate-100 rounded w-32"></div>
                    <div class="h-6 bg-slate-100 rounded w-5/6 ml-auto"></div>
                    <div class="h-3 bg-slate-100 rounded w-full"></div>
                    <div class="h-3 bg-slate-100 rounded w-3/4"></div>
                </div>
            </template>
        </div>

        <!-- Error State -->
        <div x-show="error && !loading" x-cloak class="bg-white rounded-3xl border border-rose-100 p-6 text-center space-y-3">
            <p class="text-sm font-bold text-slate-700" x-text="error"></p>
            <button type="button" @click="fetchHadiths()"
                    class="inline-flex items-center gap-1.5 bg-[#2B5B84] hover:bg-[#1E4363] text-white text-xs font-extrabold px-5 py-2.5 rounded-full transition">
                Coba Muat Ulang
            </button>
        </div>

        <!-- Daftar Hadits -->
        <div x-show="!loading && !error" x-cloak class="space-y-3 sm:space-y-4">
            <template x-for="h in filteredHadiths" :key="h.number">
                <article :id="'hadits-' + h.number"
                         :class="highlightedNumber === h.number ? 'border-[#2B5B84] ring-2 ring-[#2B5B84]/20' : 'border-[#E2EEF6]'"
                         class="bg-white rounded-3xl border p-4 sm:p-6 space-y-4 scroll-mt-20 transition">

                    <!-- Header Kartu Hadits -->
                    <div class="flex items-center justify-between gap-2 pb-2.5 border-b border-slate-100">
                        <span class="inline-flex items-center gap-1.5 bg-[#F0F6FA] text-[#2B5B84] font-extrabold text-xs px-3 py-1 rounded-full">
                            <span>{{ $bookInfo['nama'] }}</span>
                            <span>No. <span x-text="h.number"></span></span>
                        </span>

                        <div class="flex items-center gap-1.5">
                            <!-- Salin -->
                            <button type="button" @click="copyHadith(h)"
                                    class="inline-flex items-center gap-1 text-[11px] font-bold px-3 py-1.5 rounded-full transition active:scale-95"
                                    :class="copiedNumber === h.number ? 'bg-[#EAF5EE] text-[#155E4B]' : 'bg-[#F0F6FA] text-[#2B5B84] hover:bg-[#E2EEF6]'">
                                <span x-text="copiedNumber === h.number ? 'Tersalin ✓' : 'Salin'"></span>
                            </button>

                            <!-- Bookmark -->
                            <button type="button" @click="bookmarkHadith(h.number)"
                                    :class="lastReadNumber === h.number ? 'bg-[#155E4B] text-white' : 'bg-[#F0F6FA] text-slate-600 hover:bg-[#E2EEF6]'"
                                    class="w-8 h-8 rounded-full flex items-center justify-center transition active:scale-95"
                                    title="Tandai Terakhir Dibaca">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Teks Arab -->
                    <p x-show="showArab"
                       dir="rtl"
                       :class="arabSizeClass"
                       class="text-right font-bold text-slate-900 leading-[2.2] py-1"
                       style="font-family: 'Amiri', serif;"
                       x-text="h.arab"></p>

                    <!-- Terjemahan Bahasa Indonesia -->
                    <p x-show="showIndo"
                       class="text-xs sm:text-sm text-slate-700 leading-relaxed whitespace-pre-line"
                       x-text="h.id"></p>
                </article>
            </template>

            <div x-show="filteredHadiths.length === 0" class="bg-white rounded-3xl border border-[#E2EEF6] p-8 text-center">
                <p class="text-sm font-bold text-slate-600">Tidak ada hadits yang cocok dengan kata kunci tersebut.</p>
            </div>
        </div>

        <!-- Navigasi Paginasi Bawah -->
        <div x-show="!loading && !error" class="flex items-center justify-between gap-3 pt-1">
            <button type="button" @click="changePage(page - 1)" :disabled="page <= 1"
                    class="flex-1 bg-white hover:bg-[#F0F6FA] disabled:opacity-40 border border-[#E2EEF6] rounded-2xl py-3 px-4 text-xs font-extrabold text-[#2B5B84] transition">
                ← Halaman Sebelumnya
            </button>
            <button type="button" @click="changePage(page + 1)" :disabled="rangeEnd >= totalFiltered"
                    class="flex-1 bg-white hover:bg-[#F0F6FA] disabled:opacity-40 border border-[#E2EEF6] rounded-2xl py-3 px-4 text-xs font-extrabold text-[#2B5B84] transition">
                Halaman Berikutnya →
            </button>
        </div>

    </main>

    <script>
        function haditsShowApp(bookInfo) {
            return {
                bookInfo,
                perPage: 20,
                page: 1,
                totalAvailable: bookInfo.total_default || 1000,
                allHadiths: [],
                loading: true,
                error: null,

                keyword: '',
                jumpNumber: '',
                highlightedNumber: null,
                copiedNumber: null,
                lastReadNumber: null,

                settingsOpen: false,
                showArab: true,
                showIndo: true,
                arabSize: 'normal',

                init() {
                    const params = new URLSearchParams(window.location.search);
                    const p = parseInt(params.get('page') || '1', 10);
                    if (!isNaN(p) && p >= 1) this.page = p;

                    try {
                        const prefs = JSON.parse(localStorage.getItem('alfutuh_hadits_prefs') || '{}');
                        if (typeof prefs.showArab === 'boolean') this.showArab = prefs.showArab;
                        if (typeof prefs.showIndo === 'boolean') this.showIndo = prefs.showIndo;
                        if (prefs.arabSize) this.arabSize = prefs.arabSize;

                        const lastRead = JSON.parse(localStorage.getItem('alfutuh_hadits_last_read') || 'null');
                        if (lastRead && lastRead.slug === this.bookInfo.slug) {
                            this.lastReadNumber = lastRead.number;
                        }
                    } catch (e) {}

                    this.fetchHadiths();
                },

                savePrefs() {
                    try {
                        localStorage.setItem('alfutuh_hadits_prefs', JSON.stringify({
                            showArab: this.showArab,
                            showIndo: this.showIndo,
                            arabSize: this.arabSize,
                        }));
                    } catch (e) {}
                },

                get arabSizeClass() {
                    if (this.arabSize === 'large') return 'text-2xl sm:text-3xl';
                    if (this.arabSize === 'xlarge') return 'text-3xl sm:text-4xl';
                    return 'text-xl sm:text-2xl';
                },

                get filteredAllHadiths() {
                    const q = this.keyword.trim().toLowerCase();
                    if (!q) return this.allHadiths;
                    return this.allHadiths.filter(h =>
                        String(h.number) === q ||
                        (h.id && h.id.toLowerCase().includes(q)) ||
                        (h.arab && h.arab.includes(q))
                    );
                },

                get totalFiltered() {
                    return this.filteredAllHadiths.length;
                },

                get filteredHadiths() {
                    const start = (this.page - 1) * this.perPage;
                    return this.filteredAllHadiths.slice(start, start + this.perPage);
                },

                get rangeStart() {
                    if (this.totalFiltered === 0) return 0;
                    return (this.page - 1) * this.perPage + 1;
                },

                get rangeEnd() {
                    return Math.min(this.page * this.perPage, this.totalFiltered);
                },

                async fetchHadiths() {
                    this.loading = true;
                    this.error = null;

                    try {
                        const cdnBase = 'https://cdn.jsdelivr.net/gh/fawazahmed0/hadith-api@1/editions';
                        const cdnSlug = this.bookInfo.cdn_slug;

                        if (this.bookInfo.slug === 'ahmad') {
                            // Untuk Musnad Ahmad: coba gadingnst/hadith-api terlebih dahulu (ada terjemah ID),
                            // jika gagal fallback ke ara-ahmad + eng-ahmad dari jsDelivr CDN
                            try {
                                const resG = await fetch(`https://api.hadith.gading.dev/books/ahmad?range=1-300`);
                                if (resG.ok) {
                                    const jG = await resG.json();
                                    if (jG?.data?.hadiths?.length) {
                                        this.allHadiths = jG.data.hadiths;
                                        this.totalAvailable = this.allHadiths.length;
                                        this.scrollToHash();
                                        return;
                                    }
                                }
                            } catch (e) {}

                            const [araRes, engRes] = await Promise.all([
                                fetch(`${cdnBase}/ara-ahmad.min.json`),
                                fetch(`${cdnBase}/eng-ahmad.min.json`).catch(() => null),
                            ]);
                            if (!araRes.ok) throw new Error('HTTP ' + araRes.status);
                            const araJson = await araRes.json();
                            const engJson = (engRes && engRes.ok) ? await engRes.json() : { hadiths: [] };

                            const engMap = {};
                            (engJson.hadiths || []).forEach(item => { engMap[item.hadithnumber] = item.text; });

                            this.allHadiths = (araJson.hadiths || []).map(item => ({
                                number: item.hadithnumber,
                                arab: item.text || '',
                                id: engMap[item.hadithnumber] || '(Terjemahan Indonesia Musnad Ahmad sedang tidak tersedia dari server sumber)'
                            }));
                        } else {
                            // Kutubus Sittah: ambil Arab & Indonesia langsung dari jsDelivr CDN
                            const [araRes, indRes] = await Promise.all([
                                fetch(`${cdnBase}/ara-${cdnSlug}.min.json`),
                                fetch(`${cdnBase}/ind-${cdnSlug}.min.json`),
                            ]);
                            if (!araRes.ok || !indRes.ok) throw new Error('Gagal mengambil data dari CDN');

                            const [araJson, indJson] = await Promise.all([araRes.json(), indRes.json()]);
                            const araMap = {};
                            (araJson.hadiths || []).forEach(item => { araMap[item.hadithnumber] = item.text; });

                            this.allHadiths = (indJson.hadiths || []).map(item => ({
                                number: item.hadithnumber,
                                arab: araMap[item.hadithnumber] || '',
                                id: item.text || ''
                            }));
                        }

                        this.totalAvailable = this.allHadiths.length;
                        this.scrollToHash();
                    } catch (err) {
                        this.error = 'Gagal memuat data hadits. Pastikan koneksi internet aktif.';
                    } finally {
                        this.loading = false;
                    }
                },

                scrollToHash() {
                    this.$nextTick(() => {
                        if (window.location.hash && window.location.hash.startsWith('#hadits-')) {
                            const num = parseInt(window.location.hash.replace('#hadits-', ''), 10);
                            if (!isNaN(num)) this.highlightedNumber = num;
                            const el = document.querySelector(window.location.hash);
                            if (el) el.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                    });
                },

                changePage(newPage) {
                    if (newPage < 1) return;
                    this.page = newPage;
                    this.highlightedNumber = null;
                    const url = new URL(window.location.href);
                    url.searchParams.set('page', newPage);
                    url.hash = '';
                    window.history.replaceState({}, '', url);
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                },

                jumpToNumber() {
                    const num = parseInt(this.jumpNumber, 10);
                    if (isNaN(num) || num < 1) return;
                    this.keyword = '';
                    const idx = this.allHadiths.findIndex(h => Number(h.number) === num);
                    const targetPage = idx >= 0 ? Math.floor(idx / this.perPage) + 1 : Math.ceil(num / this.perPage);
                    this.page = targetPage;
                    this.highlightedNumber = num;
                    const url = new URL(window.location.href);
                    url.searchParams.set('page', targetPage);
                    url.hash = '#hadits-' + num;
                    window.history.replaceState({}, '', url);
                    this.scrollToHash();
                },

                bookmarkHadith(number) {
                    this.lastReadNumber = number;
                    try {
                        localStorage.setItem('alfutuh_hadits_last_read', JSON.stringify({
                            slug: this.bookInfo.slug,
                            nama: this.bookInfo.nama,
                            page: this.page,
                            number: number,
                            ts: Date.now()
                        }));
                    } catch (e) {}
                },

                async copyHadith(h) {
                    const text = `${this.bookInfo.nama} No. ${h.number}\n\n${h.arab}\n\n${h.id}`;
                    try {
                        await navigator.clipboard.writeText(text);
                        this.copiedNumber = h.number;
                        setTimeout(() => {
                            if (this.copiedNumber === h.number) this.copiedNumber = null;
                        }, 2000);
                    } catch (e) {}
                }
            };
        }
    </script>
</body>
</html>
