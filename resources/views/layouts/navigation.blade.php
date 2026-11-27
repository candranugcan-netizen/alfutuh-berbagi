<nav x-data="{ open: false }" class="bg-white border-b border-slate-100 sticky top-0 z-40 shadow-sm">
    <!-- Primary Navigation Menu (Desktop & Mobile Header) -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo & Brand -->
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="flex items-center gap-2.5">
                    <img src="{{ asset('images/icon-192.png') }}" alt="Al Futuh" class="w-10 h-10 object-contain rounded-xl">
                    <div>
                        <span class="font-extrabold text-lg text-[#155E4B] tracking-tight block leading-tight">Al Futuh</span>
                        <span class="text-[9px] font-bold text-slate-400 block tracking-[0.2em] uppercase">Donasi &amp; Zakat</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Links -->
            <div class="hidden md:flex md:items-center md:gap-1 text-xs font-bold">
                <a href="{{ route('landing') }}" class="px-3.5 py-2 rounded-full transition {{ request()->routeIs('landing') ? 'text-[#155E4B] bg-[#F2F7F4]' : 'text-slate-600 hover:text-[#155E4B]' }}">
                    Beranda
                </a>
                <a href="{{ route('programs.index') }}" class="px-3.5 py-2 rounded-full transition {{ request()->routeIs('programs.*') ? 'text-[#155E4B] bg-[#F2F7F4]' : 'text-slate-600 hover:text-[#155E4B]' }}">
                    Program
                </a>
                <a href="{{ route('donations.my-donations') }}" class="px-3.5 py-2 rounded-full transition {{ request()->routeIs('donations.my-donations') ? 'text-[#155E4B] bg-[#F2F7F4]' : 'text-slate-600 hover:text-[#155E4B]' }}">
                    Riwayat
                </a>
                <a href="{{ route('transparansi') }}" class="px-3.5 py-2 rounded-full transition {{ request()->routeIs('transparansi') ? 'text-[#155E4B] bg-[#F2F7F4]' : 'text-slate-600 hover:text-[#155E4B]' }}">
                    Transparansi
                </a>
                <a href="{{ route('kabars.index') }}" class="px-3.5 py-2 rounded-full transition {{ request()->routeIs('kabars.*') ? 'text-[#155E4B] bg-[#F2F7F4]' : 'text-slate-600 hover:text-[#155E4B]' }}">
                    Kabar
                </a>
            </div>

            <!-- Right Actions (Auth / Admin) -->
            <div class="flex items-center gap-2">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-[#155E4B] text-white px-4 py-2 rounded-full shadow-sm hover:bg-[#0E4436] active:scale-95 transition">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="3" stroke-width="1.8"/><path d="M19 12a7 7 0 0 0-.1-1l2-1.5-2-3.4-2.5 1a7 7 0 0 0-1.7-1L14.4 3h-4l-.4 3.1a7 7 0 0 0-1.7 1l-2.5-1-2 3.4L6 11a7 7 0 0 0 0 2l-2.1 1.5 2 3.4 2.5-1a7 7 0 0 0 1.7 1l.3 3.1h4l.4-3.1a7 7 0 0 0 1.7-1l2.5 1 2-3.4L19 13a7 7 0 0 0 0-1Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            <span>Portal Admin</span>
                        </a>
                    @else
                        <a href="{{ route('profile.edit') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-[#F2F7F4] text-[#155E4B] px-3.5 py-2 rounded-full border border-[#D2E6DC] hover:bg-[#E8F1EC] transition">
                            {{ Str::limit(Auth::user()->name, 12) }}
                        </a>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="p-2 text-slate-400 hover:text-slate-600 rounded-full hover:bg-slate-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @if(Auth::user()->isAdmin())
                                <x-dropdown-link :href="route('dashboard')">Dashboard Admin</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.users.index')">Kelola Pengguna &amp; Donatur</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.laporan-internal.index')">Laporan Keuangan Internal</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.donasi.index')">Verifikasi Donasi</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.donasi.manual.create')">Input Manual Donasi</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.penyaluran.index')">Penyaluran Dana</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.programs.index')">Kelola Program</x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('donations.my-donations')">Riwayat Donasi Saya</x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">Pengaturan Akun</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Keluar (Logout)</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 hover:text-[#155E4B] px-3 py-2 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-xs font-bold bg-[#155E4B] text-white px-4 py-2 rounded-full shadow-sm hover:bg-[#0E4436] active:scale-95 transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- PWA Mobile Bottom Navigation Bar with Big Center Action Button -->
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-50 px-2 py-1.5 pb-[max(.5rem,env(safe-area-inset-bottom))] shadow-[0_-4px_20px_rgba(15,23,42,.08)]">
    <div class="flex justify-between items-end relative">
        <!-- 1. Beranda -->
        <a href="{{ route('landing') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] {{ request()->routeIs('landing') ? 'text-[#155E4B] font-extrabold' : 'text-slate-400 font-medium hover:text-[#155E4B]' }}">
            <svg class="w-5 h-5" fill="{{ request()->routeIs('landing') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path d="M3 11.5 12 4l9 7.5M5 10v10h14V10M9 20v-6h6v6" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Beranda</span>
        </a>

        <!-- 2. Program -->
        <a href="{{ route('programs.index') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] {{ request()->routeIs('programs.*') ? 'text-[#155E4B] font-extrabold' : 'text-slate-400 font-medium hover:text-[#155E4B]' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <rect x="3" y="3" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                <rect x="14" y="3" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                <rect x="3" y="14" width="7" height="7" rx="1.5" stroke-width="1.8"/>
                <rect x="14" y="14" width="7" height="7" rx="1.5" stroke-width="1.8"/>
            </svg>
            <span>Program</span>
        </a>

        <!-- 3. TOMBOL BESAR DI TENGAH (AKSI CEPAT DONASI OPERASIONAL UMUM) -->
        @php
            $operasionalProg = \App\Models\Program::where('slug', 'sedekah-operasional-dakwah-yayasan')
                ->orWhere('nama', 'like', '%operasional%')
                ->first() ?? \App\Models\Program::where('is_active', true)->first();
            $quickDonateUrl = $operasionalProg ? route('programs.show', $operasionalProg->slug) : route('programs.index');
        @endphp
        <div class="flex-1 flex justify-center -mt-6">
            <a href="{{ $quickDonateUrl }}" class="group relative flex flex-col items-center focus:outline-none" aria-label="Aksi Cepat Donasi Operasional Umum">
                <div class="w-14 h-14 rounded-full bg-gradient-to-br from-[#1c775e] to-[#155E4B] text-white flex flex-col items-center justify-center shadow-lg shadow-[#155E4B]/40 border-[3.5px] border-white group-active:scale-95 transition-transform duration-200">
                    <svg class="w-6 h-6 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                </div>
                <span class="text-[9px] font-black text-[#155E4B] tracking-tight mt-0.5">Donasi</span>
            </a>
        </div>

        <!-- 4. Riwayat -->
        <a href="{{ route('donations.my-donations') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] {{ request()->routeIs('donations.my-donations') ? 'text-[#155E4B] font-extrabold' : 'text-slate-400 font-medium hover:text-[#155E4B]' }}">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <circle cx="12" cy="12" r="9" stroke-width="1.8"/>
                <path d="M12 7v5l3 3" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>Riwayat</span>
        </a>

        <!-- 5. Akun -->
        @auth
            @if(Auth::user()->isAdmin())
                <a href="{{ route('dashboard') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] {{ (request()->routeIs('dashboard') || request()->routeIs('admin.*')) ? 'text-[#155E4B] font-extrabold' : 'text-slate-400 font-medium hover:text-[#155E4B]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="12" r="3" stroke-width="1.8"/>
                        <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06A1.7 1.7 0 0 0 16.44 18a1.7 1.7 0 0 0-1 .6V19H13v-.4a1.7 1.7 0 0 0-1-.6 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9 15.44a1.7 1.7 0 0 0-.6-1H8v-2.44h.4A1.7 1.7 0 0 0 9 10.56a1.7 1.7 0 0 0-.34-1.88l-.06-.06L10.02 7.2l.06.06A1.7 1.7 0 0 0 12 7a1.7 1.7 0 0 0 1-.6V6h2.44v.4A1.7 1.7 0 0 0 16.44 7a1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06A1.7 1.7 0 0 0 19.4 10a1.7 1.7 0 0 0 .6 1h.4v2.44H20a1.7 1.7 0 0 0-.6 1Z" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span>Admin</span>
                </a>
            @else
                <a href="{{ route('profile.edit') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] {{ request()->routeIs('profile.*') ? 'text-[#155E4B] font-extrabold' : 'text-slate-400 font-medium hover:text-[#155E4B]' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <circle cx="12" cy="8" r="4" stroke-width="1.8"/>
                        <path d="M4 20c1.5-4 4-6 8-6s6.5 2 8 6" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <span>Akun</span>
                </a>
            @endif
        @else
            <a href="{{ route('login') }}" class="flex flex-1 flex-col items-center gap-1 text-[10px] {{ request()->routeIs('login') ? 'text-[#155E4B] font-extrabold' : 'text-slate-400 font-medium hover:text-[#155E4B]' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="8" r="4" stroke-width="1.8"/>
                    <path d="M4 20c1.5-4 4-6 8-6s6.5 2 8 6" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
                <span>Akun</span>
            </a>
        @endauth
    </div>
</div>
