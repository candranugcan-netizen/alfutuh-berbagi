<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 leading-tight">Kelola Rekening Bank & QRIS</h2>
        <p class="text-xs text-slate-500">Atur nomor rekening tujuan transfer donasi Yayasan Al Futuh</p>
    </x-slot>

    <div class="py-4 space-y-6">

        <!-- Form Tambah Rekening -->
        <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm space-y-3">
            <h3 class="text-sm font-black text-slate-800">Tambah Rekening Bank Baru</h3>

            <form action="{{ route('admin.banks.store') }}" method="POST" class="space-y-3">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Bank / QRIS</label>
                        <input type="text" name="nama_bank" required placeholder="Contoh: Bank BSI"
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 p-2.5">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Kode Bank Singkat</label>
                        <input type="text" name="kode_bank" placeholder="BSI / BCA"
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 p-2.5">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nomor Rekening</label>
                        <input type="text" name="nomor_rekening" required placeholder="1234567890"
                            class="w-full text-xs font-mono font-bold border-slate-200 rounded-2xl focus:border-teal-500 p-2.5">
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Atas Nama</label>
                        <input type="text" name="atas_nama" required placeholder="Yayasan Al Futuh"
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 p-2.5">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Instruksi Transfer Singkat (Opsional)</label>
                    <input type="text" name="instruksi" placeholder="Contoh: Kode Bank 451 jika transfer antar bank"
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 p-2.5">
                </div>

                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-sm transition">
                    Simpan Rekening
                </button>
            </form>
        </div>

        <!-- Daftar Rekening Bank Aktif -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
            <h3 class="text-sm font-black text-slate-800 border-b border-slate-100 pb-2">Daftar Rekening Bank Aktif</h3>

            <div class="divide-y divide-slate-100">
                @forelse($banks as $b)
                    <div class="py-3.5 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="space-y-0.5">
                            <div class="flex items-center gap-2">
                                <span class="font-extrabold text-xs text-slate-800">{{ $b->nama_bank }}</span>
                                <span class="text-[10px] font-bold bg-teal-50 text-teal-700 px-2 py-0.5 rounded-md">{{ $b->kode_bank }}</span>
                            </div>
                            <p class="font-mono text-sm font-bold text-slate-700">{{ $b->nomor_rekening }}</p>
                            <p class="text-xs text-slate-500">Atas Nama: <strong class="text-slate-700">{{ $b->atas_nama }}</strong></p>
                            @if($b->instruksi)
                                <p class="text-[11px] text-slate-400 italic">{{ $b->instruksi }}</p>
                            @endif
                        </div>

                        <form action="{{ route('admin.banks.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Hapus rekening ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-rose-500 hover:text-rose-700 font-bold bg-rose-50 px-3 py-1.5 rounded-xl transition">
                                Hapus
                            </button>
                        </form>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 py-4 text-center">Belum ada rekening bank yang dikonfigurasi.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
