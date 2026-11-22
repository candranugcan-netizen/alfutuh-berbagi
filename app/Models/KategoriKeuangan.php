<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriKeuangan extends Model
{
    protected $fillable = [
        'nama_kategori',
        'is_internal',
    ];

    protected $casts = [
        'is_internal' => 'boolean',
    ];

    public function keuangan()
    {
        return $this->hasMany(Keuangan::class, 'kategori_id');
    }
}
