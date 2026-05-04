@extends('layouts.user')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">

    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #7B1B2A; margin: 0 0 0.25rem;">Riwayat Peminjaman</h1>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Daftar semua peminjaman yang pernah dilakukan</p>
    </div>

    <div style="background:#fff; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,0.08); overflow:hidden;">
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:0.875rem;">
                <thead style="background:#f9fafb;">
                    <tr>
                        <th style="padding:0.875rem 1.25rem; font-weight:600; color:#374151; text-align:left; border-bottom:1px solid #f3f4f6;">No</th>
                        <th style="padding:0.875rem 1.25rem; font-weight:600; color:#374151; text-align:left; border-bottom:1px solid #f3f4f6;">Inventaris</th>
                        <th style="padding:0.875rem 1.25rem; font-weight:600; color:#374151; text-align:left; border-bottom:1px solid #f3f4f6;">Tanggal Pinjam</th>
                        <th style="padding:0.875rem 1.25rem; font-weight:600; color:#374151; text-align:left; border-bottom:1px solid #f3f4f6;">Durasi</th>
                        <th style="padding:0.875rem 1.25rem; font-weight:600; color:#374151; text-align:left; border-bottom:1px solid #f3f4f6;">Total Biaya</th>
                        <th style="padding:0.875rem 1.25rem; font-weight:600; color:#374151; text-align:left; border-bottom:1px solid #f3f4f6;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $index => $loan)
                    <tr style="border-bottom:1px solid #f9fafb;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">
                        <td style="padding:1rem 1.25rem; color:#374151;">{{ $index + 1 }}</td>
                        <td style="padding:1rem 1.25rem; font-weight:600; color:#111827;">{{ $loan->inventory->name ?? '-' }}</td>
                        <td style="padding:1rem 1.25rem; color:#374151;">{{ $loan->created_at->format('j M Y') }}</td>
                        <td style="padding:1rem 1.25rem; color:#374151;">{{ $loan->duration_days }} hari</td>
                        <td style="padding:1rem 1.25rem; font-weight:600; color:#7B1B2A;">Rp {{ number_format(($loan->inventory->price ?? 0) * $loan->duration_days, 0, ',', '.') }}</td>
                        <td style="padding:1rem 1.25rem;">
                            @if($loan->status === 'approved')
                                <span style="font-size:0.75rem; padding:0.25rem 0.75rem; border-radius:9999px; background:#dcfce7; color:#15803d; font-weight:600;">Disetujui</span>
                            @elseif($loan->status === 'pending')
                                <span style="font-size:0.75rem; padding:0.25rem 0.75rem; border-radius:9999px; background:#fef9c3; color:#a16207; font-weight:600;">Menunggu</span>
                            @else
                                <span style="font-size:0.75rem; padding:0.25rem 0.75rem; border-radius:9999px; background:#fee2e2; color:#dc2626; font-weight:600;">Ditolak</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:2rem; text-align:center; color:#9ca3af;">Belum ada riwayat peminjaman.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
