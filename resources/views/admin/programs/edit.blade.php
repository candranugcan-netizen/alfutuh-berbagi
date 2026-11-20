<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 leading-tight">Edit Program Donasi: {{ $program->nama }}</h2>
    </x-slot>

    <div class="py-4 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <form action="{{ route('admin.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Program</label>
                    <input type="text" name="nama" value="{{ old('nama', $program->nama) }}" required
                        class="w-full text-xs font-bold border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Kategori</label>
                        <input type="text" name="kategori" value="{{ old('kategori', $program->kategori) }}" required
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Icon Emoji</label>
                        <input type="text" name="icon" value="{{ old('icon', $program->icon) }}"
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Target Dana (Rp)</label>
                        <input type="number" name="target_dana" value="{{ old('target_dana', $program->target_dana) }}" min="0" step="100000"
                            class="w-full text-xs font-bold border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Dana Terkumpul Saat Ini (Rp)</label>
                        <input type="number" name="dana_terkumpul" value="{{ old('dana_terkumpul', $program->dana_terkumpul) }}" min="0"
                            class="w-full text-xs font-bold border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Sifat Program</label>
                        <select name="tipe_target" class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                            <option value="berkelanjutan" {{ $program->tipe_target === 'berkelanjutan' ? 'selected' : '' }}>Berkelanjutan</option>
                            <option value="terbatas" {{ $program->tipe_target === 'terbatas' ? 'selected' : '' }}>Terbatas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tenggat Waktu</label>
                        <input type="date" name="tenggat_waktu" value="{{ old('tenggat_waktu', $program->tenggat_waktu ? $program->tenggat_waktu->format('Y-m-d') : '') }}"
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ringkasan</label>
                    <textarea name="ringkasan" rows="2" required class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">{{ old('ringkasan', $program->ringkasan) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Deskripsi Lengkap</label>
                    <textarea name="deskripsi" rows="6" required class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Foto Banner (Opsional)</label>
                    @if($program->banner)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $program->banner) }}" alt="Banner" class="h-24 rounded-xl object-cover border border-slate-200">
                        </div>
                    @endif
                    <input type="file" name="banner" accept="image/*" class="w-full text-xs border-slate-200 rounded-2xl p-2.5">
                </div>

                <div class="flex items-center gap-6 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ $program->is_featured ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                        <span class="text-xs font-bold text-slate-700">Program Unggulan</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ $program->is_active ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                        <span class="text-xs font-bold text-slate-700">Aktif</span>
                    </label>
                </div>

                <div class="pt-2 flex gap-3">
                    <a href="{{ route('admin.programs.index') }}" class="w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 rounded-2xl transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-teal-600 hover:bg-teal-700 text-white font-black text-xs py-3 rounded-2xl shadow-md active:scale-95 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
