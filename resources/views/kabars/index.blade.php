<x-app-layout>
    <div class="py-4 space-y-5">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Kabar Terbaru & Cerita Penyaluran</h1>
            <p class="text-xs text-slate-500">Berita kegiatan, dokumentasi, dan bukti nyata dampak donasi Anda</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($kabars as $kabar)
                <a href="{{ route('kabars.show', $kabar->slug) }}" class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="h-48 w-full bg-slate-100 relative overflow-hidden">
                            @if($kabar->foto)
                                <img src="{{ asset('storage/' . $kabar->foto) }}" alt="{{ $kabar->judul }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-teal-50 text-teal-600 flex items-center justify-center text-5xl">
                                    📰
                                </div>
                            @endif
                            @if($kabar->program)
                                <div class="absolute top-3 left-3">
                                    <span class="text-[10px] font-bold bg-white/90 backdrop-blur-md text-teal-700 px-2.5 py-0.5 rounded-lg shadow-sm">
                                        {{ $kabar->program->nama }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 space-y-2">
                            <span class="text-[10px] font-bold text-teal-600">
                                📅 {{ $kabar->tanggal->format('d M Y') }} • Oleh {{ $kabar->penulis }}
                            </span>
                            <h3 class="font-extrabold text-sm sm:text-base text-slate-800 leading-snug line-clamp-2">
                                {{ $kabar->judul }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $kabar->ringkasan ?: Str::limit(strip_tags($kabar->konten), 90) }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-0 text-xs font-bold text-teal-600">
                        Baca Selengkapnya →
                    </div>
                </a>
            @empty
                <div class="bg-white p-12 text-center rounded-3xl border border-slate-100 col-span-2 space-y-2">
                    <span class="text-4xl">📰</span>
                    <h3 class="text-sm font-bold text-slate-700">Belum ada kabar diterbitkan</h3>
                </div>
            @endforelse
        </div>

        <div class="pt-4">
            {{ $kabars->links() }}
        </div>
    </div>
</x-app-layout>
