<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
            <div>
                <h2 class="font-black text-xl text-slate-800 leading-tight">Kelola & Verifikasi Donasi</h2>
                <p class="text-xs text-slate-500">Periksa bukti transfer dan konfirmasi donasi masuk</p>
            </div>
            <a href="{{ route('admin.donasi.manual.create') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl shadow-sm transition active:scale-95">
                <span>➕</span> Input Donasi Manual
            </a>
        </div>
    </x-slot>

    <div class="py-4 space-y-4">

        <!-- Status Filter Tabs -->
        <div class="flex gap-1.5 overflow-x-auto pb-1 scrollbar-none text-xs">
            <a href="{{ route('admin.donasi.index', ['status' => 'pending_verification']) }}" class="px-3.5 py-2 rounded-2xl font-bold whitespace-nowrap transition {{ $status === 'pending_verification' ? 'bg-amber-500 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200' }}">
                Menunggu Verifikasi ({{ $counts['pending_verification'] }})
            </a>
            <a href="{{ route('admin.donasi.index', ['status' => 'verified']) }}" class="px-3.5 py-2 rounded-2xl font-bold whitespace-nowrap transition {{ $status === 'verified' ? 'bg-teal-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200' }}">
                Terverifikasi ({{ $counts['verified'] }})
            </a>
            <a href="{{ route('admin.donasi.index', ['status' => 'pending_payment']) }}" class="px-3.5 py-2 rounded-2xl font-bold whitespace-nowrap transition {{ $status === 'pending_payment' ? 'bg-slate-700 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200' }}">
                Menunggu Pembayaran ({{ $counts['pending_payment'] }})
            </a>
            <a href="{{ route('admin.donasi.index', ['status' => 'rejected']) }}" class="px-3.5 py-2 rounded-2xl font-bold whitespace-nowrap transition {{ $status === 'rejected' ? 'bg-rose-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200' }}">
                Ditolak ({{ $counts['rejected'] }})
            </a>
            <a href="{{ route('admin.donasi.index', ['status' => 'all']) }}" class="px-3.5 py-2 rounded-2xl font-bold whitespace-nowrap transition {{ $status === 'all' ? 'bg-slate-900 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200' }}">
                Semua Donasi ({{ $counts['all'] }})
            </a>
        </div>

        <!-- Pencarian -->
        <form action="{{ route('admin.donasi.index') }}" method="GET" class="bg-white p-3 rounded-2xl border border-slate-100 flex gap-2">
            <input type="hidden" name="status" value="{{ $status }}">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari Kode Donasi, Nama Donatur, atau No WhatsApp..."
                class="w-full text-xs border-slate-200 rounded-xl focus:border-teal-500 focus:ring-teal-500 p-2">
            <button type="submit" class="bg-teal-600 text-white font-bold text-xs px-4 py-2 rounded-xl">Cari</button>
        </form>

        <!-- Daftar Donasi -->
        <div class="space-y-3">
            @forelse($donations as $item)
                <div class="bg-white p-4 md:p-5 rounded-3xl border border-slate-100 shadow-sm space-y-3">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-50 pb-3">
                        <div class="flex items-center gap-2">
                            <span class="font-mono text-xs font-black text-teal-800 bg-teal-50 px-2 py-0.5 rounded-lg border border-teal-100">{{ $item->kode_donasi }}</span>
                            @if($item->is_manual)
                                <span class="text-[10px] font-bold bg-purple-50 text-purple-700 px-2 py-0.5 rounded-md">Input Manual</span>
                            @endif
                            <span class="text-[10px] text-slate-400">📅 {{ $item->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        <span class="inline-block text-[10px] font-bold px-2.5 py-0.5 rounded-full
                            @if($item->status === 'verified') bg-teal-50 text-teal-700 border border-teal-100
                            @elseif($item->status === 'pending_verification') bg-amber-50 text-amber-700 border border-amber-100
                            @elseif($item->status === 'rejected') bg-rose-50 text-rose-700 border border-rose-100
                            @else bg-slate-100 text-slate-600 @endif">
                            {{ $item->status_label }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                        <!-- Info Donatur & Program -->
                        <div class="space-y-1">
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Program Donasi</p>
                            <p class="font-extrabold text-xs text-slate-800">{{ $item->program->nama }}</p>
                            <p class="text-[11px] text-slate-600">
                                Donatur: <strong>{{ $item->displayName }}</strong>
                                @if($item->is_anonim) <span class="text-slate-400 text-[10px]">(Anonim)</span> @endif
                            </p>
                            <p class="text-[11px] text-slate-500">WA: <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $item->no_hp) }}" target="_blank" class="text-teal-600 underline">{{ $item->no_hp }}</a></p>
                        </div>

                        <!-- Info Nominal & Pembayaran -->
                        <div class="space-y-1">
                            <p class="text-[10px] text-slate-400 font-bold uppercase">Pembayaran & Bank</p>
                            <p class="font-black text-teal-700 text-base">Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-slate-400">Nominal: Rp {{ number_format($item->nominal, 0, ',', '.') }} | Unik: +{{ $item->kode_unik }}</p>
                            <p class="text-xs text-slate-700">Bank: <strong>{{ $item->bank_tujuan }}</strong></p>
                            @if($item->doa)
                                <p class="text-xs text-slate-600 italic bg-slate-50 p-2 rounded-xl mt-1">"{{ $item->doa }}"</p>
                            @endif
                        </div>

                        <!-- Bukti Transfer & Aksi Verifikasi -->
                        <div class="space-y-2 flex flex-col justify-between">
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase mb-1">Bukti Transfer</p>
                                @if($item->bukti_transfer)
                                    <div class="flex items-center gap-2">
                                        <a href="{{ asset('storage/' . $item->bukti_transfer) }}" target="_blank" class="block w-20 h-16 rounded-xl overflow-hidden border border-slate-200 bg-slate-100 hover:opacity-90 transition">
                                            <img src="{{ asset('storage/' . $item->bukti_transfer) }}" alt="Bukti" class="w-full h-full object-cover">
                                        </a>
                                        <a href="{{ asset('storage/' . $item->bukti_transfer) }}" target="_blank" class="text-xs font-bold text-teal-600 hover:underline">
                                            Buka Foto Penuh 🔍
                                        </a>
                                    </div>
                                @else
                                    <span class="text-xs text-slate-400 italic">Belum ada bukti diunggah</span>
                                @endif
                            </div>

                            <!-- Tombol Aksi -->
                            @if($item->status !== 'verified')
                                <div class="flex items-center gap-2 pt-2">
                                    <form action="{{ route('admin.donasi.verify', $item->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs py-2 rounded-xl shadow-sm transition active:scale-95">
                                            Verifikasi & Catat Kas ✓
                                        </button>
                                    </form>

                                    @if($item->status !== 'rejected')
                                        <form action="{{ route('admin.donasi.reject', $item->id) }}" method="POST" onsubmit="return confirm('Tolak donasi ini?')">
                                            @csrf
                                            <button type="submit" class="bg-rose-50 hover:bg-rose-100 text-rose-600 font-bold text-xs px-3 py-2 rounded-xl transition">
                                                Tolak
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <div class="text-[11px] text-teal-700 font-bold bg-teal-50 p-2 rounded-xl border border-teal-100">
                                    ✓ Diverifikasi oleh {{ $item->verifier->name ?? 'Admin' }} pada {{ $item->verified_at ? $item->verified_at->format('d M Y, H:i') : '-' }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="bg-white p-12 text-center rounded-3xl border border-slate-100">
                    <p class="text-xs text-slate-400">Tidak ada donasi pada tab ini.</p>
                </div>
            @endforelse

            <div class="pt-2">
                {{ $donations->links() }}
            </div>
        </div>

    </div>
</x-app-layout>
