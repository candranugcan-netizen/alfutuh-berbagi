<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Daftar Pengguna & Klasemen Donasi Terbanyak
     */
    public function index(Request $request)
    {
        $search = $request->query('q');
        $tab = $request->query('tab', 'semua'); // 'semua' atau 'klasemen'

        // 1. Klasemen Donatur Terbanyak (Top Donatur)
        $topDonaturs = User::withSum(['donations as total_nominal_verified' => function ($q) {
                $q->where('status', 'verified');
            }], 'nominal')
            ->withCount(['donations as total_donasi_count' => function ($q) {
                $q->where('status', 'verified');
            }])
            ->having('total_nominal_verified', '>', 0)
            ->orderByDesc('total_nominal_verified')
            ->take(10)
            ->get();

        // 2. Query Daftar Semua User dengan Filter & Pencarian
        $query = User::withSum(['donations as total_nominal_verified' => function ($q) {
                $q->where('status', 'verified');
            }], 'nominal')
            ->withCount(['donations as total_donasi_count' => function ($q) {
                $q->where('status', 'verified');
            }]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Urutkan berdasarkan donasi terbanyak jika tab klasemen
        if ($tab === 'klasemen') {
            $query->orderByDesc('total_nominal_verified');
        } else {
            $query->latest('id');
        }

        $users = $query->paginate(15)->withQueryString();

        // Metrik Pengguna
        $totalUserCount = User::count();
        $totalAdminCount = User::where('role', 'admin')->count();
        $totalDonaturTerdaftar = User::whereHas('donations', function ($q) {
            $q->where('status', 'verified');
        })->count();

        return view('admin.users.index', compact(
            'users',
            'topDonaturs',
            'search',
            'tab',
            'totalUserCount',
            'totalAdminCount',
            'totalDonaturTerdaftar'
        ));
    }

    /**
     * Detail User & Riwayat Donasinya
     */
    public function show($id)
    {
        $user = User::withSum(['donations as total_nominal_verified' => function ($q) {
                $q->where('status', 'verified');
            }], 'nominal')
            ->withCount(['donations as total_donasi_count' => function ($q) {
                $q->where('status', 'verified');
            }])
            ->findOrFail($id);

        $donations = Donation::with('program')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.users.show', compact('user', 'donations'));
    }

    /**
     * Form Edit Pengguna
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Simpan Perubahan Data Pengguna
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,user',
            'password' => 'nullable|string|min:8',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email tersebut sudah digunakan pengguna lain.',
            'password.min' => 'Kata sandi minimal 8 karakter.',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->phone = $validated['phone'];
        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.show', $user->id)
            ->with('success', 'Data pengguna "' . $user->name . '" berhasil diperbarui!');
    }

    /**
     * Hapus Pengguna
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Cegah admin menghapus dirinya sendiri
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri saat sedang aktif login.');
        }

        // Lepas user_id pada donasi agar riwayat keuangan dan bukti penyaluran donatur tidak rusak
        Donation::where('user_id', $user->id)->update(['user_id' => null]);

        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Pengguna "' . $userName . '" berhasil dihapus dari sistem. Riwayat donasi tetap aman tersimpan.');
    }
}
