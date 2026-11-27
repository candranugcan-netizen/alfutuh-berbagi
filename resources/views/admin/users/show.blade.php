<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-2.5">
            <div class="min-w-0">
                <h2 class="font-extrabold text-lg sm:text-xl text-slate-800 leading-tight truncate">Detail Pengguna</h2>
                <p class="text-[11px] sm:text-xs text-slate-500 truncate">Profil donatur &amp; riwayat transaksi</p>
            </div>
            <div class="flex items-center gap-1.5 sm:gap-2 shrink-0">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center gap-1 text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 sm:px-4 sm:py-2 rounded-full transition shadow-xs active:scale-95">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="1.8"/></svg>
                    <span>Edit</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full transition">
                    ← <span class="hidden sm:inline">Daftar</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-4 sm:space-y-6">

        <!-- Kartu Profil Pengguna & Ringkasan Metrik -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 p-4 sm:p-7 shadow-xs sm:shadow-sm space-y-4 sm:space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-slate-100 pb-4 sm:pb-5">
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 rounded-xl sm:rounded-2xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center font-black text-xl sm:text-2xl shrink-0 shadow-2xs">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2">
                            <h3 class="font-extrabold text-base sm:text-xl text-slate-800 truncate">{{ $user->name }}</h3>
                            @if($user->role === 'admin')
                                <span class="text-[9px] sm:text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200 shrink-0">
                                    Admin
                                </span>
                            @else
                                <span class="text-[9px] sm:text-[10px] font-bold px-2 py-0.5 rounded-full bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC] shrink-0">
                                    Donatur
                                </span>
                            @endif
                        </div>
                        <p class="text-[11px] sm:text-xs text-slate-400 mt-0.5">Bergabung sejak {{ $user->created_at->format('d M Y, H:i') }} WIB</p>
                    </div>
                </div>

                <!-- Tombol Hapus User (Hanya jika bukan akun sendiri) -->
                @if($user->id !== Auth::id())
                    <div class="self-start sm:self-auto pt-1 sm:pt-0">
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus akun user ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-full transition active:scale-95">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="1.8"/></svg>
                                <span>Hapus Akun</span>
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Detail Info & Kontak Grid Responsif -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 sm:gap-4 text-xs">
                <!-- 1. Email -->
                <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-[#F8FAF8] border border-slate-100 space-y-1">
                    <span class="text-slate-400 text-[9px] sm:text-[10px] uppercase font-bold tracking-wider block">Alamat Email</span>
                    <span class="font-extrabold text-slate-800 text-xs sm:text-sm block break-all">{{ $user->email }}</span>
                    <span class="text-[10px] text-emerald-600 font-semibold block">Tervalidasi di sistem</span>
                </div>

                <!-- 2. WhatsApp / HP -->
                <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-[#F8FAF8] border border-slate-100 space-y-1">
                    <span class="text-slate-400 text-[9px] sm:text-[10px] uppercase font-bold tracking-wider block">Nomor WhatsApp / HP</span>
                    @if($user->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone) }}" target="_blank"
                           class="font-extrabold text-[#155E4B] hover:underline text-xs sm:text-sm inline-flex items-center gap-1.5">
                            <span>📱</span>
                            <span>{{ $user->phone }}</span>
                        </a>
                        <span class="text-[10px] text-slate-400 block">Klik untuk hubungi via WA</span>
                    @else
                        <span class="font-bold text-slate-400 text-xs sm:text-sm block">Belum Ditambahkan</span>
                        <span class="text-[10px] text-slate-300 block">-</span>
                    @endif
                </div>

                <!-- 3. Total Donasi Terverifikasi -->
                <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-[#EAF5EE] border border-[#D2E6DC] space-y-1">
                    <span class="text-[#155E4B] text-[9px] sm:text-[10px] uppercase font-black tracking-wider block">Donasi Terverifikasi</span>
                    <span class="font-black text-lg sm:text-xl text-[#155E4B] block">
                        Rp {{ number_format($user->total_nominal_verified ?? 0, 0, ',', '.') }}
                    </span>
                    <span class="text-[10px] text-[#155E4B] font-bold block">{{ $user->total_donasi_count ?? 0 }} transaksi berhasil</span>
                </div>
            </div>
        </div>

        <!-- DAFTAR RIWAYAT TRANSAKSI DONASI USER -->
        <div class="bg-white rounded-2xl sm:rounded-3xl border border-slate-100 p-3.5 sm:p-6 shadow-xs sm:shadow-sm space-y-3 sm:space-y-4">
            <div class="flex items-center justify-between border-b border-slate-100 pb-2.5 sm:pb-3">
                <div>
                    <h3 class="font-extrabold text-xs sm:text-base text-slate-800">Riwayat Seluruh Donasi</h3>
                    <p class="text-[10px] sm:text-xs text-slate-400">Transaksi dan penyaluran dari akun ini</p>
                </div>
                <span class="text-[11px] sm:text-xs font-bold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                    {{ $donations->total() }} Catatan
                </span>
            </div>

            <!-- TAMPILAN 1: KARTU RIWAYAT DONASI MOBILE (< 768px) -->
            <div class="block md:hidden space-y-2.5">
                @forelse($donations as $d)
                    <div class="bg-slate-50/70 p-3 rounded-2xl border border-slate-100 space-y-2">
                        <!-- Baris Atas: Kode Donasi & Status -->
                        <div class="flex items-center justify-between gap-2">
                            <span class="font-mono text-[11px] font-bold text-slate-700 bg-white px-2 py-0.5 rounded-lg border border-slate-200">
                                {{ $d->kode_donasi }}
                            </span>
                            <span class="text-[9px] font-bold px-2 py-0.5 rounded-full
                                @if($d->status === 'verified') bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC]
                                @elseif($d->status === 'pending_verification') bg-sky-50 text-sky-700 border border-sky-100
                                @elseif($d->status === 'rejected') bg-rose-50 text-rose-700 border border-rose-100
                                @else bg-amber-50 text-amber-800 border border-amber-200 @endif">
                                {{ $d->status_label }}
                            </span>
                        </div>

                        <!-- Baris Tengah: Program & Bank -->
                        <div>
                            <h4 class="font-bold text-xs text-slate-800 leading-snug">
                                {{ $d->program->nama ?? 'Program Dihapus' }}
                            </h4>
                            <p class="text-[10px] text-slate-500 mt-0.5">
                                Bank: <span class="font-semibold text-slate-700">{{ $d->bank_tujuan }}</span>
                                <span class="text-slate-300 mx-1">•</span>
                                {{ $d->created_at->format('d M Y, H:i') }} WIB
                            </p>
                        </div>

                        <!-- Baris Bawah: Nominal & Link Detail -->
                        <div class="flex items-center justify-between pt-1 border-t border-slate-200/60">
                            <div>
                                <span class="text-[9px] text-slate-400 block leading-tight">Nominal</span>
                                <span class="font-black text-xs text-[#155E4B]">
                                    Rp {{ number_format($d->nominal, 0, ',', '.') }}
                                </span>
                            </div>
                            <a href="{{ route('donations.payment', $d->kode_donasi) }}" target="_blank"
                               class="inline-flex items-center gap-1 text-[11px] font-bold text-[#155E4B] bg-white border border-[#D2E6DC] px-2.5 py-1 rounded-xl shadow-2xs hover:bg-[#EAF5EE] transition">
                                <span>Detail</span>
                                <span>→</span>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center text-slate-400 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                        <p class="text-xs font-bold">Belum ada donasi dari pengguna ini</p>
                    </div>
                @endforelse
            </div>

            <!-- TAMPILAN 2: TABEL RIWAYAT DONASI DESKTOP (>= 768px) -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-[10px] text-slate-400 uppercase tracking-wider font-bold">
                            <th class="py-3 px-3">Kode Donasi</th>
                            <th class="py-3 px-3">Program Tujuan</th>
                            <th class="py-3 px-3">Waktu Transaksi</th>
                            <th class="py-3 px-3">Bank</th>
                            <th class="py-3 px-3 text-right">Nominal</th>
                            <th class="py-3 px-3 text-center">Status</th>
                            <th class="py-3 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($donations as $d)
                            <tr class="hover:bg-slate-50/70 transition">
                                <td class="py-3 px-3 font-mono font-bold text-slate-700">
                                    {{ $d->kode_donasi }}
                                </td>
                                <td class="py-3 px-3 font-extrabold text-slate-800">
                                    {{ $d->program->nama ?? 'Program Dihapus' }}
                                </td>
                                <td class="py-3 px-3 text-slate-500 text-[11px]">
                                    {{ $d->created_at->format('d M Y, H:i') }} WIB
                                </td>
                                <td class="py-3 px-3 text-slate-600 font-semibold">
                                    {{ $d->bank_tujuan }}
                                </td>
                                <td class="py-3 px-3 text-right font-black text-sm text-[#155E4B]">
                                    Rp {{ number_format($d->nominal, 0, ',', '.') }}
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full
                                        @if($d->status === 'verified') bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC]
                                        @elseif($d->status === 'pending_verification') bg-sky-50 text-sky-700 border border-sky-100
                                        @elseif($d->status === 'rejected') bg-rose-50 text-rose-700 border border-rose-100
                                        @else bg-amber-50 text-amber-800 border border-amber-200 @endif">
                                        {{ $d->status_label }}
                                    </span>
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <a href="{{ route('donations.payment', $d->kode_donasi) }}" target="_blank" class="text-xs font-bold text-[#155E4B] hover:underline">
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-slate-400">
                                    Pengguna ini belum pernah melakukan transaksi donasi.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Footer Paginasi Riwayat Donasi -->
            <div class="pt-3.5 border-t border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-3 text-xs text-slate-500">
                <span class="text-[11px] sm:text-xs">
                    Menampilkan <span class="font-bold text-slate-700">{{ $donations->firstItem() ?? 0 }}</span> - <span class="font-bold text-slate-700">{{ $donations->lastItem() ?? 0 }}</span> dari total <span class="font-bold text-[#155E4B]">{{ $donations->total() }}</span> riwayat donasi
                </span>

                @if($donations->hasPages())
                    <div class="overflow-x-auto self-center sm:self-auto">
                        {{ $donations->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
