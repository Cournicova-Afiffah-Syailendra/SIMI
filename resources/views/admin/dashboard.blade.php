@extends('layouts.app')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">

    {{-- Title --}}
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #111827; margin: 0 0 0.25rem;">Dashboard</h1>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Sistem Informasi Manajemen Inventaris</p>
    </div>

    {{-- Cards --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem;">

        <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-left: 4px solid #7f1d1d;">
            <div>
                <p style="font-size: 0.8rem; color: #6b7280; margin: 0 0 0.4rem;">Total Barang</p>
                <h2 style="font-size: 2rem; font-weight: 700; color: #111827; margin: 0;">{{ $totalInventories ?? 48 }}</h2>
            </div>
            <div style="background: #3b82f6; border-radius: 0.75rem; padding: 0.75rem; font-size: 1.5rem; line-height: 1;">📦</div>
        </div>

        <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-left: 4px solid #7f1d1d;">
            <div>
                <p style="font-size: 0.8rem; color: #6b7280; margin: 0 0 0.4rem;">Barang Tersedia</p>
                <h2 style="font-size: 2rem; font-weight: 700; color: #111827; margin: 0;">35</h2>
            </div>
            <div style="background: #22c55e; border-radius: 0.75rem; padding: 0.75rem; font-size: 1.5rem; line-height: 1;">✅</div>
        </div>

        <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-left: 4px solid #7f1d1d;">
            <div>
                <p style="font-size: 0.8rem; color: #6b7280; margin: 0 0 0.4rem;">Barang Dipinjam</p>
                <h2 style="font-size: 2rem; font-weight: 700; color: #111827; margin: 0;">{{ $activeLoans ?? 13 }}</h2>
            </div>
            <div style="background: #eab308; border-radius: 0.75rem; padding: 0.75rem; font-size: 1.5rem; line-height: 1;">🛒</div>
        </div>

        <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 1.25rem; display: flex; align-items: center; justify-content: space-between; border-left: 4px solid #7f1d1d;">
            <div>
                <p style="font-size: 0.8rem; color: #6b7280; margin: 0 0 0.4rem;">Menunggu Persetujuan</p>
                <h2 style="font-size: 2rem; font-weight: 700; color: #111827; margin: 0;">{{ $pendingLoans ?? 5 }}</h2>
            </div>
            <div style="background: #f97316; border-radius: 0.75rem; padding: 0.75rem; font-size: 1.5rem; line-height: 1;">⏱</div>
        </div>

    </div>

    {{-- Grafik --}}
    <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 1.5rem;">
        <h2 style="font-size: 0.95rem; font-weight: 600; color: #111827; margin: 0 0 1rem;">Statistik Peminjaman & Pengembalian</h2>
        <div style="height: 260px; position: relative;">
            <canvas id="chartPeminjaman"></canvas>
        </div>
    </div>

    {{-- Aktivitas Terbaru --}}
    <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.08); padding: 1.5rem;">
        <h2 style="font-size: 0.95rem; font-weight: 600; color: #111827; margin: 0 0 1rem;">Aktivitas Terbaru</h2>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">

            @forelse ($latestLoanRequests ?? [] as $loan)
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.875rem 1rem; border-radius: 0.5rem; border: 1px solid #f3f4f6; background: #fafafa;">
                    <div>
                        <p style="font-size: 0.875rem; font-weight: 600; color: #111827; margin: 0 0 0.2rem;">{{ $loan->borrower_name }}</p>
                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">Meminjam {{ $loan->inventory->name ?? '-' }}</p>
                    </div>
                    @if($loan->status === 'approved')
                        <span style="font-size: 0.75rem; padding: 0.25rem 0.875rem; border-radius: 9999px; background: #dcfce7; color: #15803d; font-weight: 600;">Disetujui</span>
                    @elseif($loan->status === 'pending')
                        <span style="font-size: 0.75rem; padding: 0.25rem 0.875rem; border-radius: 9999px; background: #fef9c3; color: #a16207; font-weight: 600;">Menunggu</span>
                    @else
                        <span style="font-size: 0.75rem; padding: 0.25rem 0.875rem; border-radius: 9999px; background: #fee2e2; color: #dc2626; font-weight: 600;">Ditolak</span>
                    @endif
                </div>
            @empty
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.875rem 1rem; border-radius: 0.5rem; border: 1px solid #f3f4f6; background: #fafafa;">
                    <div>
                        <p style="font-size: 0.875rem; font-weight: 600; color: #111827; margin: 0 0 0.2rem;">Ahmad Fauzi</p>
                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">Meminjam Proyektor Epson EB-X41</p>
                    </div>
                    <span style="font-size: 0.75rem; padding: 0.25rem 0.875rem; border-radius: 9999px; background: #dcfce7; color: #15803d; font-weight: 600;">Disetujui</span>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.875rem 1rem; border-radius: 0.5rem; border: 1px solid #f3f4f6; background: #fafafa;">
                    <div>
                        <p style="font-size: 0.875rem; font-weight: 600; color: #111827; margin: 0 0 0.2rem;">Siti Nurhaliza</p>
                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">Meminjam Kursi Lipat</p>
                    </div>
                    <span style="font-size: 0.75rem; padding: 0.25rem 0.875rem; border-radius: 9999px; background: #fef9c3; color: #a16207; font-weight: 600;">Menunggu</span>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.875rem 1rem; border-radius: 0.5rem; border: 1px solid #f3f4f6; background: #fafafa;">
                    <div>
                        <p style="font-size: 0.875rem; font-weight: 600; color: #111827; margin: 0 0 0.2rem;">Budi Santoso</p>
                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">Meminjam Sound System</p>
                    </div>
                    <span style="font-size: 0.75rem; padding: 0.25rem 0.875rem; border-radius: 9999px; background: #fee2e2; color: #dc2626; font-weight: 600;">Ditolak</span>
                </div>
                <div style="display: flex; align-items: center; justify-content: space-between; padding: 0.875rem 1rem; border-radius: 0.5rem; border: 1px solid #f3f4f6; background: #fafafa;">
                    <div>
                        <p style="font-size: 0.875rem; font-weight: 600; color: #111827; margin: 0 0 0.2rem;">Dewi Lestari</p>
                        <p style="font-size: 0.75rem; color: #6b7280; margin: 0;">Meminjam Kamera DSLR Canon</p>
                    </div>
                    <span style="font-size: 0.75rem; padding: 0.25rem 0.875rem; border-radius: 9999px; background: #dcfce7; color: #15803d; font-weight: 600;">Disetujui</span>
                </div>
            @endforelse

        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('chartPeminjaman').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
            datasets: [
                {
                    label: 'Peminjaman',
                    data: [13, 18, 15, 22, 17, 27],
                    backgroundColor: '#7f1d1d',
                    borderRadius: 4,
                    barPercentage: 0.4,
                    categoryPercentage: 0.7,
                },
                {
                    label: 'Pengembalian',
                    data: [11, 15, 17, 20, 15, 22],
                    backgroundColor: '#FACC15',
                    borderRadius: 4,
                    barPercentage: 0.4,
                    categoryPercentage: 0.7,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        pointStyle: 'rect',
                        font: { size: 12 },
                        padding: 20,
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false }
                },
                y: {
                    grid: { color: '#f3f4f6' },
                    border: { display: false },
                    ticks: { stepSize: 7, beginAtZero: true }
                }
            }
        }
    });
</script>

@endsection
