<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Edit Program Donasi: {{ $program->nama }}</h2>
                <p class="text-xs text-slate-500">Perbarui data program, target, dan rincian informasi kampanye</p>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-4 py-2 rounded-full transition">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <form action="{{ route('admin.programs.update', $program->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Program <span class="text-rose-500">*</span></label>
                    <input type="text" name="nama" value="{{ old('nama', $program->nama) }}" required
                        class="w-full text-xs font-bold border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kategori Program <span class="text-rose-500">*</span>
                        </label>
                        @php
                            $currentKat = old('kategori', $program->kategori);
                        @endphp
                        <select name="kategori" required class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3 bg-white">
                            <option value="Masjid" {{ $currentKat === 'Masjid' ? 'selected' : '' }}>Masjid (Pembangunan &amp; Operasional)</option>
                            <option value="Pendidikan" {{ $currentKat === 'Pendidikan' ? 'selected' : '' }}>Pendidikan (Santri &amp; Beasiswa Qur'an)</option>
                            <option value="Sosial" {{ $currentKat === 'Sosial' ? 'selected' : '' }}>Sosial (Santunan Yatim &amp; Dhuafa)</option>
                            <option value="Kemanusiaan" {{ $currentKat === 'Kemanusiaan' ? 'selected' : '' }}>Kemanusiaan (Tanggap Bencana &amp; Peduli)</option>
                            <option value="Zakat" {{ $currentKat === 'Zakat' ? 'selected' : '' }}>Zakat &amp; Sedekah</option>
                            <option value="Qurban" {{ $currentKat === 'Qurban' ? 'selected' : '' }}>Qurban</option>
                            <option value="Lainnya" {{ $currentKat === 'Lainnya' ? 'selected' : '' }}>Lainnya / Umum</option>
                            @if(!in_array($currentKat, ['Masjid', 'Pendidikan', 'Sosial', 'Kemanusiaan', 'Zakat', 'Qurban', 'Lainnya']) && !empty($currentKat))
                                <option value="{{ $currentKat }}" selected>{{ $currentKat }}</option>
                            @endif
                        </select>
                        @error('kategori') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Aktif</label>
                        <select name="is_active" class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3 bg-white">
                            <option value="1" {{ $program->is_active ? 'selected' : '' }}>Aktif (Tampil di Publik)</option>
                            <option value="0" {{ !$program->is_active ? 'selected' : '' }}>Nonaktif (Disembunyikan)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Target Dana (Rp)</label>
                        <input type="number" name="target_dana" value="{{ old('target_dana', $program->target_dana) }}" min="0" step="100000"
                            class="w-full text-xs font-bold border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Dana Terkumpul Saat Ini (Rp)</label>
                        <input type="number" name="dana_terkumpul" value="{{ old('dana_terkumpul', $program->dana_terkumpul) }}" min="0"
                            class="w-full text-xs font-bold border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Sifat Program</label>
                        <select name="tipe_target" class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                            <option value="berkelanjutan" {{ $program->tipe_target === 'berkelanjutan' ? 'selected' : '' }}>Berkelanjutan</option>
                            <option value="terbatas" {{ $program->tipe_target === 'terbatas' ? 'selected' : '' }}>Terbatas</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tenggat Waktu</label>
                        <input type="date" name="tenggat_waktu" value="{{ old('tenggat_waktu', $program->tenggat_waktu ? $program->tenggat_waktu->format('Y-m-d') : '') }}"
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ringkasan</label>
                    <textarea name="ringkasan" rows="2" required class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">{{ old('ringkasan', $program->ringkasan) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Lengkap</label>
                    <textarea name="deskripsi" rows="5" required class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">{{ old('deskripsi', $program->deskripsi) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Foto Banner Kampanye</label>
                    @if($program->banner)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $program->banner) }}" alt="Banner" class="h-28 rounded-2xl object-cover border border-slate-200">
                        </div>
                    @endif
                    <input type="file" name="banner" accept="image/*" class="w-full text-xs border border-slate-200 rounded-2xl p-2.5">
                </div>

                <div class="flex items-center gap-6 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" {{ $program->is_featured ? 'checked' : '' }} class="rounded text-[#155E4B] focus:ring-[#155E4B]">
                        <span class="text-xs font-bold text-slate-700">Jadikan Program Unggulan (Hero Banner)</span>
                    </label>
                </div>

                <div class="pt-3 flex gap-3">
                    <a href="{{ route('admin.programs.index') }}" class="w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3.5 rounded-full transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-3.5 rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
