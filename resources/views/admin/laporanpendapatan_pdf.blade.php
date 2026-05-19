<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Pendapatan – SportField</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #1f2937;
            background: #fff;
            padding: 30px 40px;
        }

        /* HEADER */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #16a34a;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }
        .brand {
            font-size: 22px;
            font-weight: 900;
            color: #111;
            letter-spacing: -0.5px;
        }
        .brand span { color: #16a34a; }
        .doc-info { text-align: right; color: #6b7280; font-size: 10px; line-height: 1.6; }
        .doc-info strong { color: #111; font-size: 11px; }

        /* SUMMARY */
        .summary-section { margin-bottom: 20px; }
        .section-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
            margin-bottom: 10px;
        }
        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }
        .summary-card {
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 12px;
            background: #f9fafb;
        }
        .summary-label { font-size: 9.5px; color: #6b7280; margin-bottom: 4px; }
        .summary-value { font-size: 14px; font-weight: 700; }
        .green { color: #16a34a; }
        .blue { color: #2563eb; }
        .purple { color: #7c3aed; }
        .orange { color: #ea580c; }

        /* FILTER INFO */
        .filter-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 20px;
            font-size: 10px;
            color: #166534;
        }
        .filter-box strong { margin-right: 4px; }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        thead tr {
            background: #16a34a;
            color: #fff;
        }
        thead th {
            padding: 9px 10px;
            text-align: left;
            font-size: 9.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody tr:nth-child(odd) { background: #fff; }
        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: top;
            font-size: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 20px;
            font-size: 9px;
            font-weight: 600;
        }
        .status-confirmed { background: #dbeafe; color: #1d4ed8; }
        .status-completed { background: #dcfce7; color: #15803d; }
        .status-pending   { background: #fef9c3; color: #a16207; }
        .status-cancelled { background: #fee2e2; color: #b91c1c; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }
        .text-green { color: #16a34a; }
        .text-muted { color: #9ca3af; font-size: 9px; }

        tfoot tr {
            background: #1f2937;
            color: #fff;
        }
        tfoot td {
            padding: 10px;
            font-size: 11px;
            font-weight: 700;
        }
        .total-label { text-align: right; }
        .total-value { color: #4ade80; }

        /* FOOTER */
        .pdf-footer {
            border-top: 1px solid #e5e7eb;
            padding-top: 12px;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #9ca3af;
        }

        /* Page break */
        @page { size: A4 landscape; margin: 0; }
    </style>
</head>
<body>

    <!-- HEADER -->
    <div class="header">
        <div>
            <div class="brand">Sport<span>Field</span></div>
            <div style="font-size:11px; color:#6b7280; margin-top:3px;">Laporan Pendapatan Booking Lapangan</div>
        </div>
        <div class="doc-info">
            <strong>Laporan Pendapatan</strong><br>
            Dicetak: {{ now()->format('d M Y, H:i') }}<br>
            @if(request('dari') || request('sampai'))
                Periode:
                @if(request('dari')) {{ \Carbon\Carbon::parse(request('dari'))->format('d M Y') }} @else Awal @endif
                –
                @if(request('sampai')) {{ \Carbon\Carbon::parse(request('sampai'))->format('d M Y') }} @else Sekarang @endif
            @else
                Periode: Semua Waktu
            @endif
        </div>
    </div>

    <!-- FILTER INFO -->
    @if(request('dari') || request('sampai') || request('status') || request('lapangan_id'))
    <div class="filter-box">
        <strong>Filter aktif:</strong>
        @if(request('dari')) Dari: {{ \Carbon\Carbon::parse(request('dari'))->format('d M Y') }} &nbsp;&nbsp; @endif
        @if(request('sampai')) Sampai: {{ \Carbon\Carbon::parse(request('sampai'))->format('d M Y') }} &nbsp;&nbsp; @endif
        @if(request('status')) Status: {{ ucfirst(request('status')) }} &nbsp;&nbsp; @endif
        @if(request('lapangan_id') && $lapangans->find(request('lapangan_id'))) Lapangan: {{ $lapangans->find(request('lapangan_id'))->nama_lapangan }} @endif
    </div>
    @endif

    <!-- SUMMARY CARDS -->
    <div class="summary-section">
        <div class="section-title">Ringkasan</div>
        <div class="summary-grid">
            <div class="summary-card">
                <div class="summary-label">Total Pendapatan</div>
                <div class="summary-value green">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Total Transaksi</div>
                <div class="summary-value blue">{{ $totalTransaksiAll }}</div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Rata-rata / Transaksi</div>
                <div class="summary-value purple">
                    Rp {{ $totalTransaksiAll > 0 ? number_format($totalPendapatan / $totalTransaksiAll, 0, ',', '.') : '0' }}
                </div>
            </div>
            <div class="summary-card">
                <div class="summary-label">Total Jam Terisi</div>
                <div class="summary-value orange">{{ $totalJam }} Jam</div>
            </div>
        </div>
    </div>

    <!-- TABLE -->
    <div class="section-title">Detail Transaksi</div>
    <table>
        <thead>
            <tr>
                <th style="width:30px">No</th>
                <th style="width:80px">Tanggal</th>
                <th>Pemesan</th>
                <th>Lapangan</th>
                <th>Kategori</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
                <th style="width:45px">Durasi</th>
                <th style="width:55px">Status</th>
                <th style="width:90px" class="text-right">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($allBookings as $i => $item)
            @php
                $durasi = \Carbon\Carbon::parse($item->jam_mulai)->diffInHours(\Carbon\Carbon::parse($item->jam_selesai));
                $pendapatan = $item->lapangan->harga_sewa * $durasi;
            @endphp
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                <td>{{ $item->user->name ?? '-' }}</td>
                <td class="font-bold">{{ $item->lapangan->nama_lapangan }}</td>
                <td>{{ $item->lapangan->jenisLapangan->nama_jenis ?? '-' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }}</td>
                <td>{{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}</td>
                <td>{{ $durasi }} jam</td>
                <td>
                    @if($item->status == 'confirmed')
                        <span class="status-badge status-confirmed">Dikonfirmasi</span>
                    @elseif($item->status == 'completed')
                        <span class="status-badge status-completed">Selesai</span>
                    @elseif($item->status == 'pending')
                        <span class="status-badge status-pending">Pending</span>
                    @else
                        <span class="status-badge status-cancelled">Dibatalkan</span>
                    @endif
                </td>
                <td class="text-right font-bold text-green">
                    Rp {{ number_format($pendapatan, 0, ',', '.') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="10" style="text-align:center; padding: 20px; color: #9ca3af;">
                    Tidak ada data transaksi
                </td>
            </tr>
            @endforelse
        </tbody>
        @if($allBookings->count() > 0)
        <tfoot>
            <tr>
                <td colspan="9" class="total-label">TOTAL PENDAPATAN</td>
                <td class="text-right total-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    <!-- FOOTER -->
    <div class="pdf-footer">
        <div>SportField – Platform Booking Lapangan Olahraga</div>
        <div>Dokumen ini digenerate otomatis oleh sistem pada {{ now()->format('d M Y H:i:s') }}</div>
    </div>

</body>
</html>