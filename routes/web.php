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
use App\Http\Controllers\Admin\LaporanInternalController;
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

        // Laporan Keuangan Internal Yayasan (BBHQ, TPA, Kajian, dsb. dari Donasi Operasional)
        Route::get('/laporan-internal', [LaporanInternalController::class, 'index'])->name('laporan-internal.index');
        Route::post('/laporan-internal', [LaporanInternalController::class, 'store'])->name('laporan-internal.store');
        Route::delete('/laporan-internal/{id}', [LaporanInternalController::class, 'destroy'])->name('laporan-internal.destroy');
        Route::get('/laporan-internal/export/pdf', [LaporanInternalController::class, 'exportPdf'])->name('laporan-internal.export.pdf');
        Route::get('/laporan-internal/export/excel', [LaporanInternalController::class, 'exportExcel'])->name('laporan-internal.export.excel');
        Route::post('/laporan-internal/kategori', [LaporanInternalController::class, 'storeKategori'])->name('laporan-internal.kategori.store');
        Route::put('/laporan-internal/kategori/{id}', [LaporanInternalController::class, 'updateKategori'])->name('laporan-internal.kategori.update');
        Route::delete('/laporan-internal/kategori/{id}', [LaporanInternalController::class, 'destroyKategori'])->name('laporan-internal.kategori.destroy');
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
// Rute Refresh Token CSRF Otomatis (Mencegah Sesi Habis saat Form Ditinggal Lama)
Route::get('/refresh-csrf', function () {
    return response()->json(['csrf_token' => csrf_token()]);
})->name('refresh-csrf');

// Rute Khusus Storage Link
Route::get('/storage-link-12345', function () {
    try {
        $storagePath = public_path('storage');
        $target = storage_path('app/public');
        $output = '';

        // Opsi ?recreate=1 jika link lama broken atau ingin dibuat ulang
        if (request()->has('recreate') && (file_exists($storagePath) || is_link($storagePath))) {
            if (is_link($storagePath)) {
                @unlink($storagePath);
                $output .= "Symlink lama berhasil dilepas/dihapus.\n";
            } elseif (is_dir($storagePath)) {
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    @rmdir($storagePath);
                } else {
                    @unlink($storagePath);
                }
                $output .= "Direktori link storage lama berhasil dibersihkan.\n";
            }
        }

        // Jalankan Artisan storage:link
        Artisan::call('storage:link');
        $output .= Artisan::output();

        // Fallback manual symlink jika artisan belum membuat link
        if (!file_exists($storagePath) && !is_link($storagePath) && function_exists('symlink')) {
            @symlink($target, $storagePath);
            $output .= "Symlink manual dibuat: [{$target}] -> [{$storagePath}]\n";
        }

        $isLinked = file_exists($storagePath) || is_link($storagePath);
        $status = $isLinked
            ? "STATUS: Storage link AKTIF & TERHUBUNG!\nTarget : {$target}\nPublic : {$storagePath}"
            : "STATUS: Storage link belum terhubung. Silakan coba klik tautan [Buat Ulang Link (Recreate)].";

        $color = $isLinked ? '#10b981' : '#f59e0b';

        return '<pre style="background:#0f172a; color:' . $color . '; padding:24px; font-family:monospace; border-radius:12px; line-height:1.6; font-size:13px;">'
            . "=== AL FUTUH STORAGE:LINK HELPER ===\n\n"
            . trim($output) . "\n\n"
            . $status . "\n\n"
            . '--------------------------------------------------\n'
            . '<a href="/storage-link-12345?recreate=1" style="color:#38bdf8; font-weight:bold; text-decoration:underline;">[Buat Ulang Link (Recreate)]</a> | '
            . '<a href="/storage-link" style="color:#94a3b8; text-decoration:underline;">/storage-link</a> | '
            . '<a href="/" style="color:#f59e0b; font-weight:bold; text-decoration:underline;">← Kembali ke Beranda</a></pre>';
    } catch (\Exception $e) {
        return '<pre style="background:#0f172a; color:#ef4444; padding:20px; font-family:monospace; border-radius:12px;">ERROR STORAGE LINK: ' . $e->getMessage() . '</pre>';
    }
})->name('storage.link.helper');

// Alias rute singkat untuk kemudahan akses
Route::redirect('/storage-link', '/storage-link-12345');

// Rute Diagnosa Sistem & Skema Tabel untuk Produksi
Route::get('/diagnosa-program-12345', function () {
    try {
        $output = "=== AL FUTUH PROGRAM DIAGNOSTICS ===\n\n";

        // 1. Cek Koneksi Database
        \Illuminate\Support\Facades\DB::connection()->getPdo();
        $output .= "[OK] Database connected.\n";

        // 2. Cek Kolom Tabel programs
        $columns = \Illuminate\Support\Facades\Schema::getColumnListing('programs');
        $output .= "[INFO] Kolom tabel 'programs':\n" . implode(', ', $columns) . "\n\n";

        // 3. Cek Kolom Tabel kategori_keuangans
        $katColumns = \Illuminate\Support\Facades\Schema::getColumnListing('kategori_keuangans');
        $output .= "[INFO] Kolom tabel 'kategori_keuangans':\n" . implode(', ', $katColumns) . "\n\n";

        // 4. Cek Permission Direktori Storage
        $storageDisk = \Illuminate\Support\Facades\Storage::disk('public');
        $testFile = 'programs/.test_' . time() . '.txt';
        $written = $storageDisk->put($testFile, 'test');
        if ($written) {
            $output .= "[OK] Storage disk 'public' Writable (bisa tulis file).\n";
            $storageDisk->delete($testFile);
        } else {
            $output .= "[WARNING] Storage disk 'public' GAGAL menulis file!\n";
        }

        // 5. Cek Program Aktif & Max Urutan
        $maxUrutan = \App\Models\Program::max('urutan');
        $countProgram = \App\Models\Program::count();
        $output .= "[OK] Total program saat ini: {$countProgram}, Max urutan: {$maxUrutan}\n\n";

        // 6. Cek Log Terakhir
        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath)) {
            $logLines = array_slice(file($logPath), -15);
            $output .= "=== 15 BARIS LOG TERAKHIR ===\n" . implode('', $logLines);
        }

        return '<pre style="background:#0f172a; color:#10b981; padding:20px; font-family:monospace; border-radius:12px; line-height:1.5;">' . e($output) . '<br><br><a href="/admin/programs" style="color:#f59e0b; font-weight:bold; text-decoration:underline;">← Kembali ke Kelola Program</a></pre>';
    } catch (\Throwable $e) {
        return '<pre style="background:#0f172a; color:#ef4444; padding:20px; font-family:monospace; border-radius:12px;">ERROR DIAGNOSA: ' . e($e->getMessage()) . "\n" . e($e->getTraceAsString()) . '</pre>';
    }
});

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
