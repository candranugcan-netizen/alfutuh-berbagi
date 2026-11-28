<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QuranController extends Controller
{
    /**
     * Halaman Daftar 114 Surat Al-Qur'an
     */
    public function index()
    {
        return view('islami.quran.index');
    }

    /**
     * Halaman Detail Surat, Ayat, Terjemah, Audio & Tafsir
     */
    public function show(int $nomor)
    {
        if ($nomor < 1 || $nomor > 114) {
            abort(404);
        }

        return view('islami.quran.show', compact('nomor'));
    }
}
