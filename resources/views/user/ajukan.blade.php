@extends('layouts.user')

@section('content')
<div style="display:flex; flex-direction:column; gap:1.5rem;">

    {{-- Title --}}
    <div>
        <h1 style="font-size:1.5rem; font-weight:700; color:#7B1B2A; margin:0 0 0.25rem;">Ajukan Peminjaman</h1>
        <p style="font-size:0.875rem; color:#6b7280; margin:0;">Ajukan permintaan peminjaman inventaris</p>
    </div>

    {{-- Success --}}
    @if(session('success'))
        <div style="padding:0.75rem 1rem; background:#dcfce7; color:#15803d; border-radius:0.5rem; font-size:0.875rem;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error upload --}}
    @if(session('error'))
        <div style="padding:0.75rem 1rem; background:#fee2e2; color:#dc2626; border-radius:0.5rem; font-size:0.875rem;">
            {{ session('error') }}
        </div>
    @endif

    {{-- Validation errors --}}
    @if($errors->any())
        <div style="padding:0.75rem 1rem; background:#fee2e2; color:#dc2626; border-radius:0.5rem; font-size:0.875rem;">
            <ul style="margin:0; padding-left:1.25rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; align-items:start;">

        {{-- ── Kolom Kiri: Form ─────────────────────────────────────── --}}
        <div style="background:#fff; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,0.08); padding:1.5rem;">
            <h3 style="font-size:0.95rem; font-weight:700; color:#111827; margin:0 0 1.25rem;">Form Pengajuan</h3>

            <form action="{{ route('user.ajukan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div style="display:flex; flex-direction:column; gap:1rem;">

                    {{-- Inventaris --}}
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">
                            Inventaris Dipinjam
                        </label>
                        <select name="inventory_id" id="inventory_select" onchange="hitungTotal()"
                            style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                            <option value="">-- Pilih Inventaris --</option>
                            @foreach($inventories as $inv)
                                <option value="{{ $inv->id }}"
                                        data-harga="{{ $inv->price ?? 0 }}"
                                        {{ old('inventory_id') == $inv->id ? 'selected' : '' }}>
                                    {{ $inv->name }} — Rp {{ number_format($inv->price ?? 0, 0, ',', '.') }}/hari
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Durasi --}}
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">
                            Durasi Pinjam (hari)
                        </label>
                        <input type="number" name="duration_days" id="duration_input"
                               min="1" value="{{ old('duration_days') }}"
                               oninput="hitungTotal()"
                               style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>

                    {{-- Total Harga --}}
                    <div id="box_total" style="display:none; padding:1rem; background:#fef2f2; border:1px solid #fecaca; border-radius:0.5rem;">
                        <p style="font-size:0.8rem; color:#6b7280; margin:0 0 0.25rem;">Total Harga yang Harus Dibayar:</p>
                        <p id="total_harga" style="font-size:1.5rem; font-weight:700; color:#dc2626; margin:0;">Rp 0</p>
                        <p id="detail_harga" style="font-size:0.75rem; color:#9ca3af; margin:0.25rem 0 0;"></p>
                    </div>

                    {{-- ── INFO REKENING ──────────────────────────────── --}}
                    <div style="padding:1rem; background:#fffbeb; border:1px solid #fcd34d; border-radius:0.5rem;">
                        <p style="font-size:0.75rem; font-weight:700; color:#92400e; margin:0 0 0.5rem; text-transform:uppercase; letter-spacing:0.05em;">
                            💳 Informasi Pembayaran
                        </p>
                        <p style="font-size:0.8rem; color:#78350f; margin:0 0 0.2rem;">
                            Transfer ke rekening berikut:
                        </p>
                        <div style="margin-top:0.5rem;">
                            <p style="font-size:0.875rem; font-weight:700; color:#1f2937; margin:0;">Bank JAGO</p>
                            <p style="font-size:1rem; font-weight:800; color:#7B1B2A; letter-spacing:0.05em; margin:0.2rem 0;">
                                104653053728
                            </p>
                            <p style="font-size:0.8rem; color:#6b7280; margin:0;">a.n. <strong>PK IMM Siti Munjiyah</strong></p>
                        </div>
                        <p style="font-size:0.75rem; color:#9ca3af; margin:0.5rem 0 0;">
                            Upload bukti transfer di bawah setelah melakukan pembayaran.
                        </p>
                    </div>

                    {{-- ── UPLOAD BUKTI TRANSFER ──────────────────────── --}}
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">
                            Bukti Transfer
                            <span style="font-weight:400; color:#9ca3af;">(opsional)</span>
                        </label>
                        <div id="drop_bukti"
                             onclick="document.getElementById('input_bukti').click()"
                             ondragover="event.preventDefault(); this.style.borderColor='#7B1B2A';"
                             ondragleave="this.style.borderColor='#e5e7eb';"
                             ondrop="handleDrop(event, 'input_bukti', 'preview_bukti')"
                             style="border:2px dashed #e5e7eb; border-radius:0.5rem; padding:1.25rem; text-align:center; cursor:pointer; transition:border-color 0.2s; background:#f9fafb;">
                            <svg style="width:2rem; height:2rem; color:#9ca3af; margin:0 auto 0.5rem; display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                            <p style="font-size:0.8rem; color:#6b7280; margin:0;">Klik atau drag file ke sini</p>
                            <p style="font-size:0.7rem; color:#9ca3af; margin:0.25rem 0 0;">JPG, PNG, PDF — maks 5MB</p>
                        </div>
                        <input type="file" id="input_bukti" name="bukti_transfer"
                               accept=".jpg,.jpeg,.png,.pdf" style="display:none;"
                               onchange="showPreview(this, 'preview_bukti')">
                        <div id="preview_bukti" style="display:none; margin-top:0.5rem; font-size:0.8rem; color:#059669; padding:0.5rem 0.75rem; background:#ecfdf5; border-radius:0.375rem;"></div>
                    </div>

                    {{-- ── UPLOAD SURAT PEMINJAMAN ────────────────────── --}}
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">
                            Surat Peminjaman
                            <span style="font-weight:400; color:#9ca3af;">(opsional — bisa dilengkapi setelah pengembalian)</span>
                        </label>
                        <div id="drop_surat"
                             onclick="document.getElementById('input_surat').click()"
                             ondragover="event.preventDefault(); this.style.borderColor='#7B1B2A';"
                             ondragleave="this.style.borderColor='#e5e7eb';"
                             ondrop="handleDrop(event, 'input_surat', 'preview_surat')"
                             style="border:2px dashed #e5e7eb; border-radius:0.5rem; padding:1.25rem; text-align:center; cursor:pointer; transition:border-color 0.2s; background:#f9fafb;">
                            <svg style="width:2rem; height:2rem; color:#9ca3af; margin:0 auto 0.5rem; display:block;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414A1 1 0 0119 9.414V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p style="font-size:0.8rem; color:#6b7280; margin:0;">Klik atau drag file ke sini</p>
                            <p style="font-size:0.7rem; color:#9ca3af; margin:0.25rem 0 0;">JPG, PNG, PDF — maks 5MB</p>
                        </div>
                        <input type="file" id="input_surat" name="surat_file"
                               accept=".jpg,.jpeg,.png,.pdf" style="display:none;"
                               onchange="showPreview(this, 'preview_surat')">
                        <div id="preview_surat" style="display:none; margin-top:0.5rem; font-size:0.8rem; color:#059669; padding:0.5rem 0.75rem; background:#ecfdf5; border-radius:0.375rem;"></div>
                    </div>

                    {{-- Link Surat (alternatif) --}}
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.4rem;">
                            Atau Link Surat
                            <span style="font-weight:400; color:#9ca3af;">(opsional)</span>
                        </label>
                        <input type="url" name="surat_link" value="{{ old('surat_link') }}"
                               placeholder="https://drive.google.com/..."
                               style="width:100%; box-sizing:border-box; padding:0.7rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            style="padding:0.85rem; background:#7B1B2A; color:#fff; font-weight:700; font-size:0.875rem; border:none; border-radius:0.5rem; cursor:pointer;"
                            onmouseover="this.style.background='#6b1624'"
                            onmouseout="this.style.background='#7B1B2A'">
                        Ajukan Peminjaman
                    </button>

                </div>
            </form>
        </div>

        {{-- ── Kolom Kanan: Peminjaman Saya ──────────────────────────── --}}
        <div style="display:flex; flex-direction:column; gap:1rem;">

            <div style="background:#fff; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,0.08); padding:1.5rem;">
                <h3 style="font-size:0.95rem; font-weight:700; color:#111827; margin:0 0 1.25rem;">Peminjaman Saya</h3>

                <div style="display:flex; flex-direction:column; gap:0.75rem;">
                    @forelse($myLoans as $loan)
                    <div style="padding:0.875rem 1rem; border:1px solid #f3f4f6; border-radius:0.5rem;">

                        {{-- Nama & Status --}}
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.35rem;">
                            <p style="font-size:0.875rem; font-weight:600; color:#111827; margin:0;">
                                {{ $loan->inventory->name ?? '-' }}
                            </p>
                            @if($loan->status === 'approved')
                                <span style="font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:9999px; background:#dcfce7; color:#15803d; font-weight:600;">Disetujui</span>
                            @elseif($loan->status === 'pending')
                                <span style="font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:9999px; background:#fef9c3; color:#a16207; font-weight:600;">Menunggu</span>
                            @else
                                <span style="font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:9999px; background:#fee2e2; color:#dc2626; font-weight:600;">Ditolak</span>
                            @endif
                        </div>

                        <p style="font-size:0.75rem; color:#6b7280; margin:0 0 0.5rem;">
                            {{ $loan->duration_days }} hari · {{ $loan->created_at->format('j M Y') }}
                        </p>

                        {{-- Indikator file --}}
                        <div style="display:flex; gap:0.4rem; flex-wrap:wrap; margin-bottom:0.5rem;">
                            @if($loan->bukti_transfer_url)
                                <a href="{{ $loan->bukti_transfer_url }}" target="_blank"
                                   style="font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:9999px; background:#dbeafe; color:#1d4ed8; text-decoration:none; font-weight:600;">
                                    ✓ Bukti Transfer
                                </a>
                            @else
                                <span style="font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:9999px; background:#f3f4f6; color:#9ca3af;">
                                    — Belum ada bukti
                                </span>
                            @endif

                            @if($loan->surat_file_url)
                                <a href="{{ $loan->surat_file_url }}" target="_blank"
                                   style="font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:9999px; background:#dcfce7; color:#15803d; text-decoration:none; font-weight:600;">
                                    ✓ Surat Peminjaman
                                </a>
                            @else
                                <span style="font-size:0.65rem; padding:0.15rem 0.5rem; border-radius:9999px; background:#f3f4f6; color:#9ca3af;">
                                    — Belum ada surat
                                </span>
                            @endif
                        </div>

                        {{-- Upload surat menyusul (jika belum ada & sudah approved) --}}
                        @if(!$loan->surat_file_url && $loan->status === 'approved')
                            <details style="margin-top:0.25rem;">
                                <summary style="font-size:0.75rem; color:#7B1B2A; cursor:pointer; font-weight:600;">
                                    + Upload Surat Menyusul
                                </summary>
                                <form action="{{ route('user.ajukan.upload-surat', $loan->id) }}"
                                      method="POST" enctype="multipart/form-data"
                                      style="margin-top:0.5rem; display:flex; gap:0.5rem; align-items:center;">
                                    @csrf
                                    <input type="file" name="surat_file" accept=".jpg,.jpeg,.png,.pdf"
                                           required
                                           style="font-size:0.75rem; flex:1;">
                                    <button type="submit"
                                            style="padding:0.4rem 0.75rem; background:#7B1B2A; color:#fff; font-size:0.75rem; border:none; border-radius:0.375rem; cursor:pointer; white-space:nowrap;">
                                        Upload
                                    </button>
                                </form>
                            </details>
                        @endif

                    </div>
                    @empty
                    <p style="font-size:0.875rem; color:#9ca3af; text-align:center; padding:1rem 0;">
                        Belum ada peminjaman.
                    </p>
                    @endforelse
                </div>
            </div>

        </div>

    </div>
