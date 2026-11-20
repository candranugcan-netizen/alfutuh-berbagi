<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-black text-xl text-slate-800 leading-tight">Kelola Program Donasi</h2>
                <p class="text-xs text-slate-500">Tambah, edit, dan atur status program kebaikan Al Futuh</p>
            </div>
            <a href="{{ route('admin.programs.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-xl shadow-sm transition active:scale-95">
                <span>➕</span> Tambah Program Baru
            </a>
        </div>
    </x-slot>

    <div class="py-4 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3.5">
            @forelse($programs as $prog)
                <div class="bg-white rounded-3xl border border-slate-100 overflow-hidden shadow-sm p-4 space-y-3 flex flex-col justify-between">
                    <div class="space-y-2">
                        <div class="flex justify-between items-start">
                            <span class="text-2xl">{{ $prog->icon ?: '🤲' }}</span>
                            <div class="flex items-center gap-1">
                                @if($prog->is_featured)
                                    <span class="text-[9px] font-extrabold bg-amber-50 text-amber-700 px-2 py-0.5 rounded-md border border-amber-200">⭐ Unggulan</span>
                                @endif
                                <span class="text-[9px] font-bold px-2 py-0.5 rounded-md {{ $prog->is_active ? 'bg-emerald-50 text-emerald-700' : 'bg-slate-100 text-slate-500' }}">
                                    {{ $prog->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <span class="text-[10px] font-bold text-teal-600 uppercase">{{ $prog->kategori }}</span>
                            <h3 class="font-extrabold text-sm text-slate-800 leading-snug line-clamp-1">{{ $prog->nama }}</h3>
                            <p class="text-[11px] text-slate-400 line-clamp-2 mt-1">{{ $prog->ringkasan }}</p>
                        </div>

                        <div class="bg-slate-50 p-2.5 rounded-2xl border border-slate-100 space-y-1 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-400 text-[10px]">Terkumpul</span>
                                <span class="font-bold text-teal-700">Rp {{ number_format($prog->dana_terkumpul, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400 text-[10px]">Target</span>
                                <span class="font-semibold text-slate-600">{{ $prog->target_dana > 0 ? 'Rp ' . number_format($prog->target_dana, 0, ',', '.') : 'Berkelanjutan' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-400 text-[10px]">Total Donatur</span>
                                <span class="font-bold text-slate-700">{{ $prog->verified_donations_count }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-2 pt-2 border-t border-slate-50">
                        <a href="{{ route('admin.programs.edit', $prog->id) }}" class="flex-1 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-2 rounded-xl transition">
                            Edit Program
                        </a>
                        <form action="{{ route('admin.programs.destroy', $prog->id) }}" method="POST" onsubmit="return confirm('Hapus program ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-rose-500 hover:text-rose-700 font-bold bg-rose-50 px-3 py-2 rounded-xl transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 text-center rounded-3xl border border-slate-100 col-span-3">
                    <p class="text-xs text-slate-400">Belum ada program donasi yang dibuat.</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
