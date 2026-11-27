<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Keuangan;
use App\Models\KategoriKeuangan;
use App\Models\Program;
use App\Models\Donation;
use App\Models\Penyaluran;
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
            'Gebraq (Gerakan Berantas Buta Huruf Al-Qur\'an)',
            'TPA / TPQ Santri Al Futuh',
            'Kajian Muslimah & Majelis Ta\'lim',
            'Operasional & Sarana Dakwah Yayasan',
            'Alokasi Donasi Umum Operasional',
        ];

        // Otomatis perbarui kategori lama yang masih bernama BBHQ menjadi Gebraq
        KategoriKeuangan::where('nama_kategori', 'like', '%BBHQ%')
            ->update(['nama_kategori' => 'Gebraq (Gerakan Berantas Buta Huruf Al-Qur\'an)']);

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
     * Dapatkan Program Donasi Operasional Umum
     */
    protected function getOperasionalProgram()
    {
        return Program::where('slug', 'sedekah-operasional-dakwah-yayasan')
            ->orWhere('nama', 'like', '%operasional%')
            ->first();
    }

    /**
     * Hitung total dana terkumpul dari Donasi Operasional Umum
     */
    protected function getTotalDonasiOperasional()
    {
        $prog = $this->getOperasionalProgram();
        if (!$prog) {
            return 0;
        }

        $verifiedSum = Donation::where('program_id', $prog->id)
            ->where('status', 'verified')
            ->sum('nominal');

        return (int) $verifiedSum;
    }

    /**
     * Hitung sisa donasi operasional sesuai laporan donatur per program
     */
    protected function getSisaDonasiOperasional()
    {
        $prog = $this->getOperasionalProgram();
        if (!$prog) {
            return 0;
        }

        $totalPenyaluran = Penyaluran::where('program_id', $prog->id)->sum('nominal');

        return max(0, $this->getTotalDonasiOperasional() - (int) $totalPenyaluran);
    }

    /**
     * Query seluruh transaksi internal, termasuk data lama yang hanya ditandai lewat kategori
     */
    protected function internalTransactions()
    {
        return Keuangan::where(function ($query) {
            $query->where('is_internal', true)
                ->orWhereHas('kategori', function ($categoryQuery) {
                    $categoryQuery->where('is_internal', true);
                });
        });
    }

    /**
     * Hitung total akumulasi pencairan dana ke pos kegiatan internal
     */
    protected function getTotalPencairanDana()
    {
        return $this->internalTransactions()->where('tipe', 'Pemasukan')->sum('nominal');
    }

    /**
     * Hitung sisa dana donasi operasional yang masih bisa dicairkan ke kegiatan
     */
    protected function getSisaBisaDicairkan()
    {
        $totalPencairan = $this->getTotalPencairanDana();

        return max(0, $this->getTotalDonasiOperasional() - $totalPencairan);
    }

    /**
     * Hitung akumulasi pengeluaran biaya kegiatan riil
     */
    protected function getTotalPengeluaranKegiatan()
    {
        return $this->internalTransactions()->where('tipe', 'Pengeluaran')->sum('nominal');
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

        // 1. Total Dana Donasi Operasional Yayasan
        $totalDonasiOperasional = $this->getTotalDonasiOperasional();
        $totalPencairanKumulatif = $this->getTotalPencairanDana();
        $sisaDonasiOperasional = $this->getSisaDonasiOperasional();
        // Saldo internal hanya dikurangi pencairan internal, bukan penyaluran publik.
        $sisaBisaDicairkan = max(0, $totalDonasiOperasional - $totalPencairanKumulatif);

        // 2 & 3. Total Pencairan & Total Pengeluaran pada filter periode
        $allFiltered = (clone $query)->get();
        $totalPencairanDana = $allFiltered->where('tipe', 'Pemasukan')->sum('nominal');
        $totalPengeluaranKegiatan = $allFiltered->where('tipe', 'Pengeluaran')->sum('nominal');
        $totalPengeluaranKumulatif = $this->getTotalPengeluaranKegiatan();

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
            'totalDonasiOperasional',
            'sisaDonasiOperasional',
            'sisaBisaDicairkan',
            'totalPencairanDana',
            'totalPencairanKumulatif',
            'totalPengeluaranKegiatan',
            'totalPengeluaranKumulatif',
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

        // 1. Validasi saat Admin Mencairkan Dana (Tipe: Pemasukan / Pencairan ke Pos Kegiatan)
        // Pencairan dana tidak boleh melebihi sisa dana donasi operasional yang dapat dicairkan
        if ($validated['tipe'] === 'Pemasukan') {
            $sisaBisaDicairkan = $this->getSisaBisaDicairkan();
            if ($validated['nominal'] > $sisaBisaDicairkan) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pencairan dana tidak dapat diproses! Nominal pencairan (Rp ' . number_format($validated['nominal'], 0, ',', '.') . ') melebihi sisa dana donasi operasional yang dapat dicairkan (Maksimal Rp ' . number_format($sisaBisaDicairkan, 0, ',', '.') . ').');
            }
        }

        // 2. Validasi saat Admin Mengeluarkan Dana Kegiatan (Tipe: Pengeluaran dari Pos Kegiatan)
        // Pengeluaran tidak boleh melebihi saldo dana yang tersedia di pos kegiatan yang bersangkutan
        if ($validated['tipe'] === 'Pengeluaran') {
            $posMasuk = Keuangan::where('kategori_id', $kategoriId)->where('tipe', 'Pemasukan')->sum('nominal');
            $posKeluar = Keuangan::where('kategori_id', $kategoriId)->where('tipe', 'Pengeluaran')->sum('nominal');
            $saldoPos = $posMasuk - $posKeluar;

            if ($validated['nominal'] > $saldoPos) {
                $posName = KategoriKeuangan::find($kategoriId)?->nama_kategori ?? 'pos kegiatan ini';
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Pengeluaran kegiatan tidak dapat diproses! Nominal pengeluaran (Rp ' . number_format($validated['nominal'], 0, ',', '.') . ') melebihi saldo dana yang tersedia pada ' . $posName . ' (Maksimal Rp ' . number_format(max(0, $saldoPos), 0, ',', '.') . '). Silakan lakukan pencairan dana ke pos kegiatan terlebih dahulu.');
            }
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
        
        // 1. Total Dana Donasi Operasional Yayasan
        $totalDonasiOperasional = $this->getTotalDonasiOperasional();
        $totalPencairanKumulatif = $this->getTotalPencairanDana();
        $sisaDonasiOperasional = $this->getSisaDonasiOperasional();
        $sisaBisaDicairkan = max(0, $totalDonasiOperasional - $totalPencairanKumulatif);

        // 2 & 3. Total Pencairan & Total Pengeluaran pada filter periode
        $totalPencairanDana = $transaksis->where('tipe', 'Pemasukan')->sum('nominal');
        $totalPengeluaranKegiatan = $transaksis->where('tipe', 'Pengeluaran')->sum('nominal');

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
            'totalDonasiOperasional',
            'sisaDonasiOperasional',
            'sisaBisaDicairkan',
            'totalPencairanDana',
            'totalPengeluaranKegiatan',
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
