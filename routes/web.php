<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KategoriKeuanganController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\Admin\AdminDonationController;
use App\Http\Controllers\Admin\AdminPenyaluranController;
use App\Http\Controllers\Admin\AdminProgramController;
use App\Http\Controllers\Admin\AdminKabarController;
use App\Http\Controllers\Admin\AdminBankController;
use App\Models\Keuangan;
use App\Models\Kegiatan;
use App\Models\Donation;
use App\Models\Program;
use App\Models\Penyaluran;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Donatur & Tamu / Guest)
|--------------------------------------------------------------------------
*/
// Beranda Utama Model KitaBisa
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Eksplorasi Program Donasi
Route::get('/programs', [LandingController::class, 'programs'])->name('programs.index');
Route::get('/program/{slug}', [LandingController::class, 'programDetail'])->name('programs.show');

// Alur Donasi
Route::get('/program/{slug}/donasi', [DonationController::class, 'create'])->name('donations.create');
Route::post('/program/{slug}/donasi', [DonationController::class, 'store'])->name('donations.store');

// Instruksi Pembayaran Transfer Bank & QRIS
Route::get('/donasi/{kode_donasi}', [DonationController::class, 'payment'])->name('donations.payment');
Route::post('/donasi/{kode_donasi}/bukti', [DonationController::class, 'uploadProof'])->name('donations.upload-proof');

// Riwayat Donasi (Pengguna Terdaftar & Lacak Tamu)
Route::get('/donasi-saya', [DonationController::class, 'myDonations'])->name('donations.my-donations');
Route::post('/donasi-saya/lacak', [DonationController::class, 'trackGuest'])->name('donations.track-guest');

// Kabar Terbaru & Cerita Penyaluran
Route::get('/kabar', [LandingController::class, 'kabars'])->name('kabars.index');
Route::get('/kabar/{slug}', [LandingController::class, 'kabarDetail'])->name('kabars.show');

// Laporan Transparansi Donasi & Kas
Route::get('/transparansi', [LandingController::class, 'transparansi'])->name('transparansi');


/*
|--------------------------------------------------------------------------
| Admin & Authenticated Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    // Cek apakah user admin, jika bukan arahkan ke riwayat donasi donatur
    $user = auth()->user();
    if (!$user->isAdmin()) {
        return redirect()->route('donations.my-donations');
    }
    
    // Metrik Donasi
    $pendingVerificationCount = Donation::where('status', 'pending_verification')->count();
    $totalDonasiVerif = Donation::where('status', 'verified')->sum('nominal');
    $totalPenyaluran = Penyaluran::sum('nominal');
    $totalProgram = Program::where('is_active', true)->count();

    // Metrik Kas Umum
    $pemasukan = Keuangan::where('tipe', 'Pemasukan')->sum('nominal');
    $pengeluaran = Keuangan::where('tipe', 'Pengeluaran')->sum('nominal');
    $saldo = $pemasukan - $pengeluaran;
    $totalKegiatan = Kegiatan::count();
    $recentKeuangan = Keuangan::with('kategori')->latest()->take(3)->get();
    
    // Donasi Terbaru yang Perlu Diverifikasi
    $pendingDonations = Donation::with('program')
        ->where('status', 'pending_verification')
        ->latest()
        ->take(5)
        ->get();

    return view('dashboard', compact(
        'pemasukan',
        'pengeluaran',
        'saldo',
        'totalKegiatan',
        'recentKeuangan',
        'pendingVerificationCount',
        'totalDonasiVerif',
        'totalPenyaluran',
        'totalProgram',
        'pendingDonations'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    // 1. Profil Pengguna
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 2. Modul Admin Donasi
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        // Verifikasi Donasi
        Route::get('/donasi', [AdminDonationController::class, 'index'])->name('donasi.index');
        Route::post('/donasi/{id}/verify', [AdminDonationController::class, 'verify'])->name('donasi.verify');
        Route::post('/donasi/{id}/reject', [AdminDonationController::class, 'reject'])->name('donasi.reject');

        // Input Manual Donasi (Donasi Offline / Kotak Infaq)
        Route::get('/donasi/manual', [AdminDonationController::class, 'createManual'])->name('donasi.manual.create');
        Route::post('/donasi/manual', [AdminDonationController::class, 'storeManual'])->name('donasi.manual.store');

        // Ambil Donasi / Penyaluran Dana (Laporan Transparan)
        Route::get('/penyaluran', [AdminPenyaluranController::class, 'index'])->name('penyaluran.index');
        Route::post('/penyaluran', [AdminPenyaluranController::class, 'store'])->name('penyaluran.store');
        Route::delete('/penyaluran/{id}', [AdminPenyaluranController::class, 'destroy'])->name('penyaluran.destroy');

        // Kelola Program Donasi
        Route::resource('programs', AdminProgramController::class);

        // Kelola Kabar Terbaru
        Route::resource('kabar', AdminKabarController::class);

        // Kelola Rekening Bank
        Route::get('/banks', [AdminBankController::class, 'index'])->name('banks.index');
        Route::post('/banks', [AdminBankController::class, 'store'])->name('banks.store');
        Route::delete('/banks/{id}', [AdminBankController::class, 'destroy'])->name('banks.destroy');
    });

    // 3. Modul Kas Keuangan & Ekspor (Legacy & Sinkronisasi)
    Route::get('/keuangan/export/excel', [KeuanganController::class, 'exportExcel'])->name('keuangan.export.excel');
    Route::get('/keuangan/export/pdf', [KeuanganController::class, 'exportPdf'])->name('keuangan.export.pdf');
    Route::resource('kategori', KategoriKeuanganController::class)->only(['index', 'store', 'destroy']);
    Route::resource('keuangan', KeuanganController::class)->only(['index', 'store', 'destroy']);
    Route::resource('kegiatan', KegiatanController::class)->only(['index', 'store', 'destroy']);
});


/*
|--------------------------------------------------------------------------
| Setup & Migration Helper
|--------------------------------------------------------------------------
*/
Route::get('/migrasi-aman-12345', function () {
    try {
        Artisan::call('migrate', ['--force' => true]);
        $output = "=== MIGRASI DATABASE SUKSES ===\n" . Artisan::output();

        Artisan::call('db:seed', ['--class' => 'AlFutuhSeeder', '--force' => true]);
        $output .= "\n=== SEEDER AL FUTUH SUKSES ===\n" . Artisan::output();

        // Buat storage link jika belum ada
        if (!file_exists(public_path('storage'))) {
            Artisan::call('storage:link');
            $output .= "\n=== STORAGE LINK SUKSES ===\n" . Artisan::output();
        }

        return '<pre style="background:#0f172a; color:#10b981; padding:20px; font-family:monospace; border-radius:12px;">' . $output . '<br><a href="/" style="color:#f59e0b; font-weight:bold; text-decoration:underline;">← Kembali ke Beranda Donasi Al Futuh</a></pre>';
    } catch (\Exception $e) {
        return '<pre style="background:#0f172a; color:#ef4444; padding:20px; font-family:monospace; border-radius:12px;">ERROR: ' . $e->getMessage() . '</pre>';
    }
});

require __DIR__.'/auth.php';
