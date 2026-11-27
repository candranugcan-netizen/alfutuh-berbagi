<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header Page -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Doa &amp; Dukungan Donatur</h1>
                <p class="text-xs text-slate-500 mt-0.5">Untaian doa kebaikan dari para muhsinin dan dermawan Yayasan Al Futuh</p>
            </div>
            <a href="{{ route('landing') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-4 py-2 rounded-full transition self-start sm:self-auto">
                ← Kembali
            </a>
        </div>

        <!-- Mini Stats Card -->
        <div class="grid grid-cols-2 gap-3.5">
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Doa Terkumpul</span>
                <p class="text-xl sm:text-2xl font-black text-[#155E4B]">{{ number_format($totalDoaCount, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Doa dari para dermawan</p>
            </div>
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Total Donasi Terverifikasi</span>
                <p class="text-xl sm:text-2xl font-black text-[#155E4B]">Rp {{ number_format($totalDonasiVerif, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Tercatat di sistem amanah</p>
            </div>
        </div>

        <!-- Daftar Doa & Donatur Berpaginasi -->
        <div class="space-y-3">
            <div class="flex justify-between items-center px-1">
                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                    Untaian Doa Terbaru
                </h3>
                <span class="text-[11px] font-bold text-slate-400">
                    Halaman {{ $donations->currentPage() }} dari {{ $donations->lastPage() }}
                </span>
            </div>

            @forelse($donations as $item)
                <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-sm space-y-2">
                    <div class="flex items-center justify-between text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center font-black text-xs shrink-0">
                                {{ strtoupper(substr($item->displayName, 0, 1)) }}
                            </div>
                            <div>
                                <span class="font-extrabold text-slate-800 block text-xs sm:text-sm">{{ $item->displayName }}</span>
                                <span class="text-[10px] text-slate-400">{{ $item->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <span class="font-black text-xs sm:text-sm text-[#155E4B] bg-[#F2F7F4] px-3 py-1 rounded-full border border-[#D2E6DC]">
                            Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="p-3 bg-[#F8FAF8] rounded-2xl border border-slate-100 text-xs text-slate-700 leading-relaxed italic">
                        "{{ $item->doa }}"
                    </div>

                    @if($item->program)
                        <div class="text-[10px] text-slate-400 flex items-center gap-1 pt-0.5">
                            <span>Berdonasi di:</span>
                            <a href="{{ route('programs.show', $item->program->slug) }}" class="text-[#155E4B] font-bold hover:underline line-clamp-1">
                                {{ $item->program->nama }}
                            </a>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-3xl border border-slate-100 space-y-2">
                    <p class="text-xs text-slate-400">Belum ada doa dan dukungan yang tercatat.</p>
                </div>
            @endforelse

            <!-- Paginasi -->
            @if($donations->hasPages())
                <div class="pt-4">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
