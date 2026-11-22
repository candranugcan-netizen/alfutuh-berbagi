<!-- Floating PWA Install Button (Positioned above WhatsApp Button) -->
<div id="pwa-floating-container" class="fixed bottom-36 right-3.5 sm:right-5 md:bottom-[5.5rem] md:right-7 z-40 transition-all duration-300">
    <button id="pwa-floating-btn" type="button"
            class="group relative flex items-center gap-2 bg-[#155E4B] hover:bg-[#0E4436] text-white w-12 h-12 md:w-auto md:h-auto md:px-4 md:py-3 rounded-full shadow-lg shadow-[#155E4B]/35 border border-white/25 active:scale-95 transition-all duration-300 hover:shadow-xl justify-center"
            aria-label="Pasang Aplikasi Al Futuh" title="Pasang Aplikasi Al Futuh (PWA)">
        
        <!-- Icon Phone Download -->
        <svg class="w-5 h-5 text-white shrink-0 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <rect width="13" height="19" x="5.5" y="2.5" rx="2.5" stroke-width="1.8"/>
            <path d="M12 18h.01M9.5 10.5 12 13m0 0 2.5-2.5M12 13V6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>

        <!-- Desktop Label -->
        <span class="hidden md:inline font-bold text-xs tracking-tight whitespace-nowrap">
            Pasang App
        </span>

        <!-- Badge Mini Golden -->
        <span class="absolute -top-1 -right-1 flex h-4 w-4">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-60"></span>
            <span class="relative inline-flex rounded-full h-4 w-4 bg-[#D4AF37] text-[8px] font-black text-slate-900 items-center justify-center border border-white shadow-xs">↓</span>
        </span>
    </button>
</div>

<!-- Modal Panduan iOS (Bila dibuka di Safari iPhone/iPad) -->
<div id="pwa-ios-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl p-6 max-w-sm w-full space-y-4 shadow-2xl border border-slate-100 text-center">
        <div class="w-14 h-14 rounded-2xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center mx-auto shadow-sm">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <rect width="13" height="19" x="5.5" y="2.5" rx="2.5" stroke-width="1.8"/>
                <path d="M12 18h.01M9.5 10.5 12 13m0 0 2.5-2.5M12 13V6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </div>
        <div class="space-y-1">
            <h3 class="font-extrabold text-base text-slate-800">Pasang di iPhone / iPad</h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Untuk memasang aplikasi Al Futuh di layar utama perangkat iOS:
            </p>
        </div>
        <div class="bg-[#F8FAF8] p-3 rounded-2xl border border-slate-100 text-xs text-left space-y-2 text-slate-700">
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-[#155E4B] text-white text-[10px] font-bold flex items-center justify-center shrink-0">1</span>
                <span>Tekan tombol <strong>Bagikan / Share</strong> (ikon <svg class="w-3.5 h-3.5 inline text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8m-4-6-4-4-4 4m4-4v13" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg> di Safari).</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-5 h-5 rounded-full bg-[#155E4B] text-white text-[10px] font-bold flex items-center justify-center shrink-0">2</span>
                <span>Gulir ke bawah lalu pilih <strong>Tambahkan ke Layar Utama</strong> (<em>Add to Home Screen</em>).</span>
            </div>
        </div>
        <button type="button" onclick="document.getElementById('pwa-ios-modal').classList.replace('flex','hidden')"
                class="w-full bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-3 rounded-full transition active:scale-95 shadow-sm">
            Saya Mengerti
        </button>
    </div>
</div>

<script>
    (function() {
        let pwaInstallPrompt = null;
        const container = document.getElementById('pwa-floating-container');
        const btn = document.getElementById('pwa-floating-btn');
        const iosModal = document.getElementById('pwa-ios-modal');

        // Cek apakah sudah terpasang (Standalone mode)
        const isStandalone = window.matchMedia('(display-mode: standalone)').matches || window.navigator.standalone === true;
        if (isStandalone && container) {
            container.style.display = 'none';
        }

        // Tangkap event sebelum instalasi di Android / Chrome / Edge
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            pwaInstallPrompt = e;
            if (container && !isStandalone) {
                container.classList.remove('hidden');
                container.style.display = 'block';
            }
        });

        // Deteksi iOS
        const isIos = /iphone|ipad|ipod/.test(window.navigator.userAgent.toLowerCase());

        if (btn) {
            btn.addEventListener('click', async () => {
                if (pwaInstallPrompt) {
                    pwaInstallPrompt.prompt();
                    const { outcome } = await pwaInstallPrompt.userChoice;
                    pwaInstallPrompt = null;
                    if (outcome === 'accepted' && container) {
                        container.style.display = 'none';
                    }
                } else if (isIos && iosModal) {
                    iosModal.classList.replace('hidden', 'flex');
                } else {
                    alert('Aplikasi Al Futuh siap dipasang. Jika menu unduh tidak muncul, Anda dapat memilih menu browser (titik tiga) lalu pilih "Instal Aplikasi" atau "Tambahkan ke Layar Utama".');
                }
            });
        }
    })();
</script>
