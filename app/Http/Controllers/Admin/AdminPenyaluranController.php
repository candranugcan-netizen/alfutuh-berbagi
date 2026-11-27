<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\Penyaluran;
use App\Models\Program;
use App\Models\KategoriKeuangan;
use App\Models\Keuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminPenyaluranController extends Controller
{
    /**
     * Tampilkan riwayat penyaluran dana (ambil donasi) & form input
     */
    public function index(Request $request)
    {
        $programs = Program::where('is_active', true)
            ->withSum('verifiedDonations as total_donasi_terverifikasi', 'nominal')
            ->withSum('penyalurans as total_penyaluran', 'nominal')
            ->orderBy('nama')
            ->get();
        $sisaDanaProgram = $programs->mapWithKeys(fn ($program) => [
            $program->id => max(0, (int) $program->total_donasi_terverifikasi - (int) $program->total_penyaluran),
        ]);
        $query = Penyaluran::with('program')->latest('created_at')->latest('id');

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $penyalurans = $query->paginate(15)->withQueryString();
        $totalPenyaluran = Penyaluran::sum('nominal');

        return view('admin.penyaluran.index', compact('penyalurans', 'programs', 'totalPenyaluran', 'sisaDanaProgram'));
    }

    /**
     * Ambil Donasi / Catat Penyaluran Dana Program
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'judul' => 'required|string|max:255',
            'nominal' => 'required|integer|min:1000',
            'tanggal' => 'required|date',
            'penerima' => 'required|string|max:255',
            'keterangan' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ], [
            'program_id.required' => 'Pilih program donasi asal dana yang disalurkan.',
            'nominal.min' => 'Nominal penyaluran minimal Rp 1.000.',
            'penerima.required' => 'Tuliskan penerima manfaat donasi.',
            'keterangan.required' => 'Tuliskan laporan rincian penggunaan dana.',
        ]);

        $availableDonation = (int) Donation::where('program_id', $validated['program_id'])
            ->where('status', 'verified')
            ->sum('nominal')
            - (int) Penyaluran::where('program_id', $validated['program_id'])->sum('nominal');
        $availableDonation = max(0, $availableDonation);

        if ($validated['nominal'] > $availableDonation) {
            return back()->withInput()->withErrors([
                'nominal' => 'Nominal penyaluran melebihi sisa donasi program yang tersedia (Maksimal Rp ' . number_format($availableDonation, 0, ',', '.') . ').',
            ]);
        }

        $program = Program::findOrFail($validated['program_id']);

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('penyaluran', 'public');
        }

        $penyaluran = Penyaluran::create([
            'program_id' => $program->id,
            'judul' => $validated['judul'],
            'nominal' => $validated['nominal'],
            'tanggal' => $validated['tanggal'],
            'penerima' => $validated['penerima'],
            'keterangan' => $validated['keterangan'],
            'foto' => $fotoPath,
            'user_id' => Auth::id(),
        ]);

        // Catat ke Buku Kas Keuangan sebagai Pengeluaran transparan
        $kategori = KategoriKeuangan::firstOrCreate(['nama_kategori' => 'Penyaluran: ' . $program->nama]);
        Keuangan::create([
            'kategori_id' => $kategori->id,
            'tipe' => 'Pengeluaran',
            'nominal' => $validated['nominal'],
            'keterangan' => 'Penyaluran: ' . $validated['judul'] . ' (' . $program->nama . ' - ' . $validated['penerima'] . ')',
            'tanggal' => $validated['tanggal'],
        ]);

        return redirect()->route('admin.penyaluran.index')
            ->with('success', 'Penyaluran dana Rp ' . number_format($validated['nominal'], 0, ',', '.') . ' berhasil dicatat dan dipublikasikan di laporan transparan!');
    }

    /**
     * Hapus Data Penyaluran
     */
    public function destroy($id)
    {
        $penyaluran = Penyaluran::findOrFail($id);

        if ($penyaluran->foto && Storage::disk('public')->exists($penyaluran->foto)) {
            Storage::disk('public')->delete($penyaluran->foto);
        }

        $penyaluran->delete();

        return redirect()->back()->with('success', 'Data penyaluran berhasil dihapus.');
    }
}
