<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan Internal Yayasan Al Futuh</title>
    <style>
        @page {
            margin: 28px 35px 35px 35px;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10px;
            color: #1e293b;
            line-height: 1.4;
        }
        /* Kop Surat Resmi Yayasan */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }
        .kop-table td {
            vertical-align: middle;
            border: none;
            padding: 0;
        }
        .kop-brand {
            font-size: 18px;
            font-weight: 800;
            color: #155E4B;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin: 0;
        }
        .kop-tagline {
            font-size: 9px;
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 2px 0 3px 0;
        }
        .kop-address {
            font-size: 8px;
            color: #64748b;
            line-height: 1.3;
            margin: 0;
        }
        .kop-divider-double {
            border-top: 2px solid #155E4B;
            border-bottom: 1px solid #155E4B;
            height: 2px;
            margin-bottom: 14px;
        }
        /* Judul Laporan */
        .report-title-box {
            text-align: center;
            margin-bottom: 14px;
        }
        .report-title {
            font-size: 13px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0;
        }
        .report-subtitle {
            font-size: 9.5px;
            font-weight: bold;
            color: #155E4B;
            margin: 2px 0;
        }
        .report-period {
            font-size: 8.5px;
            color: #64748b;
            margin: 0;
        }
        /* Ringkasan Eksekutif */
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        .summary-card {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            background-color: #f8fafc;
            border-radius: 6px;
        }
        .summary-card-title {
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            color: #64748b;
            margin-bottom: 3px;
        }
        .summary-card-amount {
            font-size: 13px;
            font-weight: 800;
        }
        .text-green { color: #155E4B; }
        .text-rose { color: #b91c1c; }
        .text-slate { color: #0f172a; }

        /* Tabel Data */
        .section-header {
            font-size: 10px;
            font-weight: bold;
            color: #155E4B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 10px 0 5px 0;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 3px;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #cbd5e1;
            padding: 5px 6px;
            text-align: left;
        }
        table.data-table th {
            background-color: #155E4B;
            color: #ffffff;
            font-size: 8.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        table.data-table tr:nth-child(even) td {
            background-color: #f8fafc;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* Kolom Tanda Tangan */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }
        .signature-table td {
            border: none;
            padding: 0;
            text-align: center;
            vertical-align: top;
            width: 50%;
        }
        .signature-space {
            height: 55px;
        }
        .signature-name {
            font-weight: bold;
            text-decoration: underline;
            font-size: 9.5px;
        }
        .signature-role {
            font-size: 8px;
            color: #64748b;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI YAYASAN -->
    <table class="kop-table">
        <tr>
            <td style="width: 15%; text-align: center;">
                <img src="{{ public_path('images/icon-192.png') }}" width="50" height="50" style="object-fit: contain;">
            </td>
            <td style="width: 85%; padding-left: 10px;">
                <h1 class="kop-brand">AL FUTUH</h1>
                <p class="kop-tagline">Sub Yayasan dari Yayasan Tebar Dakwah Al Islamy</p>
                <p class="kop-address">
                    Klepu, Rejosari, Semin, Gunungkidul, Daerah Istimewa Yogyakarta<br>
                    Izin Kemenkumham Nomor : AHU 0006697.AH.01.04 • Telp/WhatsApp: 0812-3456-7890
                </p>
            </td>
        </tr>
    </table>
    <div class="kop-divider-double"></div>

    <!-- JUDUL LAPORAN -->
    <div class="report-title-box">
        <h2 class="report-title">LAPORAN KEUANGAN INTERNAL YAYASAN</h2>
        <p class="report-subtitle">Realisasi Pos Anggaran Kegiatan Dakwah &amp; Operasional dari Donasi Umum</p>
        <p class="report-period">
            Periode: 
            <strong>
                {{ $startDate ? \Carbon\Carbon::parse($startDate)->isoFormat('D MMMM Y') : 'Awal' }}
                s/d 
                {{ $endDate ? \Carbon\Carbon::parse($endDate)->isoFormat('D MMMM Y') : 'Sekarang' }}
            </strong>
            @if($kategoriTerpilih)
                • Program: <strong>{{ $kategoriTerpilih->nama_kategori }}</strong>
            @endif
        </p>
    </div>

    <!-- RINGKASAN EKSEKUTIF -->
    <table class="summary-table">
        <tr>
            <td style="width: 33%; padding-right: 4px;">
                <div class="summary-card">
                    <div class="summary-card-title">Total Donasi Operasional</div>
                    <div class="summary-card-amount text-green">Rp {{ number_format($totalDonasiOperasional, 0, ',', '.') }}</div>
                    <div style="font-size: 8px; color: #155E4B; margin-top: 3px; font-weight: bold;">
                        Sisa siap dicairkan: Rp {{ number_format(max(0, $sisaBisaDicairkan), 0, ',', '.') }}
                    </div>
                </div>
            </td>
            <td style="width: 33%; padding: 0 2px;">
                <div class="summary-card">
                    <div class="summary-card-title">Total Pencairan Dana</div>
                    <div class="summary-card-amount text-green">Rp {{ number_format($totalPencairanDana, 0, ',', '.') }}</div>
                    <div style="font-size: 8px; color: #64748b; margin-top: 3px;">
                        Dicairkan ke pos-pos kegiatan
                    </div>
                </div>
            </td>
            <td style="width: 34%; padding-left: 4px;">
                <div class="summary-card">
                    <div class="summary-card-title">Total Pengeluaran Kegiatan</div>
                    <div class="summary-card-amount text-rose">
                        Rp {{ number_format($totalPengeluaranKegiatan, 0, ',', '.') }}
                    </div>
                    <div style="font-size: 8px; color: #64748b; margin-top: 3px;">
                        Realisasi biaya pos kegiatan
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- 1. REKAPITULASI REALISASI PER PROGRAM KEGIATAN -->
    <div class="section-header">1. Rekapitulasi Realisasi per Program Kegiatan Yayasan</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th style="width: 45%;">Nama Pos Program Kegiatan Yayasan</th>
                <th style="width: 16%;" class="text-right">Dana Dicairkan</th>
                <th style="width: 17%;" class="text-right">Biaya Pengeluaran</th>
                <th style="width: 17%;" class="text-right">Sisa Saldo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($statKegiatan as $idx => $s)
                <tr>
                    <td class="text-center">{{ $idx + 1 }}</td>
                    <td><strong>{{ $s->nama }}</strong></td>
                    <td class="text-right text-green">Rp {{ number_format($s->pemasukan, 0, ',', '.') }}</td>
                    <td class="text-right text-rose">Rp {{ number_format($s->pengeluaran, 0, ',', '.') }}</td>
                    <td class="text-right" style="font-weight: bold; color: {{ $s->saldo >= 0 ? '#155E4B' : '#b91c1c' }}">
                        Rp {{ number_format($s->saldo, 0, ',', '.') }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- 2. JURNAL DETAIL ARUS KAS INTERNAL -->
    <div class="section-header">2. Jurnal Rincian Transaksi Penggunaan Dana</div>
    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 4%;" class="text-center">No</th>
                <th style="width: 11%;" class="text-center">Tanggal</th>
                <th style="width: 25%;">Pos Kegiatan</th>
                <th style="width: 18%;">Penanggung Jawab / Penerima</th>
                <th style="width: 27%;">Rincian Penggunaan Anggaran</th>
                <th style="width: 15%;" class="text-right">Nominal (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transaksis as $i => $tx)
                <tr>
                    <td class="text-center">{{ $i + 1 }}</td>
                    <td class="text-center">{{ $tx->tanggal ? $tx->tanggal->format('d/m/Y') : '-' }}</td>
                    <td>
                        <strong>{{ $tx->kategori->nama_kategori ?? 'Operasional' }}</strong>
                        <div style="font-size: 7.5px; color: {{ $tx->tipe === 'Pemasukan' ? '#155E4B' : '#b91c1c' }}">
                            {{ $tx->tipe === 'Pemasukan' ? '[+] Alokasi Masuk' : '[-] Biaya Kegiatan' }}
                        </div>
                    </td>
                    <td>{{ $tx->penanggung_jawab ?: '-' }}</td>
                    <td>{{ $tx->keterangan }}</td>
                    <td class="text-right" style="font-weight: bold; color: {{ $tx->tipe === 'Pemasukan' ? '#155E4B' : '#b91c1c' }}">
                        {{ $tx->tipe === 'Pemasukan' ? '+' : '-' }} Rp {{ number_format($tx->nominal, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center" style="padding: 12px; color: #94a3b8;">
                        Tidak ada transaksi keuangan internal pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- TANDA TANGAN RESMI PENGURUS YAYASAN -->
    <table class="signature-table">
        <tr>
            <td>
                <p style="margin: 0;">Mengetahui,</p>
                <p style="margin: 0; font-weight: bold;">Pimpinan Yayasan</p>
                <div class="signature-space"></div>
                <p class="signature-name">( Ustadz Erwin Siregar, S.H. )</p>
                <p class="signature-role">Pimpinan Yayasan</p>
            </td>
            <td>
                <p style="margin: 0;">Dibuat pada {{ date('d F Y') }}</p>
                <p style="margin: 0; font-weight: bold;">Bendahara / Pengelola Keuangan</p>
                <div class="signature-space"></div>
                <p class="signature-name">( {{ Auth::user()->name ?? 'Admin Keuangan' }} )</p>
                <p class="signature-role">Bendahara Operasional Yayasan</p>
            </td>
        </tr>
    </table>

</body>
</html>
