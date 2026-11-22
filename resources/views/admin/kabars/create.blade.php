<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Tulis Kabar Baru</h2>
                <p class="text-xs text-slate-500">Publikasikan dokumentasi kegiatan dan cerita penyaluran untuk donatur</p>
            </div>
            <a href="{{ route('admin.kabar.index') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-4 py-2 rounded-full transition">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <form action="{{ route('admin.kabar.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Judul Artikel / Kabar <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required placeholder="Contoh: Penyaluran Paket Santunan Tahap 1 Telah Terlaksana"
                        class="w-full text-xs font-bold border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Terkait Program Donasi</label>
                        <select name="program_id" class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                            <option value="">-- Umum (Tidak Terikat Program) --</option>
                            @foreach($programs as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Publikasi <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Ringkasan (1-2 Kalimat)</label>
                    <textarea name="ringkasan" rows="2" placeholder="Ringkasan singkat yang muncul di kartu cuplikan..."
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">{{ old('ringkasan') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Isi Berita Lengkap <span class="text-rose-500">*</span></label>
                    <textarea name="konten" rows="6" required placeholder="Tuliskan cerita lengkap kabar dan laporan..."
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">{{ old('konten') }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Foto Dokumentasi (Opsional, Maks 3MB)</label>
                    <input type="file" name="foto" accept="image/*" class="w-full text-xs border border-slate-200 rounded-2xl p-2.5">
                </div>

                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="is_pub" name="is_published" value="1" checked class="rounded text-[#155E4B] focus:ring-[#155E4B]">
                    <label for="is_pub" class="text-xs font-bold text-slate-700 cursor-pointer">Terbitkan Langsung ke Publik</label>
                </div>

                <div class="pt-3 flex gap-3">
                    <a href="{{ route('admin.kabar.index') }}" class="w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3.5 rounded-full transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-3.5 rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition">
                        Terbitkan Kabar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
