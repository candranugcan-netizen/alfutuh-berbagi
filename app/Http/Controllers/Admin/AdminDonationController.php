<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Program;
use App\Models\KategoriKeuangan;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AdminDonationController extends Controller
{
    /**
     * Tampilkan daftar donasi masuk dengan filter status
     */
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending_verification');
        $query = Donation::with(['program', 'user'])->latest();

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        if ($request->filled('q')) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('kode_donasi', 'like', "%{$search}%")
                  ->orWhere('nama_donatur', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $donations = $query->paginate(15)->withQueryString();

        // Hitung statistik untuk badge status
        $counts = [
            'pending_verification' => Donation::where('status', 'pending_verification')->count(),
            'pending_payment' => Donation::where('status', 'pending_payment')->count(),
            'verified' => Donation::where('status', 'verified')->count(),
            'rejected' => Donation::where('status', 'rejected')->count(),
            'all' => Donation::count(),
        ];

        return view('admin.donasi.index', compact('donations', 'status', 'counts'));
    }

    /**
     * Verifikasi & Terima Donasi
     */
    public function verify($id)
    {
        $donation = Donation::with('program')->findOrFail($id);

        if ($donation->status === 'verified') {
            return redirect()->back()->with('info', 'Donasi ini sudah berstatus terverifikasi sebelumnya.');
        }

        $donation->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => Auth::id(),
        ]);

        // 1. Tambahkan nominal ke dana_terkumpul program
        $program = $donation->program;
        $program->increment('dana_terkumpul', $donation->nominal);

        // 2. Sinkronkan ke Catatan Kas Keuangan (Pemasukan)
        $kategori = KategoriKeuangan::firstOrCreate(
            ['nama_kategori' => $program->nama]
        );

        Keuangan::create([
            'kategori_id' => $kategori->id,
            'tipe' => 'Pemasukan',
            'nominal' => $donation->nominal,
            'keterangan' => 'Donasi: ' . $program->nama . ' dari ' . $donation->displayName . ' (' . $donation->kode_donasi . ')',
            'tanggal' => now()->toDateString(),
        ]);

        return redirect()->back()->with('success', 'Donasi ' . $donation->kode_donasi . ' sebesar Rp ' . number_format($donation->nominal, 0, ',', '.') . ' berhasil diverifikasi dan dicatat ke kas!');
    }

    /**
     * Tolak / Batalkan Donasi
     */
    public function reject(Request $request, $id)
    {
        $donation = Donation::findOrFail($id);

        $request->validate([
            'catatan_admin' => 'nullable|string|max:255',
        ]);

        $donation->update([
            'status' => 'rejected',
            'catatan_admin' => $request->catatan_admin ?? 'Bukti transfer tidak sesuai atau dana belum masuk.',
            'verified_by' => Auth::id(),
        ]);

        return redirect()->back()->with('success', 'Donasi ' . $donation->kode_donasi . ' telah ditolak.');
    }

    /**
     * Form Input Manual Donasi (Donasi Offline / Kotak Infaq / Titipan Langsung)
     */
    public function createManual()
    {
        $programs = Program::where('is_active', true)->orderBy('nama')->get();
        return view('admin.donasi.manual', compact('programs'));
    }

    /**
     * Simpan Donasi Manual oleh Admin
     */
    public function storeManual(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'nama_donatur' => 'nullable|string|max:100',
            'is_anonim' => 'nullable|boolean',
            'nominal' => 'required|integer|min:1000',
            'tanggal' => 'required|date',
            'metode_pembayaran' => 'required|string',
            'no_hp' => 'nullable|string|max:20',
            'doa' => 'nullable|string|max:500',
            'catatan_admin' => 'nullable|string|max:255',
        ]);

        $program = Program::findOrFail($request->program_id);
        $kodeDonasi = 'ALF-MANUAL-' . date('Ymd') . '-' . strtoupper(Str::random(4));

        $namaDonatur = $request->nama_donatur ?: ($request->boolean('is_anonim') ? 'Hamba Allah' : 'Donatur Langsung');

        $donation = Donation::create([
            'kode_donasi' => $kodeDonasi,
            'program_id' => $program->id,
            'user_id' => Auth::id(),
            'nama_donatur' => $namaDonatur,
            'is_anonim' => $request->boolean('is_anonim'),
            'no_hp' => $request->no_hp ?: '-',
            'nominal' => $request->nominal,
            'kode_unik' => 0,
            'total_pembayaran' => $request->nominal,
            'bank_tujuan' => $request->metode_pembayaran,
            'status' => 'verified',
            'doa' => $request->doa,
            'is_manual' => true,
            'metode_pembayaran' => $request->metode_pembayaran,
            'catatan_admin' => $request->catatan_admin ?: 'Input manual oleh ' . Auth::user()->name,
            'verified_at' => $request->tanggal . ' 12:00:00',
            'verified_by' => Auth::id(),
        ]);

        // 1. Tambah dana terkumpul program
        $program->increment('dana_terkumpul', $request->nominal);

        // 2. Sinkron ke Keuangan
        $kategori = KategoriKeuangan::firstOrCreate(['nama_kategori' => $program->nama]);
        Keuangan::create([
            'kategori_id' => $kategori->id,
            'tipe' => 'Pemasukan',
            'nominal' => $request->nominal,
            'keterangan' => 'Donasi Manual: ' . $program->nama . ' - ' . $namaDonatur,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->route('admin.donasi.index', ['status' => 'verified'])
            ->with('success', 'Donasi manual berhasil dicatat dan dana program telah diperbarui!');
    }
}
