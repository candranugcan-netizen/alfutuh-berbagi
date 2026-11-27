<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-3">
            <div class="min-w-0">
                <h2 class="font-extrabold text-lg sm:text-xl text-slate-800 leading-tight truncate">Kelola Pengguna</h2>
                <p class="text-[11px] sm:text-xs text-slate-500 truncate">Daftar user, klasemen donatur, dan kontrol akun</p>
            </div>
            <a href="{{ route('dashboard') }}" class="shrink-0 text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full transition flex items-center gap-1 shadow-2xs">
                <span>←</span>
                <span class="hidden sm:inline">Kembali ke</span>
                <span>Dashboard</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-4 sm:space-y-6">

        <!-- 3 Kartu Metrik Pengguna (Grid 3 Kolom Responsif) -->
        <div class="grid grid-cols-3 gap-2 sm:gap-3.5">
            <!-- 1. Total Pengguna -->
            <div class="bg-white p-3 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs flex flex-col justify-between">
                <div class="flex justify-between items-start gap-1">
                    <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider leading-tight">Total User</span>
                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm14 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-base sm:text-2xl font-black text-slate-800 leading-tight">{{ number_format($totalUserCount, 0, ',', '.') }}</p>
                    <p class="text-[9px] sm:text-[10px] text-slate-400 hidden sm:block mt-0.5">Semua akun terdaftar</p>
                </div>
            </div>

            <!-- 2. Donatur Aktif -->
            <div class="bg-white p-3 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs flex flex-col justify-between">
                <div class="flex justify-between items-start gap-1">
                    <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider leading-tight">Donatur</span>
                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-base sm:text-2xl font-black text-[#155E4B] leading-tight">{{ number_format($totalDonaturTerdaftar, 0, ',', '.') }}</p>
                    <p class="text-[9px] sm:text-[10px] text-emerald-700 hidden sm:block mt-0.5">Donasi terverifikasi</p>
                </div>
            </div>

            <!-- 3. Admin -->
            <div class="bg-white p-3 sm:p-5 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs flex flex-col justify-between">
                <div class="flex justify-between items-start gap-1">
                    <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider leading-tight">Admin</span>
                    <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" stroke-width="1.8"/><path d="M19 12a7 7 0 0 0-.1-1l2-1.5-2-3.4-2.5 1a7 7 0 0 0-1.7-1L14.4 3h-4l-.4 3.1a7 7 0 0 0-1.7 1l-2.5-1-2 3.4L6 11a7 7 0 0 0 0 2l-2.1 1.5 2 3.4 2.5-1a7 7 0 0 0 1.7 1l.3 3.1h4l.4-3.1a7 7 0 0 0 1.7-1l2.5 1 2-3.4L19 13a7 7 0 0 0 0-1Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <div class="mt-2">
                    <p class="text-base sm:text-2xl font-black text-amber-700 leading-tight">{{ number_format($totalAdminCount, 0, ',', '.') }}</p>
                    <p class="text-[9px] sm:text-[10px] text-slate-400 hidden sm:block mt-0.5">Akses pengurus</p>
                </div>
            </div>
        </div>

        <!-- BAGIAN KLASEMEN TOP DONATUR (TOP MUHSININ) -->
        @if($topDonaturs->isNotEmpty())
            <div class="bg-gradient-to-br from-[#155E4B] via-[#0E4436] to-[#0A3329] rounded-2xl sm:rounded-3xl p-4 sm:p-6 text-white shadow-md space-y-3 sm:space-y-4">
                <div class="flex items-center justify-between border-b border-white/10 pb-2.5">
                    <div class="flex items-center gap-2">
                        <span class="text-lg sm:text-xl">🏆</span>
                        <div>
                            <h3 class="font-extrabold text-xs sm:text-sm tracking-tight leading-snug">Klasemen Donatur Terbanyak</h3>
                            <p class="text-[10px] sm:text-xs text-teal-200">Top Muhsinin dengan donasi terverifikasi tertinggi</p>
                        </div>
                    </div>
                    <span class="text-[9px] sm:text-[10px] font-bold bg-white/10 text-teal-100 px-2.5 py-0.5 rounded-full border border-white/10 shrink-0">
                        Top {{ $topDonaturs->take(6)->count() }}
                    </span>
                </div>

                <!-- Grid Podium / Top List -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-3">
                    @foreach($topDonaturs->take(6) as $index => $top)
                        <div class="bg-white/10 backdrop-blur-md rounded-xl sm:rounded-2xl p-2.5 sm:p-3.5 border border-white/15 flex items-center justify-between gap-2.5 hover:bg-white/15 transition">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl flex items-center justify-center font-black text-xs sm:text-sm shrink-0
                                    @if($index === 0) bg-amber-400 text-amber-950 shadow-xs shadow-amber-400/40
                                    @elseif($index === 1) bg-slate-200 text-slate-800
                                    @elseif($index === 2) bg-amber-700 text-amber-100
                                    @else bg-white/20 text-white @endif">
                                    #{{ $index + 1 }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-extrabold text-xs sm:text-sm text-white truncate leading-tight">{{ $top->name }}</h4>
                                    <p class="text-[9px] sm:text-[10px] text-teal-200 truncate">{{ $top->email }}</p>
                                    <p class="text-[9px] text-teal-300 font-semibold">{{ $top->total_donasi_count }}x transaksi</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="font-black text-xs sm:text-sm text-amber-300 block">
                                    Rp {{ number_format($top->total_nominal_verified, 0, ',', '.') }}
                                </span>
                                <a href="{{ route('admin.users.show', $top->id) }}" class="text-[10px] text-teal-100 hover:text-white underline font-bold inline-block mt-0.5">
                                    Riwayat →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- TAB NAVIGASI & PENCARIAN USER -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 p-3.5 sm:p-6 shadow-xs sm:shadow-sm space-y-3 sm:space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-3">
                <!-- Segmented Filter Tabs Mobile & Desktop -->
                <div class="grid grid-cols-2 sm:flex gap-1.5 p-1 bg-slate-100 rounded-xl sm:rounded-full text-xs font-bold">
                    <a href="{{ route('admin.users.index', ['tab' => 'semua', 'q' => $search, 'per_page' => $perPage]) }}"
                       class="text-center px-3 sm:px-4 py-2 rounded-lg sm:rounded-full transition {{ $tab === 'semua' ? 'bg-[#155E4B] text-white shadow-2xs' : 'text-slate-600 hover:text-[#155E4B]' }}">
                        Semua Pengguna
                    </a>
                    <a href="{{ route('admin.users.index', ['tab' => 'klasemen', 'q' => $search, 'per_page' => $perPage]) }}"
                       class="text-center px-3 sm:px-4 py-2 rounded-lg sm:rounded-full transition inline-flex items-center justify-center gap-1 {{ $tab === 'klasemen' ? 'bg-[#155E4B] text-white shadow-2xs' : 'text-slate-600 hover:text-[#155E4B]' }}">
                        <span>🏅</span>
                        <span class="truncate">Urut Donasi</span>
                    </a>
                </div>

                <!-- Input Pencarian -->
                <form action="{{ route('admin.users.index') }}" method="GET" class="w-full sm:w-72">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="hidden" name="per_page" value="{{ $perPage }}">
                    <div class="relative">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, email, nomor HP..."
                               class="w-full text-xs pl-9 pr-8 py-2.5 rounded-xl sm:rounded-full border border-slate-200 focus:border-[#155E4B] focus:ring-[#155E4B] placeholder:text-slate-400">
                        <span class="absolute left-3 top-3 text-slate-400">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6" stroke-width="1.8"/><path d="m16 16 4 4" stroke-width="1.8" stroke-linecap="round"/></svg>
                        </span>
                        @if($search)
                            <a href="{{ route('admin.users.index', ['tab' => $tab, 'per_page' => $perPage]) }}" class="absolute right-3 top-2.5 text-slate-400 hover:text-slate-600 text-xs">✕</a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- TAMPILAN 1: DAFTAR KARTU MOBILE (Hanya Tampil di Layar Kecil < 768px) -->
            <div class="block md:hidden space-y-2.5">
                @forelse($users as $index => $u)
                    <div class="bg-slate-50/70 p-3.5 rounded-2xl border border-slate-100 space-y-2.5">
                        <!-- Baris Atas: User Info & Role -->
                        <div class="flex items-start justify-between gap-2">
                            <div class="flex items-center gap-2.5 min-w-0">
                                <div class="w-9 h-9 rounded-xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center font-bold text-xs shrink-0">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <a href="{{ route('admin.users.show', $u->id) }}" class="font-extrabold text-xs text-slate-800 hover:text-[#155E4B] block truncate">
                                        {{ $u->name }}
                                    </a>
                                    <span class="text-[10px] text-slate-400 block">Gabung {{ $u->created_at->format('d M Y') }}</span>
                                </div>
                            </div>
                            <!-- Role Badge -->
                            <div class="shrink-0">
                                @if($u->role === 'admin')
                                    <span class="text-[9px] font-extrabold px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200">
                                        Admin
                                    </span>
                                @else
                                    <span class="text-[9px] font-bold px-2 py-0.5 rounded-full bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC]">
                                        Donatur
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Baris Kontak (Email & WA) -->
                        <div class="bg-white p-2.5 rounded-xl border border-slate-100 flex flex-wrap items-center justify-between gap-1 text-[11px]">
                            <div class="truncate text-slate-600 max-w-[180px]">
                                ✉️ {{ $u->email }}
                            </div>
                            @if($u->phone)
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $u->phone) }}" target="_blank"
                                   class="inline-flex items-center gap-1 font-bold text-[#155E4B] bg-[#EAF5EE] px-2 py-0.5 rounded-lg shrink-0">
                                    <span>📱</span>
                                    <span>{{ $u->phone }}</span>
                                </a>
                            @else
                                <span class="text-slate-300 text-[10px]">-</span>
                            @endif
                        </div>

                        <!-- Baris Donasi & Frekuensi -->
                        <div class="flex items-center justify-between text-xs bg-emerald-50/50 p-2.5 rounded-xl border border-emerald-100/60">
                            <div>
                                <span class="text-[9px] text-slate-400 block font-semibold">Total Donasi Terverifikasi</span>
                                <span class="font-black text-xs text-[#155E4B]">
                                    Rp {{ number_format($u->total_nominal_verified ?? 0, 0, ',', '.') }}
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-[9px] text-slate-400 block font-semibold">Frekuensi</span>
                                <span class="font-extrabold text-xs text-slate-700 bg-white px-2 py-0.5 rounded-md border border-slate-200">
                                    {{ $u->total_donasi_count ?? 0 }}x Donasi
                                </span>
                            </div>
                        </div>

                        <!-- Baris Tombol Aksi Mobile (Mudah Ditekan) -->
                        <div class="flex items-center gap-1.5 pt-0.5">
                            <a href="{{ route('admin.users.show', $u->id) }}"
                               class="flex-1 inline-flex items-center justify-center gap-1.5 py-2 px-3 rounded-xl bg-[#155E4B] text-white text-xs font-bold active:scale-95 transition shadow-2xs">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="1.8"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="1.8"/></svg>
                                <span>Riwayat</span>
                            </a>
                            <a href="{{ route('admin.users.edit', $u->id) }}"
                               class="inline-flex items-center justify-center gap-1 py-2 px-3 rounded-xl bg-blue-50 text-blue-700 border border-blue-200 text-xs font-bold active:scale-95 transition">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="1.8"/></svg>
                                <span>Edit</span>
                            </a>
                            @if($u->id !== Auth::id())
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $u->name }}? Riwayat donasi tetap aman tersimpan.');"
                                      class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="py-2 px-3 rounded-xl bg-rose-50 text-rose-600 border border-rose-200 text-xs font-bold active:scale-95 transition" title="Hapus">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="1.8"/></svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="py-8 text-center text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <span class="text-2xl block mb-1">🔍</span>
                        <p class="text-xs font-bold">Tidak ada pengguna yang cocok</p>
                    </div>
                @endforelse
            </div>

            <!-- TAMPILAN 2: TABEL DESKTOP (Hanya Tampil di Layar Tablet & Desktop >= 768px) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3 px-3">No</th>
                            <th class="py-3 px-3">Pengguna</th>
                            <th class="py-3 px-3">Kontak</th>
                            <th class="py-3 px-3">Peran / Role</th>
                            <th class="py-3 px-3 text-right">Total Donasi</th>
                            <th class="py-3 px-3 text-center">Frekuensi</th>
                            <th class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $index => $u)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-3 text-slate-400 font-mono text-[11px]">
                                    {{ $users->firstItem() + $index }}
                                </td>
                                <td class="py-3 px-3">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-full bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center font-bold text-xs shrink-0">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('admin.users.show', $u->id) }}" class="font-extrabold text-slate-800 hover:text-[#155E4B] block leading-snug">
                                                {{ $u->name }}
                                            </a>
                                            <span class="text-[10px] text-slate-400">Bergabung {{ $u->created_at->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-3">
                                    <span class="block text-slate-600 font-medium">{{ $u->email }}</span>
                                    @if($u->phone)
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $u->phone) }}" target="_blank" class="text-[10px] text-[#155E4B] hover:underline font-bold">
                                            {{ $u->phone }}
                                        </a>
                                    @else
                                        <span class="text-[10px] text-slate-400">-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3">
                                    @if($u->role === 'admin')
                                        <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200">
                                            Administrator
                                        </span>
                                    @else
                                        <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC]">
                                            Donatur
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-right">
                                    <span class="font-black text-sm text-[#155E4B]">
                                        Rp {{ number_format($u->total_nominal_verified ?? 0, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="text-xs font-bold text-slate-700 bg-slate-100 px-2 py-0.5 rounded-full">
                                        {{ $u->total_donasi_count ?? 0 }}x
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Lihat Riwayat Donasi -->
                                        <a href="{{ route('admin.users.show', $u->id) }}" class="p-1.5 rounded-xl text-slate-600 hover:text-[#155E4B] hover:bg-[#EAF5EE] transition" title="Lihat Riwayat Donasi">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" stroke-width="1.8"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="1.8"/></svg>
                                        </a>

                                        <!-- Edit User -->
                                        <a href="{{ route('admin.users.edit', $u->id) }}" class="p-1.5 rounded-xl text-blue-600 hover:text-blue-800 hover:bg-blue-50 transition" title="Edit Akun Pengguna">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        </a>

                                        <!-- Hapus User -->
                                        @if($u->id !== Auth::id())
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user {{ $u->name }}? Riwayat donasi donatur tetap aman tersimpan.');" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1.5 rounded-xl text-rose-500 hover:text-rose-700 hover:bg-rose-50 transition" title="Hapus Pengguna">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    Tidak ada data pengguna yang ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Paginasi & Keterangan Halaman -->
            <div class="pt-3.5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
                <div class="flex items-center justify-between sm:justify-start gap-3">
                    <span class="text-[11px] sm:text-xs">
                        Menampilkan <span class="font-bold text-slate-700">{{ $users->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-700">{{ $users->lastItem() ?? 0 }}</span> dari <span class="font-bold text-[#155E4B]">{{ $users->total() }}</span> user
                    </span>

                    <!-- Dropdown Pilihan Jumlah Baris Per Halaman -->
                    <div class="flex items-center gap-1 text-[11px]">
                        <span class="text-slate-400 hidden sm:inline">Per hal:</span>
                        <select onchange="window.location.href = this.value" class="text-[11px] py-1 px-2 rounded-lg border border-slate-200 bg-white font-bold text-slate-700 focus:border-[#155E4B] focus:ring-0">
                            @foreach([10, 15, 25, 50] as $size)
                                <option value="{{ request()->fullUrlWithQuery(['per_page' => $size, 'page' => 1]) }}" {{ $perPage == $size ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @if($users->hasPages())
                    <div class="overflow-x-auto self-center sm:self-auto">
                        {{ $users->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
