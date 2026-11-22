<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Program;
use App\Models\BankAccount;
use App\Models\Kabar;
use App\Models\Penyaluran;
use App\Models\KategoriKeuangan;
use App\Models\Keuangan;
use App\Models\Donation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AlFutuhSeeder extends Seeder
{
    public function run(): void
    {
        // =========================================================================
        // 1. AKUN ADMIN (Satu-satunya akun yang dipertahankan)
        // =========================================================================
        $admin = User::firstOrCreate(
            ['email' => 'admin@alfutuh.com'],
            [
                'name' => 'Admin Al Futuh',
                'password' => Hash::make('alfutuh123'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        if ($admin->role !== 'admin') {
            $admin->update(['role' => 'admin', 'name' => 'Admin Al Futuh']);
        }

        // Bersihkan akun demo donatur
        User::where('email', 'donatur@gmail.com')->delete();


        // =========================================================================
        // 2. BANK BSI (Satu-satunya rekening bank yang dipertahankan)
        // =========================================================================
        $bsi = BankAccount::updateOrCreate(
            ['kode_bank' => 'BSI'],
            [
                'nama_bank' => 'Bank Syariah Indonesia (BSI)',
                'kode_bank' => 'BSI',
                'nomor_rekening' => '7123456789',
                'atas_nama' => 'Yayasan Al Futuh Peduli',
                'instruksi' => 'Transfer via ATM BSI, BSI Mobile, atau Transfer Antar Bank (Kode Bank 451)',
                'urutan' => 1,
            ]
        );

        // Bersihkan rekening bank lainnya (BCA, Mandiri, QRIS)
        BankAccount::where('id', '!=', $bsi->id)->delete();


        // =========================================================================
        // 3. PROGRAM DONASI OPERASIONAL & DAKWAH (Satu-satunya program donasi)
        // =========================================================================
        $programOperasional = Program::updateOrCreate(
            ['slug' => 'sedekah-operasional-dakwah-yayasan'],
            [
                'nama' => 'Sedekah Operasional & Dakwah Yayasan',
                'slug' => 'sedekah-operasional-dakwah-yayasan',
                'kategori' => 'Operasional',
                'icon' => '🕌',
                'ringkasan' => 'Dukungan operasional dakwah, Gerakan Berantas Buta Huruf Al-Qur\'an (Gebraq), TPA santri, dan kajian keumatan.',
                'deskripsi' => "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\nSedekah Operasional Umum Yayasan Al Futuh adalah denyut nadi yang menopang seluruh aktivitas dakwah dan sosial yayasan. Setiap rupiah yang Anda titipkan tidak hanya membiayai satu kegiatan, melainkan mengalir serempak untuk:\n1. Gerakan Berantas Buta Huruf Al-Qur'an (Gebraq) gratis bagi jamaah lansia dan mualaf.\n2. Pembinaan santri TPA/TPQ dan pengadaan sarana belajar Al-Qur'an.\n3. Penyelenggaraan Kajian Muslimah rutin dan majelis ilmu keumatan.\n4. Pemeliharaan fisik, kebersihan, listrik, dan kenyamanan fasilitas dakwah.\n\nMari jadikan sedekah operasional ini sebagai tabungan jariyah terbaik yang pahalanya terus mengalir selamanya.",
                'target_dana' => 0,
                'dana_terkumpul' => 0,
                'banner' => null,
                'tipe_target' => 'berkelanjutan',
                'is_featured' => true,
                'is_active' => true,
                'urutan' => 1,
            ]
        );

        // Bersihkan program donasi dummy lainnya beserta data turunannya
        $otherPrograms = Program::where('id', '!=', $programOperasional->id)->get();
        foreach ($otherPrograms as $prog) {
            Penyaluran::where('program_id', $prog->id)->delete();
            Kabar::where('program_id', $prog->id)->delete();
            Donation::where('program_id', $prog->id)->delete();
            $prog->delete();
        }

        // Bersihkan seluruh kabar dan penyaluran dummy
        Kabar::query()->delete();
        Penyaluran::query()->delete();

        // Bersihkan transaksi keuangan dummy lama
        Keuangan::query()->delete();

        // Pastikan kategori dasar untuk operasional tersedia
        KategoriKeuangan::firstOrCreate(['nama_kategori' => 'Sedekah Operasional & Dakwah Yayasan']);
        KategoriKeuangan::firstOrCreate(['nama_kategori' => 'Operasional & Sarana Dakwah Yayasan'], ['is_internal' => true]);
        KategoriKeuangan::firstOrCreate(['nama_kategori' => 'Alokasi Donasi Umum Operasional'], ['is_internal' => true]);
        KategoriKeuangan::firstOrCreate(['nama_kategori' => 'Gerakan Berantas Buta Huruf Al-Qur\'an (BBHQ)'], ['is_internal' => true]);
        KategoriKeuangan::firstOrCreate(['nama_kategori' => 'TPA / TPQ Santri Al Futuh'], ['is_internal' => true]);
        KategoriKeuangan::firstOrCreate(['nama_kategori' => 'Kajian Muslimah & Majelis Ta\'lim'], ['is_internal' => true]);
    }
}
