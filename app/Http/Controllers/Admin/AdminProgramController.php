<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\KategoriKeuangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProgramController extends Controller
{
    /**
     * Daftar Semua Program Donasi
     */
    public function index()
    {
        $programs = Program::withCount('verifiedDonations')
            ->withSum('penyalurans', 'nominal')
            ->orderBy('urutan')
            ->latest('id')
            ->get();

        return view('admin.programs.index', compact('programs'));
    }

    /**
     * Form Tambah Program Baru
     */
    public function create()
    {
        return view('admin.programs.create');
    }

    /**
     * Simpan Program Baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'icon' => 'nullable|string|max:10',
            'ringkasan' => 'required|string|max:300',
            'deskripsi' => 'required|string',
            'target_dana' => 'required|integer|min:0',
            'tipe_target' => 'required|in:berkelanjutan,terbatas',
            'tenggat_waktu' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $slug = Str::slug($validated['nama']);
        // Cek keunikan slug
        $count = Program::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $bannerPath = null;
        if ($request->hasFile('banner')) {
            $bannerPath = $request->file('banner')->store('programs', 'public');
        }

        Program::create([
            'nama' => $validated['nama'],
            'slug' => $slug,
            'kategori' => $validated['kategori'],
            'icon' => $validated['icon'] ?: '🤲',
            'ringkasan' => $validated['ringkasan'],
            'deskripsi' => $validated['deskripsi'],
            'target_dana' => $validated['target_dana'],
            'dana_terkumpul' => 0,
            'banner' => $bannerPath,
            'tipe_target' => $validated['tipe_target'],
            'tenggat_waktu' => $validated['tenggat_waktu'],
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active', true),
            'urutan' => Program::max('urutan') + 1,
        ]);

        // Buat kategori keuangan otomatis
        KategoriKeuangan::firstOrCreate(['nama_kategori' => $validated['nama']]);

        return redirect()->route('admin.programs.index')->with('success', 'Program donasi "' . $validated['nama'] . '" berhasil ditambahkan!');
    }

    /**
     * Form Edit Program
     */
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        return view('admin.programs.edit', compact('program'));
    }

    /**
     * Update Data Program
     */
    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'icon' => 'nullable|string|max:10',
            'ringkasan' => 'required|string|max:300',
            'deskripsi' => 'required|string',
            'target_dana' => 'required|integer|min:0',
            'dana_terkumpul' => 'required|integer|min:0',
            'tipe_target' => 'required|in:berkelanjutan,terbatas',
            'tenggat_waktu' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'banner' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        if ($request->hasFile('banner')) {
            if ($program->banner && Storage::disk('public')->exists($program->banner)) {
                Storage::disk('public')->delete($program->banner);
            }
            $validated['banner'] = $request->file('banner')->store('programs', 'public');
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        $program->update($validated);

        return redirect()->route('admin.programs.index')->with('success', 'Program donasi berhasil diperbarui!');
    }

    /**
     * Hapus Program
     */
    public function destroy($id)
    {
        $program = Program::findOrFail($id);

        if ($program->banner && Storage::disk('public')->exists($program->banner)) {
            Storage::disk('public')->delete($program->banner);
        }

        $program->delete();

        return redirect()->route('admin.programs.index')->with('success', 'Program donasi telah dihapus.');
    }
}
