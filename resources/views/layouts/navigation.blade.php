<nav x-data="{ open: false }" class="bg-white border-b border-slate-100 sticky top-0 z-40 shadow-sm">
    <!-- Primary Navigation Menu (Desktop & Mobile Header) -->
    <div class="max-w-5xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between h-16 items-center">
            <!-- Logo & Brand -->
            <div class="flex items-center gap-3">
                <a href="{{ route('landing') }}" class="flex items-center gap-2">
                    <div class="w-10 h-10 rounded-xl bg-teal-600 text-white flex items-center justify-center font-black text-xl shadow-md shadow-teal-600/20">
                        🕌
                    </div>
                    <div>
                        <span class="font-extrabold text-xl text-teal-700 tracking-tight block leading-tight">Al Futuh<span class="text-amber-500">.</span></span>
                        <span class="text-[10px] font-semibold text-slate-400 block -mt-0.5 tracking-wider uppercase">Donasi & Zakat</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Links -->
            <div class="hidden md:flex md:items-center md:gap-1">
                <a href="{{ route('landing') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('landing') ? 'text-teal-700 bg-teal-50' : 'text-slate-600 hover:text-teal-600' }}">
                    Beranda
                </a>
                <a href="{{ route('programs.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('programs.*') ? 'text-teal-700 bg-teal-50' : 'text-slate-600 hover:text-teal-600' }}">
                    Program Donasi
                </a>
                <a href="{{ route('kabars.index') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('kabars.*') ? 'text-teal-700 bg-teal-50' : 'text-slate-600 hover:text-teal-600' }}">
                    Kabar Terbaru
                </a>
                <a href="{{ route('transparansi') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('transparansi') ? 'text-teal-700 bg-teal-50' : 'text-slate-600 hover:text-teal-600' }}">
                    Transparansi
                </a>
                <a href="{{ route('donations.my-donations') }}" class="px-3 py-2 rounded-xl text-xs font-bold transition {{ request()->routeIs('donations.my-donations') ? 'text-teal-700 bg-teal-50' : 'text-slate-600 hover:text-teal-600' }}">
                    Donasi Saya
                </a>
            </div>

            <!-- Right Actions (Auth / Admin) -->
            <div class="flex items-center gap-2">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-teal-600 text-white px-3.5 py-2 rounded-xl shadow-sm hover:bg-teal-700 active:scale-95 transition">
                            <span>⚙️</span> Portal Admin
                        </a>
                    @else
                        <a href="{{ route('donations.my-donations') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-teal-50 text-teal-700 px-3.5 py-2 rounded-xl border border-teal-100 hover:bg-teal-100 transition">
                            <span>👤</span> {{ Str::limit(Auth::user()->name, 12) }}
                        </a>
                    @endif

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="p-2 text-slate-400 hover:text-slate-600 rounded-xl hover:bg-slate-100">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            @if(Auth::user()->isAdmin())
                                <x-dropdown-link :href="route('dashboard')">Dashboard Admin</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.donasi.index')">Verifikasi Donasi</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.donasi.manual.create')">Input Manual Donasi</x-dropdown-link>
                                <x-dropdown-link :href="route('admin.penyaluran.index')">Ambil Donasi / Penyaluran</x-dropdown-link>
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
                    <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 hover:text-teal-600 px-3 py-2 transition">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="text-xs font-bold bg-teal-600 text-white px-4 py-2 rounded-xl shadow-sm hover:bg-teal-700 active:scale-95 transition">
                        Daftar
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>

<!-- PWA Mobile Bottom Navigation Bar (Khusus Layar HP / Mobile App Feel) -->
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 z-50 flex justify-around items-center py-2 px-1 shadow-lg">
    <a href="{{ route('landing') }}" class="flex flex-col items-center text-[10px] {{ request()->routeIs('landing') ? 'text-teal-600 font-extrabold' : 'text-slate-400 font-medium' }}">
        <span class="text-lg">🏠</span>
        <span>Beranda</span>
    </a>
    <a href="{{ route('programs.index') }}" class="flex flex-col items-center text-[10px] {{ request()->routeIs('programs.*') ? 'text-teal-600 font-extrabold' : 'text-slate-400 font-medium' }}">
        <span class="text-lg">🤲</span>
        <span>Program</span>
    </a>
    <a href="{{ route('kabars.index') }}" class="flex flex-col items-center text-[10px] {{ request()->routeIs('kabars.*') ? 'text-teal-600 font-extrabold' : 'text-slate-400 font-medium' }}">
        <span class="text-lg">📰</span>
        <span>Kabar</span>
    </a>
    <a href="{{ route('donations.my-donations') }}" class="flex flex-col items-center text-[10px] {{ request()->routeIs('donations.my-donations') ? 'text-teal-600 font-extrabold' : 'text-slate-400 font-medium' }}">
        <span class="text-lg">📜</span>
        <span>Donasi Saya</span>
    </a>
    @auth
        @if(Auth::user()->isAdmin())
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center text-[10px] {{ request()->routeIs('dashboard') ? 'text-teal-600 font-extrabold' : 'text-slate-400 font-medium' }}">
                <span class="text-lg">⚙️</span>
                <span>Admin</span>
            </a>
        @else
            <a href="{{ route('profile.edit') }}" class="flex flex-col items-center text-[10px] {{ request()->routeIs('profile.*') ? 'text-teal-600 font-extrabold' : 'text-slate-400 font-medium' }}">
                <span class="text-lg">👤</span>
                <span>Akun</span>
            </a>
        @endif
    @else
        <a href="{{ route('login') }}" class="flex flex-col items-center text-[10px] {{ request()->routeIs('login') ? 'text-teal-600 font-extrabold' : 'text-slate-400 font-medium' }}">
            <span class="text-lg">🔑</span>
            <span>Masuk</span>
        </a>
    @endauth
</div>
