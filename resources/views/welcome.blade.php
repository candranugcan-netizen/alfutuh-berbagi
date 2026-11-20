<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Al Futuh Peduli - Platform Donasi, Zakat & Sedekah Terpercaya</title>

    <!-- PWA Meta Tags -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0D9488">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Al Futuh">
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-slate-50 text-slate-800 pb-20 md:pb-12 min-h-screen">

    <!-- Top Header Style KitaBisa -->
    <header class="bg-white sticky top-0 z-40 border-b border-slate-100 shadow-sm">
        <div class="max-w-md md:max-w-4xl mx-auto px-4 h-16 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
                <div class="w-10 h-10 rounded-2xl bg-teal-600 text-white flex items-center justify-center font-black text-xl shadow-md shadow-teal-600/20">
                    🕌
                </div>
                <div>
                    <h1 class="font-extrabold text-lg text-teal-700 tracking-tight leading-tight">Al Futuh<span class="text-amber-500">.</span></h1>
                    <p class="text-[10px] font-semibold text-slate-400 -mt-0.5 uppercase tracking-wider">Donasi & Zakat Online</p>
                </div>
            </a>

            <!-- Menu Kanan -->
            <div class="flex items-center gap-2">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="text-xs font-bold bg-teal-600 text-white px-3.5 py-1.5 rounded-full shadow-sm hover:bg-teal-700 transition">
                            Admin Portal
                        </a>
                    @else
                        <a href="{{ route('donations.my-donations') }}" class="text-xs font-bold bg-teal-50 text-teal-700 px-3.5 py-1.5 rounded-full border border-teal-100 hover:bg-teal-100 transition">
                            Donasi Saya
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-600 hover:text-teal-600 px-3 py-1.5 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-xs font-bold bg-teal-600 text-white px-3.5 py-1.5 rounded-full shadow-sm hover:bg-teal-700 active:scale-95 transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <main class="max-w-md md:max-w-4xl mx-auto px-4 pt-4 space-y-6">

        <!-- Banner PWA Install (Otomatis tampil di browser pendukung) -->
        <div id="pwa-install-banner" class="hidden bg-gradient-to-r from-teal-700 to-teal-800 text-white p-3.5 rounded-2xl shadow-md flex items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="text-2xl">📱</span>
                <div>
                    <p class="text-xs font-bold">Pasang Aplikasi Al Futuh</p>
                    <p class="text-[10px] text-teal-100">Akses cepat & donasi lebih mudah dari layar HP Anda</p>
                </div>
            </div>
            <button id="pwa-install-btn" class="bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-[11px] px-3 py-1.5 rounded-xl shadow-sm active:scale-95 transition">
                Pasang
            </button>
        </div>

        <!-- HERO / DONASI UNGGULAN (Featured Campaign KitaBisa Style) -->
        @if($featuredPrograms->isNotEmpty())
            @php $featured = $featuredPrograms->first(); @endphp
            <div class="relative bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
                <!-- Badge Unggulan -->
                <div class="relative h-48 md:h-64 w-full bg-gradient-to-br from-teal-600 to-teal-800 flex items-end">
                    @if($featured->banner)
                        <img src="{{ asset('storage/' . $featured->banner) }}" alt="{{ $featured->nama }}" class="absolute inset-0 w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-slate-900/20 to-transparent"></div>
                    @else
                        <div class="absolute inset-0 bg-gradient-to-br from-teal-700 via-teal-800 to-slate-900 opacity-95"></div>
                        <div class="absolute right-4 top-4 text-7xl opacity-20 select-none">
                            {{ $featured->icon ?: '🤲' }}
                        </div>
                    @endif

                    <div class="relative z-10 p-5 text-white w-full space-y-1.5">
                        <div class="flex items-center gap-2">
                            <span class="bg-amber-500 text-white text-[10px] font-extrabold px-2.5 py-0.5 rounded-full uppercase tracking-wider shadow-sm">
                                ⭐ Donasi Unggulan
                            </span>
                            <span class="bg-white/20 backdrop-blur-md text-white text-[10px] font-semibold px-2 py-0.5 rounded-full">
                                {{ $featured->kategori }}
                            </span>
                        </div>
                        <h2 class="text-lg md:text-xl font-extrabold leading-snug line-clamp-2">
                            {{ $featured->nama }}
                        </h2>
                    </div>
                </div>

                <!-- Progress & Action Card -->
                <div class="p-5 space-y-4">
                    <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                        {{ $featured->ringkasan ?: Str::limit($featured->deskripsi, 120) }}
                    </p>

                    <!-- Bar Progress -->
                    <div class="space-y-1.5">
                        <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                            <div class="bg-gradient-to-r from-teal-500 to-teal-600 h-2.5 rounded-full transition-all duration-500" style="width: {{ $featured->persentase }}%"></div>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <div>
                                <span class="text-slate-400 text-[10px] block">Terkumpul</span>
                                <span class="font-extrabold text-teal-700 text-sm">Rp {{ number_format($featured->dana_terkumpul, 0, ',', '.') }}</span>
                            </div>
                            <div class="text-right">
                                <span class="text-slate-400 text-[10px] block">Target</span>
                                <span class="font-bold text-slate-700 text-xs">
                                    @if($featured->target_dana > 0)
                                        Rp {{ number_format($featured->target_dana, 0, ',', '.') }}
                                    @else
                                        Berkelanjutan
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Call to Action -->
                    <div class="pt-2 flex items-center justify-between gap-3">
                        <div class="text-[11px] text-slate-500">
                            <span class="font-bold text-slate-700">{{ $featured->total_donatur }}</span> Donasi Terkumpul
                        </div>
                        <a href="{{ route('donations.create', $featured->slug) }}" class="bg-amber-500 hover:bg-amber-600 text-white font-extrabold text-xs px-5 py-2.5 rounded-xl shadow-md shadow-amber-500/20 active:scale-95 transition flex items-center gap-1.5">
                            <span>Donasi Sekarang</span>
                            <span>→</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- MODEL GRID MENU DONASI (KitaBisa Style Icon Grid) -->
        <div class="bg-white p-4 md:p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
            <div class="flex justify-between items-center px-1">
                <h3 class="text-xs md:text-sm font-extrabold text-slate-800 tracking-tight flex items-center gap-1.5">
                    <span>✨</span> Pilihan Kategori Donasi
                </h3>
                <a href="{{ route('programs.index') }}" class="text-[11px] font-bold text-teal-600 hover:text-teal-700">
                    Lihat Semua →
                </a>
            </div>

            <!-- Grid 3x2 di Mobile / 6 di Desktop -->
            <div class="grid grid-cols-3 sm:grid-cols-6 gap-2.5 pt-1">
                @foreach($programs->take(6) as $prog)
                    <a href="{{ route('programs.show', $prog->slug) }}" class="group flex flex-col items-center text-center p-2.5 rounded-2xl hover:bg-teal-50/60 border border-transparent hover:border-teal-100 transition duration-200">
                        <div class="w-13 h-13 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-2xl group-hover:scale-110 group-hover:bg-teal-600 group-hover:text-white transition shadow-sm mb-1.5">
                            {{ $prog->icon ?: '🤲' }}
                        </div>
                        <span class="text-[11px] font-bold text-slate-700 leading-tight group-hover:text-teal-700 line-clamp-2">
                            {{ $prog->nama }}
                        </span>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- TRANSPARANSI KAS & AMANAH DONATUR (Live Counter) -->
        <div class="bg-gradient-to-br from-teal-700 to-teal-900 rounded-3xl p-5 text-white shadow-lg shadow-teal-900/10 space-y-3">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-teal-200">Transparansi Dana Al Futuh</h3>
                </div>
                <a href="{{ route('transparansi') }}" class="text-[11px] font-bold text-amber-300 hover:text-amber-200 underline">
                    Detail Penyaluran →
                </a>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 pt-1">
                <div class="bg-white/10 backdrop-blur-md p-3 rounded-2xl border border-white/10 col-span-2 sm:col-span-1">
                    <p class="text-[10px] text-teal-200 font-medium">Total Donasi Terverifikasi</p>
                    <p class="text-lg font-black text-white mt-0.5">Rp {{ number_format($totalDonasiMasuk, 0, ',', '.') }}</p>
                    <p class="text-[9px] text-teal-300 mt-1">{{ $totalDonaturCount }} donatur berpartisipasi</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-3 rounded-2xl border border-white/10">
                    <p class="text-[10px] text-teal-200 font-medium">Total Disalurkan</p>
                    <p class="text-base font-black text-amber-300 mt-0.5">Rp {{ number_format($totalPenyaluran, 0, ',', '.') }}</p>
                    <p class="text-[9px] text-teal-300 mt-1">Amanah telah disalurkan</p>
                </div>
                <div class="bg-white/10 backdrop-blur-md p-3 rounded-2xl border border-white/10">
                    <p class="text-[10px] text-teal-200 font-medium">Saldo Kas Amanah</p>
                    <p class="text-base font-black text-emerald-300 mt-0.5">Rp {{ number_format(max(0, $totalDonasiMasuk - $totalPenyaluran), 0, ',', '.') }}</p>
                    <p class="text-[9px] text-teal-300 mt-1">Siap disalurkan</p>
                </div>
            </div>
        </div>

        <!-- DAFTAR PROGRAM DONASI LENGKAP -->
        <div class="space-y-3 pt-2">
            <div class="flex items-center justify-between px-1">
                <h3 class="text-sm font-extrabold text-slate-800 tracking-tight">
                    Program Kebaikan Al Futuh
                </h3>
                <span class="text-xs text-slate-400 font-medium">{{ $programs->count() }} Program Aktif</span>
            </div>

            <!-- Filter Kategori Tabs -->
            <div class="flex gap-1.5 overflow-x-auto pb-2 scrollbar-none text-xs">
                <a href="{{ route('landing') }}" class="px-3.5 py-1.5 rounded-full whitespace-nowrap font-bold transition {{ $kategoriAktif === 'Semua' ? 'bg-teal-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-teal-300' }}">
                    Semua
                </a>
                @foreach($categories as $kat)
                    <a href="{{ route('landing', ['kategori' => $kat]) }}" class="px-3.5 py-1.5 rounded-full whitespace-nowrap font-bold transition {{ $kategoriAktif === $kat ? 'bg-teal-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-teal-300' }}">
                        {{ $kat }}
                    </a>
                @endforeach
            </div>

            <!-- Grid Kartu Donasi (Model KitaBisa Card) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                @forelse($programs as $item)
                    <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition flex flex-col justify-between">
                        <div>
                            <!-- Header Foto / Ilustrasi Program -->
                            <div class="h-40 w-full bg-slate-100 relative overflow-hidden">
                                @if($item->banner)
                                    <img src="{{ asset('storage/' . $item->banner) }}" alt="{{ $item->nama }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-teal-500/90 to-teal-700 flex items-center justify-center text-4xl text-white">
                                        {{ $item->icon ?: '🤲' }}
                                    </div>
                                @endif
                                <div class="absolute top-2.5 left-2.5">
                                    <span class="text-[10px] font-bold bg-white/90 backdrop-blur-md text-teal-700 px-2.5 py-0.5 rounded-md shadow-sm">
                                        {{ $item->kategori }}
                                    </span>
                                </div>
                                @if($item->is_featured)
                                    <div class="absolute top-2.5 right-2.5">
                                        <span class="text-[10px] font-extrabold bg-amber-500 text-white px-2 py-0.5 rounded-md shadow-sm">
                                            ⭐ Pilihan
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Konten Card -->
                            <div class="p-4 space-y-2.5">
                                <a href="{{ route('programs.show', $item->slug) }}" class="font-extrabold text-sm md:text-base text-slate-800 leading-snug line-clamp-2 hover:text-teal-600 transition">
                                    {{ $item->nama }}
                                </a>

                                <div class="flex items-center gap-1.5 text-[11px] text-slate-500">
                                    <span>🏛️ Yayasan Al Futuh</span>
                                    <span class="text-teal-600 font-bold" title="Terverifikasi">✓</span>
                                </div>

                                <!-- Progress Bar -->
                                <div class="space-y-1 pt-1">
                                    <div class="w-full bg-slate-100 rounded-full h-2 overflow-hidden">
                                        <div class="bg-teal-500 h-2 rounded-full" style="width: {{ $item->persentase }}%"></div>
                                    </div>
                                    <div class="flex justify-between items-center text-[11px]">
                                        <div>
                                            <span class="text-slate-400 block text-[9px]">Terkumpul</span>
                                            <span class="font-black text-teal-700">Rp {{ number_format($item->dana_terkumpul, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-slate-400 block text-[9px]">
                                                {{ $item->tenggat_waktu ? 'Sisa Waktu' : 'Status' }}
                                            </span>
                                            <span class="font-semibold text-slate-600">
                                                {{ $item->sisa_hari !== null ? $item->sisa_hari . ' hari' : 'Berkelanjutan' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Donasi Cepat -->
                        <div class="p-4 pt-0">
                            <a href="{{ route('donations.create', $item->slug) }}" class="block w-full text-center bg-teal-50 hover:bg-teal-600 text-teal-700 hover:text-white font-bold text-xs py-2 rounded-xl transition duration-150 active:scale-95">
                                Donasi Sekarang
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="bg-white p-8 text-center rounded-2xl border border-slate-100 col-span-2">
                        <p class="text-xs text-slate-400">Belum ada program untuk kategori ini.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- KABAR TERBARU & CERITA PENYALURAN -->
        <div class="space-y-3 pt-4">
            <div class="flex items-center justify-between px-1">
                <div>
                    <h3 class="text-sm font-extrabold text-slate-800 tracking-tight">Kabar Terbaru & Penyaluran</h3>
                    <p class="text-[11px] text-slate-400">Cerita nyata manfaat kebaikan dari donatur</p>
                </div>
                <a href="{{ route('kabars.index') }}" class="text-xs font-bold text-teal-600 hover:text-teal-700">
                    Lihat Semua →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($kabars as $kabar)
                    <a href="{{ route('kabars.show', $kabar->slug) }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-teal-200 transition flex gap-3.5">
                        <div class="w-20 h-20 rounded-xl bg-slate-100 shrink-0 overflow-hidden relative">
                            @if($kabar->foto)
                                <img src="{{ asset('storage/' . $kabar->foto) }}" alt="{{ $kabar->judul }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full bg-teal-50 text-teal-600 flex items-center justify-center text-xl">
                                    📰
                                </div>
                            @endif
                        </div>
                        <div class="space-y-1">
                            <span class="text-[10px] font-bold text-teal-600 bg-teal-50 px-2 py-0.5 rounded-md">
                                {{ \Carbon\Carbon::parse($kabar->tanggal)->format('d M Y') }}
                            </span>
                            <h4 class="font-bold text-xs md:text-sm text-slate-800 line-clamp-2 leading-snug">
                                {{ $kabar->judul }}
                            </h4>
                            <p class="text-[11px] text-slate-400 line-clamp-1">
                                {{ $kabar->ringkasan ?: Str::limit(strip_tags($kabar->konten), 60) }}
                            </p>
                        </div>
                    </a>
                @empty
                    <div class="bg-white p-6 text-center rounded-2xl border border-slate-100 col-span-2">
                        <p class="text-xs text-slate-400">Belum ada kabar terbaru yang diterbitkan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- DOA & DUKUNGAN DONATUR TERBARU -->
        @if($recentDonations->isNotEmpty())
            <div class="bg-white p-4 md:p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                    <span>🤲</span> Doa-Doa Donatur
                </h3>
                <div class="space-y-2.5">
                    @foreach($recentDonations as $d)
                        <div class="p-3 bg-slate-50/70 rounded-2xl border border-slate-100 space-y-1">
                            <div class="flex items-center justify-between text-[11px]">
                                <span class="font-bold text-slate-800">{{ $d->displayName }}</span>
                                <span class="text-[10px] text-slate-400">{{ $d->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs text-slate-600 italic">"{{ $d->doa }}"</p>
                            <p class="text-[9px] font-medium text-teal-600">Berdonasi di {{ $d->program->nama }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- CARA BERDONASI (Langkah Mudah) -->
        <div class="bg-teal-50/60 p-5 rounded-3xl border border-teal-100 space-y-3 text-center">
            <h4 class="text-xs font-extrabold text-teal-800 uppercase tracking-wider">Alur Donasi Amanah</h4>
            <div class="grid grid-cols-4 gap-2 text-center text-[10px] text-slate-600">
                <div class="space-y-1">
                    <div class="w-8 h-8 rounded-full bg-white text-teal-700 font-black text-xs flex items-center justify-center mx-auto shadow-sm">1</div>
                    <span class="font-bold block">Pilih Program</span>
                </div>
                <div class="space-y-1">
                    <div class="w-8 h-8 rounded-full bg-white text-teal-700 font-black text-xs flex items-center justify-center mx-auto shadow-sm">2</div>
                    <span class="font-bold block">Transfer Bank</span>
                </div>
                <div class="space-y-1">
                    <div class="w-8 h-8 rounded-full bg-white text-teal-700 font-black text-xs flex items-center justify-center mx-auto shadow-sm">3</div>
                    <span class="font-bold block">Verifikasi</span>
                </div>
                <div class="space-y-1">
                    <div class="w-8 h-8 rounded-full bg-white text-teal-700 font-black text-xs flex items-center justify-center mx-auto shadow-sm">4</div>
                    <span class="font-bold block">Tersalurkan</span>
                </div>
            </div>
        </div>

    </main>

    <!-- Footer -->
    <footer class="max-w-md md:max-w-4xl mx-auto px-4 mt-10 text-center text-xs text-slate-400 space-y-2 border-t border-slate-100 pt-6">
        <p class="font-bold text-slate-600">Yayasan Al Futuh Indonesia</p>
        <p class="text-[11px]">Menebar manfaat melalui donasi operasional dakwah, qurban, santunan yatim, zakat, beasiswa, dan sedekah listrik masjid.</p>
        <p class="text-[10px] text-slate-400">© {{ date('Y') }} Al Futuh Peduli PWA. All rights reserved.</p>
    </footer>

    <!-- PWA Bottom Bar -->
    <div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-50 flex justify-around items-center py-2 px-1 shadow-lg">
        <a href="{{ route('landing') }}" class="flex flex-col items-center text-[10px] text-teal-600 font-extrabold">
            <span class="text-lg">🏠</span>
            <span>Beranda</span>
        </a>
        <a href="{{ route('programs.index') }}" class="flex flex-col items-center text-[10px] text-slate-400 font-medium">
            <span class="text-lg">🤲</span>
            <span>Program</span>
        </a>
        <a href="{{ route('kabars.index') }}" class="flex flex-col items-center text-[10px] text-slate-400 font-medium">
            <span class="text-lg">📰</span>
            <span>Kabar</span>
        </a>
        <a href="{{ route('donations.my-donations') }}" class="flex flex-col items-center text-[10px] text-slate-400 font-medium">
            <span class="text-lg">📜</span>
            <span>Donasi Saya</span>
        </a>
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-[10px] text-slate-400 font-medium">
                    <span class="text-lg">⚙️</span>
                    <span>Admin</span>
                </a>
            @else
                <a href="{{ route('profile.edit') }}" class="flex flex-col items-center text-[10px] text-slate-400 font-medium">
                    <span class="text-lg">👤</span>
                    <span>Akun</span>
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center text-[10px] text-slate-400 font-medium">
                <span class="text-lg">🔑</span>
                <span>Masuk</span>
            </a>
        @endauth
    </div>

    <!-- Service Worker & PWA Install Prompt Script -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }

        // PWA Install Prompt
        let deferredPrompt;
        const banner = document.getElementById('pwa-install-banner');
        const installBtn = document.getElementById('pwa-install-btn');

        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            if (banner) {
                banner.classList.remove('hidden');
            }
        });

        if (installBtn) {
            installBtn.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    const { outcome } = await deferredPrompt.userChoice;
                    console.log(`User response to install prompt: ${outcome}`);
                    deferredPrompt = null;
                    if (banner) banner.classList.add('hidden');
                }
            });
        }
    </script>
</body>
</html>
