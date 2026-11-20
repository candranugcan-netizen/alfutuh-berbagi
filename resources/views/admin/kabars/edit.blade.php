<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 leading-tight">Edit Kabar Terbaru</h2>
    </x-slot>

    <div class="py-4 max-w-2xl mx-auto">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <form action="{{ route('admin.kabar.update', $kabar->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Judul Artikel <span class="text-rose-500">*</span></label>
                    <input type="text" name="judul" value="{{ old('judul', $kabar->judul) }}" required
                        class="w-full text-xs font-bold border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Terkait Program Donasi</label>
                        <select name="program_id" class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                            <option value="">-- Umum (Tidak Terikat Program) --</option>
                            @foreach($programs as $p)
                                <option value="{{ $p->id }}" {{ $kabar->program_id == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Tanggal <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $kabar->tanggal->format('Y-m-d')) }}" required
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ringkasan</label>
                    <textarea name="ringkasan" rows="2" class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">{{ old('ringkasan', $kabar->ringkasan) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Isi Berita Lengkap <span class="text-rose-500">*</span></label>
                    <textarea name="konten" rows="6" required class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">{{ old('konten', $kabar->konten) }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Ganti Foto Dokumentasi</label>
                    @if($kabar->foto)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $kabar->foto) }}" alt="Foto" class="h-24 rounded-xl object-cover border border-slate-200">
                        </div>
                    @endif
                    <input type="file" name="foto" accept="image/*" class="w-full text-xs border-slate-200 rounded-2xl p-2.5">
                </div>

                <div class="flex items-center gap-2">
                    <input type="checkbox" name="is_published" value="1" {{ $kabar->is_published ? 'checked' : '' }} class="rounded text-teal-600 focus:ring-teal-500">
                    <label class="text-xs font-bold text-slate-700">Diterbitkan ke Publik</label>
                </div>

                <div class="pt-2 flex gap-3">
                    <a href="{{ route('admin.kabar.index') }}" class="w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 rounded-2xl transition">
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
