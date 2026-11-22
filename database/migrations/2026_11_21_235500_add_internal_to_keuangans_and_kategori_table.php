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
        if (Schema::hasTable('kategori_keuangans') && !Schema::hasColumn('kategori_keuangans', 'is_internal')) {
            Schema::table('kategori_keuangans', function (Blueprint $table) {
                $table->boolean('is_internal')->default(false)->after('nama_kategori');
            });
        }

        if (Schema::hasTable('keuangans')) {
            Schema::table('keuangans', function (Blueprint $table) {
                if (!Schema::hasColumn('keuangans', 'is_internal')) {
                    $table->boolean('is_internal')->default(false)->after('nominal');
                }
                if (!Schema::hasColumn('keuangans', 'penanggung_jawab')) {
                    $table->string('penanggung_jawab')->nullable()->after('keterangan');
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('kategori_keuangans') && Schema::hasColumn('kategori_keuangans', 'is_internal')) {
            Schema::table('kategori_keuangans', function (Blueprint $table) {
                $table->dropColumn('is_internal');
            });
        }

        if (Schema::hasTable('keuangans')) {
            Schema::table('keuangans', function (Blueprint $table) {
                if (Schema::hasColumn('keuangans', 'is_internal')) {
                    $table->dropColumn('is_internal');
                }
                if (Schema::hasColumn('keuangans', 'penanggung_jawab')) {
                    $table->dropColumn('penanggung_jawab');
                }
            });
        }
    }
};
