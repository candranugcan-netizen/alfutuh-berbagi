<x-app-layout>
    <div class="py-4 space-y-5">
        <!-- Banner Detail Program -->
        <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
            <div class="h-56 md:h-80 w-full bg-slate-100 relative overflow-hidden">
                @if($program->banner)
                    <img src="{{ asset('storage/' . $program->banner) }}" alt="{{ $program->nama }}" class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full bg-gradient-to-br from-teal-600 via-teal-700 to-teal-900 flex items-center justify-center text-7xl text-white">
                        {{ $program->icon ?: '🤲' }}
                    </div>
                @endif
                <div class="absolute top-4 left-4">
                    <span class="text-xs font-bold bg-white/95 backdrop-blur-md text-teal-800 px-3 py-1 rounded-xl shadow-sm">
                        {{ $program->kategori }}
                    </span>
                </div>
            </div>

            <!-- Program Info -->
            <div class="p-5 md:p-6 space-y-4">
                <h1 class="text-xl md:text-2xl font-black text-slate-800 leading-snug">
                    {{ $program->nama }}
                </h1>

                <!-- Penggalang Dana Verified -->
                <div class="flex items-center gap-3 p-3 bg-slate-50 rounded-2xl border border-slate-100">
                    <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center font-bold text-lg">
                        🕌
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="font-extrabold text-xs text-slate-800">Yayasan Al Futuh Peduli</span>
                            <span class="w-4 h-4 rounded-full bg-teal-600 text-white text-[10px] flex items-center justify-center font-bold" title="Lembaga Terverifikasi">✓</span>
                        </div>
                        <p class="text-[10px] text-slate-400">Pengelola Resmi Dana Umat</p>
                    </div>
                </div>

                <!-- Progress Bar & Metrik -->
                <div class="space-y-2 pt-2">
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-teal-600 h-3 rounded-full transition-all duration-500" style="width: {{ $program->persentase }}%"></div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 pt-1 text-center">
                        <div class="bg-teal-50/60 p-2.5 rounded-2xl border border-teal-100">
                            <span class="text-slate-400 text-[10px] block">Terkumpul</span>
                            <span class="font-black text-teal-800 text-sm">Rp {{ number_format($program->dana_terkumpul, 0, ',', '.') }}</span>
                        </div>
                        <div class="bg-slate-50 p-2.5 rounded-2xl border border-slate-100">
                            <span class="text-slate-400 text-[10px] block">Target</span>
                            <span class="font-bold text-slate-700 text-xs">
                                {{ $program->target_dana > 0 ? 'Rp ' . number_format($program->target_dana, 0, ',', '.') : 'Berkelanjutan' }}
                            </span>
                        </div>
                        <div class="bg-slate-50 p-2.5 rounded-2xl border border-slate-100">
                            <span class="text-slate-400 text-[10px] block">Donasi</span>
                            <span class="font-bold text-slate-700 text-xs">{{ $program->total_donatur }} Donatur</span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Donasi CTA -->
                <div class="pt-2">
                    <a href="{{ route('donations.create', $program->slug) }}" class="block w-full text-center bg-amber-500 hover:bg-amber-600 text-white font-black text-sm py-3.5 rounded-2xl shadow-lg shadow-amber-500/25 active:scale-95 transition">
                        Bantu Sekarang (Donasi) →
                    </a>
                </div>
            </div>
        </div>

        <!-- Tabs Content (Cerita, Kabar, Donatur) -->
        <div x-data="{ tab: 'cerita' }" class="bg-white rounded-3xl p-5 md:p-6 border border-slate-100 shadow-sm space-y-4">
            <!-- Tab Headers -->
            <div class="flex border-b border-slate-100 gap-6 text-xs font-bold">
                <button @click="tab = 'cerita'" :class="tab === 'cerita' ? 'text-teal-700 border-b-2 border-teal-600 pb-3 font-black' : 'text-slate-400 pb-3 hover:text-slate-600'">
                    📖 Cerita Lengkap
                </button>
                <button @click="tab = 'kabar'" :class="tab === 'kabar' ? 'text-teal-700 border-b-2 border-teal-600 pb-3 font-black' : 'text-slate-400 pb-3 hover:text-slate-600'">
                    📰 Kabar & Penyaluran ({{ $kabars->count() + $penyalurans->count() }})
                </button>
                <button @click="tab = 'donatur'" :class="tab === 'donatur' ? 'text-teal-700 border-b-2 border-teal-600 pb-3 font-black' : 'text-slate-400 pb-3 hover:text-slate-600'">
                    🤲 Doa & Donatur ({{ $donations->total() }})
                </button>
            </div>

            <!-- Tab 1: Cerita -->
            <div x-show="tab === 'cerita'" class="space-y-4 text-xs md:text-sm text-slate-600 leading-relaxed">
                <div class="whitespace-pre-line">
                    {{ $program->deskripsi }}
                </div>
            </div>

            <!-- Tab 2: Kabar & Penyaluran -->
            <div x-show="tab === 'kabar'" style="display: none;" class="space-y-4">
                @if($penyalurans->isNotEmpty())
                    <div class="space-y-2">
                        <h4 class="text-xs font-bold text-teal-800 uppercase tracking-wider">Laporan Penyaluran Dana</h4>
                        @foreach($penyalurans as $p)
                            <div class="p-3.5 bg-teal-50/50 rounded-2xl border border-teal-100 space-y-1">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-extrabold text-teal-800">{{ $p->judul }}</span>
                                    <span class="font-black text-teal-700">Rp {{ number_format($p->nominal, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-[11px] text-slate-500">Penerima: {{ $p->penerima }} • {{ $p->tanggal->format('d M Y') }}</p>
                                <p class="text-xs text-slate-600 mt-1">{{ $p->keterangan }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($kabars->isNotEmpty())
                    <div class="space-y-2 pt-2">
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Artikel Kabar Terbaru</h4>
                        @foreach($kabars as $k)
                            <a href="{{ route('kabars.show', $k->slug) }}" class="block p-3 rounded-2xl border border-slate-100 hover:border-teal-200 transition">
                                <span class="text-[10px] font-bold text-teal-600">{{ $k->tanggal->format('d M Y') }}</span>
                                <h5 class="font-bold text-xs text-slate-800">{{ $k->judul }}</h5>
                                <p class="text-[11px] text-slate-400 mt-0.5 line-clamp-2">{{ $k->ringkasan }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif

                @if($penyalurans->isEmpty() && $kabars->isEmpty())
                    <p class="text-xs text-slate-400 text-center py-6">Belum ada pembaruan kabar atau penyaluran untuk program ini.</p>
                @endif
            </div>

            <!-- Tab 3: Donatur & Doa -->
            <div x-show="tab === 'donatur'" style="display: none;" class="space-y-3">
                @forelse($donations as $donasi)
                    <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100 space-y-1">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-slate-800">{{ $donasi->displayName }}</span>
                            <span class="font-black text-teal-700">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</span>
                        </div>
                        <span class="text-[10px] text-slate-400 block">{{ $donasi->created_at->diffForHumans() }}</span>
                        @if($donasi->doa)
                            <p class="text-xs text-slate-600 italic bg-white p-2 rounded-xl mt-1 border border-slate-100">
                                "{{ $donasi->doa }}"
                            </p>
                        @endif
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-6">Jadilah donatur pertama yang menebar kebaikan di program ini!</p>
                @endforelse

                <div class="pt-2">
                    {{ $donations->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
