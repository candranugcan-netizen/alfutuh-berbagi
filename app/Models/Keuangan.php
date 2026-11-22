<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keuangan extends Model
{
    protected $fillable = [
        'kategori_id',
        'tipe',
        'nominal',
        'is_internal',
        'keterangan',
        'penanggung_jawab',
        'tanggal',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
        'nominal' => 'integer',
        'tanggal' => 'date',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriKeuangan::class, 'kategori_id');
    }
}
