<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class ZakatController extends Controller
{
    /**
     * Halaman Kalkulator Zakat Al Futuh
     */
    public function index()
    {
        $zakatProgram = Program::where('is_active', true)
            ->where(function ($q) {
                $q->where('slug', 'like', '%zakat%')
                  ->orWhere('nama', 'like', '%zakat%');
            })
            ->first() ?? Program::where('is_active', true)->first();

        $donateUrl = $zakatProgram
            ? route('programs.show', $zakatProgram->slug)
            : route('programs.index');

        return view('islami.zakat', compact('donateUrl'));
    }
}
