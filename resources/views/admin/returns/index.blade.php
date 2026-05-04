@extends('layouts.app')

@section('content')
<div style="padding: 2rem; background: #f9fafb; min-height: 100vh;">

    <div style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #7B1B2A; margin: 0 0 0.25rem;">Pengembalian</h2>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Sistem Informasi Manajemen Inventaris</p>
    </div>

    @if (session('success'))
        <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: #dcfce7; color: #15803d; border-radius: 0.5rem; font-size: 0.875rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">

        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f3f4f6;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin: 0;">Manajemen Pengembalian</h3>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Nama Peminjam</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Barang</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Tanggal Pinjam</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Tanggal Jatuh Tempo</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Tanggal Dikembalikan</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Denda</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Status</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($returns as $item)
                        @php
                            $sudahKembali = $item->returnItem && $item->returnItem->status === 'sudah';
                            $tanggalPinjam = $item->created_at;
                            $tanggalJatuhTempo = $tanggalPinjam->copy()->addDays($item->duration_days);
                            $tanggalKembali = $item->returnItem?->return_date
                                ? \Carbon\Carbon::parse($item->returnItem->return_date)
                                : null;
                            $denda = $item->returnItem?->denda ?? 0;
                        @endphp
                        <tr style="border-bottom: 1px solid #f9fafb;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">
                            <td style="padding: 1rem 1.25rem; font-weight: 600; color: #111827;">{{ $item->borrower_name }}</td>
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ $item->inventory->name ?? '-' }}</td>
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ $tanggalPinjam->format('j M Y') }}</td>
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ $tanggalJatuhTempo->format('j M Y') }}</td>
                            <td style="padding: 1rem 1.25rem; color: #374151;">
                                {{ $tanggalKembali ? $tanggalKembali->format('j M Y') : '-' }}
                            </td>
                            <td style="padding: 1rem 1.25rem;">
                                @if($denda > 0)
                                    <span style="color: #dc2626; font-weight: 600;">Rp {{ number_format($denda, 0, ',', '.') }}</span>
                                @else
                                    <span style="color: #9ca3af;">-</span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.25rem;">
                                @if($sudahKembali)
                                    <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.875rem; font-size: 0.75rem; font-weight: 600; color: #1d4ed8; background: #dbeafe; border-radius: 9999px;">Sudah Dikembalikan</span>
                                @else
                                    <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.875rem; font-size: 0.75rem; font-weight: 600; color: #b45309; background: #fef3c7; border-radius: 9999px;">Belum Dikembalikan</span>
                                @endif
                            </td>
                            <td style="padding: 1rem 1.25rem;">
                                @if(!$sudahKembali)
                                    <form action="{{ route('returns.confirm', $item->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: #FACC15; color: #111; font-weight: 700; font-size: 0.8rem; border: none; border-radius: 0.5rem; cursor: pointer;"
                                            onmouseover="this.style.background='#eab308'"
                                            onmouseout="this.style.background='#FACC15'">
                                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Konfirmasi Kembali
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="padding: 2rem; text-align: center; color: #9ca3af;">Belum ada data pengembalian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
