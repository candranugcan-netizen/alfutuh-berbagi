<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Al Futuh') }}</title>

        <!-- Favicon & PWA Icons -->
        <link rel="icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=manrope:400,500,600,700&family=cormorant-garamond:600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>

        @if (session('status'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'info',
                        title: 'Status',
                        text: {!! json_encode(session('status')) !!},
                        confirmButtonColor: '#155E4B',
                        confirmButtonText: 'Tutup',
                        customClass: { popup: 'rounded-3xl' }
                    });
                });
            </script>
        @endif
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: {!! json_encode(session('success')) !!},
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        customClass: { popup: 'rounded-3xl' }
                    });
                });
            </script>
        @endif
        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Perhatian',
                        text: {!! json_encode(session('error')) !!},
                        confirmButtonColor: '#155E4B',
                        confirmButtonText: 'Tutup',
                        customClass: { popup: 'rounded-3xl' }
                    });
                });
            </script>
        @endif

        <!-- Auto-refresh token CSRF saat tab kembali aktif setelah ditinggal lama -->
        <script>
            let lastGuestActive = Date.now();
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'visible') {
                    const elapsedMinutes = (Date.now() - lastGuestActive) / 60000;
                    if (elapsedMinutes >= 15) {
                        fetch('{{ route('refresh-csrf') }}', {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        })
                        .then(r => r.json())
                        .then(d => {
                            if (d.csrf_token) {
                                const meta = document.querySelector('meta[name="csrf-token"]');
                                if (meta) meta.setAttribute('content', d.csrf_token);
                                document.querySelectorAll('input[name="_token"]').forEach(el => {
                                    el.value = d.csrf_token;
                                });
                            }
                        })
                        .catch(() => {});
                    }
                    lastGuestActive = Date.now();
                }
            });
        </script>
    </body>
</html>
