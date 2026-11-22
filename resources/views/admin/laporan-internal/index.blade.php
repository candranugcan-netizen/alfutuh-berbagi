<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="text-[10px] font-extrabold uppercase tracking-wider bg-[#EAF5EE] text-[#155E4B] px-2.5 py-0.5 rounded-full border border-[#D2E6DC]">
                        Internal Yayasan
                    </span>
                    <h2 class="font-extrabold text-lg sm:text-xl text-slate-800 leading-tight">Laporan Keuangan Internal Operasional</h2>
                </div>
                <p class="text-xs text-slate-500 mt-1 leading-relaxed">Lacak alokasi donasi operasional umum untuk program BBHQ, TPA Santri, Kajian Muslimah &amp; dakwah yayasan</p>
            </div>

            <!-- Tombol Ekspor PDF & Excel (Responsive Mobile & Desktop) -->
            <div class="grid grid-cols-2 sm:flex sm:items-center gap-2 w-full sm:w-auto">
                <a href="{{ route('admin.laporan-internal.export.pdf', request()->query()) }}" title="Cetak PDF Resmi" class="bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 font-bold text-[11px] sm:text-xs px-3 sm:px-4 py-2 rounded-full flex items-center justify-center gap-1.5 transition active:scale-95 shadow-xs text-center">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Cetak PDF</span>
                </a>
                <a href="{{ route('admin.laporan-internal.export.excel', request()->query()) }}" title="Ekspor Excel" class="bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC] hover:bg-[#DCEEE5] font-bold text-[11px] sm:text-xs px-3 sm:px-4 py-2 rounded-full flex items-center justify-center gap-1.5 transition active:scale-95 shadow-xs text-center">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Ekspor Excel</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-4 sm:space-y-6">

        <!-- 3 Kartu Metrik Utama Anggaran Internal -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
            <!-- 1. Total Alokasi Masuk -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="flex items-center gap-2.5 mb-1">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider leading-tight">Total Alokasi Masuk</p>
                        <p class="text-[10px] text-slate-400">Plafon donasi operasional</p>
                    </div>
                </div>
                <p class="text-lg sm:text-xl font-black text-[#155E4B]">Rp {{ number_format($totalAlokasiMasuk, 0, ',', '.') }}</p>
            </div>

            <!-- 2. Total Pengeluaran Kegiatan -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="flex items-center gap-2.5 mb-1">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 12H4" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider leading-tight">Total Biaya Kegiatan</p>
                        <p class="text-[10px] text-slate-400">BBHQ, TPA, Kajian, dsb.</p>
                    </div>
                </div>
                <p class="text-lg sm:text-xl font-black text-rose-600">Rp {{ number_format($totalPengeluaranKegiatan, 0, ',', '.') }}</p>
            </div>

            <!-- 3. Sisa Saldo Kas Internal -->
            <div class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="flex items-center gap-2.5 mb-1">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl {{ $sisaSaldo >= 0 ? 'bg-[#EAF5EE] text-[#155E4B]' : 'bg-amber-50 text-amber-700' }} flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="1.8"/><path d="M12 7v5l3 3" stroke-width="1.8" stroke-linecap="round"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider leading-tight">Sisa Saldo Kas Internal</p>
                        <p class="text-[10px] text-slate-400">Siap dialokasikan</p>
                    </div>
                </div>
                <p class="text-lg sm:text-xl font-black {{ $sisaSaldo >= 0 ? 'text-[#155E4B]' : 'text-amber-600' }}">Rp {{ number_format($sisaSaldo, 0, ',', '.') }}</p>
            </div>
        </div>

        <!-- Rekapitulasi per Program Kegiatan Yayasan -->
        <div x-data="{
                showAddCategory: false,
                showEditCategory: false,
                editId: null,
                editName: '',
                editActionUrl: '',
                openEdit(id, name, url) {
                    this.editId = id;
                    this.editName = name;
                    this.editActionUrl = url;
                    this.showEditCategory = true;
                }
            }"
            class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm space-y-3">
            
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 border-b border-slate-100 pb-2.5">
                <div>
                    <h3 class="font-extrabold text-sm sm:text-base text-slate-800">Realisasi Pos Anggaran per Kegiatan</h3>
                    <p class="text-[11px] sm:text-xs text-slate-400">Ringkasan penyerapan dana operasional pada program yayasan</p>
                </div>
                <button type="button" @click="showAddCategory = true" class="inline-flex items-center justify-center gap-1.5 bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC] hover:bg-[#DCEEE5] text-xs font-bold px-3.5 py-1.5 rounded-full transition active:scale-95 shadow-2xs self-start sm:self-auto">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/></svg>
                    <span>Tambah Pos Kegiatan</span>
                </button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-2.5 sm:gap-3">
                @foreach($statKegiatan as $stat)
                    <div class="p-3 sm:p-3.5 rounded-2xl bg-[#F8FAF8] border border-slate-100 space-y-1.5 hover:border-[#155E4B]/40 transition group relative">
                        <div class="flex items-start justify-between gap-1">
                            <span class="text-[10px] font-bold text-[#155E4B] uppercase tracking-wider block line-clamp-1 flex-1" title="{{ $stat->nama }}">
                                {{ $stat->nama }}
                            </span>
                            <div class="flex items-center gap-0.5 shrink-0">
                                <!-- Tombol Edit Kategori -->
                                <button type="button" 
                                    @click="openEdit({{ $stat->id }}, '{{ addslashes($stat->nama) }}', '{{ route('admin.laporan-internal.kategori.update', $stat->id) }}')"
                                    class="text-slate-400 hover:text-[#155E4B] p-1 rounded hover:bg-white transition"
                                    title="Edit Kategori">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </button>
                                <!-- Tombol Hapus Kategori -->
                                <form action="{{ route('admin.laporan-internal.kategori.destroy', $stat->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Apakah Anda yakin ingin menghapus pos kegiatan &quot;{{ addslashes($stat->nama) }}&quot;?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                        class="text-slate-400 hover:text-rose-600 p-1 rounded hover:bg-white transition"
                                        title="Hapus Kategori">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="space-y-0.5 text-xs">
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="text-slate-400">Masuk:</span>
                                <span class="font-bold text-emerald-700">Rp {{ number_format($stat->pemasukan, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-[11px]">
                                <span class="text-slate-400">Biaya:</span>
                                <span class="font-bold text-rose-600">Rp {{ number_format($stat->pengeluaran, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center text-[11px] pt-1 border-t border-slate-200">
                                <span class="text-slate-600 font-bold">Saldo:</span>
                                <span class="font-black {{ $stat->saldo >= 0 ? 'text-[#155E4B]' : 'text-rose-600' }}">
                                    Rp {{ number_format($stat->saldo, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- MODAL EDIT KATEGORI -->
            <div x-show="showEditCategory" x-cloak class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
                <div @click.away="showEditCategory = false" class="bg-white rounded-3xl max-w-sm w-full p-5 sm:p-6 shadow-2xl border border-slate-100 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <h4 class="font-extrabold text-sm text-slate-800">Edit Kategori Kegiatan</h4>
                        </div>
                        <button type="button" @click="showEditCategory = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form :action="editActionUrl" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Kategori Kegiatan</label>
                            <input type="text" name="nama_kategori" x-model="editName" required class="w-full text-xs font-semibold border border-slate-200 rounded-xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-1">
                            <button type="button" @click="showEditCategory = false" class="text-xs font-bold text-slate-500 hover:bg-slate-100 px-4 py-2.5 rounded-full transition">
                                Batal
                            </button>
                            <button type="submit" class="text-xs font-extrabold bg-[#155E4B] hover:bg-[#0E4436] text-white px-5 py-2.5 rounded-full shadow-sm transition active:scale-95">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- MODAL TAMBAH KATEGORI BARU -->
            <div x-show="showAddCategory" x-cloak class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-xs" style="display: none;">
                <div @click.away="showAddCategory = false" class="bg-white rounded-3xl max-w-sm w-full p-5 sm:p-6 shadow-2xl border border-slate-100 space-y-4">
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="2" stroke-linecap="round"/></svg>
                            </div>
                            <h4 class="font-extrabold text-sm text-slate-800">Tambah Pos Kategori Baru</h4>
                        </div>
                        <button type="button" @click="showAddCategory = false" class="text-slate-400 hover:text-slate-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <form action="{{ route('admin.laporan-internal.kategori.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nama Kategori Kegiatan</label>
                            <input type="text" name="nama_kategori" placeholder="Contoh: Pembinaan Mualaf &amp; Da'i" required class="w-full text-xs font-semibold border border-slate-200 rounded-xl focus:border-[#155E4B] focus:ring-[#155E4B] p-3">
                        </div>

                        <div class="flex items-center justify-end gap-2 pt-1">
                            <button type="button" @click="showAddCategory = false" class="text-xs font-bold text-slate-500 hover:bg-slate-100 px-4 py-2.5 rounded-full transition">
                                Batal
                            </button>
                            <button type="submit" class="text-xs font-extrabold bg-[#155E4B] hover:bg-[#0E4436] text-white px-5 py-2.5 rounded-full shadow-sm transition active:scale-95">
                                Tambahkan Pos
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Form Catat Transaksi Kegiatan Internal Baru -->
        <div x-data="{ showForm: false, showNewCategory: false }" class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm space-y-3.5">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5">
                <div>
                    <h3 class="font-extrabold text-sm sm:text-base text-slate-800">Catat Transaksi Kas Internal Kegiatan</h3>
                    <p class="text-[11px] sm:text-xs text-slate-400">Pencairan alokasi atau pengeluaran operasional kegiatan (BBHQ, TPA, Kajian, dsb.)</p>
                </div>
                <button type="button" @click="showForm = !showForm" class="w-full sm:w-auto text-xs font-bold bg-[#EAF5EE] text-[#155E4B] px-4 py-2.5 rounded-full border border-[#D2E6DC] hover:bg-[#DCEEE5] transition flex items-center justify-center gap-1.5 active:scale-95 shadow-xs">
                    <span x-text="showForm ? 'Sembunyikan Form' : '+ Tambah Transaksi'"></span>
                </button>
            </div>

            <form x-show="showForm" x-cloak action="{{ route('admin.laporan-internal.store') }}" method="POST" class="space-y-3 pt-3 border-t border-slate-100">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-3">
                    <!-- Tanggal -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Tanggal Transaksi <span class="text-rose-500">*</span></label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required class="w-full text-xs border border-slate-200 rounded-xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3">
                    </div>

                    <!-- Tipe Transaksi -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Tipe Transaksi <span class="text-rose-500">*</span></label>
                        <select name="tipe" required class="w-full text-xs border border-slate-200 rounded-xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3 bg-white">
                            <option value="Pengeluaran">Pengeluaran Biaya Kegiatan (-)</option>
                            <option value="Pemasukan">Pencairan Alokasi dari Donasi Operasional (+)</option>
                        </select>
                    </div>

                    <!-- Nominal -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nominal (Rp) <span class="text-rose-500">*</span></label>
                        <input type="number" name="nominal" min="1000" step="1000" placeholder="Contoh: 1500000" required class="w-full text-xs font-bold border border-slate-200 rounded-xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
                    <!-- Pos Program Kegiatan Yayasan -->
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">Program / Pos Kegiatan <span class="text-rose-500">*</span></label>
                            <button type="button" @click="showNewCategory = !showNewCategory" class="text-[10px] text-[#155E4B] hover:underline font-bold">
                                <span x-text="showNewCategory ? 'Pilih dari daftar' : '+ Buat program baru'"></span>
                            </button>
                        </div>

                        <div x-show="!showNewCategory">
                            <select name="kategori_id" class="w-full text-xs border border-slate-200 rounded-xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3 bg-white">
                                <option value="" disabled selected>-- Pilih Program Kegiatan --</option>
                                @foreach($internalCategories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div x-show="showNewCategory" x-cloak>
                            <input type="text" name="new_kategori" placeholder="Ketik nama program kegiatan baru yayasan..." class="w-full text-xs border border-slate-200 rounded-xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3">
                        </div>
                    </div>

                    <!-- Penanggung Jawab / Penerima Manfaat -->
                    <div>
                        <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Penanggung Jawab / Penerima / Pengajar</label>
                        <input type="text" name="penanggung_jawab" placeholder="Contoh: Ustadz Erwin Siregar, S.H. / Fulan atau Fulanah" class="w-full text-xs border border-slate-200 rounded-xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3">
                    </div>
                </div>

                <!-- Rincian Penggunaan Anggaran -->
                <div>
                    <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-1">Rincian Penggunaan / Keterangan Transaksi <span class="text-rose-500">*</span></label>
                    <input type="text" name="keterangan" required placeholder="Contoh: Honorarium pengajar BBHQ 3 kelas, pengadaan 50 mushaf tajwid, snack santri TPA..." class="w-full text-xs border border-slate-200 rounded-xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3">
                </div>

                <div class="pt-1">
                    <button type="submit" class="w-full bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-3 rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition">
                        Simpan Transaksi Internal
                    </button>
                </div>
            </form>
        </div>

        <!-- Filter & Pencarian Laporan Internal -->
        <div class="bg-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm space-y-3">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Filter Periode &amp; Pos Kegiatan</h3>

            <form action="{{ route('admin.laporan-internal.index') }}" method="GET" class="space-y-2.5">
                <!-- Baris 1: Tanggal & Dropdown Kategori -->
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2 sm:gap-2.5">
                    <div>
                        <label class="block text-[10px] text-slate-400 font-bold mb-1">Dari Tanggal</label>
                        <input type="date" name="start_date" value="{{ $startDate }}" class="w-full text-xs border border-slate-200 rounded-xl focus:border-[#155E4B] p-2 sm:p-2.5">
                    </div>

                    <div>
                        <label class="block text-[10px] text-slate-400 font-bold mb-1">Sampai Tanggal</label>
                        <input type="date" name="end_date" value="{{ $endDate }}" class="w-full text-xs border border-slate-200 rounded-xl focus:border-[#155E4B] p-2 sm:p-2.5">
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-[10px] text-slate-400 font-bold mb-1">Program Kegiatan</label>
                        <select name="kategori_id" class="w-full text-xs border border-slate-200 rounded-xl focus:border-[#155E4B] p-2 sm:p-2.5 bg-white">
                            <option value="">-- Semua Kegiatan --</option>
                            @foreach($internalCategories as $cat)
                                <option value="{{ $cat->id }}" {{ $kategoriId == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-[10px] text-slate-400 font-bold mb-1">Tipe Transaksi</label>
                        <select name="tipe" class="w-full text-xs border border-slate-200 rounded-xl focus:border-[#155E4B] p-2 sm:p-2.5 bg-white">
                            <option value="">-- Semua Tipe --</option>
                            <option value="Pemasukan" {{ $tipe == 'Pemasukan' ? 'selected' : '' }}>Alokasi Masuk (+)</option>
                            <option value="Pengeluaran" {{ $tipe == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran Kegiatan (-)</option>
                        </select>
                    </div>
                </div>

                <!-- Baris 2: Kolom Pencarian & Tombol Aksi -->
                <div class="flex flex-col sm:flex-row gap-2 pt-1">
                    <div class="relative flex-1">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari keterangan, nama ustadz, atau pengeluaran..." class="w-full text-xs pl-9 pr-4 py-2 sm:py-2.5 rounded-xl border border-slate-200 focus:border-[#155E4B]">
                        <span class="absolute left-3 top-2 sm:top-2.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6" stroke-width="1.8"/><path d="m16 16 4 4" stroke-width="1.8" stroke-linecap="round"/></svg>
                        </span>
                    </div>
                    <div class="grid grid-cols-2 sm:flex gap-2">
                        <button type="submit" class="bg-[#155E4B] hover:bg-[#0E4436] text-white text-xs font-bold px-5 py-2 sm:py-2.5 rounded-xl transition shadow-xs text-center justify-center">
                            Filter
                        </button>
                        <a href="{{ route('admin.laporan-internal.index') }}" class="bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-bold px-4 py-2 sm:py-2.5 rounded-xl transition text-center flex items-center justify-center">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Jurnal Transaksi Internal -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 shadow-sm overflow-hidden p-4 sm:p-6 space-y-3.5">
            <div class="flex items-center justify-between pb-2 border-b border-slate-100">
                <div>
                    <h3 class="font-extrabold text-sm sm:text-base text-slate-800">Jurnal Transaksi Kas Internal</h3>
                    <p class="text-[11px] text-slate-400">Riwayat alokasi masuk &amp; pengeluaran operasional</p>
                </div>
                <span class="text-[10px] sm:text-xs font-bold text-[#155E4B] bg-[#EAF5EE] px-2.5 py-1 rounded-full border border-[#D2E6DC]">
                    {{ $transaksis->total() }} Transaksi
                </span>
            </div>

            <!-- TAMPILAN MOBILE (Card-Based List) -->
            <div class="block md:hidden space-y-3">
                @forelse($transaksis as $tx)
                    <div class="p-3.5 bg-[#F8FAF8] rounded-2xl border border-slate-100 space-y-2.5">
                        <!-- Header Card: Badge Program & Tipe Transaksi -->
                        <div class="flex items-start justify-between gap-2">
                            <span class="inline-block bg-[#EAF5EE] text-[#155E4B] px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border border-[#D2E6DC] line-clamp-1">
                                {{ $tx->kategori->nama_kategori ?? 'Operasional' }}
                            </span>
                            @if($tx->tipe === 'Pemasukan')
                                <span class="text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 rounded-full shrink-0">
                                    + Alokasi Masuk
                                </span>
                            @else
                                <span class="text-[10px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-0.5 rounded-full shrink-0">
                                    - Biaya Kegiatan
                                </span>
                            @endif
                        </div>

                        <!-- Rincian Keterangan Transaksi -->
                        <div>
                            <p class="text-xs font-bold text-slate-800 leading-snug">
                                {{ $tx->keterangan }}
                            </p>
                            @if($tx->penanggung_jawab)
                                <p class="text-[11px] text-slate-500 mt-1 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    <span>PJ: <strong class="text-slate-700">{{ $tx->penanggung_jawab }}</strong></span>
                                </p>
                            @endif
                        </div>

                        <!-- Baris Bawah: Tanggal, Nominal, & Aksi Hapus -->
                        <div class="flex items-center justify-between pt-2 border-t border-slate-200/60 text-xs">
                            <span class="text-[11px] text-slate-400">📅 {{ $tx->tanggal ? $tx->tanggal->format('d M Y') : '-' }}</span>
                            <div class="flex items-center gap-2.5">
                                <span class="font-black text-sm {{ $tx->tipe === 'Pemasukan' ? 'text-emerald-700' : 'text-rose-600' }}">
                                    {{ $tx->tipe === 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($tx->nominal, 0, ',', '.') }}
                                </span>
                                <form action="{{ route('admin.laporan-internal.destroy', $tx->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Hapus transaksi internal senilai Rp {{ number_format($tx->nominal, 0, ',', '.') }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-500 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 p-1.5 rounded-lg border border-rose-200 transition active:scale-95" title="Hapus Transaksi">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center bg-[#F8FAF8] rounded-2xl border border-slate-100 text-slate-400 text-xs">
                        Belum ada catatan transaksi keuangan internal untuk filter yang dipilih.
                    </div>
                @endforelse
            </div>

            <!-- TAMPILAN DESKTOP (Full Table) -->
            <div class="hidden md:block overflow-x-auto scrollbar-none">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase text-[10px]">
                            <th class="py-3 px-3">Tanggal</th>
                            <th class="py-3 px-3">Program Kegiatan</th>
                            <th class="py-3 px-3">Tipe</th>
                            <th class="py-3 px-3">Penanggung Jawab</th>
                            <th class="py-3 px-3">Rincian Keterangan</th>
                            <th class="py-3 px-3 text-right">Nominal</th>
                            <th class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($transaksis as $tx)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="py-3 px-3 font-medium text-slate-500 whitespace-nowrap">
                                    {{ $tx->tanggal ? $tx->tanggal->format('d M Y') : '-' }}
                                </td>
                                <td class="py-3 px-3 font-extrabold text-slate-800">
                                    <span class="inline-block bg-[#EAF5EE] text-[#155E4B] px-2.5 py-0.5 rounded-full text-[10px] border border-[#D2E6DC]">
                                        {{ $tx->kategori->nama_kategori ?? 'Operasional' }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 whitespace-nowrap">
                                    @if($tx->tipe === 'Pemasukan')
                                        <span class="text-[10px] font-extrabold bg-emerald-50 text-emerald-700 border border-emerald-200 px-2.5 py-0.5 rounded-full">
                                            + Alokasi Masuk
                                        </span>
                                    @else
                                        <span class="text-[10px] font-extrabold bg-rose-50 text-rose-700 border border-rose-200 px-2.5 py-0.5 rounded-full">
                                            - Biaya Kegiatan
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-slate-600 font-medium whitespace-nowrap">
                                    {{ $tx->penanggung_jawab ?: '-' }}
                                </td>
                                <td class="py-3 px-3 text-slate-600 max-w-xs leading-relaxed">
                                    {{ $tx->keterangan }}
                                </td>
                                <td class="py-3 px-3 text-right font-black whitespace-nowrap {{ $tx->tipe === 'Pemasukan' ? 'text-emerald-700' : 'text-rose-600' }}">
                                    {{ $tx->tipe === 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($tx->nominal, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3 text-center whitespace-nowrap">
                                    <form action="{{ route('admin.laporan-internal.destroy', $tx->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Hapus transaksi internal senilai Rp {{ number_format($tx->nominal, 0, ',', '.') }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-[10px] text-rose-600 hover:text-rose-800 font-bold p-1 rounded hover:bg-rose-50 transition" title="Hapus Transaksi">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    Belum ada catatan transaksi keuangan internal untuk filter yang dipilih.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($transaksis, 'links'))
                <div class="pt-2">
                    {{ $transaksis->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
