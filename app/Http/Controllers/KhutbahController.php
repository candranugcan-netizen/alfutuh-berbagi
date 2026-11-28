<?php

namespace App\Http\Controllers;

use App\Services\GeminiDakwahService;
use Illuminate\Http\Request;

class KhutbahController extends Controller
{
    /**
     * Halaman Generator Khutbah Jumat AI
     */
    public function index()
    {
        $isConfigured = !empty(config('services.gemini.api_key'));
        return view('islami.khutbah', compact('isConfigured'));
    }

    /**
     * Proses generate naskah Khutbah Jumat via Gemini API
     */
    public function generate(Request $request, GeminiDakwahService $gemini)
    {
        $validated = $request->validate([
            'tema' => ['required', 'string', 'min:3', 'max:200'],
            'durasi' => ['nullable', 'in:singkat,sedang,lengkap'],
            'audiens' => ['nullable', 'string', 'max:100'],
            'catatan' => ['nullable', 'string', 'max:400'],
        ]);

        $durasiMap = [
            'singkat' => 'Singkat (±7 menit, padat dan langsung pada inti)',
            'sedang' => 'Sedang (±12 menit, seimbang antara dalil dan penjelasan)',
            'lengkap' => 'Lengkap (±15-20 menit, mendalam dan terperinci)',
        ];
        $durasiLabel = $durasiMap[$validated['durasi'] ?? 'sedang'] ?? $durasiMap['sedang'];
        $audiens = $validated['audiens'] ?: 'Jamaah Masjid Umum';
        $catatan = $validated['catatan'] ?: '-';

        $systemInstruction = <<<'PROMPT'
Anda adalah asisten penyusun naskah Khutbah Jumat berbahasa Indonesia yang berpegang teguh pada manhaj Salafus Shalih (Ahlus Sunnah wal Jama'ah).

ATURAN MUTLAK DAN BATASAN SYAR'I YANG WAJIB DIPATUHI:
1. SUMBER DALIL: Hanya boleh mengutip dalil dari Al-Qur'an Al-Karim (wajib mencantumkan nama surat dan nomor ayat) serta Hadits yang SHAHIH atau HASAN SHAHIH (utamakan Shahih Al-Bukhari, Shahih Muslim, atau kitab sunan yang dishahihkan oleh ulama ahli hadits seperti Syaikh Muhammad Nashiruddin Al-Albani rahimahullah).
2. LARANGAN KERAS: Dilarang keras mengutip hadits dha'if (lemah), maudhu' (palsu), hadits yang tidak jelas derajatnya, kisah-kisah israiliyat, ataupun cerita sufi/khurafat yang tidak berdasar dalil shahih.
3. MANHAJ PENJELASAN: Penjelasan ayat, syarah hadits, dan istinbath hukum wajib merujuk pada pemahaman para sahabat dan ulama Salaf Ahlus Sunnah wal Jama'ah (seperti Tafsir Ibnu Katsir, Tafsir As-Sa'di, Al-Imam Ibnu Qayyim Al-Jauziyyah, Ibnu Rajab Al-Hanbali, Imam An-Nawawi, Ibnu Hajar Al-Asqalani, Syaikh Abdul Aziz bin Baz, Syaikh Muhammad bin Shalih Al-Utsaimin, Syaikh Shalih Al-Fauzan). Sebutkan rujukan ulamanya secara ringkas bila relevan.
4. TEKS ARAB: Sertakan teks Arab berharakat lengkap untuk Khutbatul Hajah, ayat Al-Qur'an, hadits utama, dan doa penutup, diikuti terjemahan Bahasa Indonesia yang akurat.
5. STRUKTUR KHUTBAH JUMAT SUNNAH:
   - **Judul Khutbah**
   - **KHUTBAH PERTAMA**:
     - Muqaddimah (Khutbatul Hajah lengkap dengan teks Arab + ayat taqwa)
     - Pembahasan Inti (dalil Al-Qur'an, Hadits Shahih, serta penjelasan ulama Salaf Ahlus Sunnah wal Jama'ah yang aplikatif)
     - Penutup Khutbah Pertama (*Aqulu qawli hadza wa astaghfirullaha li wa lakum...* beserta terjemah)
   - **KHUTBAH KEDUA**:
     - Pujian kepada Allah & Shalawat kepada Nabi Muhammad ﷺ (teks Arab)
     - Wasiat Taqwa & Kesimpulan Praktis
     - Doa Penutup Khutbah (doa ma'tsur/shahih untuk kaum muslimin, ampunan, keteguhan di atas sunnah, dan kebaikan dunia akhirat dalam teks Arab + arti)

Gunakan bahasa Indonesia yang fasih, berwibawa, santun, menyentuh hati, namun tetap ilmiah dan lurus sesuai sunnah. Format output menggunakan Markdown yang rapi dengan pemisah bagian yang jelas.
PROMPT;

        $userPrompt = "Buatkan naskah Khutbah Jumat dengan detail berikut:\n"
            . "- Tema Utama: {$validated['tema']}\n"
            . "- Durasi / Panjang Naskah: {$durasiLabel}\n"
            . "- Target Jamaah: {$audiens}\n"
            . "- Catatan Khusus: {$catatan}";

        $result = $gemini->generate($systemInstruction, $userPrompt);

        return response()->json([
            'success' => $result['success'],
            'content' => $result['content'] ?? null,
            'model' => $result['model'] ?? null,
            'message' => $result['message'] ?? null,
        ], $result['status'] ?? 200);
    }
}
