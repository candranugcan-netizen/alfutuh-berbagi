<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Kelola Program Donasi</h2>
                <p class="text-xs text-slate-500">Tambah, edit, dan atur status kampanye kebaikan Al Futuh</p>
            </div>
            <a href="{{ route('admin.programs.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-[#155E4B] hover:bg-[#0E4436] text-white px-4 py-2 rounded-full shadow-sm transition active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round"/></svg>
                <span>Tambah Program Baru</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($programs as $prog)
                <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm p-5 space-y-3 flex flex-col justify-between">
                    <div class="space-y-2.5">
                        <div class="flex justify-between items-start">
                            <div class="w-12 h-12 rounded-2xl bg-[#F2F7F4] text-[#155E4B] flex items-center justify-center">
                                <x-program-icon :category="$prog->kategori" :name="$prog->nama" class="w-7 h-7" />
                            </div>
                            <div class="flex items-center gap-1.5">
                                @if($prog->is_featured)
                                    <span class="text-[9px] font-extrabold bg-amber-50 text-amber-800 px-2 py-0.5 rounded-full border border-amber-200">Unggulan</span>
                                @endif
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-full {{ $prog->is_active ? 'bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC]' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $prog->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] font-bold text-[#155E4B] uppercase tracking-wider">{{ $prog->kategori }}</span>
                            <h3 class="font-extrabold text-sm text-slate-800 leading-snug line-clamp-1">{{ $prog->nama }}</h3>
                            <p class="text-[11px] text-slate-400 line-clamp-2 mt-1">{{ $prog->ringkasan }}</p>
                        </div>

                        <!-- Mini Stats Card -->
                        <div class="bg-[#F8FAF8] p-3 rounded-2xl border border-slate-100 space-y-1.5 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-400 text-[10px]">Terkumpul</span>
                                <span class="font-black text-[#155E4B]">Rp {{ number_format($prog->dana_terkumpul, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-400 text-[10px]">Target</span>
                                @if($prog->target_dana > 0)
                                    <span class="font-semibold text-slate-600">Rp {{ number_format($prog->target_dana, 0, ',', '.') }}</span>
                                @else
                                    <span class="inline-flex items-center gap-1 font-bold text-[#155E4B] text-[11px]">
                                        <x-infinity-icon class="w-3.5 h-3.5 text-[#155E4B]" />
                                        <span>Tidak Terbatas</span>
                                    </span>
                                @endif
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400 text-[10px]">Total Donatur</span>
                                <span class="font-bold text-slate-700">{{ $prog->verified_donations_count }} Donatur</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-2 border-t border-slate-50">
                        <a href="{{ route('admin.programs.edit', $prog->id) }}" class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2 rounded-full transition">
                            Edit Program
                        </a>
                        <form action="{{ route('admin.programs.destroy', $prog->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Program &quot;{{ addslashes($prog->nama) }}&quot; beserta seluruh riwayat terkait akan dihapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-rose-600 hover:text-rose-700 font-bold bg-rose-50 border border-rose-100 px-3.5 py-2 rounded-full transition active:scale-95">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-3xl border border-slate-100 col-span-3">
                    <p class="text-xs text-slate-400">Belum ada program donasi yang dibuat.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
