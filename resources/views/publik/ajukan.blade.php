@extends('layouts.public')

@section('content')

<div style="display:flex; flex-direction:column; gap:1.5rem;">

    {{-- Title --}}
    <div>
        <h1 style="font-size:1.5rem; font-weight:700; color:#7B1B2A; margin:0 0 0.25rem;">
            Ajukan Peminjaman
        </h1>
        <p style="font-size:0.875rem; color:#6b7280; margin:0;">
            Ajukan permintaan peminjaman inventaris. Tidak perlu login.
        </p>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div style="padding:0.75rem 1rem; background:#dcfce7; color:#15803d;
                    border-radius:0.5rem; font-size:0.875rem; border:1px solid #bbf7d0;">
            ✅ {{ session('success') }}
        </div>
    @endif

    {{-- Errors --}}
    @if($errors->any())
        <div style="padding:0.75rem 1rem; background:#fee2e2; color:#dc2626;
                    border-radius:0.5rem; font-size:0.875rem; border:1px solid #fecaca;">
            <ul style="margin:0; padding-left:1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Layout 2 kolom --}}
    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; align-items:start;">

        {{-- ── KOLOM KIRI: Form ─────────────────────────────────────── --}}
        <div style="background:#fff; border-radius:0.75rem;
                    box-shadow:0 1px 4px rgba(0,0,0,0.08); padding:1.5rem;">

            <h3 style="font-size:0.95rem; font-weight:700; color:#111827; margin:0 0 1.25rem;">
                Form Pengajuan
            </h3>

            <form action="{{ route('publik.ajukan.store') }}" method="POST">
                @csrf
                <div style="display:flex; flex-direction:column; gap:1rem;">

                    {{-- Nama Lengkap --}}
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700;
                                      color:#1f2937; margin-bottom:0.4rem;">
                            Nama Lengkap <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="text" name="borrower_name"
                               value="{{ old('borrower_name') }}"
                               placeholder="contoh: Ahmad Fauzi"
                               required
                               style="width:100%; box-sizing:border-box; padding:0.7rem 1rem;
                                      font-size:0.875rem; color:#374151; border:1px solid #e5e7eb;
                                      border-radius:0.5rem; background:#f9fafb; outline:none;"
                               onfocus="this.style.borderColor='#7B1B2A'"
                               onblur="this.style.borderColor='#e5e7eb'">
                    </div>

                    {{-- Instansi --}}
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700;
                                      color:#1f2937; margin-bottom:0.4rem;">
                            Asal Instansi / Organisasi <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="text" name="organization"
                               value="{{ old('organization') }}"
                               placeholder="contoh: BEM Fakultas Hukum"
                               required
                               style="width:100%; box-sizing:border-box; padding:0.7rem 1rem;
                                      font-size:0.875rem; color:#374151; border:1px solid #e5e7eb;
                                      border-radius:0.5rem; background:#f9fafb; outline:none;"
                               onfocus="this.style.borderColor='#7B1B2A'"
                               onblur="this.style.borderColor='#e5e7eb'">
                    </div>

                    {{-- Pilih Inventaris --}}
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700;
                                      color:#1f2937; margin-bottom:0.4rem;">
                            Inventaris Dipinjam <span style="color:#dc2626;">*</span>
                        </label>
                        <select name="inventory_id" id="inventory_select"
                                onchange="hitungTotal()" required
                                style="width:100%; box-sizing:border-box; padding:0.7rem 1rem;
                                       font-size:0.875rem; color:#374151; border:1px solid #e5e7eb;
                                       border-radius:0.5rem; background:#f9fafb; outline:none;"
                                onfocus="this.style.borderColor='#7B1B2A'"
                                onblur="this.style.borderColor='#e5e7eb'">
                            <option value="">-- Pilih Inventaris --</option>
                            @foreach($inventories as $inv)
                                <option value="{{ $inv->id }}"
                                        data-harga="{{ $inv->price ?? 0 }}"
                                        {{ old('inventory_id') == $inv->id ? 'selected' : '' }}>
                                    {{ $inv->name }}
                                    @if(($inv->price ?? 0) > 0)
                                        — Rp {{ number_format($inv->price, 0, ',', '.') }}/hari
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Durasi --}}
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700;
                                      color:#1f2937; margin-bottom:0.4rem;">
                            Durasi Pinjam (hari) <span style="color:#dc2626;">*</span>
                        </label>
                        <input type="number" name="duration_days" id="duration_input"
                               min="1" value="{{ old('duration_days') }}"
                               placeholder="contoh: 3"
                               oninput="hitungTotal()" required
                               style="width:100%; box-sizing:border-box; padding:0.7rem 1rem;
                                      font-size:0.875rem; color:#374151; border:1px solid #e5e7eb;
                                      border-radius:0.5rem; background:#f9fafb; outline:none;"
                               onfocus="this.style.borderColor='#7B1B2A'"
                               onblur="this.style.borderColor='#e5e7eb'">
                    </div>

                    {{-- Total Harga --}}
                    <div id="box_total" style="display:none; padding:1rem; background:#fef2f2;
                                               border:1px solid #fecaca; border-radius:0.5rem;">
                        <p style="font-size:0.78rem; color:#6b7280; margin:0 0 0.25rem;">
                            Total Harga yang Harus Dibayar:
                        </p>
                        <p id="total_harga" style="font-size:1.5rem; font-weight:800;
                                                    color:#dc2626; margin:0;"></p>
                        <p id="detail_harga" style="font-size:0.75rem; color:#9ca3af;
                                                     margin:0.25rem 0 0;"></p>
                    </div>

                    {{-- Info Rekening --}}
                    <div style="padding:1rem; background:#fffbeb; border:1px solid #fcd34d;
                                border-radius:0.5rem;">
                        <p style="font-size:0.7rem; font-weight:700; color:#92400e;
                                   text-transform:uppercase; letter-spacing:0.05em; margin:0 0 0.5rem;">
                            💳 Informasi Pembayaran
                        </p>
                        <div style="background:#fff; border-radius:0.375rem;
                                    padding:0.65rem 0.875rem; border:1px solid #fde68a;">
                            <p style="font-size:0.8rem; font-weight:600; color:#374151; margin:0 0 0.15rem;">
                                Bank BRI
                            </p>
                            <p style="font-size:1rem; font-weight:800; color:#7B1B2A;
                                       letter-spacing:0.08em; margin:0 0 0.15rem;">
                                1234-5678-9012-3456
                            </p>
                            <p style="font-size:0.78rem; color:#6b7280; margin:0;">
                                a.n. <strong>PK IMM Siti Munjiyah</strong>
                            </p>
                        </div>
                        <p style="font-size:0.7rem; color:#a16207; margin:0.4rem 0 0;">
                            ⓘ Bukti transfer dikirim ke admin setelah pengajuan disetujui.
                        </p>
                    </div>

                    {{-- Link Surat --}}
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700;
                                      color:#1f2937; margin-bottom:0.4rem;">
                            Link Surat
                            <span style="font-weight:400; color:#9ca3af;">(opsional)</span>
                        </label>
                        <input type="url" name="surat_link"
                               value="{{ old('surat_link') }}"
                               placeholder="https://drive.google.com/..."
                               style="width:100%; box-sizing:border-box; padding:0.7rem 1rem;
                                      font-size:0.875rem; color:#374151; border:1px solid #e5e7eb;
                                      border-radius:0.5rem; background:#f9fafb; outline:none;"
                               onfocus="this.style.borderColor='#7B1B2A'"
                               onblur="this.style.borderColor='#e5e7eb'">
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            style="padding:0.85rem; background:#7B1B2A; color:#fff; font-weight:700;
                                   font-size:0.875rem; border:none; border-radius:0.5rem;
                                   cursor:pointer; width:100%;"
                            onmouseover="this.style.background='#6b1624'"
                            onmouseout="this.style.background='#7B1B2A'">
                        🚀 Ajukan Peminjaman
                    </button>

                </div>
            </form>
        </div>

        {{-- ── KOLOM KANAN: Katalog ─────────────────────────────────── --}}
        <div style="display:flex; flex-direction:column; gap:1rem;">

            <div style="display:flex; align-items:center; justify-content:space-between;">
                <h3 style="font-size:0.95rem; font-weight:700; color:#111827; margin:0;">
                    Inventaris Tersedia
                </h3>
                <span style="font-size:0.75rem; color:#9ca3af;">
                    Klik "Pilih" untuk memilih inventaris
                </span>
            </div>

            {{-- Search --}}
            <input type="text" id="searchKatalog"
                   placeholder="Cari barang..."
                   oninput="filterKatalog()"
                   style="width:100%; box-sizing:border-box; padding:0.65rem 1rem;
                          font-size:0.875rem; color:#374151; border:1px solid #e5e7eb;
                          border-radius:0.5rem; background:#fff; outline:none;"
                   onfocus="this.style.borderColor='#7B1B2A'"
                   onblur="this.style.borderColor='#e5e7eb'">

            {{-- List Katalog --}}
            <div id="katalogList" style="display:flex; flex-direction:column; gap:0.75rem;
                                         max-height:600px; overflow-y:auto;">

                @forelse($inventories as $inv)
                @php $stok = $inv->total_stock ?? 0; @endphp
                <div class="katalog-item"
                     data-name="{{ strtolower($inv->name) }}"
                     style="background:#fff; border-radius:0.75rem; border:1px solid #f3f4f6;
                            padding:1rem 1.25rem; box-shadow:0 1px 3px rgba(0,0,0,0.05);
                            display:flex; align-items:center; justify-content:space-between; gap:1rem;">

                    {{-- Ikon + Info --}}
                    <div style="display:flex; align-items:center; gap:0.875rem; flex:1;">
                        <div style="width:42px; height:42px; border-radius:0.6rem; background:#7B1B2A;
                                    display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <svg style="width:1.1rem; height:1.1rem;" fill="none"
                                 stroke="white" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                            </svg>
                        </div>
                        <div>
                            <p style="font-size:0.875rem; font-weight:700; color:#111827; margin:0 0 0.2rem;">
                                {{ $inv->name }}
                            </p>
                            <p style="font-size:0.72rem; color:#9ca3af; margin:0 0 0.15rem;">
                                {{ $inv->category ?? 'Umum' }}
                                · Stok:
                                <strong style="color:{{ $stok > 0 ? '#15803d' : '#dc2626' }};">
                                    {{ $stok }}
                                </strong>
                            </p>
                            @if(($inv->price ?? 0) > 0)
                                <p style="font-size:0.78rem; font-weight:700; color:#7B1B2A; margin:0;">
                                    Rp {{ number_format($inv->price, 0, ',', '.') }}/hari
                                </p>
                            @endif
                        </div>
                    </div>

                    {{-- Status + Tombol --}}
                    <div style="display:flex; flex-direction:column; align-items:flex-end;
                                gap:0.4rem; flex-shrink:0;">
                        @if($stok > 0)
                            <span style="font-size:0.65rem; padding:0.2rem 0.6rem;
                                          border-radius:9999px; background:#dcfce7;
                                          color:#15803d; font-weight:700;">
                                Tersedia
                            </span>
                            <button
                                onclick="pilihInventaris({{ $inv->id }}, '{{ addslashes($inv->name) }}', {{ $inv->price ?? 0 }})"
                                style="font-size:0.72rem; padding:0.35rem 0.75rem;
                                       background:#F59E0B; color:#fff; border:none;
                                       border-radius:0.375rem; cursor:pointer; font-weight:700;"
                                onmouseover="this.style.background='#d97706'"
                                onmouseout="this.style.background='#F59E0B'">
                                Pilih
                            </button>
                        @else
                            <span style="font-size:0.65rem; padding:0.2rem 0.6rem;
                                          border-radius:9999px; background:#fee2e2;
                                          color:#dc2626; font-weight:700;">
                                Dipinjam
                            </span>
                        @endif
                    </div>

                </div>
                @empty
                <div style="text-align:center; padding:2rem; color:#9ca3af; font-size:0.875rem;">
                    Belum ada inventaris tersedia.
                </div>
                @endforelse

            </div>
        </div>

    </div>
