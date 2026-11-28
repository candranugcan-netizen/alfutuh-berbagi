@props(['showIslamiButton' => false])

<div x-data="{
        city: localStorage.getItem('alfutuh_prayer_city') || 'Yogyakarta',
        cities: ['Yogyakarta', 'Gunungkidul', 'Jakarta', 'Bandung', 'Surabaya', 'Semarang', 'Solo', 'Medan', 'Makassar', 'Palembang'],
        timings: {
            Fajr: '04:05',
            Dhuhr: '11:36',
            Asr: '14:58',
            Maghrib: '17:46',
            Isha: '18:59'
        },
        hijriDate: '',
        nextPrayerName: 'Maghrib',
        countdown: '--:--:--',
        loading: false,
        timer: null,

        init() {
            this.fetchTimes();
            this.startCountdown();
        },

        async fetchTimes() {
            const todayKey = new Date().toISOString().slice(0, 10);
            const cacheKey = `alfutuh_prayer_${todayKey}_${this.city}`;
            const cached = localStorage.getItem(cacheKey);

            if (cached) {
                try {
                    const parsed = JSON.parse(cached);
                    this.applyData(parsed);
                    return;
                } catch (e) {}
            }

            this.loading = true;
            try {
                const queryCity = this.city === 'Gunungkidul' ? 'Wonosari' : this.city;
                const res = await fetch(`https://api.aladhan.com/v1/timingsByCity?city=${encodeURIComponent(queryCity)}&country=Indonesia&method=20`);
                const json = await res.json();
                if (json.code === 200 && json.data) {
                    localStorage.setItem(cacheKey, JSON.stringify(json.data));
                    this.applyData(json.data);
                }
            } catch (err) {
                // Gunakan fallback default jika offline
            } finally {
                this.loading = false;
            }
        },

        detectGps() {
            if (!navigator.geolocation) return;
            this.loading = true;
            navigator.geolocation.getCurrentPosition(async (pos) => {
                try {
                    const { latitude, longitude } = pos.coords;
                    const res = await fetch(`https://api.aladhan.com/v1/timings?latitude=${latitude}&longitude=${longitude}&method=20`);
                    const json = await res.json();
                    if (json.code === 200 && json.data) {
                        this.applyData(json.data);
                    }
                } catch (e) {
                } finally {
                    this.loading = false;
                }
            }, () => {
                this.loading = false;
            });
        },

        changeCity(newCity) {
            this.city = newCity;
            localStorage.setItem('alfutuh_prayer_city', newCity);
            this.fetchTimes();
        },

        applyData(data) {
            if (data.timings) {
                this.timings = {
                    Fajr: (data.timings.Fajr || '04:05').slice(0, 5),
                    Dhuhr: (data.timings.Dhuhr || '11:36').slice(0, 5),
                    Asr: (data.timings.Asr || '14:58').slice(0, 5),
                    Maghrib: (data.timings.Maghrib || '17:46').slice(0, 5),
                    Isha: (data.timings.Isha || '18:59').slice(0, 5),
                };
            }
            if (data.date && data.date.hijri) {
                const h = data.date.hijri;
                this.hijriDate = `${h.day} ${h.month.en} ${h.year} H`;
                window.dispatchEvent(new CustomEvent('hijri-updated', { detail: { day: parseInt(h.day, 10), month: h.month.en, year: h.year } }));
            }
            this.updateNextPrayer();
        },

        startCountdown() {
            this.updateNextPrayer();
            this.timer = setInterval(() => this.updateNextPrayer(), 1000);
        },

        updateNextPrayer() {
            const now = new Date();
            const list = [
                { key: 'Fajr', label: 'Subuh', time: this.timings.Fajr },
                { key: 'Dhuhr', label: 'Dzuhur', time: this.timings.Dhuhr },
                { key: 'Asr', label: 'Ashar', time: this.timings.Asr },
                { key: 'Maghrib', label: 'Maghrib', time: this.timings.Maghrib },
                { key: 'Isha', label: 'Isya', time: this.timings.Isha },
            ];

            let next = null;
            for (const item of list) {
                const [hh, mm] = item.time.split(':').map(Number);
                const target = new Date(now.getFullYear(), now.getMonth(), now.getDate(), hh, mm, 0);
                if (target > now) {
                    next = { ...item, target };
                    break;
                }
            }

            if (!next) {
                const [hh, mm] = list[0].time.split(':').map(Number);
                const target = new Date(now.getFullYear(), now.getMonth(), now.getDate() + 1, hh, mm, 0);
                next = { ...list[0], target };
            }

            this.nextPrayerName = next.label;
            const diff = Math.max(0, Math.floor((next.target - now) / 1000));
            const h = String(Math.floor(diff / 3600)).padStart(2, '0');
            const m = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
            const s = String(diff % 60).padStart(2, '0');
            this.countdown = `${h}:${m}:${s}`;
        }
    }"
    class="bg-white rounded-2xl sm:rounded-3xl p-3 sm:p-5 border border-orange-200 shadow-xs space-y-2.5 sm:space-y-4">

    <!-- Header Card Compact: Judul, Lokasi & Countdown -->
    <div class="flex items-center justify-between gap-2">
        <div class="flex items-center gap-2 sm:gap-2.5 min-w-0">
            <span class="inline-flex items-center justify-center w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-[#FFF7ED] text-[#EA580C] border border-orange-200 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 3c-3.5 2.5-6 6-6 10v7h12v-7c0-4-2.5-7.5-6-10Z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.6" d="M10 20v-4a2 2 0 1 1 4 0v4M3 20h18M12 1.5v2"/>
                </svg>
            </span>
            <div class="min-w-0">
                <div class="flex items-center gap-1.5 flex-wrap">
                    <h3 class="font-extrabold text-xs sm:text-base text-slate-800 tracking-tight leading-none">Jadwal Sholat</h3>
                    <span class="text-[9px] sm:text-[11px] text-slate-400 font-semibold leading-none truncate" x-show="hijriDate" x-text="'• ' + hijriDate"></span>
                </div>
                <!-- Kontrol Kota & GPS Inline Compact -->
                <div class="flex items-center gap-1 mt-1">
                    <svg class="w-3 h-3 text-[#EA580C] shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <select x-model="city" @change="changeCity($event.target.value)"
                            class="bg-transparent text-[10px] sm:text-[11px] font-bold text-slate-600 border-0 p-0 pr-4 focus:ring-0 cursor-pointer leading-none">
                        <template x-for="c in cities" :key="c">
                            <option :value="c" x-text="c" class="text-slate-800 bg-white"></option>
                        </template>
                    </select>
                    <button type="button" @click="detectGps()" title="Deteksi Lokasi GPS" class="text-[#EA580C] hover:text-[#C2410C] transition">
                        <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" :class="loading ? 'animate-spin' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="3" stroke-width="2"/>
                            <path stroke-linecap="round" stroke-width="2" d="M12 2v3m0 14v3M2 12h3m14 0h3"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Countdown Pill Compact -->
        <div class="inline-flex flex-col sm:flex-row items-end sm:items-center sm:gap-1.5 bg-[#EA580C] text-white px-2.5 py-1 sm:px-3 sm:py-1.5 rounded-xl sm:rounded-full text-[9px] sm:text-[11px] font-bold shrink-0 leading-tight">
            <span class="opacity-90">Menuju <span x-text="nextPrayerName"></span></span>
            <span class="font-mono font-black text-[11px] sm:text-xs" x-text="countdown"></span>
        </div>
    </div>

    <!-- Grid 5 Waktu Sholat (Flat & Compact) -->
    <div class="grid grid-cols-5 gap-1 sm:gap-2.5">
        <template x-for="item in [
            { label: 'Subuh', key: 'Fajr' },
            { label: 'Dzuhur', key: 'Dhuhr' },
            { label: 'Ashar', key: 'Asr' },
            { label: 'Maghrib', key: 'Maghrib' },
            { label: 'Isya', key: 'Isha' }
        ]" :key="item.key">
            <div :class="nextPrayerName === item.label
                    ? 'bg-[#EA580C] text-white border-[#EA580C]'
                    : 'bg-[#FFF7ED] text-slate-800 border-orange-100'"
                 class="rounded-xl sm:rounded-2xl py-1.5 px-1 sm:p-3 text-center border transition flex flex-col items-center justify-center space-y-0.5">
                <span class="text-[8.5px] sm:text-[10px] font-bold uppercase tracking-tight sm:tracking-wider"
                      :class="nextPrayerName === item.label ? 'text-orange-100' : 'text-slate-500'"
                      x-text="item.label"></span>
                <span class="text-[11px] sm:text-base font-black font-mono tracking-tighter sm:tracking-tight" x-text="timings[item.key]"></span>
            </div>
        </template>
    </div>

    @if($showIslamiButton)
        <div class="pt-2 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 border-t border-slate-100">
            <p class="text-[10px] sm:text-[11px] text-slate-500">
                Akses Al-Qur'an, Hadits, Doa Shahih, Kalkulator Zakat &amp; Pengingat Amalan Sunnah
            </p>
            <a href="{{ route('islami.index') }}"
               class="inline-flex items-center justify-center gap-1.5 bg-[#EA580C] hover:bg-[#C2410C] text-white font-extrabold text-xs px-4 py-2 rounded-full active:scale-95 transition shrink-0">
                <span>Buka Fitur Islami</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
        </div>
    @endif
</div>
