<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-2.5">
            <div class="min-w-0">
                <h2 class="font-extrabold text-lg sm:text-xl text-slate-800 leading-tight truncate">Edit Pengguna</h2>
                <p class="text-[11px] sm:text-xs text-slate-500 truncate">Perbarui data profil &amp; hak akses akun</p>
            </div>
            <a href="{{ route('admin.users.show', $user->id) }}" class="shrink-0 text-xs font-bold text-slate-600 hover:text-[#155E4B] bg-white border border-slate-200 px-3 py-1.5 sm:px-4 sm:py-2 rounded-full transition shadow-2xs">
                ← <span class="hidden sm:inline">Kembali ke</span> Detail
            </a>
        </div>
    </x-slot>

    <div class="max-w-xl mx-auto">
        <div class="bg-white p-4 sm:p-7 rounded-2xl sm:rounded-3xl border border-slate-100 shadow-xs sm:shadow-sm space-y-4 sm:space-y-5">
            <!-- Header Ringkas Akun -->
            <div class="flex items-center gap-3 border-b border-slate-100 pb-3.5">
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-[#EAF5EE] text-[#155E4B] flex items-center justify-center font-black text-base sm:text-lg shrink-0 shadow-2xs">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <h3 class="font-extrabold text-xs sm:text-sm text-slate-800 truncate leading-tight">{{ $user->name }}</h3>
                    <p class="text-[10px] sm:text-xs text-slate-400 truncate">{{ $user->email }}</p>
                </div>
            </div>

            <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-3.5 sm:space-y-4">
                @csrf
                @method('PUT')

                <!-- Nama Lengkap -->
                <div>
                    <label class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nama Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                           class="w-full text-xs font-bold border border-slate-200 rounded-xl sm:rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3">
                    @error('name') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Alamat Email <span class="text-rose-500">*</span>
                    </label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                           class="w-full text-xs border border-slate-200 rounded-xl sm:rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3">
                    @error('email') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Nomor HP / WhatsApp -->
                <div>
                    <label class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Nomor HP / WhatsApp
                    </label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" placeholder="Contoh: 081234567890"
                           class="w-full text-xs border border-slate-200 rounded-xl sm:rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3">
                    @error('phone') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Hak Akses (Role) -->
                <div>
                    <label class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                        Peran / Hak Akses Akun <span class="text-rose-500">*</span>
                    </label>
                    <select name="role" required class="w-full text-xs border border-slate-200 rounded-xl sm:rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3 bg-white">
                        <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Donatur (Akses Publik & Riwayat Sendiri)</option>
                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrator (Akses Penuh Portal Pengurus)</option>
                    </select>
                    @error('role') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Ganti Password Opsional -->
                <div class="pt-2 border-t border-slate-100">
                    <label class="block text-[11px] sm:text-xs font-bold text-slate-700 uppercase tracking-wider mb-0.5">
                        Atur Ulang Kata Sandi (Opsional)
                    </label>
                    <p class="text-[10px] text-slate-400 mb-1.5">Kosongkan jika tidak ingin mengganti kata sandi pengguna.</p>
                    <input type="password" name="password" placeholder="Minimal 8 karakter baru..."
                           class="w-full text-xs border border-slate-200 rounded-xl sm:rounded-2xl focus:border-[#155E4B] focus:ring-[#155E4B] p-2.5 sm:p-3">
                    @error('password') <p class="text-[11px] text-rose-500 mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Tombol Aksi Form Responsif -->
                <div class="pt-2 flex items-center gap-2">
                    <a href="{{ route('admin.users.show', $user->id) }}" class="w-1/3 text-center bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs py-3 rounded-xl sm:rounded-full transition">
                        Batal
                    </a>
                    <button type="submit" class="w-2/3 bg-[#155E4B] hover:bg-[#0E4436] text-white font-extrabold text-xs py-3 rounded-xl sm:rounded-full shadow-md shadow-[#155E4B]/20 active:scale-95 transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
