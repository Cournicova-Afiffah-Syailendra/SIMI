<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajukan Peminjaman — {{ config('app.name', 'SIMI') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin:0; padding:0; background:#f9fafb; min-height:100vh;">

    {{-- Header publik --}}
    <header style="background:#7B1B2A; padding:0.875rem 2rem; display:flex; align-items:center; justify-content:space-between; position:sticky; top:0; z-index:99; box-shadow:0 2px 8px rgba(0,0,0,0.15);">
        <div style="display:flex; align-items:center; gap:0.75rem;">
            <div>
                <p style="font-size:1.1rem; font-weight:800; color:#fff; margin:0; letter-spacing:0.03em;">SIMI</p>
                <p style="font-size:0.7rem; color:rgba(255,255,255,0.7); margin:0;">PK IMM Siti Munjiyah</p>
            </div>
        </div>
        <span style="font-size:0.8rem; color:rgba(255,255,255,0.8);">
            Sistem Informasi Manajemen Inventaris
        </span>
    </header>

    {{-- Konten --}}
    <main style="max-width:860px; margin:2rem auto; padding:0 1.25rem;">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer style="text-align:center; padding:1.5rem; font-size:0.75rem; color:#9ca3af; margin-top:2rem; border-top:1px solid #e5e7eb;">
        © {{ date('Y') }} SIMI — PK IMM Siti Munjiyah. All rights reserved.
    </footer>

</body>
</html>
