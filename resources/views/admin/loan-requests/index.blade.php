@extends('layouts.app')

@section('content')
<div class="p-6 bg-white shadow rounded-xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-gray-800">Permintaan Peminjaman</h2>
            <p class="text-gray-500">Kelola permintaan peminjaman inventaris: setujui atau tolak.</p>
        </div>
        <button
            onclick="document.getElementById('modalTambah').classList.remove('hidden')"
            class="px-5 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700"
        >
            + Tambah Permintaan
        </button>
    </div>

    @if (session('success'))
        <div class="px-4 py-3 mb-4 text-green-800 bg-green-100 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="px-4 py-3 mb-4 text-red-800 bg-red-100 rounded-lg">
            <ul class="pl-5 list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse" style="min-width: 700px;">
            <thead>
                <tr class="text-gray-700 border-b">
                    <th class="px-2 py-3">No</th>
                    <th class="px-2 py-3">Nama Peminjam</th>
                    <th class="px-2 py-3">Organisasi</th>
                    <th class="px-2 py-3">Inventaris</th>
                    <th class="px-2 py-3">Durasi Pinjam</th>
                    <th class="px-2 py-3">Surat</th>
                    <th class="px-2 py-3">Status</th>
                    <th class="px-2 py-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($loanRequests as $index => $requestItem)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="px-2 py-3">{{ $index + 1 }}</td>
                        <td class="px-2 py-3">{{ $requestItem->borrower_name }}</td>
                        <td class="px-2 py-3">{{ $requestItem->organization ?? '-' }}</td>
                        <td class="px-2 py-3">{{ $requestItem->inventory->name ?? '-' }}</td>
                        <td class="px-2 py-3">{{ $requestItem->duration_days }} hari</td>
                        <td class="px-2 py-3">
                            @if ($requestItem->surat_link)
                                <a href="{{ $requestItem->surat_link }}" target="_blank" class="text-blue-600 hover:underline">Buka Surat</a>
                            @else
                                <span class="text-gray-400">Tidak ada</span>
                            @endif
                        </td>
                        <td class="px-2 py-3">
                            @if ($requestItem->status === 'pending')
                                <span class="px-3 py-1 text-sm text-yellow-700 bg-yellow-100 rounded-full">Menunggu Persetujuan</span>
                            @elseif ($requestItem->status === 'approved')
                                <span class="px-3 py-1 text-sm text-green-700 bg-green-100 rounded-full">Disetujui</span>
                            @else
                                <span class="px-3 py-1 text-sm text-red-700 bg-red-100 rounded-full">Ditolak</span>
                            @endif
                        </td>
                        <td class="px-2 py-3">
                            <div class="flex items-center justify-center gap-2">
                                @if ($requestItem->status === 'pending')
                                    <form action="{{ route('loan-requests.approve', $requestItem->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-4 py-2 text-sm text-white bg-green-600 rounded-lg hover:bg-green-700">Setujui</button>
                                    </form>
                                    <form action="{{ route('loan-requests.reject', $requestItem->id) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-4 py-2 text-sm text-white bg-red-600 rounded-lg hover:bg-red-700">Tolak</button>
                                    </form>
                                @else
                                    <span class="text-sm text-gray-400">Sudah diproses</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-6 text-center text-gray-500">Belum ada permintaan peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/40">
    <div class="w-full max-w-lg p-6 bg-white shadow-lg rounded-xl">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-2xl font-bold">Tambah Permintaan Peminjaman</h3>
            <button onclick="document.getElementById('modalTambah').classList.add('hidden')" class="text-xl text-gray-500">&times;</button>
        </div>

        <form action="{{ route('loan-requests.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Nama Peminjam</label>
                <input type="text" name="borrower_name" class="w-full px-4 py-2 border rounded-lg" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Organisasi</label>
                <input type="text" name="organization" class="w-full px-4 py-2 border rounded-lg">
            </div>

            <div>
                <label class="block mb-1 font-medium">Inventaris Dipinjam</label>
                <select name="inventory_id" id="inventory_select" class="w-full px-4 py-2 border rounded-lg" required onchange="hitungTotal()">
                    <option value="" data-harga="0">-- Pilih Inventaris --</option>
                    @foreach ($inventories as $inventory)
                        <option value="{{ $inventory->id }}" data-harga="{{ $inventory->price ?? 0 }}">
                            {{ $inventory->name }} — Rp {{ number_format($inventory->price ?? 0, 0, ',', '.') }}/hari
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Durasi Pinjam (hari)</label>
                <input type="number" name="duration_days" id="duration_input" min="1" class="w-full px-4 py-2 border rounded-lg" required oninput="hitungTotal()">
            </div>

            <div>
                <label class="block mb-1 font-medium">Link Surat</label>
                <input type="url" name="surat_link" class="w-full px-4 py-2 border rounded-lg" placeholder="https://...">
                <small class="text-gray-500">Opsional.</small>
            </div>

            {{-- TOTAL HARGA --}}
            <div id="box_total" class="hidden p-4 border border-red-200 rounded-lg bg-red-50">
                <p class="text-sm text-gray-600">Total Harga yang Harus Dibayar:</p>
                <p id="total_harga" class="text-2xl font-bold text-red-600">Rp 0</p>
                <p id="detail_harga" class="mt-1 text-xs text-gray-500"></p>
            </div>

            <div class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('modalTambah').classList.add('hidden')" class="px-4 py-2 border rounded-lg">Batal</button>
                <button type="submit" class="px-4 py-2 text-white bg-red-600 rounded-lg hover:bg-red-700">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
function hitungTotal() {
    var select   = document.getElementById('inventory_select');
    var duration = document.getElementById('duration_input').value;
    var harga    = select.options[select.selectedIndex].dataset.harga;

    if (select.value && duration && duration > 0) {
        var total = parseInt(harga) * parseInt(duration);
        document.getElementById('box_total').classList.remove('hidden');
        document.getElementById('total_harga').textContent = 'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('detail_harga').textContent =
            'Rp ' + parseInt(harga).toLocaleString('id-ID') + '/hari × ' + duration + ' hari';
    } else {
        document.getElementById('box_total').classList.add('hidden');
    }
}
</script>

@endsection
