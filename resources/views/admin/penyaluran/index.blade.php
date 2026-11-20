<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-slate-800 leading-tight">Ambil Donasi & Laporan Penyaluran</h2>
        <p class="text-xs text-slate-500">Catat penarikan dana untuk disalurkan ke penerima manfaat beserta bukti dokumentasi</p>
    </x-slot>

    <div class="py-4 space-y-6">

        <!-- Form Ambil Donasi / Penyaluran Baru -->
        <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-black text-sm text-slate-800">Form Ambil Donasi (Penyaluran Baru)</h3>
                <p class="text-xs text-slate-400">Pengambilan dana akan otomatis tercatat di laporan transparansi publik dan buku kas yayasan.</p>
            </div>

            <form action="{{ route('admin.penyaluran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                    <!-- Program Asal Dana -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Program Donasi Asal Dana <span class="text-rose-500">*</span>
                        </label>
                        <select name="program_id" required class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                            <option value="">-- Pilih Program Asal Dana --</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog->id }}">{{ $prog->nama }} (Terkumpul: Rp {{ number_format($prog->dana_terkumpul, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                        @error('program_id') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Judul Kegiatan Penyaluran -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Judul Penyaluran / Penggunaan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="judul" required placeholder="Contoh: Santunan 50 Anak Yatim Tahap 1"
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                        @error('judul') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
                    <!-- Nominal Disalurkan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Nominal yang Diambil / Disalurkan (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="nominal" min="1000" step="1000" required placeholder="Contoh: 5000000"
                            class="w-full text-xs font-black border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                        @error('nominal') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tanggal Penyaluran -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Tanggal Penyaluran <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>

                    <!-- Penerima Manfaat -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                            Penerima Manfaat <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="penerima" required placeholder="Contoh: 50 Santri Yatim Binaan"
                            class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3">
                    </div>
                </div>

                <!-- Keterangan Detail -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Keterangan Rincian Penggunaan Dana <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="keterangan" rows="2" required placeholder="Jelaskan secara transparan peruntukan dana dan item yang dibelanjakan..."
                        class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-3"></textarea>
                </div>

                <!-- Foto Dokumentasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Foto Dokumentasi Penyaluran (Opsional, Maks 3MB)
                    </label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full text-xs border-slate-200 rounded-2xl p-2.5">
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-black text-xs py-3.5 rounded-2xl shadow-md active:scale-95 transition">
                    Simpan & Terbitkan Laporan Penyaluran
                </button>
            </form>
        </div>

        <!-- Riwayat Penyaluran Dana -->
        <div class="space-y-3">
            <div class="flex justify-between items-center px-1">
                <h3 class="text-sm font-black text-slate-800">Riwayat Penyaluran Dana Terdaftar</h3>
                <span class="text-xs font-bold text-amber-600">Total: Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</span>
            </div>

            <div class="space-y-3">
                @forelse($penyalurans as $item)
                    <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                        <div class="flex items-start gap-3">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" class="w-16 h-16 rounded-xl object-cover shrink-0 border border-slate-100">
                            @else
                                <div class="w-16 h-16 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center text-xl shrink-0">
                                    📤
                                </div>
                            @endif
                            <div class="space-y-0.5">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold bg-teal-50 text-teal-700 px-2 py-0.5 rounded-md">{{ $item->program->nama }}</span>
                                    <span class="text-[10px] text-slate-400">📅 {{ $item->tanggal->format('d M Y') }}</span>
                                </div>
                                <h4 class="font-bold text-sm text-slate-800">{{ $item->judul }}</h4>
                                <p class="text-xs text-slate-500">Penerima: <strong>{{ $item->penerima }}</strong></p>
                                <p class="text-[11px] text-slate-400 line-clamp-1">{{ $item->keterangan }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 pt-2 md:pt-0 border-slate-50">
                            <span class="font-black text-amber-600 text-sm">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                            <form action="{{ route('admin.penyaluran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus laporan penyaluran ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs text-rose-500 hover:text-rose-700 font-bold bg-rose-50 px-3 py-1.5 rounded-xl transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-8 text-center rounded-3xl border border-slate-100">
                        <p class="text-xs text-slate-400">Belum ada penyaluran dana yang dicatat.</p>
                    </div>
                @endforelse

                <div class="pt-2">
                    {{ $penyalurans->links() }}
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
