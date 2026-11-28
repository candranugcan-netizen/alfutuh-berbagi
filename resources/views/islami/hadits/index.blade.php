<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Kumpulan Hadits (Kutubus Sittah & Musnad Ahmad) - Al Futuh</title>

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
      x-data="haditsIndexApp(@js($books))"
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
                    <h1 class="font-extrabold text-base sm:text-lg text-[#2B5B84] leading-none truncate">Kumpulan Hadits</h1>
                    <p class="text-[10px] font-bold text-slate-400 mt-0.5 truncate">Kutubus Sittah &amp; Musnad Imam Ahmad</p>
                </div>
            </div>

            <a href="{{ route('islami.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#2B5B84] hover:bg-[#E2EEF6] bg-[#F0F6FA] border border-[#D6E6F2] px-3.5 py-1.5 rounded-full transition shrink-0">
                <span>Fitur Islami</span>
            </a>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 pt-5 space-y-5">

        <!-- Hero Banner -->
        <div class="bg-[#2B5B84] rounded-3xl p-5 sm:p-6 text-white border border-[#1E4363] space-y-2">
            <span class="inline-flex items-center gap-1.5 bg-white/15 text-sky-50 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                7 Kitab Induk Hadits • Arab &amp; Indonesia
            </span>
            <h2 class="text-lg sm:text-xl font-extrabold">Kutubus Sittah &amp; Musnad Imam Ahmad</h2>
            <p class="text-xs text-sky-100/90 leading-relaxed max-w-2xl">
                Telusuri ribuan hadits Nabi ﷺ lengkap dengan teks bahasa Arab dan terjemahan bahasa Indonesia dari tujuh kitab hadits utama.
            </p>
        </div>

        <!-- Terakhir Dibaca -->
        <template x-if="lastRead">
            <a :href="'{{ url('/islami/hadits') }}/' + lastRead.slug + '?page=' + lastRead.page + '#hadits-' + lastRead.number"
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
                            <span x-text="lastRead.nama"></span> — Hadits No. <span x-text="lastRead.number"></span>
                        </p>
                    </div>
                </div>
                <span class="text-xs font-extrabold text-[#2B5B84] bg-[#F0F6FA] px-3 py-1.5 rounded-full shrink-0">
                    Lanjutkan →
                </span>
            </a>
        </template>

        <!-- Daftar 7 Kitab Hadits -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            <template x-for="book in books" :key="book.slug">
                <a :href="'{{ url('/islami/hadits') }}/' + book.slug"
                   class="group bg-white hover:bg-[#F7FAFD] rounded-3xl border border-[#E2EEF6] hover:border-[#2B5B84] p-4 sm:p-5 flex flex-col justify-between gap-4 transition active:scale-[0.99]">
                    <div class="space-y-2.5">
                        <div class="flex items-start justify-between gap-2">
                            <span class="text-[10px] font-extrabold uppercase tracking-wider px-2.5 py-0.5 rounded-full"
                                  :class="book.kategori === 'Kutubus Sittah' ? 'bg-[#F0F6FA] text-[#2B5B84]' : 'bg-[#EAF5EE] text-[#155E4B]'"
                                  x-text="book.kategori"></span>
                            <p dir="rtl" class="text-lg font-bold text-[#2B5B84] leading-none" style="font-family: 'Amiri', serif;" x-text="book.arab"></p>
                        </div>

                        <div>
                            <h3 class="text-base font-extrabold text-slate-800 group-hover:text-[#2B5B84] transition" x-text="book.nama"></h3>
                            <p class="text-[11px] font-semibold text-slate-400 mt-0.5" x-text="book.imam"></p>
                        </div>

                        <p class="text-xs text-slate-600 leading-relaxed" x-text="book.deskripsi"></p>
                    </div>

                    <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                        <span class="text-xs font-extrabold text-[#2B5B84]">
                            <span x-text="formatNumber(book.available || book.total_default)"></span> Hadits
                        </span>
                        <span class="text-xs font-extrabold text-[#2B5B84] group-hover:translate-x-0.5 transition">
                            Baca Kitab →
                        </span>
                    </div>
                </a>
            </template>
        </div>

    </main>

    <script>
        function haditsIndexApp(initialBooks) {
            return {
                books: initialBooks,
                lastRead: null,

                init() {
                    try {
                        const saved = localStorage.getItem('alfutuh_hadits_last_read');
                        if (saved) this.lastRead = JSON.parse(saved);
                    } catch (e) {}
                },

                formatNumber(num) {
                    return Number(num || 0).toLocaleString('id-ID');
                }
            };
        }
    </script>
</body>
</html>