</div>

<script>
// ── Hitung total harga ──────────────────────────────────────────────
function hitungTotal() {
    var select   = document.getElementById('inventory_select');
    var duration = document.getElementById('duration_input').value;
    var harga    = select.options[select.selectedIndex]?.dataset.harga ?? 0;

    if (select.value && duration && duration > 0) {
        var total = parseInt(harga) * parseInt(duration);
        document.getElementById('box_total').style.display = 'block';
        document.getElementById('total_harga').textContent =
            'Rp ' + total.toLocaleString('id-ID');
        document.getElementById('detail_harga').textContent =
            'Rp ' + parseInt(harga).toLocaleString('id-ID') + '/hari × ' + duration + ' hari';
    } else {
        document.getElementById('box_total').style.display = 'none';
    }
}

// ── Preview nama file setelah dipilih ──────────────────────────────
function showPreview(input, previewId) {
    var preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var sizeMB = (file.size / 1024 / 1024).toFixed(2);
        preview.style.display = 'block';
        preview.innerHTML = '📎 ' + file.name + ' (' + sizeMB + ' MB)';
    }
}

// ── Drag & drop handler ────────────────────────────────────────────
function handleDrop(event, inputId, previewId) {
    event.preventDefault();
    var input = document.getElementById(inputId);
    input.files = event.dataTransfer.files;
    showPreview(input, previewId);
    // Reset border
    event.currentTarget.style.borderColor = '#e5e7eb';
}
</script>
@endsection
