<x-app-layout>
    <div class="py-4 max-w-lg mx-auto space-y-4">

        <!-- Header Program Singkat -->
        <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-2xl shrink-0">
                {{ $program->icon ?: '🤲' }}
            </div>
            <div>
                <span class="text-[10px] font-bold text-teal-600 uppercase tracking-wider">Anda Akan Berdonasi Pada:</span>
                <h2 class="font-extrabold text-sm text-slate-800 leading-snug line-clamp-1">{{ $program->nama }}</h2>
            </div>
        </div>

        <!-- Formulir Donasi -->
        <form action="{{ route('donations.store', $program->slug) }}" method="POST" x-data="{ nominal: 50000, isAnonim: false }" class="space-y-4">
            @csrf

            <!-- 1. Pilihan Preset Nominal -->
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                    Pilih Nominal Donasi
                </label>

                <div class="grid grid-cols-3 gap-2">
                    @foreach([25000, 50000, 100000, 250000, 500000, 1000000] as $preset)
                        <button type="button" 
                            @click="nominal = {{ $preset }}"
                            :class="nominal == {{ $preset }} ? 'bg-teal-600 text-white font-extrabold shadow-sm' : 'bg-slate-50 hover:bg-slate-100 text-slate-700 font-bold border border-slate-100'"
                            class="py-2.5 px-1 rounded-2xl text-xs transition active:scale-95 text-center">
                            Rp {{ number_format($preset, 0, ',', '.') }}
                        </button>
                    @endforeach
                </div>

                <!-- Input Nominal Manual -->
                <div class="pt-2">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                        Atau Masukkan Nominal Lainnya (Min. Rp 10.000)
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-3 font-extrabold text-slate-400 text-sm">Rp</span>
                        <input type="number" name="nominal" x-model="nominal" min="10000" step="5000" required
                            class="w-full text-base font-black pl-12 pr-4 py-3 rounded-2xl border-slate-200 focus:border-teal-500 focus:ring-teal-500">
                    </div>
                    @error('nominal') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <!-- 2. Pilihan Rekening Pembayaran -->
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                    Metode Pembayaran (Transfer Bank / QRIS)
                </label>

                <div class="space-y-2">
                    @foreach($bankAccounts as $bank)
                        <label class="flex items-center justify-between p-3 rounded-2xl border border-slate-100 hover:border-teal-200 cursor-pointer transition">
                            <div class="flex items-center gap-3">
                                <input type="radio" name="bank_tujuan" value="{{ $bank->nama_bank }}" {{ $loop->first ? 'checked' : '' }} class="text-teal-600 focus:ring-teal-500">
                                <div>
                                    <p class="text-xs font-bold text-slate-800">{{ $bank->nama_bank }}</p>
                                    <p class="text-[10px] text-slate-400">a.n. {{ $bank->atas_nama }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-black text-slate-400">{{ $bank->kode_bank }}</span>
                        </label>
                    @endforeach
                </div>
                @error('bank_tujuan') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- 3. Identitas Donatur (Bisa Login atau Guest) -->
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3.5">
                <div class="flex justify-between items-center border-b border-slate-100 pb-2">
                    <label class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                        Data Donatur
                    </label>
                    @guest
                        <span class="text-[10px] font-bold bg-amber-50 text-amber-700 px-2 py-0.5 rounded-md">
                            Donasi Sebagai Tamu (Guest)
                        </span>
                    @else
                        <span class="text-[10px] font-bold bg-teal-50 text-teal-700 px-2 py-0.5 rounded-md">
                            Akun Terhubung: {{ Auth::user()->name }}
                        </span>
                    @endguest
                </div>

                <!-- Input Nama -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_donatur" 
                        value="{{ old('nama_donatur', Auth::user()->name ?? '') }}" 
                        placeholder="Contoh: Ahmad Fauzi"
                        :disabled="isAnonim"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3 disabled:bg-slate-100 disabled:text-slate-400">
                </div>

                <!-- Checkbox Anonim / Hamba Allah -->
                <div class="flex items-center gap-2 pt-0.5">
                    <input type="checkbox" id="is_anonim" name="is_anonim" value="1" x-model="isAnonim" class="rounded text-teal-600 focus:ring-teal-500">
                    <label for="is_anonim" class="text-xs font-semibold text-slate-600 cursor-pointer">
                        Sembunyikan nama saya (Tampilkan sebagai <strong class="text-teal-700">Hamba Allah</strong>)
                    </label>
                </div>

                <!-- Input No HP / WhatsApp -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                        Nomor WhatsApp <span class="text-rose-500">*</span>
                    </label>
                    <input type="tel" name="no_hp" value="{{ old('no_hp', Auth::user()->phone ?? '') }}" required placeholder="081234567890"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    <p class="text-[10px] text-slate-400 mt-1">Digunakan untuk konfirmasi dan update laporan penyaluran donasi.</p>
                    @error('no_hp') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Input Email (Opsional) -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Email (Opsional)</label>
                    <input type="email" name="email" value="{{ old('email', Auth::user()->email ?? '') }}" placeholder="nama@email.com"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                </div>

                <!-- Input Doa / Pesan Kebaikan -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Doa atau Pesan Kebaikan (Opsional)</label>
                    <textarea name="doa" rows="2" placeholder="Tuliskan doa terbaik untuk santri, masjid, atau diri dan keluarga..."
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">{{ old('doa') }}</textarea>
                </div>
            </div>

            <!-- Tombol Submit -->
            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-black text-sm py-3.5 rounded-2xl shadow-lg shadow-amber-500/25 active:scale-95 transition flex items-center justify-center gap-2">
                <span>Lanjut ke Pembayaran</span>
                <span>→</span>
            </button>
        </form>
    </div>
</x-app-layout>
