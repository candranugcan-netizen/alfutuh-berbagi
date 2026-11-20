<x-app-layout>
    <div class="py-4 max-w-lg mx-auto space-y-4">

        <!-- Status Card -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm text-center space-y-2">
            <span class="inline-block px-3 py-1 rounded-full text-xs font-bold
                @if($donation->status === 'verified') bg-teal-50 text-teal-700 border border-teal-100
                @elseif($donation->status === 'pending_verification') bg-sky-50 text-sky-700 border border-sky-100
                @elseif($donation->status === 'rejected') bg-rose-50 text-rose-700 border border-rose-100
                @else bg-amber-50 text-amber-700 border border-amber-100 @endif">
                {{ $donation->status_label }}
            </span>
            <p class="text-xs text-slate-400">Kode Transaksi: <strong class="text-slate-700">{{ $donation->kode_donasi }}</strong></p>
            <p class="text-xs font-bold text-slate-700">{{ $donation->program->nama }}</p>
        </div>

        @if($donation->status === 'verified')
            <!-- Jika Sudah Diverifikasi -->
            <div class="bg-teal-50 border border-teal-200 p-6 rounded-3xl text-center space-y-3">
                <span class="text-5xl">🎉</span>
                <h3 class="font-black text-lg text-teal-900">Alhamdulillah! Donasi Anda Telah Terverifikasi</h3>
                <p class="text-xs text-teal-700 leading-relaxed">
                    Jazakumullah khairan katsiran atas sedekah sebesar <strong>Rp {{ number_format($donation->nominal, 0, ',', '.') }}</strong>. Semoga Allah melipatgandakan pahala, memberkahi rezeki, dan menjadikannya amal jariyah abadi.
                </p>
                <div class="pt-2">
                    <a href="{{ route('landing') }}" class="inline-block bg-teal-600 text-white font-bold text-xs px-6 py-2.5 rounded-xl shadow-sm">
                        Kembali ke Beranda
                    </a>
                </div>
            </div>

        @elseif($donation->status === 'pending_verification')
            <!-- Jika Sedang Diverifikasi Admin -->
            <div class="bg-sky-50 border border-sky-200 p-5 rounded-3xl text-center space-y-2.5">
                <span class="text-4xl">⏳</span>
                <h3 class="font-extrabold text-base text-sky-900">Bukti Transfer Telah Diterima</h3>
                <p class="text-xs text-sky-700 leading-relaxed">
                    Admin Yayasan Al Futuh sedang memverifikasi bukti transfer Anda. Status donasi akan otomatis diperbarui dan nominal akan langsung ditambahkan ke dana program.
                </p>
                @if($donation->bukti_transfer)
                    <div class="pt-2">
                        <img src="{{ asset('storage/' . $donation->bukti_transfer) }}" alt="Bukti Transfer" class="max-h-48 mx-auto rounded-xl border border-sky-200 shadow-sm">
                    </div>
                @endif
            </div>

        @else
            <!-- Instruksi Transfer Nominal Unik -->
            <div class="bg-gradient-to-br from-teal-700 to-teal-900 p-6 rounded-3xl text-white shadow-lg space-y-3 text-center">
                <p class="text-xs text-teal-200 uppercase tracking-wider font-semibold">Total yang Harus Ditransfer</p>
                
                <!-- Highlight Kode Unik -->
                <div class="flex items-baseline justify-center gap-1">
                    <span class="text-2xl font-black">Rp</span>
                    <span class="text-3xl font-black">{{ number_format($donation->nominal, 0, ',', '.') }}</span>
                    <span class="text-3xl font-black text-amber-300 bg-amber-400/20 px-1.5 py-0.5 rounded-lg border border-amber-300/30" title="3 Digit Kode Unik">{{ sprintf('%03d', $donation->kode_unik) }}</span>
                </div>

                <p class="text-[11px] text-teal-200">
                    *Mohon transfer <strong>tepat hingga 3 digit terakhir</strong> agar verifikasi sistem otomatis dan mudah.
                </p>

                <!-- Tombol Salin Nominal -->
                <button type="button" onclick="navigator.clipboard.writeText('{{ $donation->total_pembayaran }}'); alert('Nominal Rp {{ $donation->total_pembayaran }} berhasil disalin!');"
                    class="bg-white/10 hover:bg-white/20 border border-white/20 text-white text-xs font-bold px-4 py-2 rounded-xl transition">
                    📋 Salin Nominal Transfer
                </button>
            </div>

            <!-- Detail Rekening Tujuan -->
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">
                    Rekening Tujuan Transfer
                </h3>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                    <div class="flex justify-between items-center">
                        <span class="font-extrabold text-sm text-slate-800">{{ $bankAccount->nama_bank }}</span>
                        <span class="text-xs font-bold text-teal-700 bg-teal-50 px-2 py-0.5 rounded-md">{{ $bankAccount->kode_bank }}</span>
                    </div>

                    <div class="flex items-center justify-between pt-1">
                        <div>
                            <span class="text-[10px] text-slate-400 block">Nomor Rekening:</span>
                            <span class="font-mono font-black text-base text-slate-800 tracking-wider">{{ $bankAccount->nomor_rekening }}</span>
                        </div>
                        <button type="button" onclick="navigator.clipboard.writeText('{{ $bankAccount->nomor_rekening }}'); alert('Nomor rekening berhasil disalin!');"
                            class="text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded-xl shadow-sm transition">
                            Salin Rekening
                        </button>
                    </div>

                    <p class="text-xs text-slate-500">Atas Nama: <strong class="text-slate-700">{{ $bankAccount->atas_nama }}</strong></p>
                </div>

                @if($bankAccount->instruksi)
                    <p class="text-[11px] text-slate-500 leading-relaxed italic">
                        ℹ️ {{ $bankAccount->instruksi }}
                    </p>
                @endif
            </div>

            <!-- Form Upload Bukti Transfer -->
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                    Sudah Transfer? Unggah Bukti Pembayaran
                </h3>

                <form action="{{ route('donations.upload-proof', $donation->kode_donasi) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                    @csrf

                    <div>
                        <input type="file" name="bukti_transfer" accept="image/*" required
                            class="w-full text-xs border border-slate-200 rounded-2xl p-2.5 focus:border-teal-500">
                        <p class="text-[10px] text-slate-400 mt-1">Format JPG, PNG, atau WEBP (Maksimal 5MB)</p>
                        @error('bukti_transfer') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-black text-xs py-3 rounded-2xl shadow-md shadow-teal-600/20 active:scale-95 transition">
                        Kirim Bukti Transfer Sekarang
                    </button>
                </form>
            </div>

            <!-- Konfirmasi Cepat via WhatsApp -->
            <div class="text-center pt-2">
                @php
                    $waText = urlencode("Assalamu'alaikum Admin Al Futuh, saya sudah transfer donasi sebesar Rp " . number_format($donation->total_pembayaran, 0, ',', '.') . " untuk program *" . $donation->program->nama . "* dengan Kode Transaksi: *" . $donation->kode_donasi . "*. Mohon diverifikasi.");
                @endphp
                <a href="https://wa.me/6281234567890?text={{ $waText }}" target="_blank"
                    class="inline-flex items-center gap-2 text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-4 py-2.5 rounded-2xl hover:bg-emerald-100 transition">
                    <span>💬</span> Konfirmasi Cepat via WhatsApp
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
