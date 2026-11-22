<?php

namespace App\Exports;

use App\Models\Keuangan;
use App\Models\KategoriKeuangan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanInternalExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $kategoriId;
    protected $tipe;
    protected $query;

    public function __construct($startDate = null, $endDate = null, $kategoriId = null, $tipe = null, $query = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->kategoriId = $kategoriId;
        $this->tipe = $tipe;
        $this->query = $query;
    }

    public function collection()
    {
        $internalCategoryIds = KategoriKeuangan::where('is_internal', true)->pluck('id');

        $q = Keuangan::with('kategori')
            ->where(function ($sub) use ($internalCategoryIds) {
                $sub->where('is_internal', true)
                    ->orWhereIn('kategori_id', $internalCategoryIds);
            })
            ->latest('tanggal')
            ->latest('id');

        if ($this->startDate) {
            $q->whereDate('tanggal', '>=', $this->startDate);
        }

        if ($this->endDate) {
            $q->whereDate('tanggal', '<=', $this->endDate);
        }

        if ($this->kategoriId) {
            $q->where('kategori_id', $this->kategoriId);
        }

        if ($this->tipe) {
            $q->where('tipe', $this->tipe);
        }

        if ($this->query) {
            $search = $this->query;
            $q->where(function ($sub) use ($search) {
                $sub->where('keterangan', 'like', "%{$search}%")
                    ->orWhere('penanggung_jawab', 'like', "%{$search}%");
            });
        }

        return $q->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Program / Kegiatan Internal Yayasan',
            'Tipe Transaksi',
            'Penanggung Jawab / Penerima',
            'Rincian Penggunaan Anggaran',
            'Nominal Pencairan Dana (Rp)',
            'Nominal Pengeluaran Kegiatan (Rp)',
        ];
    }

    public function map($row): array
    {
        static $index = 0;
        $index++;

        $masuk = $row->tipe === 'Pemasukan' ? $row->nominal : 0;
        $keluar = $row->tipe === 'Pengeluaran' ? $row->nominal : 0;

        return [
            $index,
            $row->tanggal ? $row->tanggal->format('d/m/Y') : '-',
            $row->kategori->nama_kategori ?? 'Operasional Umum',
            $row->tipe === 'Pemasukan' ? 'Pencairan Dana (+)' : 'Pengeluaran Kegiatan (-)',
            $row->penanggung_jawab ?? '-',
            $row->keterangan,
            $masuk,
            $keluar,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '155E4B'],
                ],
            ],
        ];
    }
}
