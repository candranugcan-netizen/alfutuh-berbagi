<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-black text-xl text-slate-800 leading-tight">Dashboard Admin Al Futuh</h2>
                <p class="text-xs text-slate-500">Kelola donasi masuk, penyaluran dana, dan transparansi yayasan</p>
            </div>
            <a href="{{ route('landing') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-teal-700 bg-teal-50 px-3.5 py-2 rounded-xl font-bold hover:bg-teal-100 transition border border-teal-100">
                🌐 Lihat Web Publik
            </a>
        </div>
    </x-slot>

    <div class="py-4 space-y-5">

        <!-- Alert Donasi Menunggu Verifikasi -->
        @if($pendingVerificationCount > 0)
            <div class="bg-amber-500 text-white p-4 rounded-3xl shadow-md shadow-amber-500/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <span class="text-2xl bg-white/20 p-2 rounded-2xl">🔔</span>
                    <div>
                        <h4 class="font-black text-sm">Ada {{ $pendingVerificationCount }} Donasi Menunggu Verifikasi!</h4>
                        <p class="text-xs text-amber-100">Donatur telah mengunggah bukti transfer. Segera periksa dan konfirmasi.</p>
                    </div>
                </div>
                <a href="{{ route('admin.donasi.index', ['status' => 'pending_verification']) }}" class="bg-white text-amber-700 font-extrabold text-xs px-4 py-2 rounded-xl shadow-sm hover:bg-amber-50 active:scale-95 transition">
                    Verifikasi Sekarang →
                </a>
            </div>
        @endif

        <!-- 4 Kartu Metrik Utama -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
            <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-8 h-8 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center font-bold text-base mb-1">📥</div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Donasi Terverifikasi</p>
                <p class="text-lg font-black text-teal-700">Rp {{ number_format($totalDonasiVerif, 0, ',', '.') }}</p>
                <p class="text-[10px] text-teal-600 font-medium">Masuk ke kas program</p>
            </div>

            <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-8 h-8 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-base mb-1">⏳</div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Perlu Verifikasi</p>
                <p class="text-lg font-black text-amber-600">{{ $pendingVerificationCount }} Donasi</p>
                <p class="text-[10px] text-amber-600 font-medium">Menunggu persetujuan</p>
            </div>

            <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-base mb-1">📤</div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Penyaluran</p>
                <p class="text-lg font-black text-rose-600">Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Tersalurkan ke mustahik</p>
            </div>

            <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-base mb-1">⚖️</div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Saldo Kas Yayasan</p>
                <p class="text-lg font-black text-emerald-700">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                <p class="text-[10px] text-emerald-600 font-medium">Total saldo aktif</p>
            </div>
        </div>

        <!-- Menu Pintas Admin (Quick Actions) -->
        <div class="space-y-2">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Menu Operasional Donasi & Yayasan</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-2.5">
                <a href="{{ route('admin.donasi.index') }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-teal-200 transition flex flex-col items-center text-center group">
                    <span class="text-2xl mb-1 group-hover:scale-110 transition">📋</span>
                    <p class="text-xs font-bold text-slate-800">Verifikasi Donasi</p>
                    <p class="text-[10px] text-slate-400">Cek bukti transfer</p>
                </a>

                <a href="{{ route('admin.donasi.manual.create') }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-teal-200 transition flex flex-col items-center text-center group">
                    <span class="text-2xl mb-1 group-hover:scale-110 transition">✍️</span>
                    <p class="text-xs font-bold text-slate-800">Input Manual</p>
                    <p class="text-[10px] text-slate-400">Infaq offline & kotak</p>
                </a>

                <a href="{{ route('admin.penyaluran.index') }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-teal-200 transition flex flex-col items-center text-center group">
                    <span class="text-2xl mb-1 group-hover:scale-110 transition">📤</span>
                    <p class="text-xs font-bold text-slate-800">Ambil Donasi</p>
                    <p class="text-[10px] text-slate-400">Catat penyaluran dana</p>
                </a>

                <a href="{{ route('admin.programs.index') }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-teal-200 transition flex flex-col items-center text-center group">
                    <span class="text-2xl mb-1 group-hover:scale-110 transition">🤲</span>
                    <p class="text-xs font-bold text-slate-800">Kelola Program</p>
                    <p class="text-[10px] text-slate-400">Tambah program baru</p>
                </a>

                <a href="{{ route('admin.kabar.index') }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-teal-200 transition flex flex-col items-center text-center group">
                    <span class="text-2xl mb-1 group-hover:scale-110 transition">📰</span>
                    <p class="text-xs font-bold text-slate-800">Kabar Berita</p>
                    <p class="text-[10px] text-slate-400">Update kegiatan</p>
                </a>

                <a href="{{ route('keuangan.index') }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-teal-200 transition flex flex-col items-center text-center group">
                    <span class="text-2xl mb-1 group-hover:scale-110 transition">💰</span>
                    <p class="text-xs font-bold text-slate-800">Buku Kas</p>
                    <p class="text-[10px] text-slate-400">Ekspor Excel & PDF</p>
                </a>
            </div>
        </div>

        <!-- Tabel Donasi Perlu Verifikasi Cepat -->
        <div class="bg-white rounded-3xl border border-slate-100 p-5 shadow-sm space-y-3">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-sm font-black text-slate-800">Donasi Menunggu Verifikasi Terbaru</h3>
                    <p class="text-xs text-slate-400">Bukti transfer yang baru saja dikirim oleh donatur</p>
                </div>
                <a href="{{ route('admin.donasi.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700">
                    Lihat Semua Donasi →
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($pendingDonations as $item)
                    <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs font-bold text-teal-700">{{ $item->kode_donasi }}</span>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md font-bold">{{ $item->bank_tujuan }}</span>
                            </div>
                            <p class="text-xs font-bold text-slate-800">{{ $item->program->nama }}</p>
                            <p class="text-[11px] text-slate-500">
                                Donatur: <strong class="text-slate-700">{{ $item->displayName }}</strong> ({{ $item->no_hp }})
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <span class="text-[10px] text-slate-400 block">Total Transfer</span>
                                <span class="font-black text-teal-700 text-sm">Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }}</span>
                            </div>

                            @if($item->bukti_transfer)
                                <a href="{{ asset('storage/' . $item->bukti_transfer) }}" target="_blank" class="text-xs font-bold text-sky-600 bg-sky-50 px-2.5 py-1.5 rounded-xl border border-sky-100 hover:bg-sky-100 transition">
                                    Lihat Bukti 🔍
                                </a>
                            @endif

                            <form action="{{ route('admin.donasi.verify', $item->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs px-3 py-1.5 rounded-xl shadow-sm transition active:scale-95">
                                    Verifikasi ✓
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Tidak ada donasi yang menunggu verifikasi saat ini.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
