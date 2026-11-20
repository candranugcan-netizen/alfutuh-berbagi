<x-app-layout>
    <div class="py-4 space-y-5">
        <!-- Header Page -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Pilih Program Donasi</h1>
                <p class="text-xs text-slate-500">Salurkan infaq, zakat, dan sedekah untuk program dakwah & sosial Yayasan Al Futuh</p>
            </div>
            <!-- Search Input -->
            <form action="{{ route('programs.index') }}" method="GET" class="w-full sm:w-72">
                <div class="relative">
                    <input type="text" name="q" value="{{ $search ?? '' }}" placeholder="Cari program donasi..." class="w-full text-xs pl-9 pr-4 py-2.5 rounded-2xl border-slate-200 focus:border-teal-500 focus:ring-teal-500">
                    <span class="absolute left-3 top-3 text-slate-400 text-xs">🔍</span>
                </div>
            </form>
        </div>

        <!-- Filter Kategori Tabs -->
        <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-none text-xs">
            <a href="{{ route('programs.index') }}" class="px-4 py-2 rounded-2xl font-bold whitespace-nowrap transition {{ ($kategori === 'Semua' || empty($kategori)) ? 'bg-teal-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-teal-300' }}">
                Semua Program
            </a>
            @foreach($categories as $kat)
                <a href="{{ route('programs.index', ['kategori' => $kat]) }}" class="px-4 py-2 rounded-2xl font-bold whitespace-nowrap transition {{ $kategori === $kat ? 'bg-teal-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-teal-300' }}">
                    {{ $kat }}
                </a>
            @endforeach
        </div>

        <!-- Grid Program List -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
            @forelse($programs as $item)
                <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-44 w-full bg-slate-100 relative overflow-hidden">
                            @if($item->banner)
                                <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center text-5xl text-white">
                                    {{ $item->icon ?: '🤲' }}
                                </div>
                            @endif
                            <div class="absolute top-3 left-3">
                                <span class="text-[10px] font-bold bg-white/90 backdrop-blur-md text-teal-700 px-2.5 py-0.5 rounded-lg shadow-sm">
                                    {{ $item->kategori }}
                                </span>
                            </div>
                            @if($item->is_featured)
                                <div class="absolute top-3 right-3">
                                    <span class="text-[10px] font-extrabold bg-amber-500 text-white px-2 py-0.5 rounded-lg shadow-sm">
                                        ⭐ Unggulan
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 space-y-2.5">
                            <a href="{{ route('programs.show', $item->slug) }}" class="font-extrabold text-sm sm:text-base text-slate-800 leading-snug line-clamp-2 hover:text-teal-600 transition">
                                {{ $item->nama }}
                            </a>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $item->ringkasan ?: Str::limit($item->deskripsi, 80) }}
                            </p>

                            <!-- Progress Bar -->
                            <div class="space-y-1 pt-1">
                                <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                    <div class="bg-teal-500 h-2 rounded-full" style="width: {{ $item->persentase }}%"></div>
                                </div>
                                <div class="flex justify-between items-center text-[11px]">
                                    <div>
                                        <span class="text-slate-400 block text-[9px]">Terkumpul</span>
                                        <span class="font-black text-teal-700">Rp {{ number_format($item->dana_terkumpul, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-slate-400 block text-[9px]">{{ $item->tenggat_waktu ? 'Sisa' : 'Status' }}</span>
                                        <span class="font-semibold text-slate-600">
                                            {{ $item->sisa_hari !== null ? $item->sisa_hari . ' hari' : 'Berkelanjutan' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 pt-0">
                        <a href="{{ route('donations.create', $item->slug) }}" class="block w-full text-center bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs py-2.5 rounded-xl shadow-sm active:scale-95 transition">
                            Donasi Sekarang
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-3xl border border-slate-100 col-span-3 space-y-2">
                    <span class="text-4xl">🔍</span>
                    <h3 class="text-sm font-bold text-slate-700">Tidak ada program ditemukan</h3>
                    <p class="text-xs text-slate-400">Silakan coba kata kunci pencarian atau kategori lain.</p>
                </div>
            @endforelse
        </div>

        <div class="pt-4">
            {{ $programs->links() }}
        </div>
    </div>
</x-app-layout>
