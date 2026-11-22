<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Tambah Program Donasi Baru</h2>
                <p class="text-xs text-slate-500">Buat kampanye donasi baru untuk kegiatan Yayasan Al Futuh</p>
            </div>
            <a href="{{ route('admin.programs.index') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-4 py-2 rounded-full transition">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <form action="{{ route('admin.programs.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Nama Program -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nama Program Donasi <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Pembangunan & Perawatan Fasilitas Masjid"
                        class="w-full text-xs font-bold border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    @error('nama') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <!-- Kategori Dropdown -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Kategori Program <span class="text-rose-500">*</span>
                        </label>
                        <select name="kategori" required class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3 bg-white">
                            <option value="" disabled {{ old('kategori') ? '' : 'selected' }}>-- Pilih Kategori Program --</option>
                            <option value="Masjid" {{ old('kategori') === 'Masjid' ? 'selected' : '' }}>Masjid (Pembangunan &amp; Operasional)</option>
                            <option value="Pendidikan" {{ old('kategori') === 'Pendidikan' ? 'selected' : '' }}>Pendidikan (Santri &amp; Beasiswa Qur'an)</option>
                            <option value="Sosial" {{ old('kategori') === 'Sosial' ? 'selected' : '' }}>Sosial (Santunan Yatim &amp; Dhuafa)</option>
                            <option value="Kemanusiaan" {{ old('kategori') === 'Kemanusiaan' ? 'selected' : '' }}>Kemanusiaan (Tanggap Bencana &amp; Peduli)</option>
                            <option value="Zakat" {{ old('kategori') === 'Zakat' ? 'selected' : '' }}>Zakat &amp; Sedekah</option>
                            <option value="Qurban" {{ old('kategori') === 'Qurban' ? 'selected' : '' }}>Qurban</option>
                            <option value="Lainnya" {{ old('kategori') === 'Lainnya' ? 'selected' : '' }}>Lainnya / Umum</option>
                        </select>
                        @error('kategori') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Petunjuk Kategori -->
                    <div class="bg-[#F2F7F4] border border-[#D2E6DC] rounded-2xl p-3 text-[11px] text-[#155E4B] flex items-center">
                        <span>Pilihan <strong>Masjid, Pendidikan, Sosial, Kemanusiaan</strong> otomatis terhubung dengan kartu kategori dan ikon grafis di halaman Beranda.</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <!-- Target Dana -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Target Dana (Rp) <span class="text-slate-400 font-normal">(0 = Berkelanjutan)</span>
                        </label>
                        <input type="number" name="target_dana" value="{{ old('target_dana', 0) }}" min="0" step="100000"
                            class="w-full text-xs font-bold border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    </div>

                    <!-- Tipe Target -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Sifat Program <span class="text-rose-500">*</span>
                        </label>
                        <select name="tipe_target" class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                            <option value="berkelanjutan">Berkelanjutan (Rutin Bulanan / Tanpa Batas)</option>
                            <option value="terbatas">Terbatas (Target & Batas Waktu Tertentu)</option>
                        </select>
                    </div>
                </div>

                <!-- Tenggat Waktu -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tenggat Waktu / Tanggal Berakhir (Opsional)
                    </label>
                    <input type="date" name="tenggat_waktu" value="{{ old('tenggat_waktu') }}"
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                </div>

                <!-- Ringkasan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Ringkasan Singkat (1-2 Kalimat) <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="ringkasan" rows="2" required placeholder="Deskripsi singkat yang tampil di kartu donasi..."
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">{{ old('ringkasan') }}</textarea>
                </div>

                <!-- Deskripsi Lengkap -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Deskripsi Cerita Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="deskripsi" rows="5" required placeholder="Jelaskan latar belakang, tujuan, dan peruntukan donasi secara detail..."
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">{{ old('deskripsi') }}</textarea>
                </div>

                <!-- Banner Gambar -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Foto Banner Kampanye (Maks 3MB)
                    </label>
                    <input type="file" name="banner" accept="image/*"
                        class="w-full text-xs border border-slate-200 rounded-2xl p-2.5">
                </div>

                <!-- Checkbox Opsi -->
                <div class="flex items-center gap-6 pt-1">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_featured" value="1" class="rounded text-[#155E4B] focus:ring-[#155E4B]">
                        <span class="text-xs font-bold text-slate-700">Jadikan Program Unggulan (Hero Banner)</span>
                    </label>
                </div>

                <div class="pt-3 flex gap-3">
                    <a href="{{ route('admin.programs.index') }}" class="w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3.5 rounded-full transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-3.5 rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition">
                        Simpan Program Baru
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
