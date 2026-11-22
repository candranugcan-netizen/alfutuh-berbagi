<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Kelola Buku Kas Keuangan</h2>
                <p class="text-xs text-slate-500">Catat arus kas masuk, pengeluaran, serta ekspor laporan Excel &amp; PDF</p>
            </div>
            <!-- Tombol Ekspor Excel & PDF -->
            <div class="flex items-center gap-2">
                <a href="{{ route('keuangan.export.excel', request()->query()) }}" title="Ekspor Excel" class="bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC] hover:bg-[#DCEEE5] font-bold text-xs px-4 py-2 rounded-full flex items-center gap-1.5 transition active:scale-95 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Ekspor Excel</span>
                </a>
                <a href="{{ route('keuangan.export.pdf', request()->query()) }}" title="Ekspor PDF" class="bg-rose-50 text-rose-700 border border-rose-200 hover:bg-rose-100 font-bold text-xs px-4 py-2 rounded-full flex items-center gap-1.5 transition active:scale-95 shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Ekspor PDF</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Banner Pintas Laporan Keuangan Internal Yayasan -->
        <div class="bg-[#EAF5EE] border border-[#D2E6DC] p-4 sm:p-5 rounded-3xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-xs">
            <div class="flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-[#155E4B] text-white flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </span>
                <div>
                    <h4 class="font-extrabold text-sm text-[#155E4B]">Laporan Keuangan Khusus Kegiatan Internal Yayasan</h4>
                    <p class="text-xs text-slate-600 mt-0.5">Pantau alokasi dan realisasi biaya program non-publik (BBHQ, TPA Santri, Kajian Muslimah) dengan format resmi PDF &amp; Excel.</p>
                </div>
            </div>
            <a href="{{ route('admin.laporan-internal.index') }}" class="bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs px-5 py-2.5 rounded-full shadow-sm active:scale-95 transition shrink-0 whitespace-nowrap">
                Buka Laporan Internal →
            </a>
        </div>
        <!-- Form Catat Transaksi Baru -->
        <div class="p-5 sm:p-6 bg-white shadow-sm border border-slate-100 rounded-3xl space-y-3.5">
            <h3 class="text-sm font-extrabold text-slate-800">Catat Transaksi Kas Baru</h3>
            <form action="{{ route('keuangan.store') }}" method="POST" class="space-y-3.5">
                @csrf
                @if ($errors->any())
                    <div class="text-xs text-rose-700 bg-rose-50 border border-rose-200 p-3 rounded-2xl">
                        @foreach ($errors->all() as $error) <p>{{ $error }}</p> @endforeach
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Tanggal Transaksi</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" class="text-xs border border-slate-200 rounded-2xl w-full focus:border-[#155E4B] focus:ring-[#155E4B] p-3" required>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Tipe Transaksi</label>
                        <select name="tipe" class="text-xs border border-slate-200 rounded-2xl w-full focus:border-[#155E4B] focus:ring-[#155E4B] p-3" required>
                            <option value="Pemasukan">Pemasukan (+)</option>
                            <option value="Pengeluaran">Pengeluaran (-)</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Kategori Kas</label>
                        <select name="kategori_id" class="text-xs border border-slate-200 rounded-2xl w-full focus:border-[#155E4B] focus:ring-[#155E4B] p-3" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Nominal (Rp)</label>
                        <input type="number" name="nominal" placeholder="100000" class="text-xs font-bold border border-slate-200 rounded-2xl w-full focus:border-[#155E4B] focus:ring-[#155E4B] p-3" required min="0">
                    </div>
                </div>

                <div>
                    <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider block mb-1">Keterangan / Rincian</label>
                    <input type="text" name="keterangan" placeholder="Contoh: Donasi Infaq Kasir / Pembelian Sound System" class="text-xs border border-slate-200 rounded-2xl w-full focus:border-[#155E4B] focus:ring-[#155E4B] p-3" required>
                </div>

                <button type="submit" class="w-full bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-3.5 rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition">
                    Simpan Transaksi Kas
                </button>
            </form>
        </div>

        <!-- Filter Data -->
        <div class="p-4 sm:p-5 bg-white shadow-sm border border-slate-100 rounded-3xl space-y-3">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Filter Buku Kas</h3>

            <form action="{{ route('keuangan.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-2.5">
                <div>
                    <select name="kategori_id" class="text-xs border border-slate-200 rounded-xl w-full focus:border-[#155E4B] p-2.5">
                        <option value="">-- Semua Kategori --</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="tipe" class="text-xs border border-slate-200 rounded-xl w-full focus:border-[#155E4B] p-2.5">
                        <option value="">-- Semua Tipe --</option>
                        <option value="Pemasukan" {{ request('tipe') == 'Pemasukan' ? 'selected' : '' }}>Pemasukan (+)</option>
                        <option value="Pengeluaran" {{ request('tipe') == 'Pengeluaran' ? 'selected' : '' }}>Pengeluaran (-)</option>
                    </select>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-[#155E4B] hover:bg-[#0E4436] text-white text-xs font-bold py-2 rounded-xl transition">
                        Terapkan
                    </button>
                    @if(request()->hasAny(['kategori_id', 'tipe']))
                        <a href="{{ route('keuangan.index') }}" class="bg-slate-100 text-slate-600 text-xs font-bold px-3 py-2 rounded-xl flex items-center justify-center hover:bg-slate-200 transition">
                            Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Card Ringkasan Data Per Kategori -->
        <div class="space-y-2.5">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Ringkasan Per Kategori</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                @forelse($statKategori as $stat)
                    <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm space-y-2.5">
                        <div class="flex items-center justify-between border-b border-slate-50 pb-2">
                            <span class="text-xs font-extrabold text-slate-800 truncate">{{ $stat->nama_kategori }}</span>
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#EAF5EE] text-[#155E4B]">
                                Saldo: Rp {{ number_format($stat->saldo, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-[11px]">
                            <div class="bg-[#F2F7F4] p-2 rounded-xl border border-[#D2E6DC]">
                                <p class="text-[9px] font-bold text-[#155E4B] uppercase">Pemasukan</p>
                                <p class="font-black text-[#155E4B] mt-0.5">Rp {{ number_format($stat->pemasukan, 0, ',', '.') }}</p>
                            </div>
                            <div class="bg-rose-50/70 p-2 rounded-xl border border-rose-100">
                                <p class="text-[9px] font-bold text-rose-600 uppercase">Pengeluaran</p>
                                <p class="font-black text-rose-700 mt-0.5">Rp {{ number_format($stat->pengeluaran, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-4 rounded-2xl border border-slate-100 text-center col-span-full">
                        <p class="text-xs text-slate-400">Belum ada kategori terdaftar.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Daftar Transaksi (Mobile: Cards) -->
        <div class="space-y-2 sm:hidden">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider px-1">Riwayat Transaksi</h3>
            @forelse($keuangan as $item)
                <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm flex justify-between items-center">
                    <div class="space-y-0.5">
                        <div class="flex items-center gap-2">
                            <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $item->tipe == 'Pemasukan' ? 'bg-[#EAF5EE] text-[#155E4B]' : 'bg-rose-50 text-rose-600' }}">
                                {{ $item->tipe }}
                            </span>
                            <span class="text-xs text-slate-400">{{ $item->tanggal }}</span>
                        </div>
                        <p class="text-sm font-extrabold text-slate-800">{{ $item->keterangan }}</p>
                        <p class="text-xs text-slate-500">
                            {{ $item->kategori->nama_kategori ?? '-' }}
                        </p>
                    </div>
                    <div class="text-right space-y-1">
                        <p class="text-sm font-black {{ $item->tipe == 'Pemasukan' ? 'text-[#155E4B]' : 'text-rose-600' }}">
                            {{ $item->tipe == 'Pemasukan' ? '+' : '-' }}Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </p>
                        <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Catatan transaksi kas ini akan dihapus permanen.')">
                            @csrf
                            @method('DELETE')
                            <button class="text-[10px] text-rose-500 font-bold hover:underline">Hapus</button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-xs text-slate-400 text-center py-6 bg-white rounded-3xl border border-slate-100">Belum ada transaksi sesuai filter.</p>
            @endforelse

            @if(method_exists($keuangan, 'links'))
                <div class="pt-2">
                    {{ $keuangan->links() }}
                </div>
            @endif
        </div>

        <!-- Daftar Transaksi (Desktop: Table) -->
        <div class="hidden sm:block bg-white border border-slate-100 rounded-3xl p-5 shadow-sm space-y-3">
            <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Riwayat Transaksi</h3>
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-bold uppercase tracking-wider">
                        <th class="p-2.5">Tanggal</th>
                        <th class="p-2.5">Tipe</th>
                        <th class="p-2.5">Kategori</th>
                        <th class="p-2.5">Keterangan</th>
                        <th class="p-2.5">Nominal</th>
                        <th class="p-2.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($keuangan as $item)
                    <tr>
                        <td class="p-2.5 text-slate-500">{{ $item->tanggal }}</td>
                        <td class="p-2.5">
                            <span class="inline-block px-2.5 py-0.5 rounded-full font-bold text-[10px] {{ $item->tipe == 'Pemasukan' ? 'bg-[#EAF5EE] text-[#155E4B]' : 'bg-rose-50 text-rose-600' }}">
                                {{ $item->tipe }}
                            </span>
                        </td>
                        <td class="p-2.5 text-slate-700 font-bold">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                        <td class="p-2.5 text-slate-800 font-medium">{{ $item->keterangan }}</td>
                        <td class="p-2.5 font-black {{ $item->tipe == 'Pemasukan' ? 'text-[#155E4B]' : 'text-rose-600' }}">
                            {{ $item->tipe == 'Pemasukan' ? '+' : '-' }}Rp {{ number_format($item->nominal, 0, ',', '.') }}
                        </td>
                        <td class="p-2.5 text-right">
                            <form action="{{ route('keuangan.destroy', $item->id) }}" method="POST" onsubmit="return confirmDelete(event, 'Catatan transaksi kas ini akan dihapus permanen.')">
                                @csrf
                                @method('DELETE')
                                <button class="text-xs text-rose-600 hover:text-rose-700 font-bold hover:underline">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="p-6 text-center text-xs text-slate-400">Belum ada transaksi sesuai filter.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>

            @if(method_exists($keuangan, 'links'))
                <div class="pt-2">
                    {{ $keuangan->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
