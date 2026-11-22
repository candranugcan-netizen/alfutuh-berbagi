<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Input Manual Donasi</h2>
                <p class="text-xs text-slate-500">Catat penerimaan donasi offline, titipan tunai, atau infaq kotak amal</p>
            </div>
            <a href="{{ route('admin.donasi.index') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-4 py-2 rounded-full transition">
                ← Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto">
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <form action="{{ route('admin.donasi.manual.store') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Pilih Program -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Program Tujuan <span class="text-rose-500">*</span>
                    </label>
                    <select name="program_id" required class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                        <option value="">-- Pilih Program Donasi --</option>
                        @foreach($programs as $prog)
                            <option value="{{ $prog->id }}">{{ $prog->nama }} ({{ $prog->kategori }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Nominal Donasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Nominal Donasi (Rp) <span class="text-rose-500">*</span>
                    </label>
                    <input type="number" name="nominal" min="1000" step="1000" required placeholder="Contoh: 100000"
                        class="w-full text-sm font-black border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                </div>

                <!-- Tanggal Penerimaan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Tanggal Penerimaan <span class="text-rose-500">*</span>
                    </label>
                    <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                </div>

                <!-- Metode Penerimaan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Metode Penerimaan <span class="text-rose-500">*</span>
                    </label>
                    <select name="metode_pembayaran" required class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                        <option value="Tunai / Kasir Yayasan">Tunai / Langsung ke Yayasan</option>
                        <option value="Kotak Infaq Masjid">Kotak Infaq / Kencleng Masjid</option>
                        <option value="Transfer Langsung Bank">Transfer Langsung Bank (Tanpa Web)</option>
                        <option value="Titipan Jemput Donasi">Titipan / Layanan Jemput Donasi</option>
                    </select>
                </div>

                <!-- Identitas Donatur -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Donatur</label>
                        <input type="text" name="nama_donatur" placeholder="Contoh: Fulan atau Fulanah (atau kosongkan untuk Hamba Allah)"
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No WhatsApp</label>
                        <input type="text" name="no_hp" placeholder="08..."
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    </div>
                </div>

                <!-- Checkbox Anonim -->
                <div class="flex items-center gap-2 pt-1">
                    <input type="checkbox" id="is_anonim" name="is_anonim" value="1" class="rounded text-[#155E4B] focus:ring-[#155E4B]">
                    <label for="is_anonim" class="text-xs font-semibold text-slate-600 cursor-pointer">
                        Tampilkan publik sebagai <strong class="text-[#155E4B]">Hamba Allah</strong>
                    </label>
                </div>

                <!-- Doa / Catatan -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Doa / Pesan / Catatan Donatur</label>
                    <textarea name="doa" rows="2" placeholder="Catatan titipan doa dari donatur..."
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3"></textarea>
                </div>

                <!-- Tombol Submit -->
                <div class="pt-3 flex gap-3">
                    <a href="{{ route('admin.donasi.index') }}" class="w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3.5 rounded-full transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-3.5 rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition">
                        Simpan Donasi Manual
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
