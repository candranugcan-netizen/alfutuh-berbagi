<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_donasi',
        'program_id',
        'user_id',
        'nama_donatur',
        'is_anonim',
        'no_hp',
        'email',
        'nominal',
        'kode_unik',
        'total_pembayaran',
        'bank_tujuan',
        'bukti_transfer',
        'status',
        'doa',
        'is_manual',
        'metode_pembayaran',
        'catatan_admin',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'is_manual' => 'boolean',
        'nominal' => 'integer',
        'kode_unik' => 'integer',
        'total_pembayaran' => 'integer',
        'verified_at' => 'datetime',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Helper Display Nama Donatur
    public function getDisplayNameAttribute(): string
    {
        return $this->is_anonim ? 'Hamba Allah' : ($this->nama_donatur ?: 'Hamba Allah');
    }

    // Badge Status HTML / Warna
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending_payment' => 'Menunggu Pembayaran',
            'pending_verification' => 'Menunggu Verifikasi',
            'verified' => 'Berhasil (Terverifikasi)',
            'rejected' => 'Dibatalkan / Ditolak',
            default => $this->status,
        };
    }
}
