<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IslamicFeatureController extends Controller
{
    /**
     * Halaman Utama Fitur-Fitur Islami Al Futuh
     */
    public function index()
    {
        // Kumpulan Ayat Al-Qur'an & Hadits Shahih Harian (Acak)
        $dailyQuotes = [
            [
                'type' => 'Ayat Al-Qur\'an',
                'arab' => 'مَثَلُ الَّذِينَ يُنْفِقُونَ أَمْوَالَهُمْ فِي سَبِيلِ اللَّهِ كَمَثَلِ حَبَّةٍ أَنْبَتَتْ سَبْعَ سَنَابِلَ فِي كُلِّ سُنْبُلَةٍ مِائَةُ حَبَّةٍ',
                'terjemah' => 'Perumpamaan orang yang menginfakkan hartanya di jalan Allah seperti sebutir biji yang menumbuhkan tujuh tangkai, pada setiap tangkai ada seratus biji.',
                'sumber' => 'QS. Al-Baqarah: 261',
            ],
            [
                'type' => 'Hadits Shahih',
                'arab' => 'مَا نَقَصَتْ صَدَقَةٌ مِنْ مَالٍ، وَمَا زَادَ اللَّهُ عَبْدًا بِعَفْوٍ إِلَّا عِزًّا',
                'terjemah' => 'Sedekah itu tidak akan mengurangi harta. Tidaklah Allah menambah kepada seorang hamba dengan sifat pemaafnya kecuali kemuliaan.',
                'sumber' => 'HR. Muslim no. 2588',
            ],
            [
                'type' => 'Ayat Al-Qur\'an',
                'arab' => 'فَإِنَّ مَعَ الْعُسْرِ يُسْرًا ۝ إِنَّ مَعَ الْعُسْرِ يُسْرًا',
                'terjemah' => 'Maka sesungguhnya bersama kesulitan ada kemudahan. Sesungguhnya bersama kesulitan itu ada kemudahan.',
                'sumber' => 'QS. Al-Insyirah: 5-6',
            ],
            [
                'type' => 'Hadits Shahih',
                'arab' => 'خَيْرُ النَّاسِ أَنْفَعُهُمْ لِلنَّاسِ',
                'terjemah' => 'Sebaik-baik manusia adalah yang paling bermanfaat bagi manusia lainnya.',
                'sumber' => 'HR. Ahmad, Ath-Thabrani (Shahih)',
            ],
            [
                'type' => 'Ayat Al-Qur\'an',
                'arab' => 'وَمَا تُقَدِّمُوا لِأَنْفُسِكُمْ مِنْ خَيْرٍ تَجِدُوهُ عِنْدَ اللَّهِ هُوَ خَيْرًا وَأَعْظَمَ أَجْرًا',
                'terjemah' => 'Dan kebaikan apa saja yang kamu perbuat untuk dirimu niscaya kamu memperoleh balasannya di sisi Allah sebagai balasan yang paling baik dan paling besar pahalanya.',
                'sumber' => 'QS. Al-Muzzammil: 20',
            ],
            [
                'type' => 'Hadits Shahih',
                'arab' => 'أَحَبُّ الْأَعْمَالِ إِلَى اللَّهِ تَعَالَى أَدْوَمُهَا وَإِنْ قَلَّ',
                'terjemah' => 'Amalan yang paling dicintai oleh Allah Ta\'ala adalah amalan yang konsisten (kontinu) walaupun sedikit.',
                'sumber' => 'HR. Bukhari no. 6464 & Muslim no. 783',
            ],
            [
                'type' => 'Ayat Al-Qur\'an',
                'arab' => 'أَلَا بِذِكْرِ اللَّهِ تَطْمَئِنُّ الْقُلُوبُ',
                'terjemah' => 'Ingatlah, hanya dengan mengingat Allah hati menjadi tenteram.',
                'sumber' => 'QS. Ar-Ra\'d: 28',
            ],
            [
                'type' => 'Hadits Shahih',
                'arab' => 'اتَّقِ اللَّهَ حَيْثُمَا كُنْتَ، وَأَتْبِعِ السَّيِّئَةَ الْحَسَنَةَ تَمْحُهَا، وَخَالِقِ النَّاسَ بِخُلُقٍ حَسَنٍ',
                'terjemah' => 'Bertakwalah kepada Allah di mana pun engkau berada, iringilah keburukan dengan kebaikan niscaya kebaikan itu akan menghapusnya, dan pergaulilah manusia dengan akhlak yang baik.',
                'sumber' => 'HR. Tirmidzi no. 1987 (Hasan Shahih)',
            ],
        ];

        // Otomatis acak berganti setiap hari (konsisten sepanjang hari yang sama)
        $daySeed = abs(crc32(date('Y-m-d')));
        $dailyQuote = $dailyQuotes[$daySeed % count($dailyQuotes)];

        // Daftar Amalan Sunnah Harian
        $amalanSunnah = [
            [
                'id' => 'sholat_subuh',
                'judul' => 'Sholat Subuh Berjamaah / Tepat Waktu',
                'keterangan' => 'Dua rakaat fajar lebih baik daripada dunia dan seisinya',
                'waktu' => 'Subuh',
            ],
            [
                'id' => 'dzikir_pagi',
                'judul' => 'Dzikir Pagi & Petang',
                'keterangan' => 'Penjagaan diri dan ketenangan hati sepanjang hari',
                'waktu' => 'Pagi / Sore',
            ],
            [
                'id' => 'sholat_dhuha',
                'judul' => 'Sholat Sunnah Dhuha',
                'keterangan' => 'Minimal 2 rakaat sebagai sedekah seluruh persendian tubuh',
                'waktu' => 'Pagi',
            ],
            [
                'id' => 'tilawah_quran',
                'judul' => 'Tilawah Al-Qur\'an Harian',
                'keterangan' => 'Membaca walau 1 halaman dengan tadabbur maknanya',
                'waktu' => 'Fleksibel',
            ],
            [
                'id' => 'sedekah_harian',
                'judul' => 'Sedekah Subuh / Harian',
                'keterangan' => 'Didoakan malaikat setiap pagi bagi yang gemar berinfak',
                'waktu' => 'Harian',
            ],
            [
                'id' => 'istighfar_100',
                'judul' => 'Istighfar & Shalawat Nabi',
                'keterangan' => 'Memperbanyak istighfar dan shalawat minimal 100x sehari',
                'waktu' => 'Sepanjang Hari',
            ],
        ];

        return view('islami.index', compact('dailyQuote', 'amalanSunnah'));
    }
}
