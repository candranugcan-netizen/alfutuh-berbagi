<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\KategoriKeuangan;
use App\Exports\LaporanInternalExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanInternalController extends Controller
{
    /**
     * Pastikan kategori internal baku selalu ada
     */
    protected function ensureDefaultInternalCategories()
    {
        if (Schema::hasTable('kategori_keuangans') && !Schema::hasColumn('kategori_keuangans', 'is_internal')) {
            try {
                \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                // Ignore error if schema builder is in progress
            }
        }

        $defaultCategories = [
            'Gerakan Berantas Buta Huruf Al-Qur\'an (BBHQ)',
            'TPA / TPQ Santri Al Futuh',
            'Kajian Muslimah & Majelis Ta\'lim',
            'Operasional & Sarana Dakwah Yayasan',
            'Alokasi Donasi Umum Operasional',
        ];

        if (KategoriKeuangan::where('is_internal', true)->count() === 0) {
            foreach ($defaultCategories as $catName) {
                $cat = KategoriKeuangan::firstOrCreate(
                    ['nama_kategori' => $catName],
                    ['is_internal' => true]
                );
                if (!$cat->is_internal) {
                    $cat->update(['is_internal' => true]);
                }
            }
        }
    }

    /**
     * Dashboard & Laporan Keuangan Internal Yayasan
     */
    public function index(Request $request)
    {
        $this->ensureDefaultInternalCategories();

        $internalCategories = KategoriKeuangan::where('is_internal', true)->get();
        $internalCategoryIds = $internalCategories->pluck('id');

        // Parameter Filter
        $startDate = $request->input('start_date', now()->startOfMonth()->toDateString());
        $endDate = $request->input('end_date', now()->endOfMonth()->toDateString());
        $kategoriId = $request->input('kategori_id');
        $tipe = $request->input('tipe');
        $search = $request->input('q');

        // Query Dasar Transaksi Internal
        $query = Keuangan::with('kategori')
            ->where(function ($q) use ($internalCategoryIds) {
                $q->where('is_internal', true)
                  ->orWhereIn('kategori_id', $internalCategoryIds);
            })
            ->latest('tanggal')
            ->latest('id');

        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }

        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }

        if ($tipe) {
            $query->where('tipe', $tipe);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$search}%");
            });
        }

        // Paginasi Transaksi
        $transaksis = (clone $query)->paginate(15)->withQueryString();

        // Hitung Ringkasan Statistik Berdasarkan Filter
        $allFiltered = (clone $query)->get();
        $totalAlokasiMasuk = $allFiltered->where('tipe', 'Pemasukan')->sum('nominal');
        $totalPengeluaranKegiatan = $allFiltered->where('tipe', 'Pengeluaran')->sum('nominal');
        $sisaSaldo = $totalAlokasiMasuk - $totalPengeluaranKegiatan;

        // Breakdown Statistik per Program Kegiatan Internal
        $statKegiatan = $internalCategories->map(function ($kat) use ($startDate, $endDate) {
            $q = Keuangan::where('kategori_id', $kat->id);
            if ($startDate) {
                $q->whereDate('tanggal', '>=', $startDate);
            }
            if ($endDate) {
                $q->whereDate('tanggal', '<=', $endDate);
            }

            $txs = $q->get();
            $pemasukan = $txs->where('tipe', 'Pemasukan')->sum('nominal');
            $pengeluaran = $txs->where('tipe', 'Pengeluaran')->sum('nominal');
            $saldo = $pemasukan - $pengeluaran;

            return (object) [
                'id' => $kat->id,
                'nama' => $kat->nama_kategori,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'saldo' => $saldo,
                'total_transaksi' => $txs->count(),
            ];
        });

        return view('admin.laporan-internal.index', compact(
            'transaksis',
            'internalCategories',
            'startDate',
            'endDate',
            'kategoriId',
            'tipe',
            'search',
            'totalAlokasiMasuk',
            'totalPengeluaranKegiatan',
            'sisaSaldo',
            'statKegiatan'
        ));
    }

    /**
     * Catat Transaksi Alokasi atau Pengeluaran Internal Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'tipe' => 'required|in:Pemasukan,Pengeluaran',
            'kategori_id' => 'nullable',
            'new_kategori' => 'nullable|string|max:100',
            'nominal' => 'required|numeric|min:1000',
            'penanggung_jawab' => 'nullable|string|max:255',
            'keterangan' => 'required|string|max:500',
        ], [
            'nominal.min' => 'Nominal transaksi minimal Rp 1.000.',
            'keterangan.required' => 'Rincian pengeluaran / alokasi wajib diisi.',
        ]);

        // Jika admin menambahkan program kegiatan internal baru
        if ($request->filled('new_kategori')) {
            $cat = KategoriKeuangan::firstOrCreate(
                ['nama_kategori' => trim($request->new_kategori)],
                ['is_internal' => true]
            );
            $cat->update(['is_internal' => true]);
            $kategoriId = $cat->id;
        } else {
            $request->validate(['kategori_id' => 'required|exists:kategori_keuangans,id']);
            $kategoriId = $request->kategori_id;
        }

        Keuangan::create([
            'tanggal' => $validated['tanggal'],
            'tipe' => $validated['tipe'],
            'kategori_id' => $kategoriId,
            'nominal' => $validated['nominal'],
            'is_internal' => true,
            'penanggung_jawab' => $validated['penanggung_jawab'] ?? '-',
            'keterangan' => $validated['keterangan'],
        ]);

        return redirect()->route('admin.laporan-internal.index')
            ->with('success', 'Transaksi internal sebesar Rp ' . number_format($validated['nominal'], 0, ',', '.') . ' berhasil dicatat!');
    }

    /**
     * Hapus Transaksi Internal
     */
    public function destroy($id)
    {
        $data = Keuangan::findOrFail($id);
        $data->delete();

        return redirect()->route('admin.laporan-internal.index')
            ->with('success', 'Transaksi internal berhasil dihapus.');
    }

    /**
     * Tambah Kategori Kegiatan Internal Baru
     */
    public function storeKategori(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ], [
            'nama_kategori.required' => 'Nama kategori kegiatan wajib diisi.',
        ]);

        $nama = trim($request->nama_kategori);
        $kategori = KategoriKeuangan::firstOrCreate(
            ['nama_kategori' => $nama],
            ['is_internal' => true]
        );
        if (!$kategori->is_internal) {
            $kategori->update(['is_internal' => true]);
        }

        return redirect()->route('admin.laporan-internal.index')
            ->with('success', "Kategori kegiatan '{$kategori->nama_kategori}' berhasil ditambahkan.");
    }

    /**
     * Ubah / Edit Nama Kategori Kegiatan Internal
     */
    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100',
        ], [
            'nama_kategori.required' => 'Nama kategori kegiatan wajib diisi.',
        ]);

        $kategori = KategoriKeuangan::findOrFail($id);
        $oldName = $kategori->nama_kategori;
        $newName = trim($request->nama_kategori);

        $kategori->update([
            'nama_kategori' => $newName,
            'is_internal' => true,
        ]);

        return redirect()->route('admin.laporan-internal.index')
            ->with('success', "Kategori '{$oldName}' berhasil diperbarui menjadi '{$newName}'.");
    }

    /**
     * Hapus Kategori Kegiatan Internal
     */
    public function destroyKategori($id)
    {
        $kategori = KategoriKeuangan::findOrFail($id);
        $txCount = Keuangan::where('kategori_id', $id)->count();

        if ($txCount > 0) {
            return redirect()->route('admin.laporan-internal.index')
                ->with('error', "Kategori '{$kategori->nama_kategori}' tidak dapat dihapus karena masih digunakan oleh {$txCount} transaksi kas internal. Hapus atau alihkan transaksi terkait terlebih dahulu.");
        }

        $nama = $kategori->nama_kategori;
        $kategori->delete();

        return redirect()->route('admin.laporan-internal.index')
            ->with('success', "Kategori kegiatan '{$nama}' berhasil dihapus.");
    }

    /**
     * Cetak Laporan PDF Resmi Yayasan Al Futuh
     */
    public function exportPdf(Request $request)
    {
        $this->ensureDefaultInternalCategories();
        $internalCategoryIds = KategoriKeuangan::where('is_internal', true)->pluck('id');

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kategoriId = $request->input('kategori_id');
        $tipe = $request->input('tipe');
        $search = $request->input('q');

        $query = Keuangan::with('kategori')
            ->where(function ($q) use ($internalCategoryIds) {
                $q->where('is_internal', true)
                  ->orWhereIn('kategori_id', $internalCategoryIds);
            })
            ->latest('tanggal')
            ->latest('id');

        if ($startDate) {
            $query->whereDate('tanggal', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('tanggal', '<=', $endDate);
        }
        if ($kategoriId) {
            $query->where('kategori_id', $kategoriId);
        }
        if ($tipe) {
            $query->where('tipe', $tipe);
        }
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('keterangan', 'like', "%{$search}%")
                  ->orWhere('penanggung_jawab', 'like', "%{$search}%");
            });
        }

        $transaksis = $query->get();
        $totalAlokasiMasuk = $transaksis->where('tipe', 'Pemasukan')->sum('nominal');
        $totalPengeluaranKegiatan = $transaksis->where('tipe', 'Pengeluaran')->sum('nominal');
        $sisaSaldo = $totalAlokasiMasuk - $totalPengeluaranKegiatan;

        // Breakdown per Program
        $kategoriTerpilih = $kategoriId ? KategoriKeuangan::find($kategoriId) : null;
        $statKegiatan = KategoriKeuangan::where('is_internal', true)->get()->map(function ($kat) use ($startDate, $endDate) {
            $q = Keuangan::where('kategori_id', $kat->id);
            if ($startDate) $q->whereDate('tanggal', '>=', $startDate);
            if ($endDate) $q->whereDate('tanggal', '<=', $endDate);
            $txs = $q->get();
            $pemasukan = $txs->where('tipe', 'Pemasukan')->sum('nominal');
            $pengeluaran = $txs->where('tipe', 'Pengeluaran')->sum('nominal');
            return (object) [
                'nama' => $kat->nama_kategori,
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
                'saldo' => $pemasukan - $pengeluaran,
            ];
        });

        $pdf = Pdf::loadView('admin.laporan-internal.pdf', compact(
            'transaksis',
            'startDate',
            'endDate',
            'kategoriTerpilih',
            'totalAlokasiMasuk',
            'totalPengeluaranKegiatan',
            'sisaSaldo',
            'statKegiatan'
        ))->setPaper('a4', 'portrait');

        $fileName = 'Laporan_Internal_Yayasan_Al_Futuh_' . date('Ymd_His') . '.pdf';
        return $pdf->download($fileName);
    }

    /**
     * Ekspor Excel (.xlsx) Laporan Internal
     */
    public function exportExcel(Request $request)
    {
        $this->ensureDefaultInternalCategories();

        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $kategoriId = $request->input('kategori_id');
        $tipe = $request->input('tipe');
        $search = $request->input('q');

        $fileName = 'Laporan_Keuangan_Internal_Al_Futuh_' . date('Ymd_His') . '.xlsx';

        return Excel::download(
            new LaporanInternalExport($startDate, $endDate, $kategoriId, $tipe, $search),
            $fileName
        );
    }
}
