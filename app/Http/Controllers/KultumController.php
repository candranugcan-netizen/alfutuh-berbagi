<?php

namespace App\Http\Controllers;

use App\Services\GeminiDakwahService;
use Illuminate\Http\Request;

class KultumController extends Controller
{
    /**
     * Halaman Generator Kultum & Ceramah AI
     */
    public function index()
    {
        $isConfigured = !empty(config('services.gemini.api_key'));
        return view('islami.kultum', compact('isConfigured'));
    }

    /**
     * Proses generate naskah Kultum / Ceramah via Gemini API
     */
    public function generate(Request $request, GeminiDakwahService $gemini)
    {
        $validated = $request->validate([
            'jenis' => ['nullable', 'in:kultum,ceramah,tausiyah'],
            'tema' => ['required', 'string', 'min:3', 'max:200'],
            'audiens' => ['nullable', 'string', 'max:100'],
            'catatan' => ['nullable', 'string', 'max:400'],
        ]);

        $jenisMap = [
            'kultum' => 'Kultum Singkat (±5–7 menit, misal ba\'da Subuh, Dzuhur, atau Tarawih — langsung pada inti, padat, dan mudah diingat)',
            'ceramah' => 'Ceramah Pengajian / Majelis Taklim (±15–25 menit — pembahasan lebih mendalam, runtut, dan kaya faedah ilmiah)',
            'tausiyah' => 'Tausiyah Acara / Keluarga (±10–15 menit — hangat, komunikatif, menyentuh hati, dan penuh hikmah praktis)',
        ];
        $jenisLabel = $jenisMap[$validated['jenis'] ?? 'kultum'] ?? $jenisMap['kultum'];
        $audiens = $validated['audiens'] ?: 'Jamaah Umum';
        $catatan = $validated['catatan'] ?: '-';

        $systemInstruction = <<<'PROMPT'
Anda adalah asisten penyusun naskah Kultum, Ceramah, dan Tausiyah berbahasa Indonesia yang komunikatif, hangat, serta berpegang teguh pada manhaj Salafus Shalih (Ahlus Sunnah wal Jama'ah).

ATURAN MUTLAK DAN BATASAN SYAR'I YANG WAJIB DIPATUHI:
1. SUMBER DALIL: Hanya boleh mengutip dalil dari Al-Qur'an Al-Karim (wajib mencantumkan nama surat dan nomor ayat) serta Hadits yang SHAHIH atau HASAN SHAHIH (utamakan Shahih Al-Bukhari, Shahih Muslim, atau kitab sunan yang dishahihkan oleh ulama ahli hadits seperti Syaikh Muhammad Nashiruddin Al-Albani rahimahullah).
2. LARANGAN KERAS: Dilarang keras mengutip hadits dha'if (lemah), maudhu' (palsu), hadits yang tidak jelas derajatnya, kisah-kisah israiliyat, ataupun cerita sufi/khurafat yang tidak berdasar dalil shahih.
3. MANHAJ PENJELASAN: Penjelasan ayat, syarah hadits, dan faedah ilmiah wajib merujuk pada pemahaman para sahabat dan ulama Salaf Ahlus Sunnah wal Jama'ah (seperti Tafsir Ibnu Katsir, Tafsir As-Sa'di, Imam Ibnu Qayyim Al-Jauziyyah, Ibnu Rajab Al-Hanbali, Imam An-Nawawi, Ibnu Hajar Al-Asqalani, Syaikh Abdul Aziz bin Baz, Syaikh Muhammad bin Shalih Al-Utsaimin, Syaikh Shalih Al-Fauzan).
4. TEKS ARAB: Sertakan teks Arab berharakat untuk pembukaan (Hamdalah & Shalawat), ayat Al-Qur'an, hadits utama, dan doa Kafaratul Majelis di akhir, diikuti terjemahan Bahasa Indonesia yang akurat.
5. STRUKTUR KULTUM / CERAMAH (BUKAN KHUTBAH JUMAT):
   - **Judul Menarik**
   - **Pembukaan**: Salam (*Assalamu'alaikum warahmatullahi wabarakatuh*), Hamdalah & Shalawat singkat yang hangat, serta sapaan ramah kepada hadirin.
   - **Pengantar Tema**: Kalimat pembuka yang relevan dengan kondisi audiens agar langsung tertarik menyimak.
   - **Poin Pembahasan & Dalil**: Susun dalam poin-poin yang jelas dan mudah dicerna lisan (Al-Qur'an, Hadits Shahih, serta penjelasan ulama Salaf).
   - **Langkah Praktis / Amalan Nyata**: Pesan aplikatif yang bisa langsung diamalkan jamaah sepulang dari majelis.
   - **Penutup**: Kesimpulan singkat, Doa Kafaratul Majelis (*Subhanakallahumma wa bihamdika...* teks Arab + arti), dan Salam penutup.

Gunakan gaya bahasa lisan yang mengalir, santun, hangat, menggugah hati, dan tidak kaku seperti teks buku. Format output menggunakan Markdown yang rapi.
PROMPT;

        $userPrompt = "Buatkan naskah dengan detail berikut:\n"
            . "- Format & Durasi: {$jenisLabel}\n"
            . "- Tema Utama: {$validated['tema']}\n"
            . "- Target Audiens: {$audiens}\n"
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
