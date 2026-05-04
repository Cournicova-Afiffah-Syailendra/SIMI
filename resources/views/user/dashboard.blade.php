@extends('layouts.user')

@section('content')
<div style="display: flex; flex-direction: column; gap: 1.5rem;">

    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; color: #7B1B2A; margin: 0 0 0.25rem;">Dashboard</h1>
        <p style="font-size: 0.875rem; color: #6b7280; margin: 0;">Sistem Informasi Manajemen Inventaris</p>
    </div>

    {{-- Cards --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 1.25rem;">

        <div style="background:#fff; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,0.08); padding:1.25rem; display:flex; align-items:center; justify-content:space-between; border-left:4px solid #7f1d1d;">
            <div>
                <p style="font-size:0.8rem; color:#6b7280; margin:0 0 0.4rem;">Peminjaman Aktif</p>
                <h2 style="font-size:2rem; font-weight:700; color:#111827; margin:0;">{{ $peminjamAktif }}</h2>
            </div>
            <div style="background:#eab308; border-radius:0.75rem; padding:0.75rem; font-size:1.5rem; line-height:1;">🛒</div>
        </div>

        <div style="background:#fff; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,0.08); padding:1.25rem; display:flex; align-items:center; justify-content:space-between; border-left:4px solid #7f1d1d;">
            <div>
                <p style="font-size:0.8rem; color:#6b7280; margin:0 0 0.4rem;">Total Peminjaman</p>
                <h2 style="font-size:2rem; font-weight:700; color:#111827; margin:0;">{{ $totalPeminjaman }}</h2>
            </div>
            <div style="background:#3b82f6; border-radius:0.75rem; padding:0.75rem; font-size:1.5rem; line-height:1;">📦</div>
        </div>

        <div style="background:#fff; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,0.08); padding:1.25rem; display:flex; align-items:center; justify-content:space-between; border-left:4px solid #7f1d1d;">
            <div>
                <p style="font-size:0.8rem; color:#6b7280; margin:0 0 0.4rem;">Selesai</p>
                <h2 style="font-size:2rem; font-weight:700; color:#111827; margin:0;">{{ $selesai }}</h2>
            </div>
            <div style="background:#22c55e; border-radius:0.75rem; padding:0.75rem; font-size:1.5rem; line-height:1;">✅</div>
        </div>

        <div style="background:#fff; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,0.08); padding:1.25rem; display:flex; align-items:center; justify-content:space-between; border-left:4px solid #7f1d1d;">
            <div>
                <p style="font-size:0.8rem; color:#6b7280; margin:0 0 0.4rem;">Menunggu Persetujuan</p>
                <h2 style="font-size:2rem; font-weight:700; color:#111827; margin:0;">{{ $menunggu }}</h2>
            </div>
            <div style="background:#f97316; border-radius:0.75rem; padding:0.75rem; font-size:1.5rem; line-height:1;">⏱</div>
        </div>

    </div>

    {{-- Konten Bawah --}}
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">

        {{-- Peminjaman Aktif --}}
        <div style="background:#fff; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,0.08); padding:1.5rem;">
            <h3 style="font-size:0.95rem; font-weight:700; color:#111827; margin:0 0 1rem;">Peminjaman Aktif</h3>
            <div style="display:flex; flex-direction:column; gap:0.75rem;">
                @forelse($peminjamAktifList as $loan)
                <div style="padding:1rem; border:1px solid #f3f4f6; border-radius:0.5rem;">
                    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:0.5rem;">
                        <p style="font-size:0.875rem; font-weight:700; color:#111827; margin:0;">{{ $loan->inventory->name ?? '-' }}</p>
                        @if($loan->status === 'approved')
                            <span style="font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:9999px; background:#dcfce7; color:#15803d; font-weight:600;">Disetujui</span>
                        @else
                            <span style="font-size:0.7rem; padding:0.2rem 0.6rem; border-radius:9999px; background:#fef9c3; color:#a16207; font-weight:600;">Menunggu</span>
                        @endif
                    </div>
                    <p style="font-size:0.75rem; color:#6b7280; margin:0;">Pinjam: {{ $loan->created_at->format('j F Y') }}</p>
                    <p style="font-size:0.75rem; color:#6b7280; margin:0;">Kembali: {{ $loan->created_at->addDays($loan->duration_days)->format('j F Y') }}</p>
                </div>
                @empty
                <p style="font-size:0.875rem; color:#9ca3af; text-align:center; padding:1rem 0;">Belum ada peminjaman aktif.</p>
                @endforelse
            </div>
        </div>

        {{-- Inventaris Populer --}}
        <div style="background:#fff; border-radius:0.75rem; box-shadow:0 1px 3px rgba(0,0,0,0.08); padding:1.5rem;">
            <h3 style="font-size:0.95rem; font-weight:700; color:#111827; margin:0 0 1rem;">Inventaris Populer</h3>
            <div style="display:flex; flex-direction:column; gap:0.5rem;">
                @foreach($inventarisPopuler as $inv)
                <div style="display:flex; align-items:center; justify-content:space-between; padding:0.875rem 1rem; border:1px solid #f3f4f6; border-radius:0.5rem;">
                    <div>
                        <p style="font-size:0.875rem; font-weight:600; color:#111827; margin:0 0 0.25rem;">{{ $inv->name }}</p>
                        <div style="display:flex; align-items:center; gap:0.5rem;">
                            <span style="font-size:0.75rem; color:#6b7280;">{{ $inv->category }}</span>
                            <span style="font-size:0.7rem; color:#15803d; font-weight:600;">Tersedia: {{ $inv->total_stock }}</span>
                        </div>
                    </div>
                    <div style="text-align:right;">
                        <p style="font-size:0.875rem; font-weight:700; color:#7B1B2A; margin:0;">Rp {{ number_format($inv->price ?? 0, 0, ',', '.') }}</p>
                        <p style="font-size:0.7rem; color:#9ca3af; margin:0;">per hari</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Banner --}}
<a href="https://wa.me/6287826754634?text=Halo%20Pengurus%20SIMI%2C%20saya%20ingin%20bertanya%20tentang%20peminjaman%20inventaris."
   target="_blank"
   style="text-decoration:none; display:block;">
    <div style="background:#7B1B2A; border-radius:0.75rem; padding:1.75rem 2rem; display:flex; align-items:center; justify-content:space-between; cursor:pointer; transition: opacity 0.2s;"
        onmouseover="this.style.opacity='0.9'"
        onmouseout="this.style.opacity='1'">
        <div style="display:flex; align-items:center; gap:1.25rem;">
            {{-- Logo WhatsApp --}}
            <div style="background:#25D366; border-radius:9999px; width:3rem; height:3rem; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg style="width:1.75rem; height:1.75rem;" viewBox="0 0 24 24" fill="white">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
            </div>
            <div>
                <h3 style="font-size:1.1rem; font-weight:700; color:#fff; margin:0 0 0.4rem;">Butuh bantuan peminjaman inventaris?</h3>
                <p style="font-size:0.875rem; color:rgba(255,255,255,0.7); margin:0;">Hubungi pengurus PK IMM Siti Munjiyah untuk informasi lebih lanjut</p>
            </div>
        </div>
        <div style="font-size:2.5rem; opacity:0.3;">📦</div>
    </div>
</a>
@endsection
