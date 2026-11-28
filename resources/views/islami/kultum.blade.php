<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Generator Kultum & Ceramah AI - Al Futuh</title>

    <link rel="icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#2B5B84">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=manrope:500,600,700,800&family=amiri:400,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media print {
            body { background: #fff !important; padding: 0 !important; }
            .no-print { display: none !important; }
            .print-area { border: none !important; box-shadow: none !important; padding: 0 !important; }
        }
    </style>
</head>
<body class="font-sans antialiased bg-[#F7FAFC] text-slate-800 pb-20 min-h-screen"
      x-data="kultumApp({{ $isConfigured ? 'true' : 'false' }})"
      x-init="init()">

    <!-- Top Header -->
    <header class="bg-white sticky top-0 z-40 border-b border-[#E2EEF6] no-print">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
                <a href="{{ route('islami.index') }}"
                   class="w-9 h-9 rounded-full bg-[#F0F6FA] hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] shrink-0 transition active:scale-95"
                   aria-label="Kembali ke Fitur Islami">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <div class="min-w-0">
                    <h1 class="font-extrabold text-base sm:text-lg text-[#2B5B84] leading-none truncate">Generator Kultum &amp; Ceramah</h1>
                    <p class="text-[10px] font-bold text-slate-400 mt-0.5 truncate">Al-Qur'an, Hadits Shahih &amp; Manhaj Salaf</p>
                </div>
            </div>

            <a href="{{ route('islami.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#2B5B84] hover:bg-[#E2EEF6] bg-[#F0F6FA] border border-[#D6E6F2] px-3.5 py-1.5 rounded-full transition shrink-0">
                <span>Fitur Islami</span>
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 pt-5 space-y-5">

        <!-- Hero & Manhaj Notice -->
        <div class="bg-[#2B5B84] rounded-3xl p-5 sm:p-6 text-white border border-[#1E4363] space-y-2.5 no-print">
            <span class="inline-flex items-center gap-1.5 bg-white/15 text-sky-50 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                Gemini AI • Kultum, Pengajian &amp; Tausiyah
            </span>
            <h2 class="text-lg sm:text-xl font-extrabold">Penyusun Materi Kultum &amp; Ceramah</h2>
            <p class="text-xs text-sky-100/90 leading-relaxed">
                Susun materi dakwah yang hangat, komunikatif, dan mudah dipahami untuk kultum ba'da shalat, majelis taklim, atau tausiyah acara—dengan batasan ketat <strong>Al-Qur'an, Hadits Shahih, serta pemahaman ulama Salaf Ahlus Sunnah wal Jama'ah</strong>.
            </p>
        </div>

        <!-- Peringatan jika GEMINI_API_KEY belum diisi -->
        <div x-show="!isConfigured" x-cloak class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-xs text-amber-900 space-y-1 no-print">
            <p class="font-extrabold">Konfigurasi Gemini API Belum Aktif</p>
            <p>Tambahkan <code class="bg-amber-100 px-1.5 py-0.5 rounded font-mono">GEMINI_API_KEY</code> pada file <code class="bg-amber-100 px-1.5 py-0.5 rounded font-mono">.env</code> untuk mengaktifkan generator ini.</p>
        </div>

        <!-- Form Input -->
        <form @submit.prevent="generateKultum()" class="bg-white rounded-3xl border border-[#E2EEF6] p-5 sm:p-6 space-y-4 no-print">
            <div class="space-y-2">
                <label class="block text-xs font-extrabold text-[#2B5B84]">Tema / Topik Kultum atau Ceramah <span class="text-rose-500">*</span></label>
                <input type="text"
                       x-model="form.tema"
                       required
                       minlength="3"
                       maxlength="200"
                       placeholder="Contoh: Sabar dan Syukur saat Menghadapi Ujian Hidup"
                       class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-semibold">

                <!-- Tema Populer -->
                <div class="flex flex-wrap gap-1.5 pt-1">
                    <template x-for="preset in presets" :key="preset">
                        <button type="button" @click="form.tema = preset"
                                class="text-[11px] font-bold bg-[#F0F6FA] hover:bg-[#E2EEF6] text-[#2B5B84] border border-[#D6E6F2] px-2.5 py-1 rounded-full transition">
                            + <span x-text="preset"></span>
                        </button>
                    </template>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Format Acara &amp; Durasi</label>
                    <select x-model="form.jenis"
                            class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-xs sm:text-sm font-bold">
                        <option value="kultum">Kultum Singkat (5–7 menit)</option>
                        <option value="tausiyah">Tausiyah Acara / Keluarga (10–15 menit)</option>
                        <option value="ceramah">Ceramah Majelis Taklim (15–25 menit)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Target Audiens (Opsional)</label>
                    <input type="text"
                           x-model="form.audiens"
                           maxlength="100"
                           placeholder="Misal: Jamaah Masjid, Ibu-ibu Majelis Taklim, Remaja"
                           class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-xs sm:text-sm font-semibold">
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Catatan / Konteks Acara (Opsional)</label>
                <textarea x-model="form.catatan"
                          rows="2"
                          maxlength="400"
                          placeholder="Misal: Untuk kultum ba'da Subuh, atau acara santunan anak yatim..."
                          class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-xs sm:text-sm font-medium"></textarea>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pt-1">
                <p class="text-[11px] text-slate-400">
                    Catatan: Periksa kembali ketepatan harakat dan rujukan sebelum disampaikan.
                </p>
                <button type="submit"
                        :disabled="loading || !form.tema.trim()"
                        class="inline-flex items-center justify-center gap-2 bg-[#2B5B84] hover:bg-[#1E4363] disabled:opacity-50 text-white font-extrabold text-xs sm:text-sm px-6 py-3 rounded-full transition active:scale-95 shrink-0">
                    <svg x-show="loading" x-cloak class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span x-text="loading ? 'Menyusun Materi...' : 'Buat Materi Kultum / Ceramah'"></span>
                </button>
            </div>
        </form>

        <!-- Error Alert -->
        <div x-show="error" x-cloak class="bg-rose-50 border border-rose-200 rounded-2xl p-4 text-xs font-bold text-rose-700 no-print" x-text="error"></div>

        <!-- Hasil Materi -->
        <div x-show="resultText" x-cloak class="bg-white rounded-3xl border border-[#E2EEF6] p-5 sm:p-7 space-y-4 print-area">
            <div class="flex flex-wrap items-center justify-between gap-2 pb-3 border-b border-slate-100 no-print">
                <span class="text-[10px] font-extrabold uppercase tracking-wider bg-[#F0F6FA] text-[#2B5B84] px-2.5 py-1 rounded-full">
                    Naskah Siap Sampaikan
                </span>

                <div class="flex flex-wrap items-center gap-1.5">
                    <button type="button" @click="readMode = !readMode"
                            :class="readMode ? 'bg-[#2B5B84] text-white' : 'bg-[#F0F6FA] text-[#2B5B84] hover:bg-[#E2EEF6]'"
                            class="text-[11px] font-bold px-3 py-1.5 rounded-full transition">
                        <span x-text="readMode ? 'Ukuran Normal' : 'Mode Baca'"></span>
                    </button>

                    <button type="button" @click="copyResult()"
                            :class="copied ? 'bg-[#EAF5EE] text-[#155E4B]' : 'bg-[#F0F6FA] text-[#2B5B84] hover:bg-[#E2EEF6]'"
                            class="text-[11px] font-bold px-3 py-1.5 rounded-full transition">
                        <span x-text="copied ? 'Tersalin ✓' : 'Salin Naskah'"></span>
                    </button>

                    <button type="button" @click="window.print()"
                            class="text-[11px] font-bold bg-[#2B5B84] hover:bg-[#1E4363] text-white px-3.5 py-1.5 rounded-full transition">
                        Cetak / PDF
                    </button>
                </div>
            </div>

            <div :class="readMode ? 'text-base sm:text-lg leading-relaxed' : 'text-xs sm:text-sm leading-relaxed'"
                 class="space-y-3 text-slate-700"
                 x-html="renderedHtml">
            </div>
        </div>

        <!-- Riwayat -->
        <div x-show="history.length > 0" x-cloak class="bg-white rounded-3xl border border-[#E2EEF6] p-4 sm:p-5 space-y-3 no-print">
            <div class="flex items-center justify-between">
                <h3 class="text-xs font-extrabold text-[#2B5B84] uppercase tracking-wider">Riwayat Materi Tersimpan</h3>
                <button type="button" @click="clearHistory()" class="text-[11px] font-bold text-slate-400 hover:text-rose-600">Hapus Semua</button>
            </div>
            <div class="divide-y divide-slate-100">
                <template x-for="(item, idx) in history" :key="idx">
                    <div class="py-2.5 flex items-center justify-between gap-3">
                        <div class="min-w-0">
                            <p class="text-xs font-extrabold text-slate-800 truncate" x-text="item.tema"></p>
                            <p class="text-[10px] text-slate-400" x-text="item.date + ' • ' + item.jenis"></p>
                        </div>
                        <button type="button" @click="loadFromHistory(item)"
                                class="text-[11px] font-extrabold text-[#2B5B84] bg-[#F0F6FA] hover:bg-[#E2EEF6] px-3 py-1 rounded-full shrink-0 transition">
                            Buka
                        </button>
                    </div>
                </template>
            </div>
        </div>

    </main>

    <script>
        function kultumApp(isConfigured) {
            return {
                isConfigured,
                presets: [
                    'Keutamaan Shalat Subuh Berjamaah',
                    'Sabar & Syukur dalam Ujian Hidup',
                    'Keutamaan Sedekah & Menolong Sesama',
                    'Bahaya Ghibah & Menjaga Lisan',
                    'Keberkahan Rezeki yang Halal',
                    'Mendidik Anak Sesuai Sunnah'
                ],
                form: {
                    jenis: 'kultum',
                    tema: '',
                    audiens: 'Jamaah Umum',
                    catatan: ''
                },
                loading: false,
                error: null,
                resultText: '',
                readMode: false,
                copied: false,
                history: [],

                init() {
                    try {
                        const saved = JSON.parse(localStorage.getItem('alfutuh_kultum_history') || '[]');
                        if (Array.isArray(saved)) this.history = saved;
                    } catch (e) {}
                },

                async generateKultum() {
                    if (!this.form.tema.trim() || this.loading) return;
                    this.loading = true;
                    this.error = null;

                    try {
                        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                        const res = await fetch('{{ route('islami.kultum.generate') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrf
                            },
                            body: JSON.stringify(this.form)
                        });

                        const json = await res.json();
                        if (!res.ok || !json.success) {
                            this.error = json.message || 'Gagal menyusun materi. Silakan coba lagi.';
                            return;
                        }

                        this.resultText = json.content;
                        this.saveToHistory(this.form.tema, this.form.jenis, json.content);
                    } catch (err) {
                        this.error = 'Terjadi gangguan koneksi ke server. Silakan coba lagi.';
                    } finally {
                        this.loading = false;
                    }
                },

                saveToHistory(tema, jenis, content) {
                    const entry = {
                        tema,
                        jenis,
                        content,
                        date: new Date().toLocaleDateString('id-ID', { day: '2-digit', month: 'short', year: 'numeric' })
                    };
                    this.history = [entry, ...this.history.filter(h => h.tema !== tema)].slice(0, 8);
                    try {
                        localStorage.setItem('alfutuh_kultum_history', JSON.stringify(this.history));
                    } catch (e) {}
                },

                loadFromHistory(item) {
                    this.form.tema = item.tema;
                    this.form.jenis = item.jenis || 'kultum';
                    this.resultText = item.content;
                    this.error = null;
                    window.scrollTo({ top: 320, behavior: 'smooth' });
                },

                clearHistory() {
                    this.history = [];
                    try { localStorage.removeItem('alfutuh_kultum_history'); } catch (e) {}
                },

                async copyResult() {
                    if (!this.resultText) return;
                    try {
                        await navigator.clipboard.writeText(this.resultText);
                        this.copied = true;
                        setTimeout(() => { this.copied = false; }, 2000);
                    } catch (e) {}
                },

                escapeHtml(str) {
                    return str
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/>/g, '&gt;');
                },

                hasArabic(str) {
                    return /[\u0600-\u06FF]/.test(str);
                },

                formatInline(str) {
                    return str
                        .replace(/\*\*(.+?)\*\*/g, '<strong class="font-extrabold text-slate-900">$1</strong>')
                        .replace(/\*(.+?)\*/g, '<em class="italic">$1</em>');
                },

                get renderedHtml() {
                    if (!this.resultText) return '';
                    const lines = this.resultText.split('\n');
                    let html = '';

                    for (const rawLine of lines) {
                        const line = rawLine.trim();
                        if (!line) {
                            html += '<div class="h-1.5"></div>';
                            continue;
                        }

                        const safe = this.escapeHtml(line);

                        if (line === '---' || line === '***') {
                            html += '<hr class="border-[#E2EEF6] my-4">';
                        } else if (line.startsWith('### ')) {
                            html += `<h4 class="text-sm sm:text-base font-extrabold text-[#2B5B84] pt-2">${this.formatInline(safe.slice(4))}</h4>`;
                        } else if (line.startsWith('## ')) {
                            html += `<h3 class="text-base sm:text-lg font-extrabold text-[#2B5B84] border-b border-[#E2EEF6] pb-1.5 pt-3">${this.formatInline(safe.slice(3))}</h3>`;
                        } else if (line.startsWith('# ')) {
                            html += `<h2 class="text-lg sm:text-xl font-black text-[#2B5B84] pt-1">${this.formatInline(safe.slice(2))}</h2>`;
                        } else if (line.startsWith('> ')) {
                            const inner = safe.slice(2);
                            const rtl = this.hasArabic(inner) && !/[a-zA-Z]{4,}/.test(inner);
                            html += rtl
                                ? `<blockquote dir="rtl" class="bg-[#F0F6FA] border-r-4 border-[#2B5B84] rounded-xl p-3.5 text-right text-xl sm:text-2xl font-bold text-slate-900 leading-[2.2]" style="font-family: 'Amiri', serif;">${inner}</blockquote>`
                                : `<blockquote class="bg-[#F0F6FA] border-l-4 border-[#2B5B84] rounded-xl p-3.5 text-slate-700 italic">${this.formatInline(inner)}</blockquote>`;
                        } else if (line.startsWith('- ') || line.startsWith('* ')) {
                            html += `<div class="flex items-start gap-2 pl-2"><span class="text-[#2B5B84] font-bold">•</span><span>${this.formatInline(safe.slice(2))}</span></div>`;
                        } else if (this.hasArabic(line) && !/[a-zA-Z]{5,}/.test(line)) {
                            html += `<p dir="rtl" class="bg-[#F7FAFC] border border-[#E2EEF6] rounded-2xl p-4 text-right text-xl sm:text-2xl font-bold text-slate-900 leading-[2.2]" style="font-family: 'Amiri', serif;">${safe}</p>`;
                        } else {
                            html += `<p class="leading-relaxed">${this.formatInline(safe)}</p>`;
                        }
                    }

                    return html;
                }
            };
        }
    </script>
</body>
</html>
