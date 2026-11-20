<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-black text-xl text-slate-800 leading-tight">Kelola Kabar Terbaru</h2>
                <p class="text-xs text-slate-500">Terbitkan artikel, cerita dokumentasi, dan update kegiatan yayasan</p>
            </div>
            <a href="{{ route('admin.kabar.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-xl shadow-sm transition active:scale-95">
                <span>➕</span> Tulis Kabar Baru
            </a>
        </div>
    </x-slot>

    <div class="py-4 space-y-4">
        <div class="space-y-3">
            @forelse($kabars as $k)
                <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                    <div class="flex items-start gap-3">
                        @if($k->foto)
                            <img src="{{ asset('storage/' . $k->foto) }}" alt="Foto" class="w-16 h-16 rounded-xl object-cover shrink-0 border border-slate-100">
                        @else
                            <div class="w-16 h-16 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl shrink-0">
                                📰
                            </div>
                        @endif
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-bold text-teal-600 bg-teal-50 px-2 py-0.5 rounded-md">
                                    {{ $k->program->nama ?? 'Umum' }}
                                </span>
                                <span class="text-[10px] text-slate-400">📅 {{ $k->tanggal->format('d M Y') }}</span>
                            </div>
                            <h4 class="font-bold text-sm text-slate-800">{{ $k->judul }}</h4>
                            <p class="text-[11px] text-slate-400 line-clamp-1">{{ $k->ringkasan }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 pt-2 md:pt-0 border-slate-50">
                        <a href="{{ route('admin.kabar.edit', $k->id) }}" class="text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 px-3 py-1.5 rounded-xl transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.kabar.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Hapus kabar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-rose-500 hover:text-rose-700 font-bold bg-rose-50 px-3 py-1.5 rounded-xl transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 text-center rounded-3xl border border-slate-100">
                    <p class="text-xs text-slate-400">Belum ada kabar terbaru yang diterbitkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
