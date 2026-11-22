<x-app-layout>
    <div x-data="{
        selectedNominal: 50000,
        customNominal: '',
        showCustom: false,
        shareModal: false,
        share() {
            if (navigator.share) {
                navigator.share({
                    title: '{{ $program->nama }} - Al Futuh',
                    text: 'Mari salurkan donasi terbaik untuk {{ $program->nama }} melalui Al Futuh.',
                    url: window.location.href,
                }).catch(() => {});
            } else {
                navigator.clipboard.writeText(window.location.href);
                Swal.fire({
                    icon: 'success',
                    title: 'Tautan Disalin!',
                    text: 'Tautan program donasi berhasil disalin ke clipboard.',
                    timer: 2000,
                    showConfirmButton: false,
                    customClass: { popup: 'rounded-3xl' }
                });
            }
        }
    }" class="max-w-2xl mx-auto space-y-6">

        <!-- Top Header Navigation Bar -->
        <div class="flex items-center justify-between">
            <a href="{{ route('landing') }}" class="w-10 h-10 rounded-full bg-white border border-slate-100 flex items-center justify-center text-slate-700 hover:text-[#155E4B] shadow-sm transition active:scale-95" title="Kembali">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 12H5M12 19l-7-7 7-7" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
            <h1 class="text-sm font-extrabold text-slate-800">Detail Program</h1>
            <button type="button" @click="share()" class="w-10 h-10 rounded-full bg-white border border-slate-100 flex items-center justify-center text-slate-700 hover:text-[#155E4B] shadow-sm transition active:scale-95" title="Bagikan Program">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 1 1 0-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 1 0 5.367-2.684 3 3 0 0 0-5.367 2.684zm0 9.316a3 3 0 1 0 5.368 2.684 3 3 0 0 0-5.368-2.684z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </button>
        </div>

        <!-- Main Detail Card -->
        <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
            <!-- Hero Mosque Image Banner -->
            <div class="h-56 sm:h-72 w-full bg-slate-100 relative overflow-hidden">
                @if($program->banner)
                    <img src="{{ asset('storage/' . $program->banner) }}" alt="{{ $program->nama }}" class="w-full h-full object-cover">
                @else
                    <img src="{{ asset('images/mosque-hero.svg') }}" alt="{{ $program->nama }}" class="w-full h-full object-cover">
                @endif
                <div class="absolute top-4 left-4">
                    <span class="text-xs font-bold bg-white/95 backdrop-blur-md text-[#155E4B] px-3.5 py-1 rounded-full shadow-sm">
                        {{ $program->kategori }}
                    </span>
                </div>
            </div>

            <!-- Content Details -->
            <div class="p-6 sm:p-8 space-y-5">
                <div>
                    <h2 class="text-xl sm:text-2xl font-extrabold text-slate-800 leading-snug">
                        {{ $program->nama }}
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-2 leading-relaxed">
                        {{ $program->ringkasan ?: Str::limit(strip_tags($program->deskripsi), 130) }}
                    </p>
                </div>

                <!-- Progress Bar -->
                <div class="w-full bg-slate-100 rounded-full h-2.5 overflow-hidden">
                    <div class="bg-[#155E4B] h-2.5 rounded-full transition-all duration-500" style="width: {{ $program->persentase }}%"></div>
                </div>

                <!-- 2-Column Stats -->
                <div class="flex justify-between items-baseline pt-1">
                    <div>
                        <span class="text-lg sm:text-xl font-black text-slate-800 block">
                            Rp {{ number_format($program->dana_terkumpul, 0, ',', '.') }}
                        </span>
                        <span class="text-xs text-slate-400 font-medium">Terkumpul</span>
                    </div>
                    <div class="text-right">
                        @if($program->target_dana > 0)
                            <span class="text-lg sm:text-xl font-black text-slate-800 block">
                                Rp {{ number_format($program->target_dana, 0, ',', '.') }}
                            </span>
                            <span class="text-xs text-slate-400 font-medium">Target</span>
                        @else
                            <div class="flex items-center justify-end gap-1.5 text-[#155E4B]">
                                <x-infinity-icon class="w-5 h-5 text-[#155E4B]" />
                                <span class="text-base sm:text-lg font-extrabold">Tidak Terbatas</span>
                            </div>
                            <span class="text-xs text-slate-400 font-medium">Target Berkelanjutan</span>
                        @endif
                    </div>
                </div>

                <!-- Section: Pilih Nominal Donasi -->
                <div class="space-y-3 pt-3 border-t border-slate-100">
                    <label class="block text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                        Pilih Nominal Donasi
                    </label>

                    <div class="grid grid-cols-2 gap-3">
                        <button type="button" @click="selectedNominal = 25000; showCustom = false"
                            :class="(selectedNominal == 25000 && !showCustom) ? 'bg-[#EAF3EE] text-[#155E4B] border-2 border-[#155E4B] font-extrabold' : 'bg-[#F2F7F4] text-slate-700 border border-[#E2ECE6] font-bold'"
                            class="py-3.5 px-4 rounded-2xl text-xs sm:text-sm transition active:scale-95 text-center">
                            Rp 25.000
                        </button>

                        <button type="button" @click="selectedNominal = 50000; showCustom = false"
                            :class="(selectedNominal == 50000 && !showCustom) ? 'bg-[#EAF3EE] text-[#155E4B] border-2 border-[#155E4B] font-extrabold' : 'bg-[#F2F7F4] text-slate-700 border border-[#E2ECE6] font-bold'"
                            class="py-3.5 px-4 rounded-2xl text-xs sm:text-sm transition active:scale-95 text-center">
                            Rp 50.000
                        </button>

                        <button type="button" @click="selectedNominal = 100000; showCustom = false"
                            :class="(selectedNominal == 100000 && !showCustom) ? 'bg-[#EAF3EE] text-[#155E4B] border-2 border-[#155E4B] font-extrabold' : 'bg-[#F2F7F4] text-slate-700 border border-[#E2ECE6] font-bold'"
                            class="py-3.5 px-4 rounded-2xl text-xs sm:text-sm transition active:scale-95 text-center">
                            Rp 100.000
                        </button>

                        <button type="button" @click="showCustom = true; selectedNominal = customNominal || ''"
                            :class="showCustom ? 'bg-[#EAF3EE] text-[#155E4B] border-2 border-[#155E4B] font-extrabold' : 'bg-[#F2F7F4] text-slate-700 border border-[#E2ECE6] font-bold'"
                            class="py-3.5 px-4 rounded-2xl text-xs sm:text-sm transition active:scale-95 text-center flex items-center justify-center gap-1.5">
                            <span>Nominal Lainnya</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </button>
                    </div>

                    <!-- Custom Nominal Input -->
                    <div x-show="showCustom" x-cloak class="pt-2">
                        <div class="relative">
                            <span class="absolute left-4 top-3.5 font-extrabold text-slate-400 text-sm">Rp</span>
                            <input type="number" x-model="customNominal" @input="selectedNominal = customNominal" placeholder="Contoh: 200000" min="10000" step="5000"
                                class="w-full text-sm font-bold pl-12 pr-4 py-3 rounded-2xl border border-slate-200 focus:border-[#155E4B] focus:ring-[#155E4B]">
                        </div>
                        <p class="text-[10px] text-slate-400 mt-1">Minimal nominal donasi Rp 10.000</p>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="pt-2">
                    <a :href="'{{ route('donations.create', $program->slug) }}?nominal=' + (showCustom ? (customNominal || 50000) : selectedNominal)"
                        class="w-full flex items-center justify-center gap-2 bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-sm py-4 px-6 rounded-full shadow-lg shadow-[#155E4B]/20 active:scale-95 transition">
                        <span>Lanjutkan Donasi</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Interactive Tabs -->
        <div id="tabs-section" x-data="{ tab: '{{ request('tab', request('page') ? 'donatur' : 'cerita') }}' }" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-sm space-y-5">
            <!-- Tab Headers -->
            <div class="flex border-b border-slate-100 gap-6 text-xs sm:text-sm font-bold">
                <button @click="tab = 'cerita'" :class="tab === 'cerita' ? 'text-[#155E4B] border-b-2 border-[#155E4B] pb-3.5 font-extrabold' : 'text-slate-400 pb-3.5 hover:text-slate-600'" class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20V4H6.5A2.5 2.5 0 0 0 4 6.5v13ZM4 6.5A2.5 2.5 0 0 1 6.5 4M8 8h8M8 12h6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Cerita Lengkap</span>
                </button>
                <button @click="tab = 'kabar'" :class="tab === 'kabar' ? 'text-[#155E4B] border-b-2 border-[#155E4B] pb-3.5 font-extrabold' : 'text-slate-400 pb-3.5 hover:text-slate-600'" class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 5h16v14H4zM8 9h8M8 13h5M16 13h2M8 16h10" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span>Kabar &amp; Penyaluran ({{ $kabars->count() + $penyalurans->count() }})</span>
                </button>
                <button @click="tab = 'donatur'" :class="tab === 'donatur' ? 'text-[#155E4B] border-b-2 border-[#155E4B] pb-3.5 font-extrabold' : 'text-slate-400 pb-3.5 hover:text-slate-600'" class="inline-flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="8" r="3.5" stroke-width="1.8"/><path d="M5 20c1-4 3.3-6 7-6s6 2 7 6" stroke-width="1.8" stroke-linecap="round"/></svg>
                    <span>Doa &amp; Donatur ({{ $donations->total() }})</span>
                </button>
            </div>

            <!-- Tab 1: Cerita -->
            <div x-show="tab === 'cerita'" class="space-y-4 text-xs sm:text-sm text-slate-600 leading-relaxed">
                <div class="whitespace-pre-line">
                    {{ $program->deskripsi }}
                </div>
            </div>

            <!-- Tab 2: Kabar & Penyaluran -->
            <div x-show="tab === 'kabar'" style="display: none;" class="space-y-4">
                @if($penyalurans->isNotEmpty())
                    <div class="space-y-2.5">
                        <h4 class="text-xs font-bold text-[#155E4B] uppercase tracking-wider">Laporan Penyaluran Dana</h4>
                        @foreach($penyalurans as $p)
                            <div class="p-4 bg-[#F2F7F4] rounded-2xl border border-[#D2E6DC] space-y-1">
                                <div class="flex justify-between items-center text-xs">
                                    <span class="font-extrabold text-[#155E4B]">{{ $p->judul }}</span>
                                    <span class="font-black text-[#155E4B]">Rp {{ number_format($p->nominal, 0, ',', '.') }}</span>
                                </div>
                                <p class="text-[11px] text-slate-500">Penerima: {{ $p->penerima }} • {{ $p->tanggal->format('d M Y') }}</p>
                                <p class="text-xs text-slate-600 mt-1">{{ $p->keterangan }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif

                @if($kabars->isNotEmpty())
                    <div class="space-y-2.5 pt-2">
                        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Artikel Kabar Penyaluran</h4>
                        @foreach($kabars as $k)
                            <a href="{{ route('kabars.show', $k->slug) }}" class="block p-4 rounded-2xl border border-slate-100 hover:border-[#155E4B] transition">
                                <span class="text-[10px] font-bold text-[#155E4B]">{{ $k->tanggal->format('d M Y') }}</span>
                                <h5 class="font-bold text-xs sm:text-sm text-slate-800 mt-0.5">{{ $k->judul }}</h5>
                                <p class="text-[11px] text-slate-400 mt-1 line-clamp-2">{{ $k->ringkasan }}</p>
                            </a>
                        @endforeach
                    </div>
                @endif

                @if($penyalurans->isEmpty() && $kabars->isEmpty())
                    <p class="text-xs text-slate-400 text-center py-8">Belum ada pembaruan kabar atau penyaluran untuk program ini.</p>
                @endif
            </div>

            <!-- Tab 3: Donatur & Doa -->
            <div x-show="tab === 'donatur'" style="display: none;" class="space-y-3">
                @forelse($donations as $donasi)
                    <div class="p-4 bg-[#F8FAF8] rounded-2xl border border-slate-100 space-y-1">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-slate-800">{{ $donasi->displayName }}</span>
                            <span class="font-black text-[#155E4B]">Rp {{ number_format($donasi->nominal, 0, ',', '.') }}</span>
                        </div>
                        <span class="text-[10px] text-slate-400 block">{{ $donasi->created_at->diffForHumans() }}</span>
                        @if($donasi->doa)
                            <p class="text-xs text-slate-600 italic bg-white p-3 rounded-xl mt-1.5 border border-slate-100">
                                "{{ $donasi->doa }}"
                            </p>
                        @endif
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-8">Jadilah donatur pertama yang menebar kebaikan di program ini!</p>
                @endforelse

                @if(method_exists($donations, 'links'))
                    <div class="pt-4">
                        {{ $donations->appends(['tab' => 'donatur'])->fragment('tabs-section')->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
