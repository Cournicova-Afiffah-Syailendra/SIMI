@extends('layouts.app')

@section('content')
<div style="padding: 2rem; background: #f9fafb; min-height: 100vh;">

    {{-- Filter --}}
    <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.5rem; margin-bottom: 1.5rem;">
        <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin: 0 0 1.25rem;">Filter Laporan</h3>
        <form method="GET" action="{{ route('reports.index') }}">
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1rem; align-items: end;">
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #374151; margin-bottom: 0.4rem;">Tanggal Mulai</label>
                    <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                        style="width: 100%; box-sizing: border-box; padding: 0.6rem 1rem; font-size: 0.875rem; color: #374151; border: 1px solid #e5e7eb; border-radius: 0.5rem; background: #f9fafb; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #374151; margin-bottom: 0.4rem;">Tanggal Akhir</label>
                    <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                        style="width: 100%; box-sizing: border-box; padding: 0.6rem 1rem; font-size: 0.875rem; color: #374151; border: 1px solid #e5e7eb; border-radius: 0.5rem; background: #f9fafb; outline: none;">
                </div>
                <div>
                    <label style="display: block; font-size: 0.8rem; font-weight: 600; color: #374151; margin-bottom: 0.4rem;">Jenis Transaksi</label>
                    <select name="jenis"
                        style="width: 100%; box-sizing: border-box; padding: 0.6rem 1rem; font-size: 0.875rem; color: #374151; border: 1px solid #e5e7eb; border-radius: 0.5rem; background: #f9fafb; outline: none;">
                        <option value="semua" {{ $jenis === 'semua' ? 'selected' : '' }}>Semua</option>
                        <option value="peminjaman" {{ $jenis === 'peminjaman' ? 'selected' : '' }}>Peminjaman</option>
                        <option value="pengembalian" {{ $jenis === 'pengembalian' ? 'selected' : '' }}>Pengembalian</option>
                    </select>
                </div>
            </div>
            <div style="margin-top: 1rem; display: flex; justify-content: flex-end;">
                <button type="submit"
                    style="padding: 0.6rem 1.5rem; background: #7f1d1d; color: #fff; font-weight: 700; font-size: 0.875rem; border: none; border-radius: 0.5rem; cursor: pointer;">
                    Tampilkan
                </button>
            </div>
        </form>
    </div>

    {{-- Summary Cards --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem; margin-bottom: 1.5rem;">

        <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.5rem; border-left: 4px solid #7f1d1d;">
            <p style="font-size: 0.8rem; color: #6b7280; margin: 0 0 0.5rem;">Total Transaksi</p>
            <h2 style="font-size: 2.5rem; font-weight: 700; color: #111827; margin: 0;">{{ $totalTransaksi }}</h2>
        </div>

        <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.5rem; border-left: 4px solid #FACC15;">
            <p style="font-size: 0.8rem; color: #6b7280; margin: 0 0 0.5rem;">Total Pendapatan</p>
            <h2 style="font-size: 2rem; font-weight: 700; color: #111827; margin: 0;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
        </div>

        <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); padding: 1.5rem; border-left: 4px solid #22c55e;">
            <p style="font-size: 0.8rem; color: #6b7280; margin: 0 0 0.5rem;">Periode</p>
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #111827; margin: 0;">
                {{ $startDate->format('j M Y') }} - {{ $endDate->format('j M Y') }}
            </h2>
        </div>

    </div>

    {{-- Tabel Preview --}}
    <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">

        <div style="padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f3f4f6;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin: 0;">Preview Laporan</h3>
            <div style="display: flex; gap: 0.75rem;">
                <a href="{{ route('reports.index', array_merge(request()->all(), ['export' => 'pdf'])) }}"
                    style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: #7f1d1d; color: #fff; font-weight: 700; font-size: 0.8rem; border-radius: 0.5rem; text-decoration: none;">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    Export PDF
                </a>
                <a href="{{ route('reports.index', array_merge(request()->all(), ['export' => 'excel'])) }}"
                    style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.5rem 1rem; background: #FACC15; color: #111; font-weight: 700; font-size: 0.8rem; border-radius: 0.5rem; text-decoration: none;">
                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Export Excel
                </a>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Tanggal</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Jenis</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Detail</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6;">Peminjam</th>
                        <th style="padding: 0.875rem 1.25rem; font-weight: 600; color: #374151; border-bottom: 1px solid #f3f4f6; text-align: right;">Biaya</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loanRequests as $loan)
                        @php
                            $biaya = ($loan->inventory->price ?? 0) * ($loan->duration_days ?? 0);
                            $sudahKembali = $loan->returnItem && $loan->returnItem->status === 'sudah';
                        @endphp

                        {{-- Baris Peminjaman --}}
                        @if($jenis === 'semua' || $jenis === 'peminjaman')
                        <tr style="border-bottom: 1px solid #f9fafb;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ $loan->created_at->format('j F Y') }}</td>
                            <td style="padding: 1rem 1.25rem;">
                                <span style="display: inline-flex; align-items: center; padding: 0.2rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #1d4ed8; background: #dbeafe; border-radius: 9999px;">Peminjaman</span>
                            </td>
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ $loan->inventory->name ?? '-' }}</td>
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ $loan->borrower_name }}</td>
                            <td style="padding: 1rem 1.25rem; color: #111827; font-weight: 600; text-align: right;">Rp {{ number_format($biaya, 0, ',', '.') }}</td>
                        </tr>
                        @endif

                        {{-- Baris Pengembalian --}}
                        @if($sudahKembali && ($jenis === 'semua' || $jenis === 'pengembalian'))
                        <tr style="border-bottom: 1px solid #f9fafb;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ \Carbon\Carbon::parse($loan->returnItem->return_date)->format('j F Y') }}</td>
                            <td style="padding: 1rem 1.25rem;">
                                <span style="display: inline-flex; align-items: center; padding: 0.2rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #15803d; background: #dcfce7; border-radius: 9999px;">Pengembalian</span>
                            </td>
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ $loan->inventory->name ?? '-' }}</td>
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ $loan->borrower_name }}</td>
                            <td style="padding: 1rem 1.25rem; color: #111827; font-weight: 600; text-align: right;">-</td>
                        </tr>
                        @endif

                        {{-- Baris Denda --}}
                        @if($sudahKembali && ($loan->returnItem->denda ?? 0) > 0 && ($jenis === 'semua'))
                        <tr style="border-bottom: 1px solid #f9fafb;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ \Carbon\Carbon::parse($loan->returnItem->return_date)->format('j F Y') }}</td>
                            <td style="padding: 1rem 1.25rem;">
                                <span style="display: inline-flex; align-items: center; padding: 0.2rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #dc2626; background: #fee2e2; border-radius: 9999px;">Denda</span>
                            </td>
                            <td style="padding: 1rem 1.25rem; color: #374151;">Keterlambatan pengembalian</td>
                            <td style="padding: 1rem 1.25rem; color: #374151;">{{ $loan->borrower_name }}</td>
                            <td style="padding: 1rem 1.25rem; color: #dc2626; font-weight: 600; text-align: right;">Rp {{ number_format($loan->returnItem->denda, 0, ',', '.') }}</td>
                        </tr>
                        @endif

                    @empty
                        <tr>
                            <td colspan="5" style="padding: 2rem; text-align: center; color: #9ca3af;">Tidak ada data pada periode ini.</td>
                        </tr>
                    @endforelse
                </tbody>
                @if($loanRequests->count() > 0)
                <tfoot>
                    <tr style="border-top: 2px solid #e5e7eb;">
                        <td colspan="4" style="padding: 1rem 1.25rem; font-weight: 700; color: #111827; text-align: right;">Total Pendapatan:</td>
                        <td style="padding: 1rem 1.25rem; font-weight: 700; color: #111827; text-align: right;">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>
</div>
@endsection
