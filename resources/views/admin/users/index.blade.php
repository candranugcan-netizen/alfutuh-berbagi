<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Kelola Pengguna &amp; Klasemen Donatur</h2>
                <p class="text-xs text-slate-500">Daftar user terdaftar, klasemen infaq tertinggi, riwayat donasi, dan kontrol akun admin</p>
            </div>
            <a href="{{ route('dashboard') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-4 py-2 rounded-full transition self-start sm:self-auto">
                ← Kembali ke Dashboard
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- 3 Kartu Metrik Pengguna -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5">
            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Pengguna</span>
                    <div class="w-8 h-8 rounded-full bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2M9 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm14 10v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <p class="text-xl sm:text-2xl font-black text-slate-800">{{ number_format($totalUserCount, 0, ',', '.') }}</p>
                <p class="text-[10px] text-slate-400">Termasuk donatur dan staf pengurus</p>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Donatur Aktif</span>
                    <div class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <p class="text-xl sm:text-2xl font-black text-[#155E4B]">{{ number_format($totalDonaturTerdaftar, 0, ',', '.') }}</p>
                <p class="text-[10px] text-emerald-700 font-medium">Telah memiliki donasi terverifikasi</p>
            </div>

            <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                <div class="flex justify-between items-center">
                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Akses Administrator</span>
                    <div class="w-8 h-8 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3" stroke-width="1.8"/><path d="M19 12a7 7 0 0 0-.1-1l2-1.5-2-3.4-2.5 1a7 7 0 0 0-1.7-1L14.4 3h-4l-.4 3.1a7 7 0 0 0-1.7 1l-2.5-1-2 3.4L6 11a7 7 0 0 0 0 2l-2.1 1.5 2 3.4 2.5-1a7 7 0 0 0 1.7 1l.3 3.1h4l.4-3.1a7 7 0 0 0 1.7-1l2.5 1 2-3.4L19 13a7 7 0 0 0 0-1Z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </div>
                </div>
                <p class="text-xl sm:text-2xl font-black text-amber-700">{{ number_format($totalAdminCount, 0, ',', '.') }} Akun</p>
                <p class="text-[10px] text-slate-400">Akses penuh panel kontrol yayasan</p>
            </div>
        </div>

        <!-- BAGIAN KLASEMEN 3 BESAR / TOP DONATUR -->
        @if($topDonaturs->isNotEmpty())
            <div class="bg-gradient-to-br from-[#155E4B] via-[#0E4436] to-[#0A3329] rounded-3xl p-5 sm:p-7 text-white shadow-md space-y-4">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-white/10 pb-3">
                    <div class="flex items-center gap-2.5">
                        <span class="text-xl">🏆</span>
                        <div>
                            <h3 class="font-extrabold text-sm sm:text-base tracking-tight">Klasemen Donatur Terbanyak (Top Muhsinin)</h3>
                            <p class="text-xs text-teal-200">Apresiasi donatur dengan akumulasi sedekah terverifikasi tertinggi</p>
                        </div>
                    </div>
                    <span class="text-[10px] font-bold bg-white/10 text-teal-100 px-3 py-1 rounded-full border border-white/10 self-start sm:self-auto">
                        Real-Time
                    </span>
                </div>

                <!-- Grid Podium / Top 5 -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                    @foreach($topDonaturs->take(6) as $index => $top)
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-3.5 border border-white/15 flex items-center justify-between gap-3 hover:bg-white/15 transition">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-sm shrink-0
                                    @if($index === 0) bg-amber-400 text-amber-950 shadow-md shadow-amber-400/30
                                    @elseif($index === 1) bg-slate-200 text-slate-800
                                    @elseif($index === 2) bg-amber-700 text-amber-100
                                    @else bg-white/20 text-white @endif">
                                    #{{ $index + 1 }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="font-extrabold text-xs sm:text-sm text-white truncate">{{ $top->name }}</h4>
                                    <p class="text-[10px] text-teal-200 truncate">{{ $top->email }}</p>
                                    <p class="text-[9px] text-teal-300 font-semibold">{{ $top->total_donasi_count }}x donasi disalurkan</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <span class="text-[9px] text-teal-200 block">Total Donasi:</span>
                                <span class="font-black text-xs sm:text-sm text-amber-300 block">
                                    Rp {{ number_format($top->total_nominal_verified, 0, ',', '.') }}
                                </span>
                                <a href="{{ route('admin.users.show', $top->id) }}" class="text-[10px] text-teal-100 hover:text-white underline font-bold mt-0.5 inline-block">
                                    Riwayat →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- TAB NAVIGASI & PENCARIAN USER -->
        <div class="bg-white rounded-3xl border border-slate-100 p-5 sm:p-6 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <!-- Filter Tabs -->
                <div class="flex gap-2 border-b sm:border-b-0 border-slate-100 pb-2 sm:pb-0 text-xs font-bold">
                    <a href="{{ route('admin.users.index', ['tab' => 'semua', 'q' => $search]) }}"
                       class="px-4 py-2 rounded-full transition {{ $tab === 'semua' ? 'bg-[#155E4B] text-white shadow-xs' : 'bg-[#F2F7F4] text-slate-600 hover:text-[#155E4B]' }}">
                        Semua Pengguna
                    </a>
                    <a href="{{ route('admin.users.index', ['tab' => 'klasemen', 'q' => $search]) }}"
                       class="px-4 py-2 rounded-full transition inline-flex items-center gap-1.5 {{ $tab === 'klasemen' ? 'bg-[#155E4B] text-white shadow-xs' : 'bg-[#F2F7F4] text-slate-600 hover:text-[#155E4B]' }}">
                        <span>🏅 Urut Donasi Terbanyak</span>
                    </a>
                </div>

                <!-- Input Pencarian -->
                <form action="{{ route('admin.users.index') }}" method="GET" class="w-full sm:w-72">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <div class="relative">
                        <input type="text" name="q" value="{{ $search }}" placeholder="Cari nama, email, nomor HP..."
                               class="w-full text-xs pl-9 pr-4 py-2 rounded-full border border-slate-200 focus:border-[#155E4B] focus:ring-[#155E4B]">
                        <span class="absolute left-3 top-2.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6" stroke-width="1.8"/><path d="m16 16 4 4" stroke-width="1.8" stroke-linecap="round"/></svg>
                        </span>
                    </div>
                </form>
            </div>

            <!-- TABEL DAFTAR PENGGUNA -->
            <div class="overflow-x-auto">
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

            <!-- Paginasi Pengguna -->
            @if($users->hasPages())
                <div class="pt-4 border-t border-slate-100">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
