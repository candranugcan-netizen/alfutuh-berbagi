<x-app-layout>
    <div class="space-y-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Kabar Terbaru &amp; Penyaluran</h1>
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
                                <img src="{{ asset('images/mosque-hero.svg') }}" alt="{{ $kabar->judul }}" class="w-full h-full object-cover">
                            @endif
                            @if($kabar->program)
                                <div class="absolute top-3 left-3">
                                    <span class="text-[10px] font-bold bg-white/95 backdrop-blur-md text-[#155E4B] px-3 py-1 rounded-full shadow-sm">
                                        {{ $kabar->program->nama }}
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-4 space-y-2">
                            <span class="text-[10px] font-bold text-[#155E4B] inline-flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="2" stroke-width="1.7"/><path d="M8 3v4M16 3v4M3 10h18" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                {{ $kabar->tanggal->format('d M Y') }} • Oleh {{ $kabar->penulis }}
                            </span>
                            <h3 class="font-extrabold text-sm sm:text-base text-slate-800 leading-snug line-clamp-2">
                                {{ $kabar->judul }}
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                                {{ $kabar->ringkasan ?: Str::limit(strip_tags($kabar->konten), 90) }}
                            </p>
                        </div>
                    </div>

                    <div class="p-4 pt-0 text-xs font-bold text-[#155E4B] inline-flex items-center gap-1">
                        <span>Baca Selengkapnya</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </a>
            @empty
                <div class="bg-white p-12 text-center rounded-3xl border border-slate-100 col-span-2 space-y-2">
                    <h3 class="text-sm font-bold text-slate-700">Belum ada kabar diterbitkan</h3>
                </div>
            @endforelse
        </div>

        @if(method_exists($kabars, 'links'))
            <div class="pt-4">
                {{ $kabars->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
