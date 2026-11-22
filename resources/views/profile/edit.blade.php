<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-xl text-slate-800 leading-tight">Pengaturan Profil &amp; Keamanan</h2>
                <p class="text-xs text-slate-500">Kelola informasi akun, kata sandi, dan privasi donatur</p>
            </div>
            <a href="{{ route('donations.my-donations') }}" class="text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-4 py-2 rounded-full transition">
                ← Riwayat Donasi
            </a>
        </div>
    </x-slot>

    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Informasi Profil -->
        <div class="p-5 sm:p-6 bg-white border border-slate-100 shadow-sm rounded-3xl space-y-4">
            @include('profile.partials.update-profile-information-form')
        </div>

        <!-- Ubah Kata Sandi -->
        <div class="p-5 sm:p-6 bg-white border border-slate-100 shadow-sm rounded-3xl space-y-4">
            @include('profile.partials.update-password-form')
        </div>

        <!-- Hapus Akun -->
        <div class="p-5 sm:p-6 bg-white border border-slate-100 shadow-sm rounded-3xl space-y-4">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</x-app-layout>
