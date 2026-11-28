<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HadithController extends Controller
{
    /**
     * Daftar Kitab Kutubus Sittah & Musnad Imam Ahmad
     */
    private function getBooks(): array
    {
        return [
            'bukhari' => [
                'slug' => 'bukhari',
                'cdn_slug' => 'bukhari',
                'nama' => 'Shahih Bukhari',
                'arab' => 'صحيح البخاري',
                'imam' => 'Imam Muhammad bin Ismail al-Bukhari',
                'kategori' => 'Kutubus Sittah',
                'total_default' => 7563,
                'deskripsi' => 'Kitab hadits paling shahih yang disusun oleh Imam Al-Bukhari.',
            ],
            'muslim' => [
                'slug' => 'muslim',
                'cdn_slug' => 'muslim',
                'nama' => 'Shahih Muslim',
                'arab' => 'صحيح مسلم',
                'imam' => 'Imam Muslim bin al-Hajjaj',
                'kategori' => 'Kutubus Sittah',
                'total_default' => 3033,
                'deskripsi' => 'Kumpulan hadits shahih pilihan karya Imam Muslim.',
            ],
            'abu-daud' => [
                'slug' => 'abu-daud',
                'cdn_slug' => 'abudawud',
                'nama' => 'Sunan Abu Dawud',
                'arab' => 'سنن أبي داود',
                'imam' => 'Imam Abu Dawud as-Sijistani',
                'kategori' => 'Kutubus Sittah',
                'total_default' => 5274,
                'deskripsi' => 'Kitab sunan yang banyak memuat hadits hukum dan fiqih.',
            ],
            'tirmidzi' => [
                'slug' => 'tirmidzi',
                'cdn_slug' => 'tirmidhi',
                'nama' => 'Sunan Tirmidzi',
                'arab' => 'سنن الترمذي',
                'imam' => 'Imam Abu Isa at-Tirmidzi',
                'kategori' => 'Kutubus Sittah',
                'total_default' => 3956,
                'deskripsi' => 'Al-Jami\' as-Shahih karya Imam Tirmidzi beserta keterangan derajat hadits.',
            ],
            'nasai' => [
                'slug' => 'nasai',
                'cdn_slug' => 'nasai',
                'nama' => 'Sunan An-Nasa\'i',
                'arab' => 'سنن النسائي',
                'imam' => 'Imam Ahmad bin Syu\'aib an-Nasa\'i',
                'kategori' => 'Kutubus Sittah',
                'total_default' => 5758,
                'deskripsi' => 'As-Sunan as-Sughra (Al-Mujtaba) karya Imam An-Nasa\'i.',
            ],
            'ibnu-majah' => [
                'slug' => 'ibnu-majah',
                'cdn_slug' => 'ibnmajah',
                'nama' => 'Sunan Ibnu Majah',
                'arab' => 'سنن ابن ماجه',
                'imam' => 'Imam Muhammad bin Yazid Ibnu Majah',
                'kategori' => 'Kutubus Sittah',
                'total_default' => 4341,
                'deskripsi' => 'Kitab pelengkap Kutubus Sittah yang disusun oleh Imam Ibnu Majah.',
            ],
            'ahmad' => [
                'slug' => 'ahmad',
                'cdn_slug' => 'ahmad',
                'nama' => 'Musnad Imam Ahmad',
                'arab' => 'مسند الإمام أحمد',
                'imam' => 'Imam Ahmad bin Hanbal',
                'kategori' => 'Musnad',
                'total_default' => 4305,
                'deskripsi' => 'Ensiklopedia hadits besar yang disusun berdasarkan nama sahabat perawi.',
            ],
        ];
    }

    /**
     * Halaman Daftar Kitab Hadits (Kutubus Sittah + Musnad Imam Ahmad)
     */
    public function index()
    {
        $books = array_values($this->getBooks());
        return view('islami.hadits.index', compact('books'));
    }

    /**
     * Halaman Baca Hadits per Kitab (Arab & Terjemah Indonesia)
     */
    public function show(string $book)
    {
        $books = $this->getBooks();
        if (!isset($books[$book])) {
            abort(404);
        }

        $bookInfo = $books[$book];
        return view('islami.hadits.show', compact('bookInfo'));
    }
}
