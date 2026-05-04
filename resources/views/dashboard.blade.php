@extends('layouts.app')

@section('content')

<div class="space-y-6">

    {{-- Title --}}
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="mt-1 text-sm text-gray-500">Sistem Informasi Manajemen Inventaris</p>
    </div>

    {{-- 4 Stats Cards --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Barang --}}
        <div class="flex items-center justify-between p-5 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div>
                <p class="text-sm text-gray-500">Total Barang</p>
                <h2 class="mt-1 text-3xl font-bold text-gray-800">{{ $totalBarang }}</h2>
            </div>
            <div class="p-3 rounded-xl" style="background-color: #3B82F6;">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
        </div>

        {{-- Barang Tersedia --}}
        <div class="flex items-center justify-between p-5 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div>
                <p class="text-sm text-gray-500">Barang Tersedia</p>
                <h2 class="mt-1 text-3xl font-bold text-gray-800">{{ $barangTersedia }}</h2>
            </div>
            <div class="p-3 rounded-xl" style="background-color: #22C55E;">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

        {{-- Barang Dipinjam --}}
        <div class="flex items-center justify-between p-5 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div>
                <p class="text-sm text-gray-500">Barang Dipinjam</p>
                <h2 class="mt-1 text-3xl font-bold text-gray-800">{{ $barangDipinjam }}</h2>
            </div>
            <div class="p-3 rounded-xl" style="background-color: #F59E0B;">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 7h11"/>
                </svg>
            </div>
        </div>

        {{-- Menunggu Persetujuan --}}
        <div class="flex items-center justify-between p-5 bg-white border border-gray-100 shadow-sm rounded-xl">
            <div>
                <p class="text-sm text-gray-500">Menunggu Persetujuan</p>
                <h2 class="mt-1 text-3xl font-bold text-gray-800">{{ $menungguPersetujuan }}</h2>
            </div>
            <div class="p-3 rounded-xl" style="background-color: #EF4444;">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
        </div>

    </div>

    {{-- Chart --}}
    <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">

        <h2 class="mb-5 text-base font-semibold text-gray-800">
            Statistik Peminjaman & Pengembalian
        </h2>

        <div style="position: relative; height: 260px;">
            <canvas id="chartPeminjaman"></canvas>
        </div>

        {{-- Legend --}}
        <div class="flex items-center gap-6 mt-4 text-sm text-gray-600">
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 rounded-sm" style="background-color: #7B1B2A;"></span>
                Peminjaman
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-block w-3 h-3 rounded-sm" style="background-color: #F59E0B;"></span>
                Pengembalian
            </div>
        </div>

    </div>

    {{-- Aktivitas Terbaru --}}
    <div class="p-6 bg-white border border-gray-100 shadow-sm rounded-xl">

        <div class="flex items-center justify-between mb-5">
            <h2 class="text-base font-semibold text-gray-800">Aktivitas Terbaru</h2>
            <a href="{{ route('loan-requests.index') }}"
               class="text-sm font-medium" style="color: #7B1B2A;">
                Lihat Semua
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead>
                    <tr class="text-xs tracking-wide text-left text-gray-400 uppercase border-b border-gray-100">
                        <th class="pb-3 font-medium">Nama Peminjam</th>
                        <th class="pb-3 font-medium">Organisasi</th>
                        <th class="pb-3 font-medium">Inventaris</th>
                        <th class="pb-3 font-medium">Jumlah</th>
                        <th class="pb-3 font-medium">Tanggal</th>
                        <th class="pb-3 font-medium">Status</th>
                        <th class="pb-3 font-medium">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-50">

                    @foreach($recentLoans as $loan)
                    <tr class="transition hover:bg-gray-50">
                        <td class="py-3 font-medium text-gray-800">{{ $loan->user->name ?? 'N/A' }}</td>
                        <td class="py-3 text-gray-600">{{ $loan->organization ?? '-' }}</td>
                        <td class="py-3 text-gray-600">{{ $loan->inventory->name ?? 'N/A' }}</td>
                        <td class="py-3 text-gray-600">{{ $loan->quantity }}</td>
                        <td class="py-3 text-gray-500">{{ \Carbon\Carbon::parse($loan->loan_date)->format('Y-m-d') }}</td>
                        <td class="py-3">
                            @if($loan->status === 'pending')
                                <span class="bg-yellow-100 text-yellow-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    Menunggu Persetujuan
                                </span>
                            @elseif($loan->status === 'approved')
                                <span class="bg-green-100 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    Disetujui
                                </span>
                            @elseif($loan->status === 'rejected')
                                <span class="bg-red-100 text-red-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    Ditolak
                                </span>
                            @else
                                <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-medium">
                                    {{ ucfirst($loan->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="py-3">
                            <a href="{{ route('loan-requests.show', $loan->id) }}"
                               class="text-sm font-medium hover:underline" style="color: #7B1B2A;">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    @if($recentLoans->isEmpty())
                    <tr>
                        <td colspan="7" class="py-8 text-center text-gray-400">
                            Belum ada aktivitas peminjaman.
                        </td>
                    </tr>
                    @endif

                </tbody>

            </table>
        </div>

    </div>

</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    const ctx = document.getElementById('chartPeminjaman').getContext('2d');

    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [
                {
                    label: 'Peminjaman',
                    data: {!! json_encode($chartPeminjaman) !!},
                    backgroundColor: '#7B1B2A',
                    borderRadius: 4,
                    barPercentage: 0.4,
                },
                {
                    label: 'Pengembalian',
                    data: {!! json_encode($chartPengembalian) !!},
                    backgroundColor: '#F59E0B',
                    borderRadius: 4,
                    barPercentage: 0.4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { mode: 'index', intersect: false }
            },
            scales: {
                x: {
                    grid: { display: false },
                    border: { display: false }
                },
                y: {
                    beginAtZero: true,
                    grid: { color: '#F3F4F6' },
                    border: { display: false },
                    ticks: { stepSize: 7 }
                }
            }
        }
    });
</script>

@endsection
