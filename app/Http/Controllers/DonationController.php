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
            'nominal' => 'required|integer|min:10000',
            'nama_donatur' => 'nullable|string|max:100',
            'is_anonim' => 'nullable|boolean',
            'no_hp' => 'required|string|max:20',
            'email' => 'nullable|email|max:100',
            'bank_tujuan' => 'required|string',
            'doa' => 'nullable|string|max:500',
        ], [
            'nominal.min' => 'Nominal donasi minimal adalah Rp 10.000.',
            'no_hp.required' => 'Nomor WhatsApp wajib diisi untuk konfirmasi status donasi.',
            'bank_tujuan.required' => 'Silakan pilih rekening bank tujuan transfer.',
        ]);

        // Generate kode donasi unik (Format: ALF-Ymd-XXXX)
        $kodeDonasi = 'ALF-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        // Generate 3 digit kode unik (1 - 999) agar mudah diverifikasi di mutasi bank
        $kodeUnik = rand(101, 899);
        $totalPembayaran = $validated['nominal'] + $kodeUnik;

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

        if (Auth::check()) {
            // Donasi terikat akun user
            $donations = Donation::with('program')
                ->where('user_id', Auth::id())
                ->latest()
                ->paginate(10);
        }

        return view('donations.my-donations', compact('donations'));
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

        $donations = Donation::with('program')
            ->where('kode_donasi', $query)
            ->orWhere('no_hp', $query)
            ->orWhere('email', $query)
            ->latest()
            ->get();

        return view('donations.my-donations', [
            'donations' => $donations,
            'searchQuery' => $query,
            'isSearch' => true,
        ]);
    }
}
