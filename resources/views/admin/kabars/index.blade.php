<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Kelola Kabar &amp; Penyaluran</h2>
                <p class="text-xs text-slate-500">Terbitkan artikel, cerita dokumentasi, dan update kegiatan dakwah yayasan</p>
            </div>
            <a href="{{ route('admin.kabar.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-[#155E4B] hover:bg-[#0E4436] text-white px-4 py-2 rounded-full shadow-sm transition active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round"/></svg>
                <span>Tulis Kabar Baru</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-5">
        <div class="space-y-3">
            @forelse($kabars as $k)
                <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                    <div class="flex items-start gap-3.5">
                        @if($k->foto)
                            <img src="{{ asset('storage/' . $k->foto) }}" alt="Foto" class="w-16 h-16 rounded-2xl object-cover shrink-0 border border-slate-100">
                        @else
                            <div class="w-16 h-16 rounded-2xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5h16v14H4zM8 9h8M8 13h8M8 17h5" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                        @endif
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="text-[10px] font-bold text-[#155E4B] bg-[#EAF5EE] px-2.5 py-0.5 rounded-full border border-[#D2E6DC]">
                                    {{ $k->program->nama ?? 'Umum' }}
                                </span>
                                <span class="text-[10px] text-slate-400">📅 {{ $k->tanggal->format('d M Y') }}</span>
                            </div>
                            <h4 class="font-extrabold text-sm text-slate-800">{{ $k->judul }}</h4>
                            <p class="text-[11px] text-slate-400 line-clamp-1">{{ $k->ringkasan }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 pt-2 md:pt-0 border-slate-50">
                        <a href="{{ route('admin.kabar.edit', $k->id) }}" class="text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 px-4 py-2 rounded-full transition">
                            Edit
                        </a>
                        <form action="{{ route('admin.kabar.destroy', $k->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Kabar berita &quot;{{ addslashes($k->judul) }}&quot; akan dihapus permanen.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-rose-600 hover:text-rose-700 font-bold bg-rose-50 border border-rose-100 px-4 py-2 rounded-full transition active:scale-95">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-3xl border border-slate-100">
                    <p class="text-xs text-slate-400">Belum ada kabar terbaru yang diterbitkan.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
