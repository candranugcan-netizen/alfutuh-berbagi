<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Program;
use App\Models\BankAccount;
use App\Models\Kabar;
use App\Models\Penyaluran;
use App\Models\KategoriKeuangan;
use App\Models\Keuangan;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlFutuhSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@alfutuh.com'],
            [
                'name' => 'Admin Al Futuh',
                'password' => bcrypt('alfutuh123'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        if ($admin->role !== 'admin') {
            $admin->update(['role' => 'admin', 'name' => 'Admin Al Futuh']);
        }

        // Akun Demo Donatur
        User::firstOrCreate(
            ['email' => 'donatur@gmail.com'],
            [
                'name' => 'Fulan bin Fulan',
                'password' => bcrypt('password'),
                'role' => 'donatur',
                'phone' => '082198765432',
            ]
        );

        // 2. Bank Accounts
        $banks = [
            [
                'nama_bank' => 'Bank Syariah Indonesia (BSI)',
                'kode_bank' => 'BSI',
                'nomor_rekening' => '7123456789',
                'atas_nama' => 'Yayasan Al Futuh Peduli',
                'instruksi' => 'Transfer via ATM BSI, BSI Mobile, atau Transfer Antar Bank (Kode Bank 451)',
                'urutan' => 1,
            ],
            [
                'nama_bank' => 'Bank Central Asia (BCA)',
                'kode_bank' => 'BCA',
                'nomor_rekening' => '8720192345',
                'atas_nama' => 'Yayasan Al Futuh',
                'instruksi' => 'Transfer via KlikBCA, BCA Mobile, atau ATM BCA (Kode Bank 014)',
                'urutan' => 2,
            ],
            [
                'nama_bank' => 'Bank Mandiri',
                'kode_bank' => 'MANDIRI',
                'nomor_rekening' => '1370019283741',
                'atas_nama' => 'Yayasan Al Futuh',
                'instruksi' => 'Transfer via Livin by Mandiri atau ATM Mandiri (Kode Bank 008)',
                'urutan' => 3,
            ],
            [
                'nama_bank' => 'QRIS Al Futuh (Semua Pembayaran)',
                'kode_bank' => 'QRIS',
                'nomor_rekening' => 'NMID: ID1020304050607',
                'atas_nama' => 'Yayasan Al Futuh Peduli',
                'instruksi' => 'Scan QRIS menggunakan BCA, Mandiri, BRI, BSI, GoPay, OVO, Dana, LinkAja, atau ShopeePay.',
                'urutan' => 4,
            ],
        ];

        foreach ($banks as $bank) {
            BankAccount::updateOrCreate(
                ['nama_bank' => $bank['nama_bank']],
                $bank
            );
        }

        // 3. Program Donasi Awal (6 Kegiatan Pokok Al Futuh)
        $programs = [
            [
                'nama' => 'Donasi Operasional Umum',
                'slug' => 'donasi-operasional-umum',
                'kategori' => 'Operasional',
                'icon' => '🏛️',
                'ringkasan' => 'Dukungan operasional harian, dakwah, kebersihan, dan pemeliharaan fasilitas Yayasan Al Futuh.',
                'deskripsi' => 'Program Donasi Operasional Umum diperuntukkan untuk membiayai kelancaran aktivitas dakwah, administrasi, kebersihan, dan pemeliharaan fasilitas di lingkungan Yayasan Al Futuh. Setiap rupiah sedekah Anda menjadi pondasi kokoh bagi keberlangsungan dakwah dan pelayanan umat yang amanah.',
                'target_dana' => 50000000,
                'dana_terkumpul' => 18450000,
                'banner' => null,
                'tipe_target' => 'berkelanjutan',
                'is_featured' => true,
                'is_active' => true,
                'urutan' => 1,
            ],
            [
                'nama' => 'Qurban Berkah Al Futuh',
                'slug' => 'qurban-berkah-al-futuh',
                'kategori' => 'Qurban',
                'icon' => '🐄',
                'ringkasan' => 'Tebar hewan qurban untuk kaum dhuafa, santri penghafal Al-Qur\'an, dan pelosok desa.',
                'deskripsi' => 'Sambut hari raya Idul Adha dengan berqurban bersama Al Futuh. Hewan qurban dirawat secara syar\'i, sehat, dan disalurkan tepat sasaran kepada masyarakat yang jarang menikmati daging qurban, santri yatim, dan dhuafa di wilayah binaan.',
                'target_dana' => 75000000,
                'dana_terkumpul' => 32500000,
                'banner' => null,
                'tipe_target' => 'terbatas',
                'tenggat_waktu' => now()->addDays(60)->toDateString(),
                'is_featured' => true,
                'is_active' => true,
                'urutan' => 2,
            ],
            [
                'nama' => 'Santunan Anak Yatim',
                'slug' => 'santunan-anak-yatim',
                'kategori' => 'Anak Yatim',
                'icon' => '🤲',
                'ringkasan' => 'Santunan rutin bulanan, paket nutrisi, dan perlengkapan sekolah untuk anak yatim binaan.',
                'deskripsi' => 'Rasulullah SAW bersabda: "Aku dan orang yang menanggung anak yatim seperti ini di surga" seraya merapatkan jari telunjuk dan tengah. Mari bahagiakan mereka melalui santunan kebutuhan pokok, biaya hidup layak, dan kehangatan kasih sayang bersama Yayasan Al Futuh.',
                'target_dana' => 60000000,
                'dana_terkumpul' => 28900000,
                'banner' => null,
                'tipe_target' => 'berkelanjutan',
                'is_featured' => true,
                'is_active' => true,
                'urutan' => 3,
            ],
            [
                'nama' => 'Zakat Maal & Fitrah',
                'slug' => 'zakat-maal-fitrah',
                'kategori' => 'Zakat',
                'icon' => '🌾',
                'ringkasan' => 'Tunaikan kewajiban zakat maal dan fitrah untuk disalurkan ke 8 asnaf yang berhak.',
                'deskripsi' => 'Bersihkan harta dan jiwa dengan menunaikan zakat melalui Lembaga Amil Zakat Al Futuh. Dikelola secara profesional, transparan, dan disalurkan sesuai tuntunan syariat Islam kepada para mustahik di sekitar kita.',
                'target_dana' => 100000000,
                'dana_terkumpul' => 45600000,
                'banner' => null,
                'tipe_target' => 'berkelanjutan',
                'is_featured' => false,
                'is_active' => true,
                'urutan' => 4,
            ],
            [
                'nama' => 'Beasiswa Anak Asuh Santri',
                'slug' => 'beasiswa-anak-asuh-santri',
                'kategori' => 'Anak Asuh',
                'icon' => '🎓',
                'ringkasan' => 'Program orang tua asuh untuk santri yatim dhuafa penghafal Al-Qur\'an.',
                'deskripsi' => 'Bantu santri berprestasi dari keluarga prasejahtera mewujudkan impian menjadi hafidz Al-Qur\'an dan ulama yang berakhlak mulia. Donasi Anda mencakup kitab kajian, biaya makan harian, perlengkapan belajar, dan pembinaan intensif.',
                'target_dana' => 40000000,
                'dana_terkumpul' => 15200000,
                'banner' => null,
                'tipe_target' => 'berkelanjutan',
                'is_featured' => false,
                'is_active' => true,
                'urutan' => 5,
            ],
            [
                'nama' => 'Sedekah Listrik Masjid',
                'slug' => 'sedekah-listrik-masjid',
                'kategori' => 'Listrik Masjid',
                'icon' => '⚡',
                'ringkasan' => 'Sedekah jariyah penerangan, AC, dan sound system Masjid Al Futuh agar ibadah nyaman.',
                'deskripsi' => 'Setiap huruf Al-Qur\'an yang dibaca dalam terangnya lampu masjid, serta setiap sholat yang ditegakkan dalam sejuknya ruangan masjid, pahalanya mengalir tiada henti untuk para muhsinin yang patungan membiayai token dan listrik Masjid Al Futuh.',
                'target_dana' => 15000000,
                'dana_terkumpul' => 9850000,
                'banner' => null,
                'tipe_target' => 'berkelanjutan',
                'is_featured' => true,
                'is_active' => true,
                'urutan' => 6,
            ],
        ];

        foreach ($programs as $item) {
            $program = Program::updateOrCreate(
                ['slug' => $item['slug']],
                $item
            );

            // Buat kategori keuangan sinkron
            KategoriKeuangan::firstOrCreate(['nama_kategori' => $item['nama']]);
        }

        // Kategori Penyaluran / Pengeluaran
        KategoriKeuangan::firstOrCreate(['nama_kategori' => 'Penyaluran Donasi']);
        KategoriKeuangan::firstOrCreate(['nama_kategori' => 'Operasional Kantor']);

        // 4. Kabar Terbaru / Cerita Aktivitas Awal
        $operasional = Program::where('slug', 'donasi-operasional-umum')->first();
        $yatim = Program::where('slug', 'santunan-anak-yatim')->first();
        $listrik = Program::where('slug', 'sedekah-listrik-masjid')->first();

        $kabars = [
            [
                'program_id' => $listrik ? $listrik->id : null,
                'judul' => 'Alhamdulillah, Pembayaran Token & Listrik Masjid Al Futuh Berjalan Lancar',
                'slug' => 'pembayaran-listrik-masjid-al-futuh-lancar',
                'ringkasan' => 'Terima kasih kepada seluruh donatur yang telah menyisihkan rezeki untuk sedekah listrik masjid.',
                'konten' => "Assalamu'alaikum Warahmatullahi Wabarakatuh.\n\nAlhamdulillah puji syukur kepada Allah SWT, donasi sedekah listrik yang terkumpul telah kami bayarkan untuk operasional kelistrikan Masjid Al Futuh bulan ini. Jamaah sholat fardhu, pengajian anak-anak Gebraq (Berantas Buta Huruf Al-Qur'an), dan tadarus malam dapat beribadah dengan tenang dan nyaman.\n\nSemoga setiap kilowatt energi yang menerangi rumah Allah ini menjadi amal jariyah yang berlipat ganda untuk Bapak/Ibu donatur sekalian. Aamiin ya Rabbal 'Alamin.",
                'tanggal' => now()->subDays(2)->toDateString(),
                'penulis' => 'Pengurus Masjid Al Futuh',
            ],
            [
                'program_id' => $yatim ? $yatim->id : null,
                'judul' => 'Penyaluran Paket Nutrisi & Santunan Rutin untuk 45 Anak Yatim',
                'slug' => 'penyaluran-paket-nutrisi-santunan-45-anak-yatim',
                'ringkasan' => 'Senyum bahagia terukir di wajah adik-adik yatim saat menerima santunan dan bingkisan makanan bergizi.',
                'konten' => "Assalamu'alaikum Sahabat Kebaikan Al Futuh.\n\nAlhamdulillahil ladzii bi ni'matihii tatimmush shoolihaat. Tim Al Futuh Peduli telah menyalurkan santunan tunai beserta paket nutrisi berupa susu, madu, dan perlengkapan sekolah kepada 45 anak yatim dhuafa di wilayah binaan.\n\nTitipan doa dari adik-adik untuk para donatur: semoga dipanjangkan umur dalam ketaatan, dimudahkan urusan, dilapangkan rezeki yang berkah, dan diampuni segala dosa. Jazakumullah khairan katsiran.",
                'tanggal' => now()->subDays(5)->toDateString(),
                'penulis' => 'Tim Al Futuh Peduli',
            ],
            [
                'program_id' => $operasional ? $operasional->id : null,
                'judul' => 'Laporan Pengadaan Sarana Belajar Qur\'an Santri Al Futuh',
                'slug' => 'laporan-pengadaan-sarana-belajar-santri-al-futuh',
                'ringkasan' => 'Dukungan operasional telah digunakan untuk memperbarui meja lipat dan Al-Qur\'an mushaf baru.',
                'konten' => "Penyelenggaraan kelas belajar membaca Al-Qur'an kini semakin kondusif dengan adanya meja lipat dan mushaf standar tajwid yang baru. Fasilitas ini diperuntukkan bagi anak-anak dan lansia yang mengikuti program pemberantasan buta aksara Qur'an.\n\nSeluruh sarana ini terwujud berkat sedekah operasional umum dari para sahabat Al Futuh. Terima kasih atas kepercayaan yang diberikan.",
                'tanggal' => now()->subDays(9)->toDateString(),
                'penulis' => 'Admin Al Futuh',
            ],
        ];

        foreach ($kabars as $kabar) {
            Kabar::updateOrCreate(
                ['slug' => $kabar['slug']],
                $kabar
            );
        }

        // 5. Penyaluran Donasi Transparan Awal
        if ($yatim) {
            Penyaluran::firstOrCreate(
                ['judul' => 'Penyaluran Santunan Tunai 45 Anak Yatim Tahap November'],
                [
                    'program_id' => $yatim->id,
                    'nominal' => 9000000,
                    'tanggal' => now()->subDays(5)->toDateString(),
                    'penerima' => '45 Anak Yatim Dhuafa Binaan Al Futuh',
                    'keterangan' => 'Santunan tunai @ Rp 200.000 per anak untuk kebutuhan biaya hidup dan sekolah.',
                    'foto' => null,
                ]
            );
        }

        if ($listrik) {
            Penyaluran::firstOrCreate(
                ['judul' => 'Pembayaran Tagihan Listrik & Token Masjid Al Futuh'],
                [
                    'program_id' => $listrik->id,
                    'nominal' => 1850000,
                    'tanggal' => now()->subDays(2)->toDateString(),
                    'penerima' => 'PLN - Idpel Masjid Al Futuh',
                    'keterangan' => 'Pembayaran tagihan listrik dan pembelian token cadangan operasional penerangan dan AC masjid.',
                    'foto' => null,
                ]
            );
        }
    }
}
