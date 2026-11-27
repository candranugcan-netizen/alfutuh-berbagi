<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Dashboard Admin Al Futuh</h2>
                <p class="text-xs text-slate-500">Kelola donasi masuk, verifikasi transfer, penyaluran dana, dan transparansi yayasan</p>
            </div>
            <a href="{{ route('landing') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-[#155E4B] bg-[#EAF5EE] px-4 py-2 rounded-full font-bold hover:bg-[#DCEEE5] transition border border-[#D2E6DC]">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>Lihat Web Publik</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Alert Donasi Menunggu Verifikasi -->
        @if($pendingVerificationCount > 0)
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white p-4 sm:p-5 rounded-3xl shadow-md shadow-amber-500/20 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div class="flex items-center gap-3.5">
                    <span class="w-11 h-11 shrink-0 bg-white/20 rounded-2xl flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9ZM10 21h4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <div>
                        <h4 class="font-black text-sm sm:text-base">Ada {{ $pendingVerificationCount }} Donasi Menunggu Verifikasi!</h4>
                        <p class="text-xs text-amber-100 mt-0.5">Donatur telah mengunggah bukti transfer. Segera periksa mutasi dan konfirmasi.</p>
                    </div>
                </div>
                <a href="{{ route('admin.donasi.index', ['status' => 'pending_verification']) }}" class="bg-white text-amber-800 font-extrabold text-xs px-5 py-2.5 rounded-full shadow-sm hover:bg-amber-50 active:scale-95 transition shrink-0">
                    Verifikasi Sekarang →
                </a>
            </div>
        @endif

        <!-- 4 Kartu Metrik Utama -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            <!-- 1. Total Donasi Terverifikasi -->
            <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-10 h-10 rounded-2xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center mb-1.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v12m0 0 5-5m-5 5-5-5M5 21h14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Donasi Terverifikasi</p>
                <p class="text-lg sm:text-xl font-black text-[#155E4B]">Rp {{ number_format($totalDonasiVerif, 0, ',', '.') }}</p>
                <p class="text-[10px] text-[#155E4B] font-semibold">Tercatat amanah di sistem</p>
            </div>

            <!-- 2. Perlu Verifikasi -->
            <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-1.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="2"/><path d="M12 7v5l3 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Perlu Verifikasi</p>
                <p class="text-lg sm:text-xl font-black text-amber-600">{{ $pendingVerificationCount }} Donasi</p>
                <p class="text-[10px] text-amber-600 font-semibold">Menunggu pengecekan</p>
            </div>

            <!-- 3. Total Penyaluran -->
            <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center mb-1.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21V9m0 0 5 5m-5-5-5 5M5 3h14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Penyaluran</p>
                <p class="text-lg sm:text-xl font-black text-rose-600">Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400 font-semibold">Tersalur ke mustahik</p>
            </div>

            <!-- 4. Saldo Kas Yayasan -->
            <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-10 h-10 rounded-2xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center mb-1.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h18v12H3zM7 7V5h10v2M7 12h10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Saldo Kas Yayasan</p>
                <p class="text-lg sm:text-xl font-black text-[#155E4B]">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                <p class="text-[10px] text-emerald-600 font-semibold">Saldo Kas Seluruh Donasi</p>
            </div>
        </div>

        <!-- Menu Pintas Admin (Quick Actions dengan Ikon Bersih dan Berbeda) -->
        <div class="space-y-2.5">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Menu Operasional Donasi &amp; Yayasan</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-7 gap-2.5">
                <!-- 0. Laporan Keuangan Internal Yayasan -->
                <a href="{{ route('admin.laporan-internal.index') }}" class="bg-gradient-to-b from-[#EAF5EE] to-white p-4 rounded-2xl border border-[#D2E6DC] shadow-sm hover:border-[#155E4B] transition flex flex-col items-center text-center group active:scale-95">
                    <div class="w-12 h-12 rounded-2xl bg-[#155E4B] text-white flex items-center justify-center mb-2 group-hover:scale-110 transition shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-xs font-black text-[#155E4B]">Laporan Internal</p>
                    <p class="text-[10px] text-slate-500 mt-0.5">Laporan Untuk Yayasan</p>
                </a>
                <!-- 1. Verifikasi Donasi -->
                <a href="{{ route('admin.donasi.index') }}" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:border-[#155E4B] transition flex flex-col items-center text-center group active:scale-95">
                    <div class="w-12 h-12 rounded-2xl bg-[#F2F7F4] text-[#155E4B] flex items-center justify-center mb-2 group-hover:scale-110 group-hover:bg-[#155E4B] group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-xs font-extrabold text-slate-800">Verifikasi Donasi</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Cek bukti transfer</p>
                </a>

                <!-- 2. Input Donasi Manual -->
                <a href="{{ route('admin.donasi.manual.create') }}" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:border-[#155E4B] transition flex flex-col items-center text-center group active:scale-95">
                    <div class="w-12 h-12 rounded-2xl bg-[#F2F7F4] text-[#155E4B] flex items-center justify-center mb-2 group-hover:scale-110 group-hover:bg-[#155E4B] group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-xs font-extrabold text-slate-800">Input Manual</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Infaq kotak &amp; cash</p>
                </a>

                <!-- 3. Ambil Donasi / Penyaluran -->
                <a href="{{ route('admin.penyaluran.index') }}" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:border-[#155E4B] transition flex flex-col items-center text-center group active:scale-95">
                    <div class="w-12 h-12 rounded-2xl bg-[#F2F7F4] text-[#155E4B] flex items-center justify-center mb-2 group-hover:scale-110 group-hover:bg-[#155E4B] group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-xs font-extrabold text-slate-800">Ambil Donasi</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Lapor penyaluran</p>
                </a>

                <!-- 4. Kelola Program -->
                <a href="{{ route('admin.programs.index') }}" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:border-[#155E4B] transition flex flex-col items-center text-center group active:scale-95">
                    <div class="w-12 h-12 rounded-2xl bg-[#F2F7F4] text-[#155E4B] flex items-center justify-center mb-2 group-hover:scale-110 group-hover:bg-[#155E4B] group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                            <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                            <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                            <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <p class="text-xs font-extrabold text-slate-800">Kelola Program</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Tambah kampanye</p>
                </a>

                <!-- 5. Kabar Berita -->
                <a href="{{ route('admin.kabar.index') }}" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:border-[#155E4B] transition flex flex-col items-center text-center group active:scale-95">
                    <div class="w-12 h-12 rounded-2xl bg-[#F2F7F4] text-[#155E4B] flex items-center justify-center mb-2 group-hover:scale-110 group-hover:bg-[#155E4B] group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-xs font-extrabold text-slate-800">Kabar Berita</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Update kegiatan</p>
                </a>

                <!-- 6. Rekening Bank -->
                <a href="{{ route('admin.banks.index') }}" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:border-[#155E4B] transition flex flex-col items-center text-center group active:scale-95">
                    <div class="w-12 h-12 rounded-2xl bg-[#F2F7F4] text-[#155E4B] flex items-center justify-center mb-2 group-hover:scale-110 group-hover:bg-[#155E4B] group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 21h18M3 9l9-5 9 5v2H3V9ZM5 11v7m4-7v7m6-7v7m4-7v7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <p class="text-xs font-extrabold text-slate-800">Rekening Bank</p>
                    <p class="text-[10px] text-slate-400 mt-0.5">Bank &amp; QRIS</p>
                </a>
            </div>
        </div>

        <!-- Tabel Donasi Perlu Verifikasi Cepat -->
        <div class="bg-white rounded-3xl border border-slate-100 p-5 sm:p-6 shadow-sm space-y-3.5">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-800">Donasi Menunggu Verifikasi Terbaru</h3>
                    <p class="text-xs text-slate-400">Bukti transfer yang baru saja dikirim oleh donatur</p>
                </div>
                <a href="{{ route('admin.donasi.index') }}" class="text-xs font-bold text-[#155E4B] hover:underline inline-flex items-center gap-1">
                    <span>Lihat Semua Donasi</span>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </a>
            </div>

            <div class="divide-y divide-slate-100">
                @forelse($pendingDonations as $item)
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-mono text-xs font-bold text-[#155E4B] bg-[#EAF5EE] px-2.5 py-0.5 rounded-full border border-[#D2E6DC]">{{ $item->kode_donasi }}</span>
                                <span class="text-[10px] bg-slate-100 text-slate-600 px-2 py-0.5 rounded-md font-bold">{{ $item->bank_tujuan }}</span>
                                <span class="text-[10px] text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs font-extrabold text-slate-800">{{ $item->program->nama }}</p>
                            <p class="text-[11px] text-slate-500">
                                Donatur: <strong class="text-slate-700">{{ $item->displayName }}</strong>
                                @if($item->no_hp)
                                    • WA: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}" target="_blank" class="text-[#155E4B] hover:underline">{{ $item->no_hp }}</a>
                                @endif
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="text-right">
                                <span class="text-[10px] text-slate-400 block">Total Transfer</span>
                                <span class="font-black text-[#155E4B] text-sm">Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }}</span>
                            </div>

                            @if($item->bukti_transfer)
                                <a href="{{ asset('storage/' . $item->bukti_transfer) }}" target="_blank" class="text-xs font-bold text-sky-700 bg-sky-50 px-3 py-1.5 rounded-full border border-sky-100 hover:bg-sky-100 transition">
                                    Bukti Foto
                                </a>
                            @endif

                            <form action="{{ route('admin.donasi.verify', $item->id) }}" method="POST" onsubmit="return confirmSubmit(event, { title: 'Verifikasi Donasi?', text: 'Pastikan dana sebesar Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }} sudah masuk rekening.', icon: 'question', confirmButtonText: 'Ya, Verifikasi!', confirmButtonColor: '#155E4B', danger: false })">
                                @csrf
                                <button type="submit" class="bg-[#155E4B] hover:bg-[#0E4436] text-white font-bold text-xs px-4 py-1.5 rounded-full shadow-sm transition active:scale-95">
                                    Verifikasi ✓
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 space-y-1">
                        <div class="w-10 h-10 rounded-full bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 6 9 17l-5-5" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <p class="text-xs font-bold text-slate-700">Semua Donasi Telah Diverifikasi</p>
                        <p class="text-[11px] text-slate-400">Tidak ada antrean donasi yang menunggu persetujuan saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
