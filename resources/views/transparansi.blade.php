<x-app-layout>
    <div class="py-4 space-y-6">
        <!-- Header Transparansi -->
        <div class="text-center max-w-xl mx-auto space-y-2">
            <span class="inline-block px-3 py-1 bg-teal-50 text-teal-700 text-xs font-extrabold rounded-full border border-teal-100">
                🛡️ Akuntabel & Amanah
            </span>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-800 tracking-tight">Laporan Transparansi Dana</h1>
            <p class="text-xs text-slate-500 leading-relaxed">
                Setiap rupiah infaq, sedekah, dan zakat yang diamanahkan kepada Yayasan Al Futuh dicatat dan dilaporkan secara terbuka untuk kemaslahatan umat.
            </p>
        </div>

        <!-- 3 Kartu Ringkasan Keuangan Utama -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-9 h-9 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-lg mb-2">📥</div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Donasi Terkumpul</p>
                <p class="text-xl font-black text-teal-700">Rp {{ number_format($totalDonasi, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Dari seluruh donasi terverifikasi</p>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-9 h-9 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg mb-2">📤</div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Dana Disalurkan</p>
                <p class="text-xl font-black text-amber-600">Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Telah diterima oleh mustahik</p>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg mb-2">⚖️</div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Sisa Saldo Kas Amanah</p>
                <p class="text-xl font-black text-emerald-600">Rp {{ number_format($saldoAmanah, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Siap dialokasikan ke program</p>
            </div>
        </div>

        <!-- Transparansi Berdasarkan Program -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
            <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider border-b border-slate-100 pb-2">
                Ringkasan Donasi Per Program
            </h3>

            <div class="divide-y divide-slate-100">
                @foreach($programsSummary as $ps)
                    <div class="py-3 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                        <div class="space-y-0.5">
                            <span class="font-bold text-xs sm:text-sm text-slate-800">{{ $ps->nama }}</span>
                            <span class="text-[10px] text-slate-400 block">{{ $ps->verified_donations_count }} kali donasi diterima</span>
                        </div>
                        <div class="flex items-center gap-4 text-right">
                            <div>
                                <span class="text-[9px] text-slate-400 block">Terkumpul</span>
                                <span class="font-bold text-teal-700 text-xs">Rp {{ number_format($ps->dana_terkumpul, 0, ',', '.') }}</span>
                            </div>
                            <div>
                                <span class="text-[9px] text-slate-400 block">Disalurkan</span>
                                <span class="font-bold text-amber-600 text-xs">Rp {{ number_format($ps->penyalurans_sum_nominal ?? 0, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Timeline Log Penyaluran Dana -->
        <div class="space-y-3">
            <div class="flex justify-between items-center px-1">
                <h3 class="text-sm font-extrabold text-slate-800 tracking-tight">Riwayat Penyaluran Dana Nyata</h3>
                <span class="text-xs text-slate-400">{{ $penyalurans->total() }} Laporan Diterbitkan</span>
            </div>

            <div class="space-y-3">
                @forelse($penyalurans as $item)
                    <div class="bg-white p-4 md:p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row gap-4">
                        @if($item->foto)
                            <div class="w-full md:w-44 h-36 bg-slate-100 rounded-2xl overflow-hidden shrink-0">
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul }}" class="w-full h-full object-cover">
                            </div>
                        @endif

                        <div class="space-y-2 flex-1">
                            <div class="flex flex-wrap items-center justify-between gap-1">
                                <span class="text-[10px] font-bold bg-teal-50 text-teal-700 px-2.5 py-0.5 rounded-md">
                                    {{ $item->program->nama }}
                                </span>
                                <span class="text-[11px] font-bold text-slate-400">
                                    📅 {{ $item->tanggal->format('d M Y') }}
                                </span>
                            </div>

                            <h4 class="font-bold text-sm md:text-base text-slate-800 leading-snug">
                                {{ $item->judul }}
                            </h4>

                            <div class="flex items-center gap-3 text-xs">
                                <div>
                                    <span class="text-slate-400 text-[10px] block">Nominal Disalurkan:</span>
                                    <span class="font-black text-amber-600 text-sm">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                                </div>
                                <div class="border-l border-slate-100 pl-3">
                                    <span class="text-slate-400 text-[10px] block">Penerima Manfaat:</span>
                                    <span class="font-bold text-slate-700">{{ $item->penerima }}</span>
                                </div>
                            </div>

                            <p class="text-xs text-slate-500 leading-relaxed pt-1">
                                {{ $item->keterangan }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-8 text-center rounded-3xl border border-slate-100">
                        <p class="text-xs text-slate-400">Belum ada riwayat penyaluran dana yang dicatat.</p>
                    </div>
                @endforelse

                <div class="pt-2">
                    {{ $penyalurans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
