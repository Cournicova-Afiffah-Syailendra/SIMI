<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan SIMI</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #111; }
        h2 { color: #7f1d1d; margin-bottom: 0.25rem; }
        p { margin: 0; color: #6b7280; font-size: 11px; }
        .summary { display: flex; gap: 2rem; margin: 1rem 0; }
        .summary-item { border-left: 3px solid #7f1d1d; padding-left: 0.75rem; }
        .summary-item .label { font-size: 10px; color: #6b7280; }
        .summary-item .value { font-size: 14px; font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        thead { background: #f3f4f6; }
        th { padding: 0.6rem 0.75rem; text-align: left; font-size: 11px; color: #374151; border-bottom: 1px solid #e5e7eb; }
        td { padding: 0.6rem 0.75rem; font-size: 11px; border-bottom: 1px solid #f3f4f6; }
        .badge-pinjam { background: #dbeafe; color: #1d4ed8; padding: 2px 8px; border-radius: 999px; font-size: 10px; }
        .badge-kembali { background: #dcfce7; color: #15803d; padding: 2px 8px; border-radius: 999px; font-size: 10px; }
        .badge-denda { background: #fee2e2; color: #dc2626; padding: 2px 8px; border-radius: 999px; font-size: 10px; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        tfoot td { font-weight: bold; border-top: 2px solid #e5e7eb; }
    </style>
</head>
<body>
    <h2>Laporan SIMI</h2>
    <p>PK IMM Siti Munjiyah</p>

    <div style="margin: 1rem 0; display: flex; gap: 2rem;">
        <div style="border-left: 3px solid #7f1d1d; padding-left: 0.75rem;">
            <div style="font-size: 10px; color: #6b7280;">Total Transaksi</div>
            <div style="font-size: 18px; font-weight: bold;">{{ $totalTransaksi }}</div>
        </div>
        <div style="border-left: 3px solid #FACC15; padding-left: 0.75rem;">
            <div style="font-size: 10px; color: #6b7280;">Total Pendapatan</div>
            <div style="font-size: 18px; font-weight: bold;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        </div>
        <div style="border-left: 3px solid #22c55e; padding-left: 0.75rem;">
            <div style="font-size: 10px; color: #6b7280;">Periode</div>
            <div style="font-size: 14px; font-weight: bold;">{{ $startDate->format('j M Y') }} - {{ $endDate->format('j M Y') }}</div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Detail</th>
                <th>Peminjam</th>
                <th class="text-right">Biaya</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($loanRequests as $loan)
                @php
                    $biaya = ($loan->inventory->price ?? 0) * ($loan->duration_days ?? 0);
                    $sudahKembali = $loan->returnItem && $loan->returnItem->status === 'sudah';
                @endphp

                @if($jenis === 'semua' || $jenis === 'peminjaman')
                <tr>
                    <td>{{ $loan->created_at->format('j F Y') }}</td>
                    <td><span class="badge-pinjam">Peminjaman</span></td>
                    <td>{{ $loan->inventory->name ?? '-' }}</td>
                    <td>{{ $loan->borrower_name }}</td>
                    <td class="text-right">Rp {{ number_format($biaya, 0, ',', '.') }}</td>
                </tr>
                @endif

                @if($sudahKembali && ($jenis === 'semua' || $jenis === 'pengembalian'))
                <tr>
                    <td>{{ \Carbon\Carbon::parse($loan->returnItem->return_date)->format('j F Y') }}</td>
                    <td><span class="badge-kembali">Pengembalian</span></td>
                    <td>{{ $loan->inventory->name ?? '-' }}</td>
                    <td>{{ $loan->borrower_name }}</td>
                    <td class="text-right">-</td>
                </tr>
                @endif

                @if($sudahKembali && ($loan->returnItem->denda ?? 0) > 0 && $jenis === 'semua')
                <tr>
                    <td>{{ \Carbon\Carbon::parse($loan->returnItem->return_date)->format('j F Y') }}</td>
                    <td><span class="badge-denda">Denda</span></td>
                    <td>Keterlambatan pengembalian</td>
                    <td>{{ $loan->borrower_name }}</td>
                    <td class="text-right" style="color: #dc2626;">Rp {{ number_format($loan->returnItem->denda, 0, ',', '.') }}</td>
                </tr>
                @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right">Total Pendapatan:</td>
                <td class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
