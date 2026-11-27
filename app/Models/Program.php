<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'slug',
        'kategori',
        'icon',
        'ringkasan',
        'deskripsi',
        'target_dana',
        'dana_terkumpul',
        'banner',
        'tipe_target',
        'tenggat_waktu',
        'is_featured',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'target_dana' => 'integer',
        'dana_terkumpul' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'tenggat_waktu' => 'date',
    ];

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function verifiedDonations()
    {
        return $this->hasMany(Donation::class)->where('status', 'verified');
    }

    public function penyalurans()
    {
        return $this->hasMany(Penyaluran::class);
    }

    public function kabars()
    {
        return $this->hasMany(Kabar::class);
    }

    // Persentase Terkumpul
    public function getPersentaseAttribute(): int
    {
        if ($this->target_dana <= 0) {
            return 100;
        }
        $pct = ($this->dana_terkumpul / $this->target_dana) * 100;
        return (int) min(100, round($pct));
    }

    // Sisa Hari
    public function getSisaHariAttribute(): ?int
    {
        if (!$this->tenggat_waktu) {
            return null;
        }
        $diff = now()->diffInDays($this->tenggat_waktu, false);
        return max(0, (int) $diff);
    }

    // Total Penyaluran Dana
    public function getTotalPenyaluranAttribute(): int
    {
        // Jika relasi sudah di-eager load withSum('penyalurans', 'nominal')
        if (isset($this->attributes['penyalurans_sum_nominal'])) {
            return (int) $this->attributes['penyalurans_sum_nominal'];
        }
        return (int) $this->penyalurans()->sum('nominal');
    }

    // Sisa Dana Donasi Saat Ini (Total Dana Terkumpul - Total Penyaluran)
    public function getSisaDonasiAttribute(): int
    {
        return max(0, (int) $this->dana_terkumpul - $this->total_penyaluran);
    }

    // Persentase Sisa Donasi Terhadap Total Terkumpul (Berapa persen sisa dana yang belum disalurkan)
    public function getPersentaseSisaAttribute(): int
    {
        if ($this->dana_terkumpul <= 0) {
            return 0;
        }
        $pct = ($this->sisa_donasi / $this->dana_terkumpul) * 100;
        return (int) max(0, min(100, round($pct)));
    }

    // Status / Tingkat Kritis Sisa Donasi (danger, warning, safe)
    public function getStatusSisaAttribute(): string
    {
        // Jika sisa donasi 0 atau dana terkumpul 0
        if ($this->dana_terkumpul <= 0 || $this->sisa_donasi <= 0) {
            return 'empty'; // Habis / Belum Ada
        }

        $pct = $this->persentase_sisa;
        if ($pct <= 15) {
            return 'critical'; // < 15% Sisa sangat tipis (Merah)
        } elseif ($pct <= 35) {
            return 'warning'; // 15% - 35% Sisa menipis (Amber/Kuning)
        } else {
            return 'safe'; // > 35% Masih aman (Hijau/Emerald)
        }
    }

    // Cek apakah program ini adalah Donasi Operasional Umum Yayasan
    public function getIsOperasionalAttribute(): bool
    {
        return $this->slug === 'sedekah-operasional-dakwah-yayasan'
            || str_contains(strtolower($this->nama), 'operasional')
            || str_contains(strtolower($this->kategori), 'operasional');
    }

    // Total Donatur Terverifikasi
    public function getTotalDonaturAttribute(): int
    {
        return $this->verifiedDonations()->count();
    }
}
