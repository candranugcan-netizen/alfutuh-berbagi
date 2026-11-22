<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Kas - Al Futuh</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #333; }
        .kop-table { width: 100%; border-collapse: collapse; margin-bottom: 8px; }
        .kop-table td { border: none; padding: 0; vertical-align: middle; }
        .kop-brand { font-size: 16px; font-weight: 800; color: #155E4B; margin: 0; }
        .kop-tagline { font-size: 9px; font-weight: bold; color: #475569; margin: 2px 0; }
        .kop-address { font-size: 8px; color: #64748b; line-height: 1.3; margin: 0; }
        .kop-divider { border-top: 2px solid #155E4B; border-bottom: 1px solid #155E4B; height: 2px; margin-bottom: 12px; }
        h2 { margin-bottom: 2px; text-align: center; color: #155E4B; font-weight: 800; font-size: 12px; text-transform: uppercase; }
        p.subtitle { text-align: center; font-size: 8.5px; color: #666; margin-top: 0; margin-bottom: 15px; }
        table.data-table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.data-table th, table.data-table td { border: 1px solid #cbd5e1; padding: 5px 6px; text-align: left; }
        table.data-table th { background-color: #155E4B; color: white; text-transform: uppercase; font-size: 8.5px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .pemasukan { color: #059669; font-weight: bold; }
        .pengeluaran { color: #dc2626; font-weight: bold; }
        .summary { margin-top: 15px; float: right; width: 45%; }
        .summary table { width: 100%; border-collapse: collapse; }
        .summary td { border: none; padding: 4px; }
        .signature-table { width: 100%; border-collapse: collapse; margin-top: 35px; clear: both; }
        .signature-table td { border: none; text-align: center; width: 50%; vertical-align: top; }
        .signature-space { height: 50px; }
        .signature-name { font-weight: bold; text-decoration: underline; font-size: 9.5px; }
    </style>
</head>
<body>
    <table class="kop-table">
        <tr>
            <td style="width: 15%; text-align: center;">
                <img src="{{ public_path('images/icon-192.png') }}" width="48" height="48" style="object-fit: contain;">
            </td>
            <td style="width: 85%; padding-left: 10px;">
                <h1 class="kop-brand">AL FUTUH</h1>
                <p class="kop-tagline">Sub Yayasan dari Yayasan Tebar Dakwah Al Islamy</p>
                <p class="kop-address">
                    Klepu, Rejosari, Semin, Gunungkidul, Daerah Istimewa Yogyakarta<br>
                    Izin Kemenkumham Nomor : AHU 0006697.AH.01.04
                </p>
            </td>
        </tr>
    </table>
    <div class="kop-divider"></div>

    <h2>Laporan Buku Kas Keuangan</h2>
    <p class="subtitle">Dicetak pada: {{ date('d-m-Y H:i') }} WIB</p>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 14%;" class="text-center">Tanggal</th>
                <th style="width: 12%;" class="text-center">Tipe</th>
                <th style="width: 20%;">Kategori</th>
                <th>Keterangan</th>
                <th style="width: 18%;" class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keuangan as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">{{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') : '-' }}</td>
                <td class="text-center {{ $item->tipe == 'Pemasukan' ? 'pemasukan' : 'pengeluaran' }}">{{ $item->tipe }}</td>
                <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $item->keterangan }}</td>
                <td class="text-right">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #94a3b8; padding: 12px;">Tidak ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="summary">
        <table>
            <tr>
                <td>Total Pemasukan</td>
                <td class="text-right pemasukan">Rp {{ number_format($pemasukan, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pengeluaran</td>
                <td class="text-right pengeluaran">Rp {{ number_format($pengeluaran, 0, ',', '.') }}</td>
            </tr>
            <tr style="border-top: 1px solid #333;">
                <td><strong>Sisa Saldo</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($saldo, 0, ',', '.') }}</strong></td>
            </tr>
        </table>
    </div>

    <!-- Tanda Tangan Resmi Pengurus -->
    <table class="signature-table">
        <tr>
            <td>
                <p style="margin: 0;">Mengetahui,</p>
                <p style="margin: 0; font-weight: bold;">Pimpinan Yayasan</p>
                <div class="signature-space"></div>
                <p class="signature-name">( Ustadz Erwin Siregar, S.H. )</p>
                <p style="margin: 0; font-size: 8px; color: #64748b;">Pimpinan Yayasan</p>
            </td>
            <td>
                <p style="margin: 0;">Dibuat pada {{ date('d F Y') }}</p>
                <p style="margin: 0; font-weight: bold;">Bendahara Yayasan</p>
                <div class="signature-space"></div>
                <p class="signature-name">( {{ Auth::user()->name ?? 'Admin Keuangan' }} )</p>
                <p style="margin: 0; font-size: 8px; color: #64748b;">Bendahara</p>
            </td>
        </tr>
    </table>
</body>
</html>
