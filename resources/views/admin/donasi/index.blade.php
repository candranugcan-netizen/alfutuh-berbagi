<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Kelola &amp; Verifikasi Donasi</h2>
                <p class="text-xs text-slate-500">Periksa mutasi transfer, cocokkan 3 digit kode unik, dan verifikasi donasi masuk</p>
            </div>
            <a href="{{ route('admin.donasi.manual.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-[#155E4B] hover:bg-[#0E4436] text-white px-4 py-2 rounded-full shadow-sm transition active:scale-95">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 5v14M5 12h14" stroke-width="2" stroke-linecap="round"/></svg>
                <span>Input Donasi Manual</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-5">

        <!-- Status Filter Tabs (Clean Rounded-Full Pills) -->
        <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-none text-xs">
            <a href="{{ route('admin.donasi.index', ['status' => 'pending_verification']) }}" class="px-4 py-2 rounded-full font-bold whitespace-nowrap transition {{ $status === 'pending_verification' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-amber-400' }}">
                Menunggu Verifikasi ({{ $counts['pending_verification'] }})
            </a>
            <a href="{{ route('admin.donasi.index', ['status' => 'verified']) }}" class="px-4 py-2 rounded-full font-bold whitespace-nowrap transition {{ $status === 'verified' ? 'bg-[#155E4B] text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-[#155E4B]' }}">
                Terverifikasi ({{ $counts['verified'] }})
            </a>
            <a href="{{ route('admin.donasi.index', ['status' => 'pending_payment']) }}" class="px-4 py-2 rounded-full font-bold whitespace-nowrap transition {{ $status === 'pending_payment' ? 'bg-slate-700 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-400' }}">
                Menunggu Transfer ({{ $counts['pending_payment'] }})
            </a>
            <a href="{{ route('admin.donasi.index', ['status' => 'rejected']) }}" class="px-4 py-2 rounded-full font-bold whitespace-nowrap transition {{ $status === 'rejected' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-rose-300' }}">
                Ditolak ({{ $counts['rejected'] }})
            </a>
            <a href="{{ route('admin.donasi.index', ['status' => 'all']) }}" class="px-4 py-2 rounded-full font-bold whitespace-nowrap transition {{ $status === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:border-slate-800' }}">
                Semua Donasi ({{ $counts['all'] }})
            </a>
        </div>

        <!-- Pencarian Donasi -->
        <form action="{{ route('admin.donasi.index') }}" method="GET" class="bg-white p-2.5 rounded-2xl border border-slate-100 flex gap-2 shadow-sm">
            <input type="hidden" name="status" value="{{ $status }}">
            <div class="relative flex-1">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Kode Donasi (ALF-...), Nama Donatur, atau No WhatsApp..."
                    class="w-full text-xs pl-9 pr-4 py-2 rounded-xl border border-slate-200 focus:border-[#155E4B] focus:ring-[#155E4B]">
                <span class="absolute left-3 top-2.5 text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="11" cy="11" r="6" stroke-width="1.8"/><path d="m16 16 4 4" stroke-width="1.8" stroke-linecap="round"/></svg>
                </span>
            </div>
            <button type="submit" class="bg-[#155E4B] hover:bg-[#0E4436] text-white font-bold text-xs px-5 py-2 rounded-xl transition">
                Cari
            </button>
        </form>

        <!-- Daftar Donasi Masuk -->
        <div class="space-y-3">
            @forelse($donations as $item)
                <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="font-mono text-xs font-bold text-[#155E4B] bg-[#EAF5EE] px-2.5 py-0.5 rounded-full border border-[#D2E6DC]">{{ $item->kode_donasi }}</span>
                            @if($item->is_manual)
                                <span class="text-[10px] font-bold bg-purple-50 text-purple-700 px-2 py-0.5 rounded-md border border-purple-100">Input Manual</span>
                            @endif
                            <span class="text-[10px] text-slate-400">📅 {{ $item->created_at->format('d M Y, H:i') }} WIB</span>
                        </div>
                        <span class="inline-block text-[10px] font-bold px-3 py-1 rounded-full
                            @if($item->status === 'verified') bg-[#EAF5EE] text-[#155E4B] border border-[#D2E6DC]
                            @elseif($item->status === 'pending_verification') bg-amber-50 text-amber-800 border border-amber-200
                            @elseif($item->status === 'rejected') bg-rose-50 text-rose-700 border border-rose-100
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ $item->status_label }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3.5">
                        <!-- Info Donatur & Program -->
                        <div class="space-y-1">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Program Donasi</p>
                            <p class="font-extrabold text-xs text-slate-800">{{ $item->program->nama }}</p>
                            <p class="text-[11px] text-slate-600">
                                Donatur: <strong class="text-slate-800">{{ $item->displayName }}</strong>
                                @if($item->is_anonim) <span class="text-slate-400 text-[10px]">(Anonim)</span> @endif
                            </p>
                            <p class="text-[11px] text-slate-500 flex items-center gap-1">
                                <span>WA:</span>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}" target="_blank" class="text-[#155E4B] font-bold hover:underline">
                                    {{ $item->no_hp }}
                                </a>
                            </p>
                        </div>

                        <!-- Info Nominal & Pembayaran -->
                        <div class="space-y-1">
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Total Pembayaran</p>
                            <p class="font-black text-[#155E4B] text-base">Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-slate-400">Nominal: Rp {{ number_format($item->nominal, 0, ',', '.') }} | Unik: <strong class="text-amber-600">+{{ $item->kode_unik }}</strong></p>
                            <p class="text-xs text-slate-700">Bank Tujuan: <strong>{{ $item->bank_tujuan }}</strong></p>
                            @if($item->doa)
                                <p class="text-xs text-slate-600 italic bg-[#F8FAF8] p-2.5 rounded-xl border border-slate-100 mt-1">"{{ $item->doa }}"</p>
                            @endif
                        </div>

                        <!-- Bukti Transfer & Aksi Verifikasi -->
                        <div class="space-y-2 flex flex-col justify-between">
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Bukti Transfer</p>
                                @if($item->bukti_transfer)
                                    <div class="flex items-center gap-2.5">
                                        <a href="{{ asset('storage/' . $item->bukti_transfer) }}" target="_blank" class="block w-20 h-16 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 hover:opacity-90 transition">
                                            <img src="{{ asset('storage/' . $item->bukti_transfer) }}" alt="Bukti" class="w-full h-full object-cover">
                                        </a>
                                        <a href="{{ asset('storage/' . $item->bukti_transfer) }}" target="_blank" class="text-xs font-bold text-[#155E4B] hover:underline">
                                            Buka Foto Penuh →
                                        </a>
                                    </div>
                                @else
                                    <p class="text-[11px] text-slate-400 italic">Belum ada bukti yang diunggah</p>
                                @endif
                            </div>

                            <!-- Tombol Aksi Verifikasi / Tolak -->
                            @if($item->status !== 'verified')
                                <div class="flex items-center gap-2 pt-2">
                                    <form action="{{ route('admin.donasi.verify', $item->id) }}" method="POST" class="flex-1" onsubmit="return confirmSubmit(event, { title: 'Verifikasi Donasi?', text: 'Pastikan mutasi transfer sebesar Rp {{ number_format($item->nominal + $item->kode_unik, 0, ',', '.') }} sudah masuk rekening.', icon: 'question', confirmButtonText: 'Ya, Verifikasi!', confirmButtonColor: '#155E4B', danger: false })">
                                        @csrf
                                        <button type="submit" class="w-full bg-[#155E4B] hover:bg-[#0E4436] text-white font-bold text-xs py-2 rounded-full shadow-sm transition active:scale-95">
                                            Verifikasi ✓
                                        </button>
                                    </form>

                                    @if($item->status !== 'rejected')
                                        <form action="{{ route('admin.donasi.reject', $item->id) }}" method="POST" onsubmit="return confirmSubmit(event, { title: 'Tolak Donasi Ini?', text: 'Status donasi {{ $item->kode_donasi }} akan diubah menjadi Ditolak.', icon: 'warning', confirmButtonText: 'Ya, Tolak!', danger: true })">
                                            @csrf
                                            <button type="submit" class="text-xs text-rose-600 hover:text-rose-700 font-bold bg-rose-50 border border-rose-100 px-3 py-2 rounded-full transition active:scale-95">
                                                Tolak ✕
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <div class="text-[11px] font-bold text-[#155E4B] bg-[#EAF5EE] p-2 rounded-xl border border-[#D2E6DC] text-center">
                                    ✓ Donasi Telah Terverifikasi
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-3xl border border-slate-100 space-y-2">
                    <p class="text-xs text-slate-400">Tidak ada data donasi untuk filter ini.</p>
                </div>
            @endforelse
        </div>

        @if(method_exists($donations, 'links'))
            <div class="pt-2">
                {{ $donations->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
