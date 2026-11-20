<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kabar extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'judul',
        'slug',
        'ringkasan',
        'konten',
        'foto',
        'penulis',
        'tanggal',
        'is_published',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'is_published' => 'boolean',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}
