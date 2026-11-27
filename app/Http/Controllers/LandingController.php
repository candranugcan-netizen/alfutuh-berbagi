<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Donation;
use App\Models\Penyaluran;
use App\Models\Kabar;
use App\Models\Keuangan;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    /**
     * Halaman Utama (Beranda KitaBisa style Al Futuh)
     */
    public function index(Request $request)
    {
        // 1. Program Pilihan / Unggulan (Carousel Program Unggulan)
        $featuredPrograms = Program::withSum('penyalurans', 'nominal')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('urutan')
            ->get();

        // Jika tidak ada yang ditandai featured, ambil program teratas
        if ($featuredPrograms->isEmpty()) {
            $featuredPrograms = Program::withSum('penyalurans', 'nominal')
                ->where('is_active', true)
                ->orderBy('urutan')
                ->take(6)
                ->get();
        }

        // 2. Program Terbaru (3 penggalangan dana terbaru)
        $latestPrograms = Program::withSum('penyalurans', 'nominal')
            ->where('is_active', true)
            ->latest('created_at')
            ->take(3)
            ->get();

        // 2. Semua Program untuk Grid Menu & List Program
        $kategoriAktif = $request->query('kategori', 'Semua');
        $programsQuery = Program::withSum('penyalurans', 'nominal')
            ->where('is_active', true)
            ->orderBy('urutan');

        if ($kategoriAktif && $kategoriAktif !== 'Semua') {
            $programsQuery->where('kategori', $kategoriAktif);
        }

        $programs = $programsQuery->get();

        // Daftar kategori unik untuk filter tabs
        $categories = Program::where('is_active', true)
            ->distinct()
            ->pluck('kategori');

        // 3. Kabar Terbaru / Cerita Penyaluran
        $kabars = Kabar::with('program')
            ->where('is_published', true)
            ->latest('tanggal')
            ->take(4)
            ->get();

        // 4. Ringkasan Transparansi Donasi & Kas
        $totalDonasiMasuk = Donation::where('status', 'verified')->sum('nominal');
        $totalPenyaluran = Penyaluran::sum('nominal');
        $totalDonaturCount = Donation::where('status', 'verified')->count();
        $totalProgramCount = Program::where('is_active', true)->count();
        
        // Saldo Kas Nyata (Pemasukan - Pengeluaran di tabel Keuangan)
        $pemasukan = Keuangan::where('tipe', 'Pemasukan')->sum('nominal');
        $pengeluaran = Keuangan::where('tipe', 'Pengeluaran')->sum('nominal');
        $saldoKas = $pemasukan - $pengeluaran;

        // 5. Doa & Donatur Terkini (Real-time feed)
        $recentDonations = Donation::with('program')
            ->where('status', 'verified')
            ->whereNotNull('doa')
            ->latest()
            ->take(5)
            ->get();

        // 6. Program Sedekah Operasional Dakwah untuk Pop-Up Promosi
        $operasionalProgram = Program::withSum('penyalurans', 'nominal')
            ->where('is_active', true)
            ->where(function ($q) {
                $q->where('slug', 'sedekah-operasional-dakwah-yayasan')
                  ->orWhere('nama', 'like', '%operasional%');
            })
            ->first() ?? ($featuredPrograms->first() ?? $programs->first());

        return view('welcome', compact(
            'featuredPrograms',
            'latestPrograms',
            'programs',
            'categories',
            'kategoriAktif',
            'kabars',
            'totalDonasiMasuk',
            'totalPenyaluran',
            'totalDonaturCount',
            'totalProgramCount',
            'saldoKas',
            'recentDonations',
            'operasionalProgram'
        ));
    }

    /**
     * Halaman Eksplor Semua Program Donasi
     */
    public function programs(Request $request)
    {
        $kategori = $request->query('kategori', 'Semua');
        $search = $request->query('q');

        $query = Program::withSum('penyalurans', 'nominal')->where('is_active', true)->orderBy('urutan');

        if ($kategori && $kategori !== 'Semua') {
            $query->where(function ($q) use ($kategori) {
                $q->where('kategori', $kategori)
                  ->orWhere('kategori', 'like', "%{$kategori}%");
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%")
                  ->orWhere('ringkasan', 'like', "%{$search}%");
            });
        }

        $programs = $query->paginate(9)->withQueryString();

        $dbCategories = Program::where('is_active', true)->distinct()->pluck('kategori')->toArray();
        $baseCategories = ['Masjid', 'Pendidikan', 'Sosial', 'Kemanusiaan'];
        $categories = collect(array_values(array_unique(array_merge($baseCategories, $dbCategories))));

        return view('programs.index', compact('programs', 'categories', 'kategori', 'search'));
    }

    /**
     * Halaman Detail Program Donasi
     */
    public function programDetail($slug)
    {
        $program = Program::with(['penyalurans', 'kabars'])->where('slug', $slug)->firstOrFail();

        // Donatur terverifikasi terbaru untuk program ini
        $donations = Donation::where('program_id', $program->id)
            ->where('status', 'verified')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        // Kabar update untuk program ini
        $kabars = Kabar::where('program_id', $program->id)
            ->where('is_published', true)
            ->latest('tanggal')
            ->get();

        // Penyaluran dana untuk program ini
        $penyalurans = Penyaluran::where('program_id', $program->id)
            ->latest('tanggal')
            ->get();

        return view('programs.show', compact('program', 'donations', 'kabars', 'penyalurans'));
    }

    /**
     * Halaman Daftar Kabar Terbaru
     */
    public function kabars()
    {
        $kabars = Kabar::with('program')
            ->where('is_published', true)
            ->latest('tanggal')
            ->paginate(10);

        return view('kabars.index', compact('kabars'));
    }

    /**
     * Detail Kabar Berita
     */
    public function kabarDetail($slug)
    {
        $kabar = Kabar::with('program')->where('slug', $slug)->firstOrFail();
        $otherKabars = Kabar::where('id', '!=', $kabar->id)
            ->where('is_published', true)
            ->latest('tanggal')
            ->take(3)
            ->get();

        return view('kabars.show', compact('kabar', 'otherKabars'));
    }

    /**
     * Halaman Transparansi Dana & Penyaluran Publik
     */
    public function transparansi()
    {
        $totalDonasi = Donation::where('status', 'verified')->sum('nominal');
        $totalPenyaluran = Penyaluran::sum('nominal');
        $saldoAmanah = max(0, $totalDonasi - $totalPenyaluran);

        $penyalurans = Penyaluran::with('program')
            ->latest('tanggal')
            ->paginate(15)
            ->withQueryString();

        $programsSummary = Program::withCount('verifiedDonations')
            ->withSum('verifiedDonations as total_donasi_terverifikasi', 'nominal')
            ->withSum('penyalurans as total_penyaluran', 'nominal')
            ->get();

        return view('transparansi', compact('totalDonasi', 'totalPenyaluran', 'saldoAmanah', 'penyalurans', 'programsSummary'));
    }
}
