<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyaluran extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'judul',
        'nominal',
        'tanggal',
        'penerima',
        'keterangan',
        'foto',
        'user_id',
    ];

    protected $casts = [
        'nominal' => 'integer',
        'tanggal' => 'date',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
