<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Detail Pengguna &amp; Riwayat Donasi</h2>
                <p class="text-xs text-slate-500">Profil akun donatur, ringkasan sedekah, dan rincian transaksi</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-full transition shadow-xs">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="1.8"/></svg>
                    <span>Edit Akun</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-4 py-2 rounded-full transition">
                    ← Kembali
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">

        <!-- Kartu Profil Pengguna & Ringkasan Metrik -->
        <div class="bg-white rounded-3xl border border-slate-100 p-6 sm:p-7 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-slate-100 pb-5">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 rounded-2xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center font-black text-2xl shrink-0 shadow-xs">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-extrabold text-lg sm:text-xl text-slate-800">{{ $user->name }}</h3>
                            @if($user->role === 'admin')
                                <span class="text-[10px] font-extrabold px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 border border-amber-200">
                                    Admin
                                </span>
                            @else
                                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC]">
                                    Donatur
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-500 mt-0.5">Bergabung sejak {{ $user->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>

                <!-- Tombol Hapus User (Hanya jika bukan akun sendiri) -->
                @if($user->id !== Auth::id())
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus akun user ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-1.5 text-xs font-bold text-rose-600 hover:text-white bg-rose-50 hover:bg-rose-600 border border-rose-200 px-4 py-2 rounded-full transition active:scale-95">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="1.8"/></svg>
                            <span>Hapus Akun Pengguna</span>
                        </button>
                    </form>
                @endif
            </div>

            <!-- Detail Info & Kontak -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                <div class="p-4 rounded-2xl bg-[#F8FAF8] border border-slate-100 space-y-1">
                    <span class="text-slate-400 text-[10px] uppercase font-bold tracking-wider block">Alamat Email</span>
                    <span class="font-extrabold text-slate-800 text-sm block">{{ $user->email }}</span>
                    <span class="text-[10px] text-emerald-600 font-semibold">Tervalidasi di sistem</span>
                </div>

                <div class="p-4 rounded-2xl bg-[#F8FAF8] border border-slate-100 space-y-1">
                    <span class="text-slate-400 text-[10px] uppercase font-bold tracking-wider block">Nomor WhatsApp / HP</span>
                    @if($user->phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $user->phone) }}" target="_blank" class="font-extrabold text-[#155E4B] hover:underline text-sm block">
                            {{ $user->phone }}
                        </a>
                        <span class="text-[10px] text-slate-400">Klik untuk hubungi via WA</span>
                    @else
                        <span class="font-bold text-slate-400 text-sm block">Belum Ditambahkan</span>
                        <span class="text-[10px] text-slate-400">-</span>
                    @endif
                </div>

                <div class="p-4 rounded-2xl bg-[#EAF5EE] border border-[#D2E6DC] space-y-1">
                    <span class="text-[#155E4B] text-[10px] uppercase font-black tracking-wider block">Akumulasi Donasi Terverifikasi</span>
                    <span class="font-black text-xl text-[#155E4B] block">
                        Rp {{ number_format($user->total_nominal_verified ?? 0, 0, ',', '.') }}
                    </span>
                    <span class="text-[10px] text-[#155E4B] font-bold">{{ $user->total_donasi_count ?? 0 }} transaksi berhasil</span>
                </div>
            </div>
        </div>

        <!-- DAFTAR RIWAYAT TRANSAKSI DONASI USER -->
        <div class="bg-white rounded-3xl border border-slate-100 p-5 sm:p-6 shadow-sm space-y-4">
            <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                <div>
                    <h3 class="font-extrabold text-sm sm:text-base text-slate-800">Riwayat Seluruh Donasi</h3>
                    <p class="text-xs text-slate-400">Semua riwayat pengajuan dan bukti transfer yang dilakukan oleh akun ini</p>
                </div>
                <span class="text-xs font-bold text-slate-500">
                    Total {{ $donations->total() }} Catatan
                </span>
            </div>

            <div class="overflow-x-auto">
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

            <!-- Paginasi Riwayat Donasi -->
            @if($donations->hasPages())
                <div class="pt-3 border-t border-slate-100">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
