<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah kolom role & phone ke users jika belum ada
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('donatur')->after('email');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('role');
            }
            if (!Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('phone');
            }
        });

        // 2. Tabel Program Donasi (Operasional Umum, Qurban, Anak Yatim, Zakat, Anak Asuh, Listrik Masjid, dll)
        if (!Schema::hasTable('programs')) {
            Schema::create('programs', function (Blueprint $table) {
                $table->id();
                $table->string('nama');
                $table->string('slug')->unique();
                $table->string('kategori'); // Operasional, Qurban, Yatim, Zakat, Pendidikan, Sarana
                $table->string('icon')->nullable(); // emoji atau icon key
                $table->text('ringkasan')->nullable();
                $table->longText('deskripsi');
                $table->unsignedBigInteger('target_dana')->default(0);
                $table->unsignedBigInteger('dana_terkumpul')->default(0);
                $table->string('banner')->nullable();
                $table->string('tipe_target')->default('berkelanjutan'); // terbatas, berkelanjutan
                $table->date('tenggat_waktu')->nullable();
                $table->boolean('is_featured')->default(false);
                $table->boolean('is_active')->default(true);
                $table->integer('urutan')->default(0);
                $table->timestamps();
            });
        }

        // 3. Tabel Rekening Bank Tujuan Transfer
        if (!Schema::hasTable('bank_accounts')) {
            Schema::create('bank_accounts', function (Blueprint $table) {
                $table->id();
                $table->string('nama_bank');
                $table->string('kode_bank')->nullable();
                $table->string('nomor_rekening');
                $table->string('atas_nama');
                $table->string('logo')->nullable();
                $table->text('instruksi')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('urutan')->default(0);
                $table->timestamps();
            });
        }

        // 4. Tabel Transaksi Donasi
        if (!Schema::hasTable('donations')) {
            Schema::create('donations', function (Blueprint $table) {
                $table->id();
                $table->string('kode_donasi')->unique();
                $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                $table->string('nama_donatur');
                $table->boolean('is_anonim')->default(false);
                $table->string('no_hp');
                $table->string('email')->nullable();
                $table->unsignedBigInteger('nominal');
                $table->integer('kode_unik')->default(0);
                $table->unsignedBigInteger('total_pembayaran');
                $table->string('bank_tujuan');
                $table->string('bukti_transfer')->nullable();
                $table->enum('status', ['pending_payment', 'pending_verification', 'verified', 'rejected'])->default('pending_payment');
                $table->text('doa')->nullable();
                $table->boolean('is_manual')->default(false);
                $table->string('metode_pembayaran')->default('transfer_bank');
                $table->text('catatan_admin')->nullable();
                $table->timestamp('verified_at')->nullable();
                $table->foreignId('verified_by')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }

        // 5. Tabel Penyaluran / Ambil Donasi (Laporan Transparan)
        if (!Schema::hasTable('penyalurans')) {
            Schema::create('penyalurans', function (Blueprint $table) {
                $table->id();
                $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
                $table->string('judul');
                $table->unsignedBigInteger('nominal');
                $table->date('tanggal');
                $table->string('penerima');
                $table->text('keterangan');
                $table->string('foto')->nullable();
                $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
                $table->timestamps();
            });
        }

        // 6. Tabel Kabar Terbaru / Cerita Aktivitas
        if (!Schema::hasTable('kabars')) {
            Schema::create('kabars', function (Blueprint $table) {
                $table->id();
                $table->foreignId('program_id')->nullable()->constrained('programs')->onDelete('set null');
                $table->string('judul');
                $table->string('slug')->unique();
                $table->text('ringkasan')->nullable();
                $table->longText('konten');
                $table->string('foto')->nullable();
                $table->string('penulis')->default('Admin Al Futuh');
                $table->date('tanggal');
                $table->boolean('is_published')->default(true);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kabars');
        Schema::dropIfExists('penyalurans');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('bank_accounts');
        Schema::dropIfExists('programs');

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn('phone');
            }
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
    }
};
