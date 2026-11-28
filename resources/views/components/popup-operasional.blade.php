@props(['program' => null])

@php
    $targetProgram = $program ?? \App\Models\Program::where('slug', 'sedekah-operasional-dakwah-yayasan')
        ->orWhere('nama', 'like', '%operasional%')
        ->first() ?? \App\Models\Program::where('is_active', true)->first();

    $programUrl = $targetProgram ? route('programs.show', $targetProgram->slug) : route('programs.index');
    $donateUrl = $targetProgram ? route('donations.create', $targetProgram->slug) : route('programs.index');
@endphp

<!-- Modal Pop-Up Promosi Donasi Operasional Umum -->
<div x-data="{
        showModal: false,
        dontShowToday: false,
        init() {
            // Cek apakah user sudah pernah menutup modal di sesi ini atau menyetel sembunyikan hari ini
            const hideTodayDate = localStorage.getItem('alfutuh_popup_hide_date');
            const todayStr = new Date().toISOString().slice(0, 10);
            const dismissedThisSession = sessionStorage.getItem('alfutuh_popup_seen');

            if (hideTodayDate === todayStr || dismissedThisSession) {
                return;
            }

            // Tampilkan popup dengan sedikit delay halus saat pertama kali halaman terbuka
            setTimeout(() => {
                this.showModal = true;
            }, 800);
        },
        closeModal() {
            this.showModal = false;
            sessionStorage.setItem('alfutuh_popup_seen', 'true');
            if (this.dontShowToday) {
                const todayStr = new Date().toISOString().slice(0, 10);
                localStorage.setItem('alfutuh_popup_hide_date', todayStr);
            }
        }
    }"
    x-show="showModal"
    x-cloak
    @keydown.escape.window="closeModal()"
    class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 sm:p-6"
    style="display: none;">

    <!-- Backdrop Gelap dengan Blur -->
    <div x-show="showModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="closeModal()"
         class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs transition-opacity"></div>

    <!-- Kotak Dialog Pop-Up -->
    <div x-show="showModal"
         x-transition:enter="ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
         class="relative bg-white rounded-3xl max-w-md w-full shadow-2xl border border-slate-100 overflow-hidden z-10 transition-all max-h-[92vh] flex flex-col">

        <!-- Tombol Tutup (X) -->
        <button type="button" @click="closeModal()"
                class="absolute top-3.5 right-3.5 z-20 w-8 h-8 rounded-full bg-black/40 hover:bg-black/60 text-white flex items-center justify-center transition active:scale-90"
                aria-label="Tutup Pop-Up">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Banner Header Visual -->
        <div class="relative h-36 sm:h-40 w-full bg-gradient-to-br from-[#1b735c] to-[#155E4B] overflow-hidden shrink-0 flex items-end p-4">
            <img src="{{ asset('images/mosque-hero.svg') }}" alt="Masjid Al Futuh" class="absolute inset-0 w-full h-full object-cover opacity-35 mix-blend-overlay">
            
            <div class="relative z-10 space-y-1">
                <span class="inline-flex items-center gap-1.5 bg-[#D4AF37] text-white text-[10px] font-extrabold px-3 py-0.5 rounded-full shadow-sm">
                    <svg class="w-3 h-3 text-white fill-current" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <span>Sedekah Jariyah Utama</span>
                </span>
                <h3 class="text-white font-extrabold text-base sm:text-lg leading-tight drop-shadow-xs">
                    Denyut Kebaikan Dakwah Bersama
                </h3>
            </div>
        </div>

        <!-- Konten Penjelasan Program Operasional -->
        <div class="p-5 sm:p-6 overflow-y-auto space-y-4">
            <div>
                <h4 class="font-black text-sm sm:text-base text-slate-800 tracking-tight leading-snug">
                    Sedekah Operasional &amp; Syiar Dakwah Yayasan
                </h4>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                    Satu sedekah operasional umum Anda menopang 4 pilar kegiatan dakwah rutin Yayasan Al Futuh secara serentak:
                </p>
            </div>

            @if($targetProgram)
                @php
                    $popSisa = $targetProgram->sisa_donasi;
                    $popPct = $targetProgram->persentase_sisa;
                    $popStatus = $targetProgram->status_sisa;
                @endphp
                <!-- Info Status Sisa Dana Operasional -->
                <div class="p-3 rounded-2xl {{ in_array($popStatus, ['critical', 'warning', 'empty']) ? 'bg-amber-50 border border-amber-200 text-amber-900' : 'bg-[#F2F7F4] border border-[#D2E6DC] text-[#155E4B]' }} space-y-1.5 text-xs">
                    <div class="flex justify-between items-center text-[11px]">
                        <span class="text-slate-500">Total Terkumpul: <strong class="text-slate-800">Rp {{ number_format($targetProgram->dana_terkumpul, 0, ',', '.') }}</strong></span>
                        <span class="font-extrabold px-2 py-0.5 rounded-full {{ in_array($popStatus, ['critical', 'warning', 'empty']) ? 'bg-amber-200 text-amber-900' : 'bg-[#EAF5EE] text-[#155E4B]' }}">
                            Sisa {{ $popPct }}%
                        </span>
                    </div>
                    <div class="flex justify-between items-center text-xs">
                        <span class="font-bold">Sisa Saldo Operasional:</span>
                        <span class="font-black text-sm {{ in_array($popStatus, ['critical', 'warning', 'empty']) ? 'text-amber-800' : 'text-[#155E4B]' }}">
                            Rp {{ number_format($popSisa, 0, ',', '.') }}
                        </span>
                    </div>
                    @if(in_array($popStatus, ['critical', 'warning', 'empty']))
                        <p class="text-[10px] text-amber-700 font-medium pt-0.5">
                            ⚠️ Sisa dana operasional sedang menipis. Dukungan Anda sangat mendesak untuk menjaga kelangsungan kegiatan dakwah.
                        </p>
                    @endif
                </div>
            @endif

            <!-- 4 Pilar Program Yayasan yang Ditopang -->
            <div class="grid grid-cols-2 gap-2.5 text-[11px]">
                <!-- 1. BBHQ -->
                <div class="p-2.5 rounded-2xl bg-[#F8FAF8] border border-slate-100 flex items-center gap-2.5 hover:border-[#155E4B]/30 transition">
                    <div class="w-8 h-8 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0 shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 6.5c-2.5-2-6-2.5-9-2v13c3-.5 6.5 0 9 2m0-13c2.5-2 6-2.5 9-2v13c-3-.5-6.5 0-9 2m0-13v13"/>
                        </svg>
                    </div>
                    <div>
                        <strong class="text-slate-800 block text-[10.5px]">Gebraq</strong>
                        <span class="text-[9.5px] text-slate-400 leading-tight block">Berantas Buta Huruf Qur'an</span>
                    </div>
                </div>

                <!-- 2. TPA Santri -->
                <div class="p-2.5 rounded-2xl bg-[#F8FAF8] border border-slate-100 flex items-center gap-2.5 hover:border-[#155E4B]/30 transition">
                    <div class="w-8 h-8 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0 shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3c-3.5 2.5-6 6-6 10v7h12v-7c0-4-2.5-7.5-6-10Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M10 20v-4a2 2 0 1 1 4 0v4M3 20h18M12 1.5v2M10.5 2.5h3"/>
                        </svg>
                    </div>
                    <div>
                        <strong class="text-slate-800 block text-[10.5px]">TPA Al Futuh</strong>
                        <span class="text-[9.5px] text-slate-400 leading-tight block">Fasilitas &amp; modul santri</span>
                    </div>
                </div>

                <!-- 3. Kajian Muslimah -->
                <div class="p-2.5 rounded-2xl bg-[#F8FAF8] border border-slate-100 flex items-center gap-2.5 hover:border-[#155E4B]/30 transition">
                    <div class="w-8 h-8 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0 shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4" stroke-width="1.8"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                    <div>
                        <strong class="text-slate-800 block text-[10.5px]">Kajian Muslimah</strong>
                        <span class="text-[9.5px] text-slate-400 leading-tight block">Majelis ta'lim &amp; da'iyah</span>
                    </div>
                </div>

                <!-- 4. Sarana Masjid -->
                <div class="p-2.5 rounded-2xl bg-[#F8FAF8] border border-slate-100 flex items-center gap-2.5 hover:border-[#155E4B]/30 transition">
                    <div class="w-8 h-8 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0 shadow-2xs">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m13 2-8 12h7l-1 8 8-12h-7l1-8Z"/>
                        </svg>
                    </div>
                    <div>
                        <strong class="text-slate-800 block text-[10.5px]">Listrik &amp; Fasilitas</strong>
                        <span class="text-[9.5px] text-slate-400 leading-tight block">Kenyamanan ibadah umat</span>
                    </div>
                </div>
            </div>

            <!-- Tombol CTA Utama -->
            <div class="space-y-2 pt-1">
                <a href="{{ route('register') }}" @click="closeModal()"
                   class="inline-flex items-center justify-center gap-2 w-full bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs sm:text-sm py-3 rounded-full shadow-md shadow-[#155E4B]/25 active:scale-95 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    <span>Daftar Akun Baru Sekarang</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>

                <div class="flex items-center justify-between pt-1">
                    <label class="inline-flex items-center gap-1.5 cursor-pointer text-slate-400 hover:text-slate-600 text-[11px]">
                        <input type="checkbox" x-model="dontShowToday" class="rounded border-slate-300 text-[#155E4B] focus:ring-[#155E4B] w-3.5 h-3.5">
                        <span>Jangan tampilkan lagi hari ini</span>
                    </label>

                    <button type="button" @click="closeModal()" class="text-[11px] font-bold text-slate-400 hover:text-slate-600">
                        Nanti Saja
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
