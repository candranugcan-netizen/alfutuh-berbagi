<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Al Futuh') }} - Berbagi Kebaikan, Menguatkan Umat</title>

        <!-- Favicon & PWA Icons -->
        <link rel="icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/icon-192.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        <meta name="theme-color" content="#155E4B">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="Al Futuh">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&family=manrope:500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased bg-[#F8FAF8] text-slate-800 pb-24 md:pb-12 min-h-screen">
        <div class="min-h-screen flex flex-col justify-between">
            <div>
                @include('layouts.navigation')

                <!-- Header Slot -->
                @if (isset($header))
                    <header class="bg-white/95 backdrop-blur-sm border-b border-slate-100 sticky top-16 z-30 shadow-xs">
                        <div class="max-w-5xl mx-auto py-3.5 sm:py-4 px-4 sm:px-6">
                            {{ $header }}
                        </div>
                    </header>
                @endif

                <!-- Notifikasi Pesan Sukses / Error / Info -->
                @if (session('success') || session('error') || session('info'))
                    <div class="max-w-5xl mx-auto px-4 sm:px-6 pt-4">
                        @if (session('success'))
                            <div class="bg-[#EAF5EE] border border-[#D2E6DC] text-[#155E4B] px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs mb-2">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M20 6 9 17l-5-5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span class="text-xs sm:text-sm font-semibold">{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs mb-2">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 9v4m0 4h.01M10.3 3.5 2.6 18a2 2 0 0 0 1.7 3h15.4a2 2 0 0 0 1.7-3L13.7 3.5a2 2 0 0 0-3.4 0Z" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span class="text-xs sm:text-sm font-semibold">{{ session('error') }}</span>
                                </div>
                            </div>
                        @endif

                        @if (session('info'))
                            <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs mb-2">
                                <div class="flex items-center gap-2.5">
                                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="9" stroke-width="1.8"/><path d="M12 11v5m0-8h.01" stroke-width="1.8" stroke-linecap="round"/></svg>
                                    <span class="text-xs sm:text-sm font-semibold">{{ session('info') }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Page Content -->
                <main class="max-w-5xl mx-auto px-4 sm:px-6 py-5 sm:py-6">
                    {{ $slot }}
                </main>
            </div>

            <!-- Global Footer -->
            <footer class="max-w-5xl mx-auto w-full px-4 sm:px-6 py-8 border-t border-slate-100 text-center text-xs text-slate-400 space-y-2">
                <p class="font-bold text-slate-700 text-sm">Al Futuh</p>
                <p class="text-xs text-slate-500 font-semibold">Sub Yayasan dari Yayasan Tebar Dakwah Al Islamy</p>
                <p class="text-[11px] max-w-lg mx-auto text-slate-400">Klepu, Rejosari, Semin, Gunungkidul, Daerah Istimewa Yogyakarta • Izin Kemenkumham Nomor : AHU 0006697.AH.01.04</p>
                <p class="text-[11px] text-slate-400">Platform donasi digital terpercaya untuk kemaslahatan umat, dakwah, dan pendidikan santri.</p>
                <p class="text-[10px] text-slate-400 pt-1">© {{ date('Y') }} Al Futuh Peduli. All rights reserved.</p>
            </footer>
        </div>

        @php
            $isAdminPage = request()->routeIs('admin.*') 
                || request()->routeIs('dashboard') 
                || request()->is('admin*') 
                || request()->is('dashboard*')
                || request()->is('keuangan*')
                || request()->is('kategori*')
                || request()->is('kegiatan*');
        @endphp

        <!-- Floating Action Buttons (PWA Install & WhatsApp Support khusus Publik Donatur) -->
        @if(!$isAdminPage)
            <x-pwa-install-floating />
            <x-whatsapp-floating />
        @endif

        <!-- SweetAlert2 Configuration & Global Handlers -->
        <script>
            // Toast Notification Preset
            window.Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });

            window.toastSuccess = function(message) {
                Toast.fire({
                    icon: 'success',
                    title: message
                });
            };

            window.toastInfo = function(message) {
                Toast.fire({
                    icon: 'info',
                    title: message
                });
            };

            // SweetAlert General Confirmation Helper
            window.confirmSubmit = function(event, options = {}) {
                event.preventDefault();
                const form = event.target.closest('form') || event.target;
                const title = options.title || 'Konfirmasi Tindakan';
                const text = options.text || 'Apakah Anda yakin ingin melanjutkan tindakan ini?';
                const confirmButtonText = options.confirmButtonText || 'Ya, Lanjutkan';
                const cancelButtonText = options.cancelButtonText || 'Batal';
                const icon = options.icon || 'warning';
                const isDanger = options.danger !== false;

                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: isDanger ? '#dc2626' : (options.confirmButtonColor || '#155E4B'),
                    cancelButtonColor: '#64748b',
                    confirmButtonText: confirmButtonText,
                    cancelButtonText: cancelButtonText,
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-3xl shadow-xl',
                        confirmButton: 'rounded-full font-bold px-5 py-2.5 text-xs',
                        cancelButton: 'rounded-full font-bold px-5 py-2.5 text-xs'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
                return false;
            };

            // SweetAlert Delete Confirmation Helper
            window.confirmDelete = function(event, message = 'Data yang dihapus tidak dapat dikembalikan!') {
                return confirmSubmit(event, {
                    title: 'Hapus Data?',
                    text: message,
                    icon: 'warning',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal',
                    danger: true
                });
            };

            // SweetAlert Flash Messages
            document.addEventListener('DOMContentLoaded', function() {
                @if (session('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: {!! json_encode(session('success')) !!},
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'rounded-3xl'
                        }
                    });
                @endif

                @if (session('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Mohon Maaf',
                        text: {!! json_encode(session('error')) !!},
                        confirmButtonColor: '#155E4B',
                        confirmButtonText: 'Tutup',
                        customClass: {
                            popup: 'rounded-3xl',
                            confirmButton: 'rounded-full font-bold px-5 py-2.5 text-xs'
                        }
                    });
                @endif

                @if (session('info'))
                    Swal.fire({
                        icon: 'info',
                        title: 'Informasi',
                        text: {!! json_encode(session('info')) !!},
                        confirmButtonColor: '#155E4B',
                        confirmButtonText: 'Mengerti',
                        customClass: {
                            popup: 'rounded-3xl',
                            confirmButton: 'rounded-full font-bold px-5 py-2.5 text-xs'
                        }
                    });
                @endif

                @if (session('status'))
                    @php
                        $statusMsg = session('status');
                        if ($statusMsg === 'profile-updated') {
                            $statusMsg = 'Profil berhasil diperbarui!';
                        } elseif ($statusMsg === 'password-updated') {
                            $statusMsg = 'Kata sandi berhasil diperbarui!';
                        }
                    @endphp
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: {!! json_encode($statusMsg) !!},
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true,
                        customClass: {
                            popup: 'rounded-3xl'
                        }
                    });
                @endif
            });
        </script>

        <!-- PWA Service Worker Registration -->
        <script>
            if ('serviceWorker' in navigator) {
                window.addEventListener('load', () => {
                    navigator.serviceWorker.register('/sw.js')
                        .then((reg) => console.log('Al Futuh PWA Ready!', reg.scope))
                        .catch((err) => console.log('SW Registration Failed:', err));
                });
            }
        </script>
    </body>
</html>
