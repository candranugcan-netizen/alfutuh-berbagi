<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Ambil Donasi &amp; Laporan Penyaluran</h2>
                <p class="text-xs text-slate-500">Catat penarikan dana untuk disalurkan ke penerima manfaat beserta bukti dokumentasi</p>
            </div>
            <a href="{{ route('transparansi') }}" target="_blank" class="inline-flex items-center gap-1.5 text-xs text-[#155E4B] bg-[#EAF5EE] border border-[#D2E6DC] px-4 py-2 rounded-full font-bold hover:bg-[#DCEEE5] transition">
                <span>Lihat Laporan Publik →</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- Form Ambil Donasi / Penyaluran Baru -->
        <div class="bg-white p-5 sm:p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <div class="border-b border-slate-100 pb-3">
                <h3 class="font-extrabold text-sm text-slate-800">Form Ambil Donasi (Penyaluran Baru)</h3>
                <p class="text-xs text-slate-400">Pengambilan dana akan otomatis tercatat di laporan transparansi publik dan buku kas yayasan.</p>
            </div>

            <form action="{{ route('admin.penyaluran.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                    <!-- Program Asal Dana -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Program Donasi Asal Dana <span class="text-rose-500">*</span>
                        </label>
                        <select name="program_id" required class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                            <option value="">-- Pilih Program Asal Dana --</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog->id }}">{{ $prog->nama }} (Terkumpul: Rp {{ number_format($prog->dana_terkumpul, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                        @error('program_id') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Judul Kegiatan Penyaluran -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Judul Penyaluran / Penggunaan <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="judul" required placeholder="Contoh: Santunan 50 Anak Yatim Tahap 1"
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                        @error('judul') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
                    <!-- Nominal Disalurkan -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Nominal yang Diambil (Rp) <span class="text-rose-500">*</span>
                        </label>
                        <input type="number" name="nominal" min="1000" step="1000" required placeholder="Contoh: 5000000"
                            class="w-full text-xs font-black border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                        @error('nominal') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Tanggal Penyaluran -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Tanggal Penyaluran <span class="text-rose-500">*</span>
                        </label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    </div>

                    <!-- Penerima Manfaat -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                            Penerima Manfaat <span class="text-rose-500">*</span>
                        </label>
                        <input type="text" name="penerima" required placeholder="Contoh: 50 Santri Yatim Binaan"
                            class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                    </div>
                </div>

                <!-- Keterangan Detail -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Keterangan Rincian Penggunaan Dana <span class="text-rose-500">*</span>
                    </label>
                    <textarea name="keterangan" rows="2" required placeholder="Jelaskan secara transparan peruntukan dana dan item yang dibelanjakan..."
                        class="w-full text-xs border border-slate-200 rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3"></textarea>
                </div>

                <!-- Foto Dokumentasi -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">
                        Foto Dokumentasi Penyaluran (Opsional, Maks 3MB)
                    </label>
                    <input type="file" name="foto" accept="image/*"
                        class="w-full text-xs border border-slate-200 rounded-2xl p-2.5">
                </div>

                <!-- Tombol Submit -->
                <button type="submit" class="w-full bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-3.5 rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition">
                    Simpan &amp; Terbitkan Laporan Penyaluran
                </button>
            </form>
        </div>

        <!-- Riwayat Penyaluran Dana -->
        <div class="space-y-3">
            <div class="flex justify-between items-center px-1">
                <h3 class="text-sm font-extrabold text-slate-800 tracking-tight">Daftar Pengambilan &amp; Penyaluran Dana</h3>
                <span class="text-xs text-slate-400 font-medium">{{ $penyalurans->total() }} Catatan</span>
            </div>

            <div class="space-y-3">
                @forelse($penyalurans as $item)
                    <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                        <div class="flex items-start gap-3.5">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto" class="w-16 h-16 rounded-2xl object-cover shrink-0 border border-slate-100">
                            @else
                                <div class="w-16 h-16 rounded-2xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0">
                                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                            @endif
                            <div class="space-y-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold text-[#155E4B] bg-[#EAF5EE] px-2.5 py-0.5 rounded-full border border-[#D2E6DC]">
                                        {{ $item->program->nama }}
                                    </span>
                                    <span class="text-[10px] text-slate-400">📅 {{ $item->tanggal->format('d M Y') }}</span>
                                </div>
                                <h4 class="font-extrabold text-sm text-slate-800">{{ $item->judul }}</h4>
                                <p class="text-xs font-black text-rose-600">Disalurkan: Rp {{ number_format($item->nominal, 0, ',', '.') }}</p>
                                <p class="text-[11px] text-slate-500">Penerima: {{ $item->penerima }}</p>
                            </div>
                        </div>

                        <form action="{{ route('admin.penyaluran.destroy', $item->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Catatan penyaluran &quot;{{ addslashes($item->judul) }}&quot; senilai Rp {{ number_format($item->nominal, 0, \', \', \'.\') }} akan dihapus permanen.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs text-rose-600 hover:text-rose-700 font-bold bg-rose-50 border border-rose-100 px-3.5 py-1.5 rounded-full transition active:scale-95">
                                Hapus
                            </button>
                        </form>
                    </div>
                @empty
                    <div class="bg-white p-8 text-center rounded-3xl border border-slate-100">
                        <p class="text-xs text-slate-400">Belum ada riwayat penyaluran dana yang dicatat.</p>
                    </div>
                @endforelse

                @if(method_exists($penyalurans, 'links'))
                    <div class="pt-2">
                        {{ $penyalurans->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
