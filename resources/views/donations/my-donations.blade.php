<x-app-layout>
    <div class="py-4 space-y-5 max-w-2xl mx-auto">
        <!-- Header Page -->
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-800 tracking-tight">Riwayat Donasi Saya</h1>
            <p class="text-xs text-slate-500">Pantau status transfer, bukti donasi, dan transparansi amanah Anda</p>
        </div>

        <!-- Form Lacak Donasi Tamu (Untuk Donatur Guest) -->
        <div class="bg-white p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
            <h3 class="text-xs font-extrabold text-slate-700 uppercase tracking-wider flex items-center gap-1.5">
                <span>🔍</span> Cek Status Donasi Tamu (Guest)
            </h3>
            <p class="text-xs text-slate-500">
                Jika Anda berdonasi tanpa login, masukkan <strong>Kode Donasi</strong> (contoh: <code>ALF-20261120-XXXX</code>) atau <strong>Nomor WhatsApp</strong> Anda:
            </p>
            <form action="{{ route('donations.track-guest') }}" method="POST" class="flex gap-2">
                @csrf
                <input type="text" name="query" value="{{ $searchQuery ?? '' }}" required placeholder="Contoh: ALF-20261120-XXXX atau 081234..."
                    class="w-full text-xs border-slate-200 rounded-2xl focus:border-teal-500 focus:ring-teal-500 p-2.5">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs px-5 py-2.5 rounded-2xl shrink-0 transition">
                    Lacak
                </button>
            </form>
        </div>

        <!-- Daftar Riwayat Donasi -->
        <div class="space-y-3">
            <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider px-1">
                {{ isset($isSearch) ? 'Hasil Pencarian Donasi' : 'Daftar Donasi Anda' }}
            </h3>

            @forelse($donations as $item)
                <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm space-y-2.5">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-[10px] font-mono text-slate-400 block">{{ $item->kode_donasi }}</span>
                            <h4 class="font-bold text-sm text-slate-800 leading-snug">{{ $item->program->nama }}</h4>
                            <p class="text-[11px] text-slate-400">{{ $item->created_at->format('d M Y, H:i') }} WIB</p>
                        </div>
                        <span class="inline-block text-[10px] font-bold px-2.5 py-1 rounded-full
                            @if($item->status === 'verified') bg-teal-50 text-teal-700 border border-teal-100
                            @elseif($item->status === 'pending_verification') bg-sky-50 text-sky-700 border border-sky-100
                            @elseif($item->status === 'rejected') bg-rose-50 text-rose-700 border border-rose-100
                            @else bg-amber-50 text-amber-700 border border-amber-100 @endif">
                            {{ $item->status_label }}
                        </span>
                    </div>

                    <div class="flex justify-between items-center pt-2 border-t border-slate-50 text-xs">
                        <div>
                            <span class="text-slate-400 text-[10px] block">Nominal Donasi:</span>
                            <span class="font-black text-teal-700 text-sm">Rp {{ number_format($item->nominal, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('donations.payment', $item->kode_donasi) }}" class="text-xs font-bold text-teal-600 hover:text-teal-700 bg-teal-50 hover:bg-teal-100 px-3.5 py-1.5 rounded-xl transition">
                            Lihat Detail →
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white p-8 text-center rounded-3xl border border-slate-100 space-y-2">
                    <span class="text-4xl">🤲</span>
                    <h4 class="text-sm font-bold text-slate-700">Belum ada catatan donasi</h4>
                    <p class="text-xs text-slate-400">Pilihlah salah satu program kebaikan untuk memulai sedekah Anda.</p>
                    <div class="pt-2">
                        <a href="{{ route('programs.index') }}" class="inline-block bg-teal-600 text-white font-bold text-xs px-5 py-2 rounded-xl">
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
