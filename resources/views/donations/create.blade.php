<x-app-layout>
    <div class="max-w-xl mx-auto space-y-6">

        <!-- Top Header Navigation Bar -->
        <div class="flex items-center justify-between">
            <a href="{{ route('programs.show', $program->slug) }}" class="w-10 h-10 rounded-full bg-white border border-slate-100 flex items-center justify-center text-slate-700 hover:text-[#155E4B] shadow-sm transition active:scale-95" title="Kembali">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <h1 class="text-sm font-extrabold text-slate-800">Form Donasi</h1>
            <div class="w-10"></div>
        </div>

        <!-- Top Thank-You Card -->
        <div class="relative overflow-hidden bg-[#EAF5EE] rounded-3xl p-5 sm:p-6 border border-[#D2E6DC] flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4 relative z-10">
                <div class="w-12 h-12 rounded-full bg-[#155E4B] text-white flex items-center justify-center shrink-0 shadow-sm">
                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-sm sm:text-base font-extrabold text-[#155E4B] leading-tight">
                        Terima kasih telah berbagi kebaikan
                    </h2>
                    <p class="text-xs text-slate-600 mt-1">
                        Semoga menjadi amal jariyah yang barokah.
                    </p>
                </div>
            </div>

            <!-- Right Botanical Leaf Artwork -->
            <div class="absolute right-0 top-0 bottom-0 w-24 pointer-events-none opacity-80 flex items-center justify-end">
                <img src="{{ asset('images/thankyou-leaf.svg') }}" alt="" class="h-full object-contain">
            </div>
        </div>

        <!-- Program Context Bar -->
        <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex items-center justify-between text-xs">
            <span class="text-slate-500 font-medium">Program Donasi:</span>
            <span class="font-extrabold text-[#155E4B] truncate max-w-[260px]">{{ $program->nama }}</span>
        </div>

        @php
            $initialNominal = request()->query('nominal', 50000);
            if (!is_numeric($initialNominal) || $initialNominal < 1000) {
                $initialNominal = 50000;
            }
        @endphp

        <!-- Form Donasi -->
        <form action="{{ route('donations.store', $program->slug) }}" method="POST"
            x-data="{
                nominal: {{ $initialNominal }},
                isAnonim: false,
                paymentMethod: 'transfer_bank',
                bankTujuan: '{{ $bankAccounts->first()->nama_bank ?? 'Bank Syariah Indonesia (BSI)' }}'
            }"
            class="space-y-6">
            @csrf

            <!-- Form Inputs Card (Identitas & Pesan) -->
            <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <!-- Nominal Info Display & Edit Option -->
                <div class="p-4 bg-[#F2F7F4] rounded-2xl border border-[#E2ECE6] flex items-center justify-between">
                    <div>
                        <span class="text-[10px] text-slate-500 font-medium block">Nominal Donasi:</span>
                        <span class="text-base sm:text-lg font-black text-[#155E4B]">Rp <span x-text="Number(nominal).toLocaleString('id-ID')"></span></span>
                    </div>
                    <button type="button" @click="let newNom = prompt('Masukkan nominal donasi baru (min. 1000):', nominal); if(newNom && newNom >= 1000) nominal = Number(newNom);"
                        class="text-xs font-bold text-[#155E4B] bg-white border border-[#D2E6DC] px-3.5 py-1.5 rounded-full hover:bg-[#EAF3EE] transition">
                        Ubah Nominal
                    </button>
                </div>
                <input type="hidden" name="nominal" :value="nominal">

                <!-- 1. Input Nama Donatur with Person Icon -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Donatur</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="8" r="4" stroke-width="1.8"/><path d="M4 20c1.5-4 4-6 8-6s6.5 2 8 6" stroke-width="1.8" stroke-linecap="round"/></svg>
                        </span>
                        <input type="text" name="nama_donatur"
                            value="{{ old('nama_donatur', Auth::user()->name ?? '') }}"
                            placeholder="Contoh: Fulan atau Fulanah"
                            :disabled="isAnonim"
                            class="w-full text-xs sm:text-sm pl-11 pr-4 py-3.5 rounded-2xl border border-slate-200 focus:border-[#155E4B] focus:ring-[#155E4B] placeholder:text-slate-400 disabled:bg-slate-100 disabled:text-slate-400">
                    </div>
                </div>

                <!-- 2. Input Nomor WhatsApp with Phone Icon -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">
                        Nomor WhatsApp <span class="text-rose-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        <input type="tel" name="no_hp"
                            value="{{ old('no_hp', Auth::user()->phone ?? '') }}"
                            required placeholder="081234567890"
                            class="w-full text-xs sm:text-sm pl-11 pr-4 py-3.5 rounded-2xl border border-slate-200 focus:border-[#155E4B] focus:ring-[#155E4B] placeholder:text-slate-400">
                    </div>
                    @error('no_hp') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- 3. Input Doa / Pesan with Chat Icon -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Doa atau Pesan Kebaikan (Opsional)</label>
                    <div class="relative">
                        <span class="absolute left-4 top-3.5 text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </span>
                        <textarea name="doa" rows="2" placeholder="Tuliskan doa atau harapan terbaik Anda..."
                            class="w-full text-xs sm:text-sm pl-11 pr-4 py-3.5 rounded-2xl border border-slate-200 focus:border-[#155E4B] focus:ring-[#155E4B] placeholder:text-slate-400">{{ old('doa') }}</textarea>
                    </div>
                </div>

                <!-- 4. Checkbox: Sembunyikan nama saya -->
                <div class="flex items-center gap-2.5 pt-1 px-1">
                    <input type="checkbox" id="is_anonim" name="is_anonim" value="1" x-model="isAnonim"
                        class="w-4 h-4 rounded text-[#155E4B] focus:ring-[#155E4B] border-slate-300">
                    <label for="is_anonim" class="text-xs font-semibold text-slate-700 cursor-pointer select-none">
                        Sembunyikan nama saya (Tampilkan sebagai <strong class="text-[#155E4B]">Hamba Allah</strong>)
                    </label>
                </div>
            </div>

            <!-- Metode Pembayaran Section -->
            <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                    Pilih Metode Pembayaran
                </label>

                <div class="grid grid-cols-2 gap-3.5">
                    <!-- Option 1: Transfer Bank -->
                    <button type="button" @click="paymentMethod = 'transfer_bank'; bankTujuan = '{{ $bankAccounts->first()->nama_bank ?? 'Bank Syariah Indonesia (BSI)' }}'"
                        :class="paymentMethod === 'transfer_bank' ? 'bg-[#EAF5EE] border-2 border-[#155E4B] text-[#155E4B]' : 'bg-[#F8FAF8] border border-slate-200 text-slate-700 hover:bg-slate-50'"
                        class="p-4 sm:p-5 rounded-2xl flex flex-col items-center justify-center text-center gap-2 transition active:scale-95">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-[#155E4B]">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M3 21h18M3 9l9-5 9 5v2H3V9ZM5 11v7m4-7v7m6-7v7m4-7v7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <span class="text-xs sm:text-sm font-extrabold">Transfer Bank</span>
                    </button>

                    <!-- Option 2: QRIS -->
                    @php
                        $qrisAccount = $bankAccounts->firstWhere('kode_bank', 'QRIS');
                        $qrisName = $qrisAccount ? $qrisAccount->nama_bank : 'QRIS Al Futuh (Semua Pembayaran)';
                    @endphp
                    <button type="button" @click="paymentMethod = 'qris'; bankTujuan = '{{ $qrisName }}'"
                        :class="paymentMethod === 'qris' ? 'bg-[#EAF5EE] border-2 border-[#155E4B] text-[#155E4B]' : 'bg-[#F8FAF8] border border-slate-200 text-slate-700 hover:bg-slate-50'"
                        class="p-4 sm:p-5 rounded-2xl flex flex-col items-center justify-center text-center gap-2 transition active:scale-95">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-[#155E4B]">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M3 8V4a1 1 0 0 1 1-1h4M16 3h4a1 1 0 0 1 1 1v4M21 16v4a1 1 0 0 1-1 1h-4M8 21H4a1 1 0 0 1-1-1v-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <rect x="7" y="7" width="3" height="3" fill="currentColor"/>
                                <rect x="14" y="7" width="3" height="3" fill="currentColor"/>
                                <rect x="7" y="14" width="3" height="3" fill="currentColor"/>
                                <rect x="14" y="14" width="3" height="3" fill="currentColor"/>
                            </svg>
                        </div>
                        <span class="text-xs sm:text-sm font-extrabold">QRIS</span>
                    </button>
                </div>

                <!-- Sub-options for Transfer Bank -->
                <div x-show="paymentMethod === 'transfer_bank'" class="pt-2 space-y-2">
                    <p class="text-[11px] font-bold text-slate-500">Pilih Rekening Bank Tujuan:</p>
                    <div class="space-y-2">
                        @foreach($bankAccounts->where('kode_bank', '!=', 'QRIS') as $bank)
                            <label class="flex items-center justify-between p-3.5 rounded-2xl border border-slate-100 hover:border-[#155E4B] cursor-pointer transition text-xs">
                                <div class="flex items-center gap-3">
                                    <input type="radio" name="bank_tujuan" value="{{ $bank->nama_bank }}" x-model="bankTujuan" class="text-[#155E4B] focus:ring-[#155E4B]">
                                    <div>
                                        <p class="font-bold text-slate-800">{{ $bank->nama_bank }}</p>
                                        <p class="text-[10px] text-slate-400">a.n. {{ $bank->atas_nama }}</p>
                                    </div>
                                </div>
                                <span class="font-extrabold text-[11px] text-[#155E4B] bg-[#F2F7F4] px-2.5 py-1 rounded-full">{{ $bank->kode_bank }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Notice for QRIS -->
                <div x-show="paymentMethod === 'qris'" style="display: none;" class="pt-1">
                    <div class="p-3.5 bg-[#F2F7F4] rounded-2xl border border-[#D2E6DC] text-xs text-slate-600">
                        <input type="radio" name="bank_tujuan" value="{{ $qrisName }}" x-model="bankTujuan" checked class="hidden">
                        <p class="font-bold text-[#155E4B]">Mendukung Semua Aplikasi Pembayaran:</p>
                        <p class="text-[11px] text-slate-500 mt-1 leading-relaxed">BCA, Mandiri, BSI, BRI, GoPay, OVO, Dana, LinkAja, ShopeePay &amp; seluruh bank berlogo QRIS.</p>
                    </div>
                </div>
            </div>

            <!-- Bottom CTA Button -->
            <div class="pt-2">
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-sm py-4 px-6 rounded-full shadow-lg shadow-[#155E4B]/20 active:scale-95 transition">
                    <span>Konfirmasi Donasi</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </form>

    </div>
</x-app-layout>
