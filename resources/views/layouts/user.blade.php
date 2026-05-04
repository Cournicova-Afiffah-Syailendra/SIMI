<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'SIMI') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; background: #f9fafb;">
    <div style="display: flex; min-height: 100vh;">

        {{-- Sidebar --}}
        <div style="position: fixed; top: 0; left: 0; height: 100vh; z-index: 100; overflow-y: auto;">
            @include('layouts.user-sidebar')
        </div>

        {{-- Konten --}}
        <div style="margin-left: 240px; flex: 1; display: flex; flex-direction: column; min-height: 100vh;">
            <header style="position: sticky; top: 0; z-index: 99; background: #fff; border-bottom: 1px solid #e5e7eb; padding: 1rem 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <span style="font-size: 1.2rem; color: #6b7280;">☰</span>
                    <h1 style="font-size: 1rem; font-weight: 600; color: #111827; margin: 0;">Sistem Informasi Manajemen Inventaris</h1>
                </div>
                <div style="display: flex; flex-direction: column; align-items: flex-end;">
                    <span style="font-size: 0.875rem; font-weight: 600; color: #111827;">{{ Auth::user()->name ?? 'user' }}</span>
                    <span style="font-size: 0.75rem; color: #6b7280;">Peminjam</span>
                </div>
            </header>

            <main style="flex: 1; padding: 1.5rem;">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
