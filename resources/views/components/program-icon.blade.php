@props(['category' => '', 'name' => '', 'class' => 'w-7 h-7'])

@php
    $key = strtolower(trim(($category ?: $name)));
@endphp

<svg {{ $attributes->merge(['class' => $class]) }} fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
    @if(str_contains($key, 'masjid') || str_contains($key, 'operasional'))
        <!-- Clean Mosque Dome & Minaret -->
        <path d="M12 3c-3.5 2.5-6 6-6 10v7h12v-7c0-4-2.5-7.5-6-10Z" stroke-width="1.8" stroke-linejoin="round"/>
        <path d="M12 1.5v2.5M10.5 2.5h3" stroke-width="1.6" stroke-linecap="round"/>
        <path d="M10 20v-4a2 2 0 1 1 4 0v4M3 20h18" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M4 14v6M20 14v6M3 14h2M19 14h2" stroke-width="1.6" stroke-linecap="round"/>
    @elseif(str_contains($key, 'pendidikan') || str_contains($key, 'santri') || str_contains($key, 'beasiswa') || str_contains($key, 'buku') || str_contains($key, 'ilmu') || str_contains($key, 'anak asuh'))
        <!-- Clean Open Book -->
        <path d="M12 6.5c-2.5-2-6-2.5-9-2v13c3-.5 6.5 0 9 2m0-13c2.5-2 6-2.5 9-2v13c-3-.5-6.5 0-9 2m0-13v13" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    @elseif(str_contains($key, 'sosial') || str_contains($key, 'yatim') || str_contains($key, 'umat') || str_contains($key, 'masyarakat'))
        <!-- Clean 3 People / Community -->
        <circle cx="12" cy="7" r="3" stroke-width="1.8"/>
        <path d="M6.5 20c0-3 2.5-5.5 5.5-5.5s5.5 2.5 5.5 5.5" stroke-width="1.8" stroke-linecap="round"/>
        <circle cx="5" cy="10" r="2.2" stroke-width="1.6"/>
        <path d="M1.5 20c0-2.2 1.8-4 4-4 .6 0 1.2.1 1.7.4" stroke-width="1.6" stroke-linecap="round"/>
        <circle cx="19" cy="10" r="2.2" stroke-width="1.6"/>
        <path d="M22.5 20c0-2.2-1.8-4-4-4-.6 0-1.2.1-1.7.4" stroke-width="1.6" stroke-linecap="round"/>
    @elseif(str_contains($key, 'kemanusiaan') || str_contains($key, 'peduli') || str_contains($key, 'bencana') || str_contains($key, 'dhuafa'))
        <!-- Clean Hands Caring / Heart -->
        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    @elseif(str_contains($key, 'qurban') || str_contains($key, 'hewan'))
        <!-- Qurban Livestock Silhouette -->
        <path d="M4 10c1-4 4-6 8-6s7 2 8 6" stroke-width="1.8" stroke-linecap="round"/>
        <path d="M7 9v7c0 2 1.5 4 5 4s5-2 5-4V9M9 8V5m6 3V5M9 5H6m9 0h3M9 13c1.5 1 4.5 1 6 0" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    @elseif(str_contains($key, 'zakat'))
        <!-- Clean Zakat / Wealth Bowl -->
        <path d="M12 3v18M5 8l7-5 7 5M5 16l7 5 7-5M3 12h18" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    @elseif(str_contains($key, 'listrik'))
        <!-- Clean Lightning Bolt -->
        <path d="m13 2-8 12h7l-1 8 8-12h-7l1-8Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    @elseif(str_contains($key, 'bank') || str_contains($key, 'transfer'))
        <!-- Clean Bank Building -->
        <path d="M3 21h18M3 9l9-5 9 5v2H3V9ZM5 11v7m4-7v7m6-7v7m4-7v7" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    @elseif(str_contains($key, 'qris') || str_contains($key, 'qr'))
        <!-- Clean QRIS Frame -->
        <path d="M3 8V4a1 1 0 0 1 1-1h4M16 3h4a1 1 0 0 1 1 1v4M21 16v4a1 1 0 0 1-1 1h-4M8 21H4a1 1 0 0 1-1-1v-4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        <rect x="7" y="7" width="3" height="3" fill="currentColor"/>
        <rect x="14" y="7" width="3" height="3" fill="currentColor"/>
        <rect x="7" y="14" width="3" height="3" fill="currentColor"/>
        <rect x="14" y="14" width="3" height="3" fill="currentColor"/>
    @else
        <!-- Default Heart -->
        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
    @endif
</svg>
