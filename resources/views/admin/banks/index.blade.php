<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Kelola Rekening Bank &amp; QRIS</h2>
                <p class="text-xs text-slate-500">Atur nomor rekening tujuan transfer donasi Yayasan Al Futuh</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-4 py-2 rounded-full transition">
                ← Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Form Tambah Rekening -->
        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3.5">
            <h3 class="text-sm font-extrabold text-slate-800">Tambah Rekening Bank / QRIS Baru</h3>

            <form action="{{ route('admin.banks.store') }}" method="POST" class="space-y-3.5">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Bank / QRIS</label>
                        <input type="text" name="nama_bank" required placeholder="Contoh: Bank BSI"
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Kode Bank Singkat</label>
                        <input type="text" name="kode_bank" placeholder="BSI / BCA / QRIS"
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nomor Rekening / NMID</label>
                        <input type="text" name="nomor_rekening" required placeholder="1234567890"
                            class="w-full text-xs font-mono font-bold border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Atas Nama</label>
                        <input type="text" name="atas_nama" required placeholder="Yayasan Al Futuh"
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Instruksi Transfer Singkat (Opsional)</label>
                    <input type="text" name="instruksi" placeholder="Contoh: Kode Bank 451 jika transfer antar bank atau scan dengan mobile banking apapun"
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5">
                </div>

                <div class="pt-1">
                    <button type="submit" class="bg-[#155E4B] hover:bg-[#0E4436] text-white font-bold text-xs px-6 py-2.5 rounded-full shadow-sm active:scale-95 transition">
                        Simpan Rekening Baru
                    </button>
                </div>
            </form>
        </div>

        <!-- Daftar Rekening Bank Aktif -->
        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3.5">
            <h3 class="text-sm font-extrabold text-slate-800 border-b border-slate-100 pb-3">Daftar Rekening Bank &amp; QRIS Aktif</h3>

            <div class="divide-y divide-slate-100">
                @forelse($banks as $b)
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-1">
                            <div class="flex items-center gap-2">
                                <span class="font-extrabold text-xs text-slate-800">{{ $b->nama_bank }}</span>
                                <span class="text-[10px] font-bold bg-[#EAF5EE] text-[#155E4B] px-2.5 py-0.5 rounded-full border border-[#D2E6DC]">{{ $b->kode_bank }}</span>
                            </div>
                            <p class="font-mono text-sm font-extrabold text-slate-800">{{ $b->nomor_rekening }}</p>
                            <p class="text-xs text-slate-500">Atas Nama: <strong class="text-slate-700">{{ $b->atas_nama }}</strong></p>
                            @if($b->instruksi)
                                <p class="text-[11px] text-slate-400 italic">{{ $b->instruksi }}</p>
                            @endif
                        </div>

                        <form action="{{ route('admin.banks.destroy', $b->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Rekening {{ addslashes($b->nama_bank) }} - {{ $b->nomor_rekening }} akan dihapus.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-rose-600 hover:text-rose-700 font-bold bg-rose-50 border border-rose-100 px-4 py-1.5 rounded-full transition active:scale-95">
                                Hapus
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-6 text-center">Belum ada rekening bank yang dikonfigurasi.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
