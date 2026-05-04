<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SIMI - Sistem Informasi Manajemen Inventaris</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: sans-serif; }
    </style>
</head>
<body>

    {{-- NAVBAR --}}
    <nav style="background: #7B1B2A; padding: 1rem 3rem; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 100;">
        <div style="display: flex; align-items: center; gap: 0.875rem;">
            <div style="background: #FACC15; border-radius: 0.5rem; width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center;">
                <svg style="width:1.25rem; height:1.25rem; color:#7B1B2A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                </svg>
            </div>
            <div>
                <p style="font-size: 1.1rem; font-weight: 800; color: white; line-height: 1.2;">SIMI</p>
                <p style="font-size: 0.7rem; color: rgba(255,255,255,0.7); line-height: 1.2;">Sistem Informasi Manajemen Inventaris</p>
            </div>
        </div>
        <a href="{{ route('login') }}" style="background: #FACC15; color: #111; font-weight: 700; font-size: 0.875rem; padding: 0.6rem 1.5rem; border-radius: 0.5rem; text-decoration: none;"
            onmouseover="this.style.background='#eab308'"
            onmouseout="this.style.background='#FACC15'">
            Masuk
        </a>
    </nav>

    {{-- HERO --}}
    <section style="background: #7B1B2A; padding: 4rem 3rem; display: flex; align-items: center; justify-content: center; gap: 3rem;">

        {{-- Kiri --}}
        <div style="flex: 1; max-width: 600px;">
            <div style="display: inline-block; background: rgba(255,255,255,0.15); color: white; font-size: 0.8rem; font-weight: 600; padding: 0.4rem 1rem; border-radius: 9999px; margin-bottom: 1.5rem;">
                PK IMM Siti Munjiyah FKIP UMS
            </div>
            <h1 style="font-size: 3rem; font-weight: 800; color: white; line-height: 1.2; margin-bottom: 1rem;">
                Kelola Inventaris dengan<br>
                <span style="color: #FACC15;">Mudah & Efisien</span>
            </h1>
            <p style="font-size: 1rem; color: rgba(255,255,255,0.8); line-height: 1.7; margin-bottom: 2rem;">
                Pimpinan Komisariat Ikatan Mahasiswa Muhammadiyah (PK IMM) Siti Munjiyah FKIP UMS menghadirkan sistem manajemen inventaris modern untuk memudahkan mahasiswa dan organisasi dalam meminjam peralatan dan fasilitas.
            </p>
            <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                <a href="{{ route('login') }}" style="background: #FACC15; color: #111; font-weight: 700; font-size: 0.95rem; padding: 0.8rem 2rem; border-radius: 0.5rem; text-decoration: none;"
                    onmouseover="this.style.background='#eab308'"
                    onmouseout="this.style.background='#FACC15'">
                    Masuk
                </a>
                <a href="{{ route('publik.ajukan') }}" style="background: transparent; color: #FACC15; font-weight: 700; font-size: 0.95rem; padding: 0.8rem 2rem; border-radius: 0.5rem; text-decoration: none; border: 2px solid #FACC15; display: flex; align-items: center; gap: 0.5rem;"
                    onmouseover="this.style.background='rgba(250,204,21,0.1)'"
                    onmouseout="this.style.background='transparent'">
                    Ajukan Peminjaman Publik
                    <svg style="width:1rem; height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                    </svg>
                </a>
            </div>
        </div>

        {{-- Kanan — Cards Fitur --}}
        <div style="flex: 1; display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; max-width: 550px;">

            <div style="background: white; border-radius: 0.75rem; padding: 1.5rem;">
                <div style="margin-bottom: 0.75rem;">
                    <svg style="width:1.75rem; height:1.75rem; color:#7B1B2A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
                    </svg>
                </div>
                <p style="font-size: 0.95rem; font-weight: 700; color: #111827; margin-bottom: 0.4rem;">Katalog Inventaris Lengkap</p>
                <p style="font-size: 0.8rem; color: #6b7280; line-height: 1.5;">Lihat dan cari inventaris yang tersedia dengan mudah dan cepat</p>
            </div>

            <div style="background: white; border-radius: 0.75rem; padding: 1.5rem;">
                <div style="margin-bottom: 0.75rem;">
                    <svg style="width:1.75rem; height:1.75rem; color:#7B1B2A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <p style="font-size: 0.95rem; font-weight: 700; color: #111827; margin-bottom: 0.4rem;">Peminjaman Real-time</p>
                <p style="font-size: 0.8rem; color: #6b7280; line-height: 1.5;">Ajukan peminjaman kapan saja dengan sistem approval otomatis</p>
            </div>

            <div style="background: white; border-radius: 0.75rem; padding: 1.5rem;">
                <div style="margin-bottom: 0.75rem;">
                    <svg style="width:1.75rem; height:1.75rem; color:#7B1B2A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <p style="font-size: 0.95rem; font-weight: 700; color: #111827; margin-bottom: 0.4rem;">Riwayat Transparan</p>
                <p style="font-size: 0.8rem; color: #6b7280; line-height: 1.5;">Lacak semua riwayat peminjaman dan pengembalian Anda</p>
            </div>

            <div style="background: white; border-radius: 0.75rem; padding: 1.5rem;">
                <div style="margin-bottom: 0.75rem;">
                    <svg style="width:1.75rem; height:1.75rem; color:#7B1B2A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <p style="font-size: 0.95rem; font-weight: 700; color: #111827; margin-bottom: 0.4rem;">Aman & Terpercaya</p>
                <p style="font-size: 0.8rem; color: #6b7280; line-height: 1.5;">Sistem yang aman dengan verifikasi di setiap tahapan</p>
            </div>

        </div>
    </section>

    {{-- FITUR --}}
    <section style="padding: 5rem 3rem; background: white; text-align: center;">
        <h2 style="font-size: 2rem; font-weight: 800; color: #111827; margin-bottom: 0.75rem;">Fitur Peminjaman & Persewaan Inventaris</h2>
        <p style="font-size: 1rem; color: #6b7280; max-width: 600px; margin: 0 auto 3rem; line-height: 1.7;">Sistem yang dirancang khusus untuk memudahkan proses peminjaman dan persewaan inventaris organisasi</p>

        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; max-width: 1100px; margin: 0 auto;">

            <div style="background: #fef2f2; border-radius: 0.75rem; padding: 2rem; text-align: left;">
                <div style="background: #7B1B2A; border-radius: 0.5rem; width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <svg style="width:1.25rem; height:1.25rem; color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Pencarian Inventaris</h3>
                <p style="font-size: 0.85rem; color: #6b7280; line-height: 1.6;">Temukan inventaris yang dibutuhkan dengan fitur pencarian dan filter kategori yang canggih</p>
            </div>

            <div style="background: #fef9c3; border-radius: 0.75rem; padding: 2rem; text-align: left;">
                <div style="background: #FACC15; border-radius: 0.5rem; width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <svg style="width:1.25rem; height:1.25rem; color:#111;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                </div>
                <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Kalkulasi Biaya Otomatis</h3>
                <p style="font-size: 0.85rem; color: #6b7280; line-height: 1.6;">Hitung total biaya sewa secara otomatis berdasarkan durasi dan jenis inventaris yang dipinjam</p>
            </div>

            <div style="background: #f0fdf4; border-radius: 0.75rem; padding: 2rem; text-align: left;">
                <div style="background: #22c55e; border-radius: 0.5rem; width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <svg style="width:1.25rem; height:1.25rem; color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Approval Cepat</h3>
                <p style="font-size: 0.85rem; color: #6b7280; line-height: 1.6;">Proses persetujuan peminjaman yang cepat dan transparan dengan notifikasi status real-time</p>
            </div>

            <div style="background: #eff6ff; border-radius: 0.75rem; padding: 2rem; text-align: left;">
                <div style="background: #3b82f6; border-radius: 0.5rem; width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <svg style="width:1.25rem; height:1.25rem; color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Laporan Lengkap</h3>
                <p style="font-size: 0.85rem; color: #6b7280; line-height: 1.6;">Generate laporan peminjaman dan pendapatan secara otomatis dalam format PDF dan Excel</p>
            </div>

            <div style="background: #fdf4ff; border-radius: 0.75rem; padding: 2rem; text-align: left;">
                <div style="background: #a855f7; border-radius: 0.5rem; width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <svg style="width:1.25rem; height:1.25rem; color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Manajemen User</h3>
                <p style="font-size: 0.85rem; color: #6b7280; line-height: 1.6;">Kelola akun pengguna dengan sistem role admin dan user yang terstruktur dan aman</p>
            </div>

            <div style="background: #fff7ed; border-radius: 0.75rem; padding: 2rem; text-align: left;">
                <div style="background: #f97316; border-radius: 0.5rem; width: 2.5rem; height: 2.5rem; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem;">
                    <svg style="width:1.25rem; height:1.25rem; color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                </div>
                <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin-bottom: 0.5rem;">Manajemen Pengembalian</h3>
                <p style="font-size: 0.85rem; color: #6b7280; line-height: 1.6;">Pantau status pengembalian inventaris dan hitung denda keterlambatan secara otomatis</p>
            </div>

        </div>
    </section>

    {{-- UNTUK SIAPA --}}
    <section style="padding: 5rem 3rem; background: #f9fafb;">
        <h2 style="font-size: 2rem; font-weight: 800; color: #111827; text-align: center; margin-bottom: 3rem;">Dirancang untuk Semua</h2>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; max-width: 900px; margin: 0 auto;">

            <div style="background: white; border-radius: 0.75rem; padding: 2rem; border: 1px solid #e5e7eb;">
                <div style="margin-bottom: 1rem;">
                    <svg style="width:2rem; height:2rem; color:#7B1B2A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #7B1B2A; margin-bottom: 1rem;">Untuk Mahasiswa & Ormawa</h3>
                <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                    @foreach(['Proses peminjaman cepat dan mudah', 'Perhitungan biaya sewa otomatis', 'Notifikasi real-time untuk status peminjaman', 'Laporan lengkap dan terstruktur'] as $item)
                    <div style="display: flex; align-items: center; gap: 0.6rem;">
                        <svg style="width:1.1rem; height:1.1rem; color:#FACC15; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span style="font-size: 0.875rem; color: #374151;">{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <div style="background: #fffbeb; border-radius: 0.75rem; padding: 2rem; border: 1px solid #fde68a;">
                <div style="margin-bottom: 1rem;">
                    <svg style="width:2rem; height:2rem; color:#7B1B2A;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                    </svg>
                </div>
                <h3 style="font-size: 1.1rem; font-weight: 700; color: #7B1B2A; margin-bottom: 1rem;">Untuk Pengurus PK IMM</h3>
                <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                    @foreach(['Kelola inventaris dengan mudah', 'Verifikasi peminjaman secara efisien', 'Buat laporan lengkap otomatis', 'Monitoring real-time kondisi inventaris'] as $item)
                    <div style="display: flex; align-items: center; gap: 0.6rem;">
                        <svg style="width:1.1rem; height:1.1rem; color:#FACC15; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span style="font-size: 0.875rem; color: #374151;">{{ $item }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </section>

    {{-- CTA --}}
    <section style="background: #7B1B2A; padding: 5rem 3rem; text-align: center;">
        <h2 style="font-size: 2rem; font-weight: 800; color: white; margin-bottom: 1rem;">Siap Memulai?</h2>
        <p style="font-size: 1rem; color: rgba(255,255,255,0.8); max-width: 600px; margin: 0 auto 2rem; line-height: 1.7;">
            Bergabunglah dengan sistem manajemen inventaris PK IMM Siti Munjiyah dan rasakan kemudahan dalam mengelola peminjaman inventaris
        </p>
        <a href="{{ route('login') }}" style="display: inline-block; background: #FACC15; color: #111; font-weight: 700; font-size: 1rem; padding: 0.9rem 2.5rem; border-radius: 0.5rem; text-decoration: none;"
            onmouseover="this.style.background='#eab308'"
            onmouseout="this.style.background='#FACC15'">
            Masuk ke Sistem
        </a>
    </section>

    {{-- FOOTER --}}
    <footer style="background: #7B1B2A; border-top: 1px solid rgba(255,255,255,0.1); padding: 1.5rem 3rem; text-align: center;">
        <p style="font-size: 0.875rem; color: rgba(255,255,255,0.6);">
            © 2026 PK IMM Siti Munjiyah FKIP UMS. Sistem Informasi Manajemen Inventaris.
        </p>
    </footer>

</body>
</html>