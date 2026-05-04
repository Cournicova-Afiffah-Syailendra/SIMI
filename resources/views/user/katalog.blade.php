@extends('layouts.user')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">

    {{-- Card utama --}}
    <div style="background:#fff; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,0.06); padding:1.5rem;">

        <h2 style="font-size:1rem; font-weight:700; color:#111827; margin:0 0 1.25rem;">Katalog Inventaris</h2>

        {{-- Search + Filter --}}
        <div style="display:flex; align-items:center; gap:0.75rem; margin-bottom:1.5rem;">
            <div style="position:relative; flex:1;">
                <span style="position:absolute; left:0.75rem; top:50%; transform:translateY(-50%); color:#9ca3af; pointer-events:none;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>

                <input type="text" id="searchInput" placeholder="Cari barang..." oninput="filterKatalog()"
                    style="width:100%; box-sizing:border-box; padding:0.6rem 0.75rem 0.6rem 2.25rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
            </div>

            <select id="filterKategori" onchange="filterKatalog()"
                style="padding:0.6rem 2rem 0.6rem 0.875rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none; flex-shrink:0;">
                <option value="">Semua Kategori</option>
                <option value="Elektronik">Elektronik</option>
                <option value="Perlengkapan">Perlengkapan</option>
                <option value="Furniture">Furniture</option>
            </select>
        </div>

        {{-- Grid Katalog --}}
        <div id="katalogGrid" style="display:grid; grid-template-columns:repeat(3, 1fr); gap:1rem;">
            @forelse($inventories as $inv)
                <div class="katalog-item"
                    data-name="{{ strtolower($inv->name) }}"
                    data-kategori="{{ $inv->category }}"
                    style="background:#fff; border:1px solid #e5e7eb; border-radius:0.75rem; overflow:hidden; position:relative;">

                    {{-- Badge Tersedia --}}
                    <div style="position:absolute; top:0.75rem; right:0.75rem; z-index:2;">
                        <span style="font-size:0.7rem; font-weight:700; color:#15803d; background:#dcfce7; padding:0.2rem 0.6rem; border-radius:9999px;">
                            Tersedia
                        </span>
                    </div>

                    {{-- Gambar Inventaris --}}
                    <div style="width:100%; height:220px; background:#f9fafb; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; padding:10px; box-sizing:border-box;">
                        @if($inv->image)
                            <img src="{{ asset('storage/' . $inv->image) }}"
                                alt="{{ $inv->name }}"
                                style="max-width:100%; max-height:100%; object-fit:contain; display:block;">
                        @else
                            <div style="width:100%; height:100%; display:flex; align-items:center; justify-content:center; color:#9ca3af;">
                                <svg style="width:3rem; height:3rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                                </svg>
                            </div>
                        @endif
                    </div>

                    {{-- Info --}}
                    <div style="padding:1.25rem 1.5rem 1.5rem;">
                        <p style="font-size:1.25rem; font-weight:800; color:#111827; margin:0 0 0.35rem; text-transform:uppercase; line-height:1.2;">
                            {{ $inv->name }}
                        </p>

                        <p style="font-size:0.75rem; color:#9ca3af; margin:0 0 0.75rem;">
                            INV-{{ str_pad($inv->id, 3, '0', STR_PAD_LEFT) }}
                        </p>

                        @if($inv->description)
                            <p style="font-size:0.8rem; color:#6b7280; margin:0 0 0.75rem; line-height:1.5;">
                                {{ $inv->description }}
                            </p>
                        @endif

                        <div style="display:flex; flex-direction:column; gap:0.35rem; margin-bottom:1rem;">
                            <div style="display:flex; justify-content:space-between; font-size:0.8rem;">
                                <span style="color:#6b7280;">Kategori:</span>
                                <span style="font-weight:700; color:#111827;">{{ $inv->category }}</span>
                            </div>

                            <div style="display:flex; justify-content:space-between; font-size:0.8rem;">
                                <span style="color:#6b7280;">Stok Tersedia:</span>
                                <span style="font-weight:700; color:#15803d;">{{ $inv->total_stock }}</span>
                            </div>

                            <div style="display:flex; justify-content:space-between; font-size:0.8rem;">
                                <span style="color:#6b7280;">Harga Sewa:</span>
                                <span style="font-weight:700; color:#7B1B2A;">
                                    Rp {{ number_format($inv->price ?? 0, 0, ',', '.') }}/hari
                                </span>
                            </div>
                        </div>

                        <a href="{{ route('user.ajukan') }}"
                            style="display:block; width:100%; box-sizing:border-box; padding:0.65rem; background:#FACC15; color:#111; font-weight:700; font-size:0.875rem; text-align:center; border-radius:0.5rem; text-decoration:none; border:none; cursor:pointer;"
                            onmouseover="this.style.background='#eab308'"
                            onmouseout="this.style.background='#FACC15'">
                            Ajukan Peminjaman
                        </a>
                    </div>
                </div>
            @empty
                <div style="grid-column:span 3; text-align:center; padding:2rem; color:#9ca3af;">
                    Belum ada inventaris tersedia.
                </div>
            @endforelse
        </div>

    </div>
</div>

<script>
function filterKatalog() {
    var search   = document.getElementById('searchInput').value.toLowerCase();
    var kategori = document.getElementById('filterKategori').value.toLowerCase();
    var items    = document.querySelectorAll('.katalog-item');

    items.forEach(function(item) {
        var name = item.dataset.name;
        var kat  = item.dataset.kategori.toLowerCase();

        var matchSearch   = name.includes(search);
        var matchKategori = kategori === '' || kat === kategori;

        item.style.display = (matchSearch && matchKategori) ? '' : 'none';
    });
}
</script>

@endsection