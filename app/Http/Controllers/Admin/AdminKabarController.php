<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kabar;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminKabarController extends Controller
{
    public function index()
    {
        $kabars = Kabar::with('program')->latest('tanggal')->get();
        return view('admin.kabars.index', compact('kabars'));
    }

    public function create()
    {
        $programs = Program::where('is_active', true)->orderBy('nama')->get();
        return view('admin.kabars.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'program_id' => 'nullable|exists:programs,id',
            'tanggal' => 'required|date',
            'ringkasan' => 'nullable|string|max:300',
            'konten' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'is_published' => 'nullable|boolean',
        ]);

        $slug = Str::slug($validated['judul']);
        $count = Kabar::where('slug', 'like', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('kabars', 'public');
        }

        Kabar::create([
            'judul' => $validated['judul'],
            'slug' => $slug,
            'program_id' => $validated['program_id'],
            'tanggal' => $validated['tanggal'],
            'ringkasan' => $validated['ringkasan'],
            'konten' => $validated['konten'],
            'foto' => $fotoPath,
            'penulis' => Auth::user()->name ?? 'Admin Al Futuh',
            'is_published' => $request->boolean('is_published', true),
        ]);

        return redirect()->route('admin.kabar.index')->with('success', 'Kabar terbaru berhasil diterbitkan!');
    }

    public function edit($id)
    {
        $kabar = Kabar::findOrFail($id);
        $programs = Program::where('is_active', true)->orderBy('nama')->get();
        return view('admin.kabars.edit', compact('kabar', 'programs'));
    }

    public function update(Request $request, $id)
    {
        $kabar = Kabar::findOrFail($id);

        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'program_id' => 'nullable|exists:programs,id',
            'tanggal' => 'required|date',
            'ringkasan' => 'nullable|string|max:300',
            'konten' => 'required|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'is_published' => 'nullable|boolean',
        ]);

        if ($request->hasFile('foto')) {
            if ($kabar->foto && Storage::disk('public')->exists($kabar->foto)) {
                Storage::disk('public')->delete($kabar->foto);
            }
            $validated['foto'] = $request->file('foto')->store('kabars', 'public');
        }

        $validated['is_published'] = $request->boolean('is_published');

        $kabar->update($validated);

        return redirect()->route('admin.kabar.index')->with('success', 'Kabar terbaru berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $kabar = Kabar::findOrFail($id);

        if ($kabar->foto && Storage::disk('public')->exists($kabar->foto)) {
            Storage::disk('public')->delete($kabar->foto);
        }

        $kabar->delete();

        return redirect()->route('admin.kabar.index')->with('success', 'Kabar berhasil dihapus.');
    }
}
