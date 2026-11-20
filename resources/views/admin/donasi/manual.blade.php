<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 leading-tight">Input Manual Donasi</h2>
        <p class="text-xs text-slate-500">Catat penerimaan donasi offline, titipan tunai, atau infaq kotak amal</p>
    </x-slot>

    <div class="py-4 max-w-xl mx-auto">
        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <form action="{{ route('admin.donasi.manual.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Pilih Program -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Program Tujuan <span class="text-rose-500">*</span>
                    </label>
                    <select name="program_id" required class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                        <option value="">-- Pilih Program Donasi --</option>
                        @foreach($programs as $prog)
                            <option value="{{ $prog->id }}">{{ $prog->nama }} ({{ $prog->kategori }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nominal Donasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nominal Donasi (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="nominal" min="1000" step="1000" required placeholder="Contoh: 100000"
                        class="w-full text-sm font-black border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                </div>

                <!-- Tanggal Penerimaan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Tanggal Penerimaan <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                </div>

                <!-- Metode Penerimaan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Metode Penerimaan <span class="text-rose-500">*</span>
                    </label>
                    <select name="metode_pembayaran" required class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                        <option value="Tunai / Kasir Yayasan">Tunai / Langsung ke Yayasan</option>
                        <option value="Kotak Infaq Masjid">Kotak Infaq / Kencleng Masjid</option>
                        <option value="Transfer Langsung Bank">Transfer Langsung Bank (Tanpa Web)</option>
                        <option value="Titipan Jemput Donasi">Titipan / Layanan Jemput Donasi</option>
                    </select>
                </div>

                <!-- Identitas Donatur -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Nama Donatur</label>
                        <input type="text" name="nama_donatur" placeholder="Kosongkan jika Hamba Allah"
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">No WhatsApp</label>
                        <input type="text" name="no_hp" placeholder="08..."
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>
                </div>

                <!-- Checkbox Anonim -->
                <div class="flex items-center gap-2">
                    <input type="checkbox" id="is_anonim" name="is_anonim" value="1" class="rounded text-teal-600 focus:ring-teal-500">
                    <label for="is_anonim" class="text-xs font-medium text-slate-600 cursor-pointer">
                        Tampilkan publik sebagai <strong>Hamba Allah</strong>
                    </label>
                </div>

                <!-- Doa / Catatan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Doa / Pesan / Catatan Donatur</label>
                    <textarea name="doa" rows="2" placeholder="Catatan titipan doa dari donatur..."
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3"></textarea>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-2 flex gap-3">
                    <a href="{{ route('admin.donasi.index') }}" class="w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 rounded-2xl transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-teal-600 hover:bg-teal-700 text-white font-black text-xs py-3 rounded-2xl shadow-md active:scale-95 transition">
                        Simpan Donasi Manual
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
