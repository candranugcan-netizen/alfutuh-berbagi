<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header Page -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Riwayat Donasi Saya</h1>
                <p class="text-xs text-slate-500 mt-0.5">Pantau status transfer, bukti donasi, dan total akumulasi kebaikan Anda</p>
            </div>
            <a href="{{ route('transparansi') }}" class="inline-flex items-center justify-center gap-1.5 text-xs font-bold bg-[#EAF5EE] text-[#155E4B] hover:bg-[#155E4B] hover:text-white border border-[#D2E6DC] px-4 py-2.5 rounded-full transition active:scale-95 shadow-2xs self-start sm:self-auto shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span>Transparansi Dana</span>
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
        </div>

        <!-- Kartu Total Donasi yang Dilakukan oleh User -->
        @if(Auth::check() || isset($isSearch))
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                <!-- Total Donasi Terverifikasi / Berhasil -->
                <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Total Donasi Disalurkan</span>
                        <div class="w-7 h-7 rounded-full bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                    </div>
                    <p class="text-xl sm:text-2xl font-black text-[#155E4B]">
                        Rp {{ number_format($totalDonasiBerhasil ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-[10px] text-slate-400">
                        {{ $totalTransaksiCount ?? 0 }} riwayat transaksi tercatat
                    </p>
                </div>

                <!-- Total Donasi Menunggu Verifikasi / Pembayaran -->
                <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-1">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Menunggu Verifikasi</span>
                        <div class="w-7 h-7 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path d="M12 7v5l3 3" stroke-width="2" stroke-linecap="round"/></svg>
                        </div>
                    </div>
                    <p class="text-xl sm:text-2xl font-black text-amber-600">
                        Rp {{ number_format($totalDonasiPending ?? 0, 0, ',', '.') }}
                    </p>
                    <p class="text-[10px] text-slate-400">
                        Dalam proses transfer / cek admin
                    </p>
                </div>
            </div>
        @endif

        <!-- Form Lacak Donasi Tamu (Untuk Donatur Guest) -->
        <div class="bg-white p-6 sm:p-7 rounded-3xl border border-slate-100 shadow-sm space-y-3.5">
            <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider flex items-center gap-1.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#155E4B]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <circle cx="11" cy="11" r="6" stroke-width="2"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 16l4 4"/>
                </svg>
                <span>Cek Status Donasi Tamu (Guest)</span>
            </h3>
            <p class="text-xs text-slate-500 leading-relaxed">
                Jika Anda berdonasi tanpa login, masukkan <strong>Kode Donasi</strong> (contoh: <code>ALF-20261120-XXXX</code>) atau <strong>Nomor WhatsApp</strong> Anda:
            </p>
            <form action="{{ route('donations.track-guest') }}" method="POST" class="flex gap-2 pt-1">
                @csrf
                <input type="text" name="query" value="{{ $searchQuery ?? '' }}" required placeholder="Contoh: ALF-20261120-XXXX atau 081234..."
                    class="w-full text-xs border border-slate-200 rounded-full focus:border-[#155E4B] focus:ring-[#155E4B] px-4 py-2.5">
                <button type="submit" class="bg-[#155E4B] hover:bg-[#0E4436] text-white font-bold text-xs px-6 py-2.5 rounded-full shrink-0 transition active:scale-95 shadow-sm">
                    Lacak
                </button>
            </form>
        </div>

        <!-- Daftar Riwayat Donasi -->
        <div class="space-y-3.5">
            <div class="flex justify-between items-center px-1">
                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider">
                    {{ isset($isSearch) ? 'Hasil Pencarian Donasi' : 'Daftar Donasi Anda' }}
                </h3>
                @if(method_exists($donations, 'total'))
                    <span class="text-[11px] font-bold text-slate-400">
                        Total {{ $donations->total() }} Transaksi
                    </span>
                @endif
            </div>

            @forelse($donations as $item)
                <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                    <div class="flex justify-between items-start">
                        <div class="space-y-0.5">
                            <span class="text-[10px] font-mono text-slate-400 block">{{ $item->kode_donasi }}</span>
                            <h4 class="font-extrabold text-sm sm:text-base text-slate-800 leading-snug">{{ $item->program->nama }}</h4>
                            <p class="text-[11px] text-slate-400">📅 {{ $item->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                        <span class="inline-block text-[10px] font-bold px-3 py-1 rounded-full
                            @if($item->status === 'verified') bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC]
                            @elseif($item->status === 'pending_verification') bg-sky-50 text-sky-700 border border-sky-100
                            @elseif($item->status === 'rejected') bg-rose-50 text-rose-700 border border-rose-100
                            @else bg-amber-50 text-amber-800 border border-amber-200 @endif">
                            {{ $item->status_label }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center pt-3 border-t border-slate-50 text-xs">
                        <div>
                            <span class="text-slate-400 text-[10px] block">Nominal Donasi:</span>
                            <span class="font-black text-[#155E4B] text-sm sm:text-base">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('donations.payment', $item->kode_donasi) }}" class="text-xs font-bold text-[#155E4B] hover:text-white bg-[#F2F7F4] hover:bg-[#155E4B] px-4 py-2 rounded-full transition active:scale-95 shadow-xs">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-3xl border border-slate-100 space-y-3">
                    <svg class="w-12 h-12 mx-auto text-[#155E4B]" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <h4 class="text-sm font-bold text-slate-700">Belum ada catatan donasi</h4>
                    <p class="text-xs text-slate-400">Pilihlah salah satu program kebaikan untuk memulai sedekah Anda.</p>
                    <div class="pt-2">
                        <a href="{{ route('programs.index') }}" class="inline-block bg-[#155E4B] hover:bg-[#0E4436] text-white font-bold text-xs px-7 py-2.5 rounded-full shadow-sm transition">
                            Eksplor Program Donasi
                        </a>
                    </div>
                </div>
            @endforelse

            <!-- Paginasi Riwayat Donasi -->
            @if(method_exists($donations, 'links') && $donations->hasPages())
                <div class="pt-4">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
