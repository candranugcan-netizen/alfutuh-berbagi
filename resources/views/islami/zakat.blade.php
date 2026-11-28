<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Kalkulator Zakat Akurat - Al Futuh</title>

    <link rel="icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#2B5B84">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=manrope:500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F7FAFC] text-slate-800 pb-20 min-h-screen"
      x-data="zakatApp()"
      x-init="init()">

    <!-- Top Header -->
    <header class="bg-white sticky top-0 z-40 border-b border-[#E2EEF6]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5 min-w-0">
                <a href="{{ route('islami.index') }}"
                   class="w-9 h-9 rounded-full bg-[#F0F6FA] hover:bg-[#E2EEF6] border border-[#D6E6F2] flex items-center justify-center text-[#2B5B84] shrink-0 transition active:scale-95"
                   aria-label="Kembali ke Fitur Islami">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
                <div class="min-w-0">
                    <h1 class="font-extrabold text-base sm:text-lg text-[#2B5B84] leading-none truncate">Kalkulator Zakat</h1>
                    <p class="text-[10px] font-bold text-slate-400 mt-0.5 truncate">Standar Nishab 85g Emas / 595g Perak</p>
                </div>
            </div>

            <a href="{{ route('islami.index') }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#2B5B84] hover:bg-[#E2EEF6] bg-[#F0F6FA] border border-[#D6E6F2] px-3.5 py-1.5 rounded-full transition shrink-0">
                <span>Fitur Islami</span>
            </a>
        </div>
    </header>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 pt-5 space-y-5">

        <!-- Banner Harga Emas & Perak Real-Time (Acuan Nishab) -->
        <div class="bg-[#2B5B84] rounded-3xl p-5 sm:p-6 text-white border border-[#1E4363] space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <span class="inline-flex items-center gap-1.5 bg-white/15 text-sky-50 text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                        <span class="w-1.5 h-1.5 rounded-full" :class="priceStatus === 'live' ? 'bg-emerald-300' : 'bg-amber-300'"></span>
                        <span x-text="priceStatus === 'live' ? ('Kurs Logam Mulia Live (' + priceDate + ')') : (priceStatus === 'loading' ? 'Mengambil Kurs Emas & Perak...' : 'Mode Estimasi / Manual')"></span>
                    </span>
                    <h2 class="text-lg sm:text-xl font-extrabold mt-1.5">Acuan Nishab Zakat Saat Ini</h2>
                </div>
                <button type="button" @click="fetchMetalPrices()" :disabled="priceStatus === 'loading'"
                        class="inline-flex items-center gap-1.5 self-start sm:self-auto bg-white/15 hover:bg-white/25 text-white text-xs font-bold px-3.5 py-1.5 rounded-full transition">
                    <span>↻ Perbarui Kurs</span>
                </button>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5">
                <div class="bg-[#1E4363] rounded-2xl p-3 space-y-0.5">
                    <span class="text-[10px] font-bold text-sky-200 uppercase">Emas / Gram</span>
                    <p class="text-sm sm:text-base font-black text-white" x-text="formatRp(goldPricePerGram)"></p>
                </div>
                <div class="bg-[#1E4363] rounded-2xl p-3 space-y-0.5">
                    <span class="text-[10px] font-bold text-sky-200 uppercase">Nishab Emas (85g)</span>
                    <p class="text-sm sm:text-base font-black text-white" x-text="formatRp(nishabEmasTahun)"></p>
                </div>
                <div class="col-span-2 sm:col-span-1 bg-[#1E4363] rounded-2xl p-3 space-y-0.5">
                    <span class="text-[10px] font-bold text-sky-200 uppercase">Nishab Perak (595g)</span>
                    <p class="text-sm sm:text-base font-black text-white" x-text="formatRp(nishabPerakTahun)"></p>
                </div>
            </div>

            <!-- Opsional: Sesuaikan Harga Emas Lokal -->
            <div class="pt-2 border-t border-white/15 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <span class="text-[11px] text-sky-100">
                    Ingin menyesuaikan dengan harga emas Antam/lokal?
                </span>
                <div class="flex items-center gap-1.5">
                    <span class="text-xs font-bold text-sky-200">Rp</span>
                    <input type="number" x-model.number="goldPricePerGram" min="100000" step="1000"
                           class="w-36 px-3 py-1 rounded-xl bg-white text-slate-800 text-xs font-extrabold border-0 focus:ring-2 focus:ring-sky-300">
                    <span class="text-[11px] text-sky-200">/ gram</span>
                </div>
            </div>
        </div>

        <!-- Tabs Jenis Zakat -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-1.5 bg-white p-1.5 rounded-2xl border border-[#E2EEF6]">
            <button type="button" @click="activeTab = 'maal'"
                    :class="activeTab === 'maal' ? 'bg-[#2B5B84] text-white' : 'text-slate-600 hover:text-[#2B5B84] hover:bg-[#F0F6FA]'"
                    class="py-2.5 px-2 rounded-xl text-xs font-extrabold transition">Maal / Harta</button>
            <button type="button" @click="activeTab = 'emas'"
                    :class="activeTab === 'emas' ? 'bg-[#2B5B84] text-white' : 'text-slate-600 hover:text-[#2B5B84] hover:bg-[#F0F6FA]'"
                    class="py-2.5 px-2 rounded-xl text-xs font-extrabold transition">Emas &amp; Perak</button>
            <button type="button" @click="activeTab = 'perdagangan'"
                    :class="activeTab === 'perdagangan' ? 'bg-[#2B5B84] text-white' : 'text-slate-600 hover:text-[#2B5B84] hover:bg-[#F0F6FA]'"
                    class="py-2.5 px-2 rounded-xl text-xs font-extrabold transition">Perdagangan</button>
            <button type="button" @click="activeTab = 'fitrah'"
                    :class="activeTab === 'fitrah' ? 'bg-[#2B5B84] text-white' : 'text-slate-600 hover:text-[#2B5B84] hover:bg-[#F0F6FA]'"
                    class="py-2.5 px-2 rounded-xl text-xs font-extrabold transition">Zakat Fitrah</button>
        </div>

        <!-- PANEL FORM & HASIL -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 items-start">

            <!-- Form Input (Kiri) -->
            <div class="lg:col-span-7 bg-white rounded-3xl border border-[#E2EEF6] p-5 sm:p-6 space-y-4">

                <!-- 1. ZAKAT MAAL -->
                <div x-show="activeTab === 'maal'" class="space-y-4">
                    <div>
                        <h3 class="text-base font-extrabold text-[#2B5B84]">Zakat Maal (Simpanan &amp; Investasi)</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kadar 2,5% dari total harta simpanan yang telah dimiliki selama 1 tahun (haul) dan mencapai nishab 85g emas.</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tabungan / Giro / Uang Tunai (Rp)</label>
                            <input type="number" x-model.number="maal.tabungan" min="0" step="500000" placeholder="0"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Deposito / Saham / Reksadana / Aset Likuid (Rp)</label>
                            <input type="number" x-model.number="maal.investasi" min="0" step="500000" placeholder="0"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Piutang yang Diharapkan Kembali (Rp)</label>
                            <input type="number" x-model.number="maal.piutang" min="0" step="500000" placeholder="0"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Utang Jatuh Tempo Saat Ini (Rp)</label>
                            <input type="number" x-model.number="maal.utang" min="0" step="500000" placeholder="0"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                        </div>
                    </div>
                </div>

                <!-- 3. ZAKAT EMAS & PERAK -->
                <div x-show="activeTab === 'emas'" x-cloak class="space-y-4">
                    <div>
                        <h3 class="text-base font-extrabold text-[#2B5B84]">Zakat Emas &amp; Perak</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Wajib zakat 2,5% jika mencapai haul 1 tahun dengan nishab emas 85 gram atau perak 595 gram.</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kepemilikan Emas Simpanan (gram)</label>
                            <input type="number" x-model.number="emasPerak.gramEmas" min="0" step="0.5" placeholder="0"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                            <p class="text-[11px] text-slate-400 mt-1">
                                Estimasi nilai: <strong class="text-slate-600" x-text="formatRp((emasPerak.gramEmas || 0) * goldPricePerGram)"></strong>
                            </p>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kepemilikan Perak Simpanan (gram)</label>
                            <input type="number" x-model.number="emasPerak.gramPerak" min="0" step="1" placeholder="0"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                            <p class="text-[11px] text-slate-400 mt-1">
                                Harga perak: <strong class="text-slate-600" x-text="formatRp(silverPricePerGram) + '/g'"></strong> •
                                Estimasi nilai: <strong class="text-slate-600" x-text="formatRp((emasPerak.gramPerak || 0) * silverPricePerGram)"></strong>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- 3. ZAKAT PERDAGANGAN -->
                <div x-show="activeTab === 'perdagangan'" x-cloak class="space-y-4">
                    <div>
                        <h3 class="text-base font-extrabold text-[#2B5B84]">Zakat Perdagangan (Tijarah)</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kadar 2,5% dari modal berputar bersih (aset lancar dikurangi utang jangka pendek) saat genap haul 1 tahun.</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nilai Stok Barang Dagangan Siap Jual (Rp)</label>
                            <input type="number" x-model.number="dagang.stok" min="0" step="500000" placeholder="0"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                            <p class="text-[10px] text-slate-400 mt-1">Hitung nilai jual/pasar barang dagangan saat ini (aset tetap seperti toko/kendaraan tidak dihitung).</p>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Kas Tunai &amp; Saldo Rekening Usaha (Rp)</label>
                            <input type="number" x-model.number="dagang.kas" min="0" step="500000" placeholder="0"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Piutang Dagang Lancar / Diharapkan Cair (Rp)</label>
                            <input type="number" x-model.number="dagang.piutang" min="0" step="500000" placeholder="0"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Utang Usaha &amp; Beban Jatuh Tempo (Rp)</label>
                            <input type="number" x-model.number="dagang.utang" min="0" step="500000" placeholder="0"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                        </div>
                    </div>

                    <div class="bg-[#F0F6FA] border border-[#D6E6F2] rounded-2xl p-3 text-[11px] text-[#2B5B84] leading-relaxed">
                        <strong>Rumus Fikih:</strong> (Stok Barang + Kas Usaha + Piutang Lancar) − Utang Jatuh Tempo. Wajib zakat 2,5% jika mencapai nishab 85g emas dan telah berjalan 1 tahun (haul).
                    </div>
                </div>

                <!-- 5. ZAKAT FITRAH -->
                <div x-show="activeTab === 'fitrah'" x-cloak class="space-y-4">
                    <div>
                        <h3 class="text-base font-extrabold text-[#2B5B84]">Zakat Fitrah</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Kewajiban 2,5 kg (atau 3,5 liter) beras per jiwa, atau dibayarkan senilai harga beras yang dikonsumsi.</p>
                    </div>

                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Jumlah Jiwa (Tanggungan Keluarga)</label>
                            <input type="number" x-model.number="fitrah.jiwa" min="1" step="1"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Harga Beras per Kilogram (Rp)</label>
                            <input type="number" x-model.number="fitrah.hargaBeras" min="5000" step="500"
                                   class="w-full rounded-2xl border-[#D6E6F2] bg-[#F7FAFC] focus:border-[#2B5B84] focus:ring-[#2B5B84] text-sm font-bold">
                        </div>
                    </div>
                </div>

            </div>

            <!-- Ringkasan Hasil Perhitungan (Kanan) -->
            <div class="lg:col-span-5 bg-white rounded-3xl border border-[#E2EEF6] p-5 sm:p-6 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                    <h3 class="text-sm font-extrabold text-[#2B5B84]">Hasil Perhitungan</h3>
                    <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase"
                          :class="result.wajib ? 'bg-[#EAF5EE] text-[#155E4B]' : 'bg-slate-100 text-slate-500'"
                          x-text="result.wajib ? 'Wajib Zakat' : 'Belum Wajib'"></span>
                </div>

                <div class="space-y-2.5 text-xs">
                    <div class="flex items-center justify-between text-slate-600">
                        <span x-text="result.baseLabel"></span>
                        <span class="font-extrabold text-slate-800" x-text="result.baseValue"></span>
                    </div>
                    <div class="flex items-center justify-between text-slate-600">
                        <span>Batas Nishab</span>
                        <span class="font-bold text-slate-700" x-text="result.nishabLabel"></span>
                    </div>
                </div>

                <div class="bg-[#F0F6FA] border border-[#D6E6F2] rounded-2xl p-4 space-y-1">
                    <p class="text-[11px] font-bold text-[#2B5B84] uppercase tracking-wider" x-text="result.zakatTitle"></p>
                    <p class="text-2xl font-black text-[#2B5B84]" x-text="formatRp(result.zakatAmount)"></p>
                    <p class="text-[11px] text-slate-500 leading-relaxed" x-text="result.note"></p>
                </div>

                <div class="space-y-2 pt-1">
                    <a href="{{ $donateUrl }}"
                       class="w-full inline-flex items-center justify-center gap-2 bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs sm:text-sm py-3 px-5 rounded-full transition active:scale-95">
                        <span>Tunaikan Zakat / Infak Sekarang →</span>
                    </a>
                    <button type="button" @click="resetCurrent()"
                            class="w-full text-xs font-bold text-slate-500 hover:text-[#2B5B84] py-2 transition">
                        Reset Angka
                    </button>
                </div>
            </div>

        </div>

    </main>

    <script>
        function zakatApp() {
            return {
                activeTab: 'maal',
                priceStatus: 'loading',
                priceDate: '',
                goldPricePerGram: 1550000,
                silverPricePerGram: 17000,

                maal: { tabungan: 0, investasi: 0, piutang: 0, utang: 0 },
                emasPerak: { gramEmas: 0, gramPerak: 0 },
                dagang: { stok: 0, kas: 0, piutang: 0, utang: 0 },
                fitrah: { jiwa: 1, hargaBeras: 15000 },

                init() {
                    this.fetchMetalPrices();
                },

                async fetchMetalPrices() {
                    this.priceStatus = 'loading';
                    const gramPerTroyOunce = 31.1034768;

                    try {
                        const [xauRes, xagRes] = await Promise.all([
                            fetch('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/xau.json'),
                            fetch('https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/xag.json').catch(() => null),
                        ]);

                        if (!xauRes.ok) throw new Error('HTTP ' + xauRes.status);
                        const xauJson = await xauRes.json();

                        if (xauJson?.xau?.idr) {
                            this.goldPricePerGram = Math.round(xauJson.xau.idr / gramPerTroyOunce);
                            this.priceDate = xauJson.date || 'Terbaru';
                            this.priceStatus = 'live';
                        } else {
                            this.priceStatus = 'manual';
                        }

                        if (xagRes && xagRes.ok) {
                            const xagJson = await xagRes.json();
                            if (xagJson?.xag?.idr) {
                                this.silverPricePerGram = Math.round(xagJson.xag.idr / gramPerTroyOunce);
                            }
                        }
                    } catch (e) {
                        this.priceStatus = 'manual';
                    }
                },

                get nishabEmasTahun() {
                    return 85 * (Number(this.goldPricePerGram) || 0);
                },

                get nishabEmasBulan() {
                    return Math.round(this.nishabEmasTahun / 12);
                },

                get nishabPerakTahun() {
                    return 595 * (Number(this.silverPricePerGram) || 0);
                },

                get result() {
                    if (this.activeTab === 'maal') {
                        const bersih = Math.max(0, (Number(this.maal.tabungan) || 0) + (Number(this.maal.investasi) || 0) + (Number(this.maal.piutang) || 0) - (Number(this.maal.utang) || 0));
                        const wajib = bersih >= this.nishabEmasTahun && bersih > 0;
                        const zakat = wajib ? Math.round(bersih * 0.025) : 0;
                        return {
                            wajib,
                            baseLabel: 'Total Harta Bersih',
                            baseValue: this.formatRp(bersih),
                            nishabLabel: this.formatRp(this.nishabEmasTahun),
                            zakatTitle: 'Zakat Maal (2,5%)',
                            zakatAmount: zakat,
                            note: wajib
                                ? 'Harta telah melampaui nishab 85g emas. Wajib ditunaikan jika sudah genap haul 1 tahun.'
                                : 'Harta belum mencapai nishab 85g emas (' + this.formatRp(this.nishabEmasTahun) + ').'
                        };
                    }

                    if (this.activeTab === 'emas') {
                        const gEmas = Math.max(0, Number(this.emasPerak.gramEmas) || 0);
                        const gPerak = Math.max(0, Number(this.emasPerak.gramPerak) || 0);
                        const wajibEmas = gEmas >= 85;
                        const wajibPerak = gPerak >= 595;
                        const wajib = wajibEmas || wajibPerak;
                        const zakatEmas = wajibEmas ? Math.round(gEmas * this.goldPricePerGram * 0.025) : 0;
                        const zakatPerak = wajibPerak ? Math.round(gPerak * this.silverPricePerGram * 0.025) : 0;
                        const totalZakat = zakatEmas + zakatPerak;
                        return {
                            wajib,
                            baseLabel: 'Total Nilai Emas & Perak',
                            baseValue: this.formatRp((gEmas * this.goldPricePerGram) + (gPerak * this.silverPricePerGram)),
                            nishabLabel: '85g Emas / 595g Perak',
                            zakatTitle: 'Zakat Emas & Perak (2,5%)',
                            zakatAmount: totalZakat,
                            note: wajib
                                ? 'Wajib ditunaikan jika kepemilikan telah mencapai haul 1 tahun.'
                                : 'Berat emas (< 85g) dan perak (< 595g) belum mencapai batas nishab.'
                        };
                    }

                    if (this.activeTab === 'perdagangan') {
                        const bruto = (Number(this.dagang.stok) || 0) + (Number(this.dagang.kas) || 0) + (Number(this.dagang.piutang) || 0);
                        const utang = Number(this.dagang.utang) || 0;
                        const bersih = Math.max(0, bruto - utang);
                        const wajib = bersih >= this.nishabEmasTahun && bersih > 0;
                        const zakat = wajib ? Math.round(bersih * 0.025) : 0;
                        return {
                            wajib,
                            baseLabel: 'Modal Berputar Bersih',
                            baseValue: this.formatRp(bersih),
                            nishabLabel: this.formatRp(this.nishabEmasTahun),
                            zakatTitle: 'Zakat Perdagangan (2,5%)',
                            zakatAmount: zakat,
                            note: wajib
                                ? 'Total aset lancar ' + this.formatRp(bruto) + ' dikurangi utang ' + this.formatRp(utang) + ' melampaui nishab 85g emas. Wajib ditunaikan saat genap haul 1 tahun.'
                                : 'Modal berputar bersih belum mencapai nishab 85g emas (' + this.formatRp(this.nishabEmasTahun) + ').'
                        };
                    }

                    // fitrah
                    const jiwa = Math.max(1, Number(this.fitrah.jiwa) || 1);
                    const harga = Math.max(0, Number(this.fitrah.hargaBeras) || 0);
                    const total = Math.round(jiwa * 2.5 * harga);
                    return {
                        wajib: true,
                        baseLabel: 'Kebutuhan Beras',
                        baseValue: (jiwa * 2.5).toLocaleString('id-ID') + ' kg (' + jiwa + ' jiwa)',
                        nishabLabel: '2,5 kg / jiwa',
                        zakatTitle: 'Total Zakat Fitrah (Setara Uang)',
                        zakatAmount: total,
                        note: 'Dapat ditunaikan berupa beras ' + (jiwa * 2.5).toLocaleString('id-ID') + ' kg atau uang senilai ' + this.formatRp(total) + '.'
                    };
                },

                resetCurrent() {
                    if (this.activeTab === 'maal') this.maal = { tabungan: 0, investasi: 0, piutang: 0, utang: 0 };
                    else if (this.activeTab === 'emas') this.emasPerak = { gramEmas: 0, gramPerak: 0 };
                    else if (this.activeTab === 'perdagangan') this.dagang = { stok: 0, kas: 0, piutang: 0, utang: 0 };
                    else if (this.activeTab === 'fitrah') this.fitrah = { jiwa: 1, hargaBeras: 15000 };
                },

                formatRp(val) {
                    return 'Rp ' + Math.round(Number(val) || 0).toLocaleString('id-ID');
                }
            };
        }
    </script>
</body>
</html>
