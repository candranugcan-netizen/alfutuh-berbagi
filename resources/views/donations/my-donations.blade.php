<x-app-layout>
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Header Page -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Riwayat Donasi Saya</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pantau status transfer, bukti donasi, dan transparansi amanah Anda</p>
        </div>

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
            <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider px-1">
                {{ isset($isSearch) ? 'Hasil Pencarian Donasi' : 'Daftar Donasi Anda' }}
            </h3>

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

            @if(method_exists($donations, 'links'))
                <div class="pt-2">
                    {{ $donations->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
