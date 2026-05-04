@extends('layouts.app')

@section('content')
<div style="padding: 2rem; background: #f9fafb; min-height: 100vh;">

    <div style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.5rem; font-weight: 800; color: #7B1B2A; margin: 0 0 0.25rem;">Data Inventaris</h2>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Sistem Informasi Manajemen Inventaris</p>
    </div>

    <div style="background: #fff; border: 1px solid #e5e7eb; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.06);">

        <div style="padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; flex-wrap: wrap;">
            <div style="display: flex; align-items: center; gap: 0.75rem; flex: 1; min-width: 0;">
                <div style="position: relative; flex: 1; max-width: 700px;">
                    <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </span>
                    <input type="text" placeholder="Cari barang..."
                        style="width: 100%; box-sizing: border-box; padding: 0.6rem 0.75rem 0.6rem 2.25rem; font-size: 0.875rem; color: #374151; border: 1px solid #e5e7eb; border-radius: 0.5rem; background: #f9fafb; outline: none;">
                </div>
                <select style="padding: 0.6rem 2rem 0.6rem 0.875rem; font-size: 0.875rem; color: #374151; border: 1px solid #e5e7eb; border-radius: 0.5rem; background: #f9fafb; outline: none; white-space: nowrap; flex-shrink: 0;">
                    <option>Semua Kategori</option>
                    <option>Elektronik</option>
                    <option>Perlengkapan</option>
                    <option>Furniture</option>
                </select>
            </div>
            <button onclick="openModal('modalTambah')"
                style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.6rem 1.25rem; background: #FACC15; color: #111; font-weight: 700; font-size: 0.875rem; border: none; border-radius: 0.5rem; cursor: pointer; white-space: nowrap; flex-shrink: 0;">
                <span style="font-size: 1.1rem; line-height: 1; font-weight: 700;">+</span>
                Tambah Barang
            </button>
        </div>

        @if (session('success'))
            <div style="margin: 0 1.5rem 1rem; padding: 0.75rem 1rem; background: #dcfce7; color: #15803d; border-radius: 0.5rem; font-size: 0.875rem;">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div style="margin: 0 1.5rem 1rem; padding: 0.75rem 1rem; background: #fee2e2; color: #dc2626; border-radius: 0.5rem; font-size: 0.875rem;">
                <ul style="margin: 0; padding-left: 1.25rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left; border-top: 1px solid #f3f4f6;">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th style="padding: 0.875rem 1.25rem; font-size: 0.75rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap;">Kode</th>
                        <th style="padding: 0.875rem 1.25rem; font-size: 0.75rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.05em;">Nama Barang</th>
                        <th style="padding: 0.875rem 1.25rem; font-size: 0.75rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.05em;">Kategori</th>
                        <th style="padding: 0.875rem 1.25rem; font-size: 0.75rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                        <th style="padding: 0.875rem 1.25rem; font-size: 0.75rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.05em;">Stok</th>
                        <th style="padding: 0.875rem 1.25rem; font-size: 0.75rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.05em; white-space: nowrap;">Harga Sewa/Hari</th>
                        <th style="padding: 0.875rem 1.25rem; font-size: 0.75rem; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.05em; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($inventories as $inventory)
                    <tr style="border-top: 1px solid #f3f4f6;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 1rem 1.25rem; font-weight: 700; color: #111827; text-transform: uppercase;">INV-{{ str_pad($inventory->id, 3, '0', STR_PAD_LEFT) }}</td>
                        <td style="padding: 1rem 1.25rem; color: #374151;">{{ $inventory->name }}</td>
                        <td style="padding: 1rem 1.25rem; color: #6b7280;">{{ $inventory->category }}</td>
                        <td style="padding: 1rem 1.25rem;">
                            @if(($inventory->total_stock ?? 0) > 0)
                                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #15803d; background: #dcfce7; border-radius: 9999px;">Tersedia</span>
                            @else
                                <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #c2410c; background: #ffedd5; border-radius: 9999px;">Dipinjam</span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.25rem; color: #374151;">{{ $inventory->total_stock }}</td>
                        <td style="padding: 1rem 1.25rem; color: #374151;">Rp {{ number_format($inventory->price ?? 0, 0, ',', '.') }}</td>
                        <td style="padding: 1rem 1.25rem; text-align: center;">
                            <div style="display: inline-flex; align-items: center; gap: 0.4rem;">
                                <button
                                    onclick="openEditModal('{{ route('inventories.update', $inventory) }}', '{{ addslashes($inventory->name) }}', '{{ $inventory->category }}', {{ $inventory->total_stock }}, {{ $inventory->price ?? 0 }})"
                                    title="Edit"
                                    style="width: 2.25rem; height: 2.25rem; display: inline-flex; align-items: center; justify-content: center; color: #2563eb; background: #fff; border: 1px solid #bfdbfe; border-radius: 0.5rem; cursor: pointer;"
                                    onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='#fff'">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </button>
                                <form action="{{ route('inventories.destroy', $inventory) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus data ini?');" style="display:inline; margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        style="width: 2.25rem; height: 2.25rem; display: inline-flex; align-items: center; justify-content: center; color: #dc2626; background: #fff; border: 1px solid #fecaca; border-radius: 0.5rem; cursor: pointer;"
                                        onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#fff'">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                            <line x1="10" y1="11" x2="10" y2="17"/>
                                            <line x1="14" y1="11" x2="14" y2="17"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="padding: 2rem; text-align: center; color: #9ca3af;">Belum ada data inventaris.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:9999; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; padding:1rem; box-sizing:border-box;">
    <div style="position:relative; width:100%; max-width:520px; background:#fff; border-radius:1rem; overflow:hidden; box-shadow:0 25px 50px rgba(0,0,0,0.3); margin:auto;">
        <button onclick="closeModal('modalTambah')"
            style="position:absolute; top:1.25rem; right:1.25rem; width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; border-radius:9999px; border:none; background:transparent; cursor:pointer; color:#9ca3af;">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div style="padding:2.25rem 2.5rem 2rem;">
            <div style="margin-bottom:1.5rem;">
                <h3 style="font-size:1.375rem; font-weight:700; color:#111827; margin:0 0 0.375rem;">Tambah Barang Baru</h3>
                <p style="font-size:0.875rem; color:#6b7280; margin:0;">Tambahkan barang baru ke inventaris</p>
            </div>
            <form action="{{ route('inventories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display:flex; flex-direction:column; gap:1.1rem;">
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">Nama Barang</label>
                        <input type="text" name="name" placeholder="Proyektor" required
                            style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">Kategori</label>
                        <select name="category" style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                            <option value="" disabled selected>Pilih kategori</option>
                            <option value="Elektronik">Elektronik</option>
                            <option value="Perlengkapan">Perlengkapan</option>
                            <option value="Furniture">Furniture</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">Stok</label>
                        <input type="number" name="total_stock" value="0" min="0"
                            style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">Harga Sewa (per hari)</label>
                        <input type="number" name="price" value="0" min="0"
                            style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">Gambar Barang</label>
                        <input type="file" name="image" accept="image/*"
                            style="width:100%; box-sizing:border-box; padding:0.6rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div style="display:flex; gap:0.75rem; padding-top:0.5rem;">
                        <button type="submit"
                            style="flex:1; padding:0.85rem; background:#dc2626; color:#fff; font-weight:700; font-size:0.875rem; border:none; border-radius:0.5rem; cursor:pointer;">
                            Tambah
                        </button>
                        <button type="button" onclick="closeModal('modalTambah')"
                            style="padding:0.85rem 2rem; background:#fff; color:#374151; font-weight:700; font-size:0.875rem; border:1px solid #d1d5db; border-radius:0.5rem; cursor:pointer;">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:9999; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; padding:1rem; box-sizing:border-box;">
    <div style="position:relative; width:100%; max-width:520px; background:#fff; border-radius:1rem; overflow:hidden; box-shadow:0 25px 50px rgba(0,0,0,0.3); margin:auto;">
        <button onclick="closeModal('modalEdit')"
            style="position:absolute; top:1.25rem; right:1.25rem; width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; border-radius:9999px; border:none; background:transparent; cursor:pointer; color:#9ca3af;">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div style="padding:2.25rem 2.5rem 2rem;">
            <div style="margin-bottom:1.5rem;">
                <h3 style="font-size:1.375rem; font-weight:700; color:#111827; margin:0 0 0.375rem;">Edit Barang</h3>
                <p style="font-size:0.875rem; color:#6b7280; margin:0;">Perbarui data barang inventaris</p>
            </div>
            <form id="formEdit" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div style="display:flex; flex-direction:column; gap:1.1rem;">
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">Nama Barang</label>
                        <input type="text" id="editName" name="name" required
                            style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">Kategori</label>
                        <select id="editCategory" name="category" style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                            <option value="Elektronik">Elektronik</option>
                            <option value="Perlengkapan">Perlengkapan</option>
                            <option value="Furniture">Furniture</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">Stok</label>
                        <input type="number" id="editStock" name="total_stock" min="0"
                            style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">Harga Sewa (per hari)</label>
                        <input type="number" id="editPrice" name="price" min="0"
                            style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.875rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">Gambar Barang</label>
                        <input type="file" name="image" accept="image/*"
                            style="width:100%; box-sizing:border-box; padding:0.6rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div style="display:flex; gap:0.75rem; padding-top:0.5rem;">
                        <button type="submit"
                            style="flex:1; padding:0.85rem; background:#dc2626; color:#fff; font-weight:700; font-size:0.875rem; border:none; border-radius:0.5rem; cursor:pointer;">
                            Simpan
                        </button>
                        <button type="button" onclick="closeModal('modalEdit')"
                            style="padding:0.85rem 2rem; background:#fff; color:#374151; font-weight:700; font-size:0.875rem; border:1px solid #d1d5db; border-radius:0.5rem; cursor:pointer;">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
    function openEditModal(actionUrl, name, category, stock, price) {
        document.getElementById('formEdit').action = actionUrl;
        document.getElementById('editName').value = name;
        document.getElementById('editCategory').value = category;
        document.getElementById('editStock').value = stock;
        document.getElementById('editPrice').value = price;
        openModal('modalEdit');
    }
    ['modalTambah','modalEdit'].forEach(function(id) {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) closeModal(id);
        });
    });
</script>
@endsection
