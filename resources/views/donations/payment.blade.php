<x-app-layout>
    <div class="max-w-xl mx-auto space-y-6">

        <!-- Top Header Navigation Bar -->
        <div class="flex items-center justify-between">
            <a href="{{ route('donations.my-donations') }}" class="w-10 h-10 rounded-full bg-white border border-slate-100 flex items-center justify-center text-slate-700 hover:text-[#155E4B] shadow-sm transition active:scale-95" title="Riwayat">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <h1 class="text-sm font-extrabold text-slate-800">Instruksi Pembayaran</h1>
            <div class="w-10"></div>
        </div>

        <!-- Status Card -->
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm text-center space-y-2.5">
            <span class="inline-block px-4 py-1.5 rounded-full text-xs font-bold
                @if($donation->status === 'verified') bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC]
                @elseif($donation->status === 'pending_verification') bg-sky-50 text-sky-700 border border-sky-100
                @elseif($donation->status === 'rejected') bg-rose-50 text-rose-700 border border-rose-100
                @else bg-amber-50 text-amber-800 border border-amber-200 @endif">
                {{ $donation->status_label }}
            </span>
            <p class="text-xs text-slate-400">Kode Transaksi: <strong class="text-slate-700 font-mono">{{ $donation->kode_donasi }}</strong></p>
            <p class="text-sm font-extrabold text-slate-800">{{ $donation->program->nama }}</p>
        </div>

        @if($donation->status === 'verified')
            <!-- Jika Sudah Diverifikasi -->
            <div class="bg-[#EAF5EE] border border-[#D2E6DC] p-6 sm:p-8 rounded-3xl text-center space-y-3.5">
                <div class="w-12 h-12 rounded-full bg-[#155E4B] text-white flex items-center justify-center mx-auto shadow-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <h3 class="font-black text-lg sm:text-xl text-[#155E4B]">Alhamdulillah! Donasi Telah Terverifikasi</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed max-w-md mx-auto">
                    Jazakumullah khairan katsiran atas sedekah sebesar <strong>Rp {{ number_format($donation->nominal, 0, ',', '.') }}</strong>. Semoga Allah melipatgandakan pahala, memberkahi rezeki, dan menjadikannya amal jariyah abadi.
                </p>
                <div class="pt-2">
                    <a href="{{ route('landing') }}" class="inline-block bg-[#155E4B] hover:bg-[#0E4436] text-white font-bold text-xs px-7 py-3 rounded-full shadow-sm">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

        @elseif($donation->status === 'pending_verification')
            <!-- Jika Sedang Diverifikasi Admin -->
            <div class="bg-sky-50 border border-sky-200 p-6 sm:p-7 rounded-3xl text-center space-y-3">
                <svg class="w-12 h-12 mx-auto text-sky-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                    <path d="M12 7v5l3 2" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <h3 class="font-extrabold text-base sm:text-lg text-sky-900">Bukti Transfer Telah Diterima</h3>
                <p class="text-xs sm:text-sm text-sky-700 leading-relaxed max-w-md mx-auto">
                    Admin Yayasan Al Futuh sedang memverifikasi bukti transfer Anda. Status donasi akan otomatis diperbarui dan nominal akan langsung ditambahkan ke dana program.
                </p>
                @if($donation->bukti_transfer)
                    <div class="pt-2">
                        <img src="{{ asset('storage/' . $donation->bukti_transfer) }}" alt="Bukti Transfer" class="max-h-48 mx-auto rounded-2xl border border-sky-200 shadow-sm">
                    </div>
                @endif
            </div>

        @else
            <!-- Instruksi Transfer Nominal Pas -->
            <div class="bg-[#155E4B] p-6 sm:p-8 rounded-3xl text-white shadow-sm space-y-3.5 text-center">
                <p class="text-xs text-teal-200 uppercase tracking-wider font-semibold">Total yang Harus Ditransfer</p>

                <div class="flex items-baseline justify-center gap-1.5">
                    <span class="text-2xl font-black">Rp</span>
                    <span class="text-3xl sm:text-4xl font-black">{{ number_format($donation->nominal, 0, ',', '.') }}</span>
                </div>

                <p class="text-xs text-teal-200 max-w-sm mx-auto">
                    *Silakan lakukan transfer sesuai nominal pas di atas.
                </p>

                <div class="pt-1">
                    <button type="button" onclick="navigator.clipboard.writeText('{{ $donation->nominal }}'); Swal.fire({ icon: 'success', title: 'Nominal Disalin!', text: 'Nominal Rp {{ number_format($donation->nominal, 0, ',', '.') }} berhasil disalin.', timer: 2000, showConfirmButton: false, customClass: { popup: 'rounded-3xl' } });"
                        class="bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold px-5 py-2.5 rounded-full transition inline-flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><rect x="8" y="8" width="11" height="11" rx="2" stroke-width="1.8"/><path d="M16 8V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v9a2 2 0 0 0 2 2h3" stroke-width="1.8" stroke-linecap="round"/></svg>
                        <span>Salin Nominal Transfer</span>
                    </button>
                </div>
            </div>

            <!-- Detail Rekening Tujuan -->
            <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-3">
                    Rekening Tujuan Transfer
                </h3>

                <div class="p-4 sm:p-5 bg-[#F8FAF8] rounded-2xl border border-slate-100 space-y-2.5">
                    <div class="flex justify-between items-center">
                        <span class="font-extrabold text-sm sm:text-base text-slate-800">{{ $bankAccount->nama_bank }}</span>
                        <span class="text-xs font-bold text-[#155E4B] bg-[#EAF5EE] px-3 py-1 rounded-full border border-[#D2E6DC]">{{ $bankAccount->kode_bank }}</span>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <div>
                            <span class="text-[10px] text-slate-400 block">Nomor Rekening:</span>
                            <span class="font-mono font-black text-base sm:text-lg text-slate-800 tracking-wider">{{ $bankAccount->nomor_rekening }}</span>
                        </div>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $bankAccount->nomor_rekening }}'); Swal.fire({ icon: 'success', title: 'Rekening Disalin!', text: 'Nomor rekening {{ $bankAccount->nomor_rekening }} ({{ $bankAccount->nama_bank }}) berhasil disalin.', timer: 2000, showConfirmButton: false, customClass: { popup: 'rounded-3xl' } });"
                            class="text-xs font-bold bg-[#155E4B] hover:bg-[#0E4436] text-white px-4 py-2 rounded-full shadow-sm transition active:scale-95">
                            Salin Rekening
                        </button>
                    </div>

                    <p class="text-xs text-slate-500">Atas Nama: <strong class="text-slate-700">{{ $bankAccount->atas_nama }}</strong></p>
                </div>

                @if($bankAccount->instruksi)
                    <div class="flex items-center gap-2.5 text-xs text-slate-600 bg-[#F2F7F4] p-3.5 rounded-2xl border border-[#E2ECE6]">
                        <svg class="w-4 h-4 shrink-0 text-[#155E4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="1.8"/><path d="M12 11v5m0-8h.01" stroke-width="1.8" stroke-linecap="round"/></svg>
                        <span>{{ $bankAccount->instruksi }}</span>
                    </div>
                @endif
            </div>

            <!-- Form Upload Bukti Transfer -->
            <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-100 shadow-sm space-y-4">
                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                    Sudah Transfer? Unggah Bukti Pembayaran
                </h3>

                <form action="{{ route('donations.upload-proof', $donation->kode_donasi) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <input type="file" name="bukti_transfer" accept="image/*" required
                            class="w-full text-xs border border-slate-200 rounded-2xl p-3 focus:border-[#155E4B]">
                        <p class="text-[10px] text-slate-400 mt-1.5">Format JPG, PNG, atau WEBP (Maksimal 5MB)</p>
                        @error('bukti_transfer') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-4 rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition">
                        Kirim Bukti Transfer Sekarang
                    </button>
                </form>
            </div>

            <!-- Konfirmasi Cepat via WhatsApp -->
            <div class="text-center pt-1">
                @php
                    $waText = urlencode("Assalamu'alaikum Admin Al Futuh, saya sudah transfer donasi sebesar Rp " . number_format($donation->total_pembayaran, 0, ',', '.') . " untuk program *" . $donation->program->nama . "* dengan Kode Transaksi: *" . $donation->kode_donasi . "*. Mohon diverifikasi.");
                @endphp
                <a href="https://wa.me/6285799954005?text={{ $waText }}" target="_blank"
                    class="inline-flex items-center gap-2 text-xs font-bold text-[#155E4B] bg-[#EAF5EE] border border-[#D2E6DC] px-6 py-3 rounded-full hover:bg-[#DCEEE5] transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 15a4 4 0 0 1-4 4H8l-5 3V7a4 4 0 0 1 4-4h10a4 4 0 0 1 4 4v8Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Konfirmasi Cepat via WhatsApp</span>
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
