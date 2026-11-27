<x-app-layout>
    <div class="space-y-6">
        <!-- Header Transparansi -->
        <div class="text-center max-w-xl mx-auto space-y-2.5">
            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-[#EAF5EE] text-[#155E4B] text-xs font-extrabold rounded-full border border-[#D2E6DC]">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3 20 6v5c0 5-3.4 8.5-8 10-4.6-1.5-8-5-8-10V6l8-3Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/><path d="m9 12 2 2 4-4" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>Akuntabel &amp; Amanah</span>
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Laporan Transparansi Dana</h1>
            <p class="text-xs text-slate-500 leading-relaxed">
                Setiap rupiah infaq, sedekah, dan zakat yang diamanahkan kepada Al Futuh (Sub Yayasan dari Yayasan Tebar Dakwah Al Islamy, izin Kemenkumham Nomor : AHU 0006697.AH.01.04) dicatat dan dilaporkan secara terbuka untuk kemaslahatan umat.
            </p>
        </div>

        <!-- 3 Kartu Ringkasan Keuangan Utama -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-1.5">
                <div class="w-10 h-10 rounded-2xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 3v12m0 0 5-5m-5 5-5-5M5 21h14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Donasi Terkumpul</p>
                <p class="text-xl sm:text-2xl font-black text-[#155E4B]">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Dari seluruh donasi terverifikasi</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-1.5">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-[#D4AF37] flex items-center justify-center mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 21V9m0 0 5 5m-5-5-5 5M5 3h14" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Dana Disalurkan</p>
                <p class="text-xl sm:text-2xl font-black text-[#D4AF37]">Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Telah diterima oleh mustahik</p>
            </div>

            <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-1.5">
                <div class="w-10 h-10 rounded-2xl bg-[#EAF5EE] text-emerald-600 flex items-center justify-center mb-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M3 7h18v12H3zM7 7V5h10v2M7 12h10" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sisa Saldo Kas Amanah</p>
                <p class="text-xl sm:text-2xl font-black text-emerald-600">Rp {{ number_format($saldoAmanah, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Siap dialokasikan ke program</p>
            </div>
        </div>

        <!-- Transparansi Berdasarkan Program -->
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-3">
                Ringkasan Donasi Per Program
            </h3>

            <div class="divide-y divide-slate-100">
                @foreach($programsSummary as $ps)
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                        <div class="space-y-0.5">
                            <span class="font-extrabold text-xs sm:text-sm text-slate-800">{{ $ps->nama }}</span>
                            <span class="text-[10px] text-slate-400 block">{{ $ps->verified_donations_count }} kali donasi diterima</span>
                        </div>
                        <div class="flex items-center gap-4 text-right">
                            <div>
                                <span class="text-[9px] text-slate-400 block">Terkumpul</span>
                                <span class="font-black text-[#155E4B] text-xs sm:text-sm">Rp {{ number_format($ps->total_donasi_terverifikasi ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-[9px] text-slate-400 block">Disalurkan</span>
                                <span class="font-black text-[#D4AF37] text-xs sm:text-sm">Rp {{ number_format($ps->total_penyaluran ?? 0, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-[9px] text-slate-400 block">Sisa</span>
                                <span class="font-black text-emerald-600 text-xs sm:text-sm">Rp {{ number_format(max(0, (int) $ps->total_donasi_terverifikasi - (int) $ps->total_penyaluran), 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Timeline Log Penyaluran Dana -->
        <div class="space-y-3.5">
            <div class="flex justify-between items-center px-1">
                <h3 class="text-sm font-extrabold text-slate-800 tracking-tight">Riwayat Penyaluran Dana Nyata</h3>
                <span class="text-xs text-slate-400">{{ $penyalurans->total() }} Laporan Diterbitkan</span>
            </div>

            <div class="space-y-3.5">
                @forelse($penyalurans as $item)
                    <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-5">
                        @if($item->foto)
                            <div class="w-full md:w-40 h-40 rounded-2xl bg-slate-100 overflow-hidden shrink-0">
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                            </div>
                        @endif
                        <div class="space-y-2 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="text-[10px] font-bold text-[#155E4B] bg-[#EAF5EE] px-3 py-0.5 rounded-full border border-[#D2E6DC]">
                                    {{ $item->program->nama }}
                                </span>
                                <span class="text-[10px] text-slate-400">📅 {{ $item->tanggal->format('d M Y') }}</span>
                            </div>
                            <h4 class="font-extrabold text-sm sm:text-base text-slate-800">{{ $item->judul }}</h4>
                            <p class="text-xs font-black text-[#155E4B]">
                                Nominal: Rp {{ number_format($item->nominal, 0, ',', '.') }}
                            </p>
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $item->keterangan }}</p>
                            <p class="text-[10px] text-slate-400">Penerima Manfaat: <strong class="text-slate-600">{{ $item->penerima }}</strong></p>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-12 text-center rounded-3xl border border-slate-100">
                        <p class="text-xs text-slate-400">Belum ada laporan penyaluran yang diterbitkan.</p>
                    </div>
                @endforelse

                @if(method_exists($penyalurans, 'links'))
                    <div class="pt-2">
                        {{ $penyalurans->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
