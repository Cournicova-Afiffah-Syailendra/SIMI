<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — SIMI</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; padding: 0; min-height: 100vh; background-color: #7B1B2A; display: flex; align-items: center; justify-content: center; font-family: sans-serif;">

    <div style="width: 100%; max-width: 420px; margin: 1rem;">

        {{-- Card --}}
        <div style="background: #fff; border-radius: 1rem; padding: 2.5rem 2.25rem; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">

            {{-- Logo --}}
            <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 1.75rem;">
                <div style="
                    width: 4rem; height: 4rem; border-radius: 9999px;
                    background: #7B1B2A;
                    display: flex; align-items: center; justify-content: center;
                    margin-bottom: 1rem;
                ">
                    <svg style="width: 2rem; height: 2rem; color: white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h1 style="font-size: 1.25rem; font-weight: 800; color: #111827; margin: 0 0 0.25rem; text-align: center;">SIMI - PK IMM Siti Munjiyah</h1>
                <p style="font-size: 0.8rem; color: #6b7280; margin: 0; text-align: center;">Sistem Informasi Manajemen Inventaris</p>
                <p style="font-size: 0.75rem; color: #9ca3af; margin: 0.2rem 0 0; text-align: center;">FKIP Universitas Muhammadiyah Surakarta</p>
            </div>

            {{-- Error --}}
            @if ($errors->any())
                <div style="margin-bottom: 1rem; padding: 0.75rem 1rem; background: #fee2e2; color: #dc2626; border-radius: 0.5rem; font-size: 0.8rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div style="margin-bottom: 1rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #111827; margin-bottom: 0.4rem;">Username</label>
                    <input
                        type="text"
                        name="username"
                        placeholder="Masukkan username"
                        value="{{ old('username') }}"
                        required autofocus
                        style="width: 100%; box-sizing: border-box; padding: 0.7rem 1rem; font-size: 0.875rem; color: #374151; border: 1px solid #e5e7eb; border-radius: 0.5rem; background: #f9fafb; outline: none;"
                        onfocus="this.style.borderColor='#7B1B2A'"
                        onblur="this.style.borderColor='#e5e7eb'"
                    >
                </div>

                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #111827; margin-bottom: 0.4rem;">Password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Masukkan password"
                        required
                        style="width: 100%; box-sizing: border-box; padding: 0.7rem 1rem; font-size: 0.875rem; color: #374151; border: 1px solid #e5e7eb; border-radius: 0.5rem; background: #f9fafb; outline: none;"
                        onfocus="this.style.borderColor='#7B1B2A'"
                        onblur="this.style.borderColor='#e5e7eb'"
                    >
                </div>

                <button type="submit" style="
                    width: 100%; padding: 0.85rem;
                    background: #7B1B2A; color: #fff;
                    font-size: 0.9rem; font-weight: 700;
                    border: none; border-radius: 0.5rem;
                    cursor: pointer; letter-spacing: 0.03em;
                "
                onmouseover="this.style.background='#6b1624'"
                onmouseout="this.style.background='#7B1B2A'">
                    Login
                </button>

            </form>

            {{-- Demo Login Info --}}
            <div style="margin-top: 1.5rem; padding: 0.875rem 1rem; background: #f9fafb; border-radius: 0.5rem; text-align: center;">
                <p style="font-size: 0.75rem; color: #9ca3af; margin: 0 0 0.35rem;">Demo Login:</p>
                <p style="font-size: 0.8rem; color: #6b7280; margin: 0 0 0.2rem;">Admin: <strong>admin</strong> / <strong>admin</strong></p>
                <p style="font-size: 0.8rem; color: #6b7280; margin: 0;">User: <strong>user</strong> / <strong>user</strong></p>
            </div>

        </div>
    </div>

</body>
</html>
