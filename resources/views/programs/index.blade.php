<x-app-layout>
    <div class="space-y-6">
        <!-- Header Page -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Pilih Program Donasi</h1>
                <p class="text-xs text-slate-500 mt-0.5">Salurkan infaq, zakat, dan sedekah untuk kemaslahatan bersama Yayasan Al Futuh</p>
            </div>
            <!-- Search Input -->
            <form action="{{ route('programs.index') }}" method="GET" class="w-full sm:w-72">
                @if(!empty($kategori) && $kategori !== 'Semua')
                    <input type="hidden" name="kategori" value="{{ $kategori }}">
                @endif
                <div class="relative">
                    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari program donasi..." class="w-full text-xs pl-9 pr-4 py-2.5 rounded-full border border-slate-200 focus:border-[#155E4B] focus:ring-[#155E4B]">
                    <span class="absolute left-3 top-2.5 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6" stroke-width="1.8"/><path d="m16 16 4 4" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </span>
                </div>
            </form>
        </div>

        <!-- Filter Kategori Tabs -->
        <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-none text-xs">
            <a href="{{ route('programs.index') }}" class="px-4 py-2 rounded-full font-bold whitespace-nowrap transition {{ ($kategori === 'Semua' || empty($kategori)) ? 'bg-[#155E4B] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-[#155E4B]' }}">
                Semua Program
            </a>
            @foreach($categories as $kat)
                <a href="{{ route('programs.index', ['kategori' => $kat]) }}" class="px-4 py-2 rounded-full font-bold whitespace-nowrap transition {{ strcasecmp($kategori, $kat) === 0 ? 'bg-[#155E4B] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-[#155E4B]' }}">
                    {{ $kat }}
                </a>
            @endforeach
        </div>

        <!-- Grid Program List -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($programs as $item)
                @php
                    $sisaDana = $item->sisa_donasi;
                    $pctSisa = $item->persentase_sisa;
                    $statusSisa = $item->status_sisa;
                    $isOperasional = $item->is_operasional;
                @endphp
                <div class="bg-white rounded-3xl border {{ ($isOperasional && in_array($statusSisa, ['critical', 'warning', 'empty'])) ? 'border-amber-300 ring-2 ring-amber-100 shadow-sm' : 'border-slate-100 shadow-sm' }} overflow-hidden hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-44 w-full bg-slate-100 relative overflow-hidden">
                            @if($item->banner)
                                <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                            @else
                                <img src="{{ asset('images/mosque-hero.svg') }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="text-[10px] font-bold bg-white/95 backdrop-blur-md text-[#155E4B] px-3 py-1 rounded-full shadow-sm">
                                    {{ $item->kategori }}
                                </span>
                            </div>
                            @if($item->is_featured)
                                <div class="absolute top-3 right-3">
                                    <span class="text-[10px] font-extrabold bg-[#155E4B] text-white px-2.5 py-1 rounded-full shadow-sm">
                                        Unggulan
                                    </span>
                                </div>
                            @endif

                            <!-- Badge Highlight Sisa Donasi -->
                            <div class="absolute bottom-2.5 right-2.5">
                                @if($statusSisa === 'critical' || $statusSisa === 'empty')
                                    <span class="inline-flex items-center gap-1 text-[10px] font-black bg-rose-600/95 text-white px-2.5 py-1 rounded-full shadow-md backdrop-blur-xs animate-pulse">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                        Sisa: {{ $pctSisa }}%
                                    </span>
                                @elseif($statusSisa === 'warning')
                                    <span class="inline-flex items-center gap-1 text-[10px] font-black bg-amber-500/95 text-white px-2.5 py-1 rounded-full shadow-md backdrop-blur-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                        Sisa: {{ $pctSisa }}%
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 text-[10px] font-black bg-emerald-600/95 text-white px-2.5 py-1 rounded-full shadow-md backdrop-blur-xs">
                                        <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                        Sisa: {{ $pctSisa }}%
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="p-5 space-y-3">
                            <a href="{{ route('programs.show', $item->slug) }}" class="font-extrabold text-sm text-slate-800 leading-snug line-clamp-2 hover:text-[#155E4B] transition">
                                {{ $item->nama }}
                            </a>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $item->ringkasan ?: Str::limit(strip_tags($item->deskripsi), 80) }}
                            </p>

                            <!-- Card Metrik: Total Terkumpul & Sisa Donasi Saat Ini -->
                            <div class="p-3 rounded-2xl bg-[#F8FAF8] border border-slate-100 space-y-2">
                                <div class="flex justify-between items-center text-[11px]">
                                    <span class="text-slate-400 text-[10px]">Total Terkumpul</span>
                                    <span class="font-extrabold text-[#155E4B]">Rp {{ number_format($item->dana_terkumpul, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center text-[11px] pt-1.5 border-t border-slate-100">
                                    <span class="text-slate-500 font-semibold text-[10px]">Sisa Dana Saat Ini</span>
                                    @if($statusSisa === 'critical' || $statusSisa === 'empty')
                                        <span class="font-black text-rose-600 bg-rose-50 px-2 py-0.5 rounded-lg border border-rose-200">
                                            Rp {{ number_format($sisaDana, 0, ',', '.') }}
                                        </span>
                                    @elseif($statusSisa === 'warning')
                                        <span class="font-black text-amber-700 bg-amber-50 px-2 py-0.5 rounded-lg border border-amber-200">
                                            Rp {{ number_format($sisaDana, 0, ',', '.') }}
                                        </span>
                                    @else
                                        <span class="font-black text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-lg border border-emerald-200">
                                            Rp {{ number_format($sisaDana, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Progress Bar Sisa Dana Berwarna -->
                            <div class="space-y-1 pt-0.5">
                                <div class="flex justify-between text-[10px]">
                                    <span class="text-slate-400">Rasio Sisa Dana</span>
                                    <span class="font-bold {{ $statusSisa === 'critical' || $statusSisa === 'empty' ? 'text-rose-600' : ($statusSisa === 'warning' ? 'text-amber-600' : 'text-emerald-700') }}">
                                        {{ $pctSisa }}%
                                    </span>
                                </div>
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                    @if($statusSisa === 'critical' || $statusSisa === 'empty')
                                        <div class="bg-rose-500 h-2 rounded-full" style="width: {{ $pctSisa }}%"></div>
                                    @elseif($statusSisa === 'warning')
                                        <div class="bg-amber-500 h-2 rounded-full" style="width: {{ $pctSisa }}%"></div>
                                    @else
                                        <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ $pctSisa }}%"></div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 pt-0">
                        <a href="{{ route('programs.show', $item->slug) }}" class="block w-full text-center bg-[#155E4B] hover:bg-[#0E4436] text-white font-bold text-xs py-2.5 rounded-full shadow-sm active:scale-95 transition">
                            Lihat Program
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-3xl border border-slate-100 col-span-3 space-y-2">
                    <h3 class="text-sm font-bold text-slate-700">Tidak ada program ditemukan</h3>
                    <p class="text-xs text-slate-400">Silakan coba kata kunci pencarian atau kategori lain.</p>
                </div>
            @endforelse
        </div>

        @if(method_exists($programs, 'links'))
            <div class="pt-2">
                {{ $programs->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
