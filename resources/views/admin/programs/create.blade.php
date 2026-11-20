<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 leading-tight">Tambah Program Donasi Baru</h2>
        <p class="text-xs text-slate-500">Buat kampanye donasi baru untuk kegiatan Yayasan Al Futuh</p>
    </x-slot>

    <div class="py-4 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Nama Program -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nama Program Donasi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Wakaf Pembangunan Asrama Santri"
                        class="w-full text-xs font-bold border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    @error('nama') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Kategori -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Kategori Program <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="kategori" value="{{ old('kategori') }}" required placeholder="Contoh: Operasional, Yatim, Sarana, Zakat"
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>

                    <!-- Icon / Emoji -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Icon Emoji (1 Karakter)
                        </label>
                        <input type="text" name="icon" value="{{ old('icon', '🤲') }}" placeholder="Contoh: 🤲, 🕌, 🐄, ⚡, 🎓"
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <!-- Target Dana -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Target Dana (Rp) <span class="text-slate-400 font-normal">(0 = Berkelanjutan)</span>
                        </label>
                        <input type="number" name="target_dana" value="{{ old('target_dana', 0) }}" min="0" step="100000"
                            class="w-full text-xs font-bold border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>

                    <!-- Tipe Target -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Sifat Program <span class="text-rose-500">*</span>
                        </label>
                        <select name="tipe_target" class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                            <option value="berkelanjutan">Berkelanjutan (Rutin Bulanan / Tanpa Batas)</option>
                            <option value="terbatas">Terbatas (Target & Batas Waktu Tertentu)</option>
                        </select>
                    </div>
                </div>

                <!-- Tenggat Waktu -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Tenggat Waktu / Tanggal Berakhir (Opsional)
                    </label>
                    <input type="date" name="tenggat_waktu" value="{{ old('tenggat_waktu') }}"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                </div>

                <!-- Ringkasan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Ringkasan Singkat (1-2 Kalimat) <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="ringkasan" rows="2" required placeholder="Deskripsi singkat yang tampil di kartu donasi..."
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">{{ old('ringkasan') }}</textarea>
                </div>

                <!-- Deskripsi Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Deskripsi Cerita Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="deskripsi" rows="6" required placeholder="Jelaskan latar belakang, tujuan, dan peruntukan donasi secara detail..."
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">{{ old('deskripsi') }}</textarea>
                </div>

                <!-- Banner Gambar -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Foto Banner Kampanye (Maks 3MB)
                    </label>
                    <input type="file" name="banner" accept="image/*"
                        class="w-full text-xs border-slate-200 rounded-2xl p-2.5">
                </div>

                <!-- Checkbox Opsi -->
                <div class="flex items-center gap-6 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="rounded text-teal-600 focus:ring-teal-500">
                        <span class="text-xs font-bold text-slate-700">Jadikan Program Unggulan (Hero Banner)</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" checked class="rounded text-teal-600 focus:ring-teal-500">
                        <span class="text-xs font-bold text-slate-700">Aktifkan Program</span>
                    </label>
                </div>

                <div class="pt-2 flex gap-3">
                    <a href="{{ route('admin.programs.index') }}" class="w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 rounded-2xl transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-teal-600 hover:bg-teal-700 text-white font-black text-xs py-3 rounded-2xl shadow-md active:scale-95 transition">
                        Simpan & Terbitkan Program
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
