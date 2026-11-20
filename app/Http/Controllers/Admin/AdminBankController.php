<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\Request;

class AdminBankController extends Controller
{
    public function index()
    {
        $banks = BankAccount::orderBy('urutan')->get();
        return view('admin.banks.index', compact('banks'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_bank' => 'required|string|max:100',
            'kode_bank' => 'nullable|string|max:20',
            'nomor_rekening' => 'required|string|max:50',
            'atas_nama' => 'required|string|max:100',
            'instruksi' => 'nullable|string|max:255',
        ]);

        BankAccount::create([
            'nama_bank' => $validated['nama_bank'],
            'kode_bank' => $validated['kode_bank'] ?: strtoupper(explode(' ', $validated['nama_bank'])[0]),
            'nomor_rekening' => $validated['nomor_rekening'],
            'atas_nama' => $validated['atas_nama'],
            'instruksi' => $validated['instruksi'],
            'is_active' => true,
            'urutan' => BankAccount::max('urutan') + 1,
        ]);

        return redirect()->route('admin.banks.index')->with('success', 'Rekening bank tujuan berhasil ditambahkan!');
    }

    public function destroy($id)
    {
        $bank = BankAccount::findOrFail($id);
        $bank->delete();

        return redirect()->route('admin.banks.index')->with('success', 'Rekening bank berhasil dihapus.');
    }
}
