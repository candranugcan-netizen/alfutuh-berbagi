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

    // Total Donatur Terverifikasi
    public function getTotalDonaturAttribute(): int
    {
        return $this->verifiedDonations()->count();
    }
}
