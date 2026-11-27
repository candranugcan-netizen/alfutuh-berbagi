<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Donation;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    /**
     * Tampilkan formulir donasi untuk program tertentu
     */
    public function create($slug)
    {
        $program = Program::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $bankAccounts = BankAccount::where('is_active', true)->orderBy('urutan')->get();

        return view('donations.create', compact('program', 'bankAccounts'));
    }

    /**
     * Proses pembuatan transaksi donasi (Guest / Logged-in User)
     */
    public function store(Request $request, $slug)
    {
        $program = Program::where('slug', $slug)->where('is_active', true)->firstOrFail();

        $validated = $request->validate([
            'nominal' => 'required|integer|min:1000',
            'nama_donatur' => 'nullable|string|max:100',
            'is_anonim' => 'nullable|boolean',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'bank_tujuan' => 'required|string',
            'doa' => 'nullable|string|max:500',
        ], [
            'nominal.min' => 'Nominal donasi minimal adalah Rp 1.000.',
            'no_hp.required' => 'Nomor WhatsApp wajib diisi untuk konfirmasi status donasi.',
            'bank_tujuan.required' => 'Silakan pilih rekening bank tujuan transfer.',
        ]);

        // Generate kode donasi unik (Format: ALF-Ymd-XXXX)
        $kodeDonasi = 'ALF-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // Nominal pas tanpa penambahan angka unik
        $kodeUnik = 0;
        $totalPembayaran = $validated['nominal'];

        // Tentukan nama donatur
        $namaDonatur = $request->nama_donatur;
        if (empty($namaDonatur) && Auth::check()) {
            $namaDonatur = Auth::user()->name;
        }
        if (empty($namaDonatur)) {
            $namaDonatur = 'Hamba Allah';
        }

        $donation = Donation::create([
            'kode_donasi' => $kodeDonasi,
            'program_id' => $program->id,
            'user_id' => Auth::id(), // null jika donatur guest
            'nama_donatur' => $namaDonatur,
            'is_anonim' => $request->boolean('is_anonim'),
            'no_hp' => $validated['no_hp'],
            'email' => $validated['email'] ?? (Auth::check() ? Auth::user()->email : null),
            'nominal' => $validated['nominal'],
            'kode_unik' => $kodeUnik,
            'total_pembayaran' => $totalPembayaran,
            'bank_tujuan' => $validated['bank_tujuan'],
            'status' => 'pending_payment',
            'doa' => $validated['doa'],
            'is_manual' => false,
            'metode_pembayaran' => 'transfer_bank',
        ]);

        return redirect()->route('donations.payment', $donation->kode_donasi)
            ->with('success', 'Bismillah, niat donasi Anda telah tercatat. Silakan lakukan transfer sesuai nominal.');
    }

    /**
     * Halaman instruksi transfer pembayaran donasi
     */
    public function payment($kodeDonasi)
    {
        $donation = Donation::with('program')->where('kode_donasi', $kodeDonasi)->firstOrFail();

        // Pastikan nominal transfer pas (hilangkan kode unik jika donasi masih pending)
        if ($donation->status === 'pending_payment' && $donation->kode_unik > 0) {
            $donation->update([
                'kode_unik' => 0,
                'total_pembayaran' => $donation->nominal,
            ]);
            $donation->refresh();
        }
        
        // Cari informasi rekening bank tujuan yang dipilih
        $bankAccount = BankAccount::where('nama_bank', 'like', "%{$donation->bank_tujuan}%")
            ->orWhere('kode_bank', $donation->bank_tujuan)
            ->first();

        // Jika tidak ditemukan tepat, ambil bank aktif pertama
        if (!$bankAccount) {
            $bankAccount = BankAccount::where('is_active', true)->first();
        }

        $allBanks = BankAccount::where('is_active', true)->get();

        return view('donations.payment', compact('donation', 'bankAccount', 'allBanks'));
    }

    /**
     * Upload bukti transfer oleh donatur
     */
    public function uploadProof(Request $request, $kodeDonasi)
    {
        $donation = Donation::where('kode_donasi', $kodeDonasi)->firstOrFail();

        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'bukti_transfer.required' => 'Pilih foto atau tangkapan layar bukti transfer.',
            'bukti_transfer.image' => 'File bukti transfer harus berupa gambar.',
            'bukti_transfer.max' => 'Ukuran gambar maksimal 5MB.',
        ]);

        if ($request->hasFile('bukti_transfer')) {
            // Hapus file lama jika ada
            if ($donation->bukti_transfer && Storage::disk('public')->exists($donation->bukti_transfer)) {
                Storage::disk('public')->delete($donation->bukti_transfer);
            }

            $path = $request->file('bukti_transfer')->store('bukti_transfer', 'public');
            
            $donation->update([
                'bukti_transfer' => $path,
                'status' => 'pending_verification',
            ]);
        }

        return redirect()->route('donations.payment', $donation->kode_donasi)
            ->with('success', 'Alhamdulillah! Bukti transfer berhasil diunggah. Admin Yayasan Al Futuh akan segera memverifikasi.');
    }

    /**
     * Riwayat Donasi Pengguna (Donasi Saya)
     */
    public function myDonations(Request $request)
    {
        $donations = collect();
        $totalDonasiBerhasil = 0;
        $totalDonasiPending = 0;
        $totalTransaksiCount = 0;

        if (Auth::check()) {
            $user = Auth::user();

            // Total donasi yang telah terverifikasi oleh user ini
            $totalDonasiBerhasil = (int) Donation::where('user_id', $user->id)
                ->where('status', 'verified')
                ->sum('nominal');

            // Total donasi yang masih pending
            $totalDonasiPending = (int) Donation::where('user_id', $user->id)
                ->whereIn('status', ['pending_payment', 'pending_verification'])
                ->sum('nominal');

            $totalTransaksiCount = Donation::where('user_id', $user->id)->count();

            // Donasi terikat akun user dengan paginasi 10 item per halaman
            $donations = Donation::with('program')
                ->where('user_id', $user->id)
                ->latest()
                ->paginate(10)
                ->withQueryString();
        }

        return view('donations.my-donations', compact(
            'donations',
            'totalDonasiBerhasil',
            'totalDonasiPending',
            'totalTransaksiCount'
        ));
    }

    /**
     * Pelacakan Donasi untuk Guest (Berdasarkan Kode Donasi atau No HP)
     */
    public function trackGuest(Request $request)
    {
        $request->validate([
            'query' => 'required|string',
        ]);

        $query = trim($request->input('query'));

        $baseQuery = Donation::where(function ($q) use ($query) {
            $q->where('kode_donasi', $query)
              ->orWhere('no_hp', $query)
              ->orWhere('email', $query);
        });

        // Hitung total donasi hasil pencarian
        $totalDonasiBerhasil = (int) (clone $baseQuery)->where('status', 'verified')->sum('nominal');
        $totalDonasiPending = (int) (clone $baseQuery)->whereIn('status', ['pending_payment', 'pending_verification'])->sum('nominal');
        $totalTransaksiCount = (clone $baseQuery)->count();

        $donations = (clone $baseQuery)
            ->with('program')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('donations.my-donations', [
            'donations' => $donations,
            'searchQuery' => $query,
            'isSearch' => true,
            'totalDonasiBerhasil' => $totalDonasiBerhasil,
            'totalDonasiPending' => $totalDonasiPending,
            'totalTransaksiCount' => $totalTransaksiCount,
        ]);
    }
}