</div>

<script>
function hitungTotal() {
    var select   = document.getElementById('inventory_select');
    var duration = document.getElementById('duration_input').value;
    var opt      = select.options[select.selectedIndex];
    var harga    = opt ? (parseInt(opt.dataset.harga) || 0) : 0;

    if (select.value && duration && parseInt(duration) > 0 && harga > 0) {
        var total = harga * parseInt(duration);
        document.getElementById('box_total').style.display = 'block';
        document.getElementById('total_harga').textContent =
            'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('detail_harga').textContent =
            'Rp ' + harga.toLocaleString('id-ID') + '/hari × ' + duration + ' hari';
    } else {
        document.getElementById('box_total').style.display = 'none';
    }
}

function pilihInventaris(id, nama, harga) {
    var select = document.getElementById('inventory_select');
    select.value = id;
    hitungTotal();
    // Highlight & scroll ke form
    select.style.borderColor = '#7B1B2A';
    select.style.background  = '#fef9f9';
    select.scrollIntoView({ behavior: 'smooth', block: 'center' });
    setTimeout(function() {
        select.style.borderColor = '#e5e7eb';
        select.style.background  = '#f9fafb';
    }, 2000);
}

function filterKatalog() {
    var keyword = document.getElementById('searchKatalog').value.toLowerCase();
    document.querySelectorAll('.katalog-item').forEach(function(item) {
        item.style.display = item.dataset.name.includes(keyword) ? '' : 'none';
    });
}
</script>

@endsection
