<x-app-layout>
    

    <div class="space-y-4 sm:space-y-5">

        <!-- Card Motivasi & Pengingat Niat Admin -->
        <div class="relative overflow-hidden bg-[#2B5B84] text-white p-4 sm:p-5 rounded-3xl shadow-sm border border-[#1E4363]">
            <div class="absolute -right-8 -top-8 w-32 h-32 rounded-full bg-white/5 pointer-events-none"></div>
            <div class="absolute right-10 -bottom-10 w-24 h-24 rounded-full bg-white/5 pointer-events-none"></div>

            <div class="relative flex items-start gap-3.5 sm:gap-4">
                <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-2xl bg-white/15 border border-white/15 flex items-center justify-center shrink-0 mt-0.5">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-sky-100" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 3l1.9 4.5L18.5 9l-4.6 1.5L12 15l-1.9-4.5L5.5 9l4.6-1.5L12 3z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M5 19l.9 2.1L8 22l-2.1.9L5 25l-.9-2.1L2 22l2.1-.9L5 19z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" transform="translate(0 -3)"/>
                    </svg>
                </div>

                <div class="space-y-1.5 min-w-0 flex-1">
                    <div class="flex flex-wrap items-center gap-2">
                        <span class="text-[10px] font-extrabold uppercase tracking-wider bg-white/15 text-sky-50 px-2.5 py-0.5 rounded-full">
                            Pengingat Amanah
                        </span>
                        <span class="text-[11px] font-semibold text-sky-100/90">
                            Bismillah, lillahi ta'ala
                        </span>
                    </div>
                    <h3 class="text-sm sm:text-base font-extrabold leading-snug">
                        Ikhlaskan Niat Berdakwah &amp; Berjuang di Jalan Allah
                    </h3>
                    <p class="text-xs text-sky-50/90 leading-relaxed">
                        Setiap data yang diverifikasi dan amanah yang dijaga adalah bagian dari perjuangan di jalan-Nya. Jangan pernah berputus asa saat lelah atau menghadapi ujian—teruslah melangkah dengan sabar dan senantiasa memohon pertolongan serta kekuatan hanya kepada Allah.
                    </p>
                    <p class="text-[11px] font-bold text-amber-200 pt-0.5">
                        "Hasbunallahu wa ni'mal wakil" — Cukuplah Allah menjadi Penolong kami.
                    </p>
                </div>
            </div>
        </div>

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

        <!-- 4 Kartu Metrik Utama (Ringkas) -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-3">
            <!-- 1. Total Donasi Terverifikasi -->
            <div class="bg-white p-3 sm:p-3.5 rounded-2xl border border-slate-100 shadow-xs flex items-center gap-2.5 sm:gap-3">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3v12m0 0 5-5m-5 5-5-5M5 21h14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide truncate">Terverifikasi</p>
                    <p class="text-sm sm:text-base font-black text-[#155E4B] truncate">Rp {{ number_format($totalDonasiVerif, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- 2. Perlu Verifikasi -->
            <div class="bg-white p-3 sm:p-3.5 rounded-2xl border border-slate-100 shadow-xs flex items-center gap-2.5 sm:gap-3">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="2"/><path d="M12 7v5l3 2" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide truncate">Perlu Verifikasi</p>
                    <p class="text-sm sm:text-base font-black text-[#155E4B] truncate">{{ $pendingVerificationCount }} Donasi</p>
                </div>
            </div>

            <!-- 3. Total Penyaluran -->
            <div class="bg-white p-3 sm:p-3.5 rounded-2xl border border-slate-100 shadow-xs flex items-center gap-2.5 sm:gap-3">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21V9m0 0 5 5m-5-5-5 5M5 3h14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide truncate">Penyaluran</p>
                    <p class="text-sm sm:text-base font-black text-[#155E4B] truncate">Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</p>
                </div>
            </div>

            <!-- 4. Saldo Kas Yayasan -->
            <div class="bg-white p-3 sm:p-3.5 rounded-2xl border border-slate-100 shadow-xs flex items-center gap-2.5 sm:gap-3">
                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h18v12H3zM7 7V5h10v2M7 12h10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <div class="min-w-0">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wide truncate">Saldo Kas</p>
                    <p class="text-sm sm:text-base font-black text-[#155E4B] truncate">Rp {{ number_format($saldo, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Menu Pintas Admin (Quick Actions Ringkas) -->
        <div class="space-y-2.5">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Menu Operasional Donasi &amp; Yayasan</h3>
            <div class="grid grid-cols-4 sm:grid-cols-8 gap-x-2 gap-y-4 bg-white p-3.5 sm:p-4 rounded-3xl border border-slate-100 shadow-xs">
                <!-- 0. Laporan Keuangan Internal Yayasan -->
                <a href="{{ route('admin.laporan-internal.index') }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#2B5B84] group-hover:bg-[#1E4363] flex items-center justify-center text-white group-hover:scale-105 transition shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 group-hover:text-[#2B5B84] leading-tight">Laporan</span>
                </a>

                <!-- 1. Verifikasi Donasi -->
                <a href="{{ route('admin.donasi.index') }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#2B5B84] group-hover:bg-[#1E4363] flex items-center justify-center text-white group-hover:scale-105 transition shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 group-hover:text-[#2B5B84] leading-tight">Verifikasi</span>
                </a>

                <!-- 2. Input Donasi Manual -->
                <a href="{{ route('admin.donasi.manual.create') }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#2B5B84] group-hover:bg-[#1E4363] flex items-center justify-center text-white group-hover:scale-105 transition shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 group-hover:text-[#2B5B84] leading-tight">Input Manual</span>
                </a>

                <!-- 3. Ambil Donasi / Penyaluran -->
                <a href="{{ route('admin.penyaluran.index') }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#2B5B84] group-hover:bg-[#1E4363] flex items-center justify-center text-white group-hover:scale-105 transition shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 group-hover:text-[#2B5B84] leading-tight">Penyaluran</span>
                </a>

                <!-- 4. Kelola Program -->
                <a href="{{ route('admin.programs.index') }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#2B5B84] group-hover:bg-[#1E4363] flex items-center justify-center text-white group-hover:scale-105 transition shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                            <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                            <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                            <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                        </svg>
                    </div>
                    <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 group-hover:text-[#2B5B84] leading-tight">Program</span>
                </a>

                <!-- 5. Kelola Pengguna & Klasemen -->
                <a href="{{ route('admin.users.index') }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#2B5B84] group-hover:bg-[#1E4363] flex items-center justify-center text-white group-hover:scale-105 transition shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm14 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 group-hover:text-[#2B5B84] leading-tight">Pengguna</span>
                </a>

                <!-- 6. Kabar Berita -->
                <a href="{{ route('admin.kabar.index') }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#2B5B84] group-hover:bg-[#1E4363] flex items-center justify-center text-white group-hover:scale-105 transition shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 group-hover:text-[#2B5B84] leading-tight">Berita</span>
                </a>

                <!-- 7. Rekening Bank -->
                <a href="{{ route('admin.banks.index') }}" class="group flex flex-col items-center text-center gap-1.5 transition active:scale-95">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-[#2B5B84] group-hover:bg-[#1E4363] flex items-center justify-center text-white group-hover:scale-105 transition shadow-xs">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 21h18M3 9l9-5 9 5v2H3V9ZM5 11v7m4-7v7m6-7v7m4-7v7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span class="text-[11px] sm:text-xs font-extrabold text-slate-800 group-hover:text-[#2B5B84] leading-tight">Rekening</span>
                </a>
            </div>
        </div>

        <!-- Tabel Donasi Perlu Verifikasi Cepat -->
        <div class="bg-white rounded-3xl border border-slate-100 p-5 sm:p-6 shadow-sm space-y-3.5">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-800">Donasi Terbaru</h3>

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
