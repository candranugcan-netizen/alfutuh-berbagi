<x-app-layout>
    <div class="py-4 max-w-2xl mx-auto space-y-5">
        <div class="bg-white p-5 md:p-6 rounded-3xl border border-slate-100 shadow-sm space-y-4">
            <!-- Header Artikel -->
            <div class="space-y-2">
                @if($kabar->program)
                    <a href="{{ route('programs.show', $kabar->program->slug) }}" class="inline-block text-[10px] font-bold bg-teal-50 text-teal-700 px-2.5 py-0.5 rounded-md">
                        Program: {{ $kabar->program->nama }}
                    </a>
                @endif
                <h1 class="text-xl md:text-2xl font-black text-slate-800 leading-snug">
                    {{ $kabar->judul }}
                </h1>
                <p class="text-[11px] text-slate-400">
                    Dipublikasikan pada {{ $kabar->tanggal->format('d M Y') }} • Oleh <strong class="text-slate-600">{{ $kabar->penulis }}</strong>
                </p>
            </div>

            <!-- Foto Utama -->
            @if($kabar->foto)
                <div class="w-full rounded-2xl overflow-hidden max-h-96 bg-slate-100">
                    <img src="{{ asset('storage/' . $kabar->foto) }}" alt="{{ $kabar->judul }}" class="w-full h-full object-cover">
                </div>
            @endif

            <!-- Konten Lengkap -->
            <div class="text-xs md:text-sm text-slate-700 leading-relaxed whitespace-pre-line space-y-3 pt-2">
                {{ $kabar->konten }}
            </div>

            @if($kabar->program)
                <!-- Ajakan Donasi Terkait -->
                <div class="mt-6 p-4 bg-teal-50 rounded-2xl border border-teal-100 flex items-center justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold text-teal-800">Mari terus dukung program ini</p>
                        <p class="text-[11px] text-teal-600">{{ $kabar->program->nama }}</p>
                    </div>
                    <a href="{{ route('donations.create', $kabar->program->slug) }}" class="bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs px-4 py-2 rounded-xl transition shrink-0">
                        Donasi Sekarang
                    </a>
                </div>
            @endif
        </div>

        <!-- Artikel Lainnya -->
        @if($otherKabars->isNotEmpty())
            <div class="space-y-3 pt-2">
                <h3 class="text-xs font-extrabold text-slate-800 uppercase tracking-wider px-1">Kabar Lainnya</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    @foreach($otherKabars as $ok)
                        <a href="{{ route('kabars.show', $ok->slug) }}" class="bg-white p-3.5 rounded-2xl border border-slate-100 shadow-sm hover:border-teal-200 transition space-y-1 block">
                            <span class="text-[10px] font-bold text-teal-600">{{ $ok->tanggal->format('d M Y') }}</span>
                            <h4 class="font-bold text-xs text-slate-800 line-clamp-2">{{ $ok->judul }}</h4>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
