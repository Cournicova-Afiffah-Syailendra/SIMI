<aside style="
    width: 240px; min-width: 240px;
    background-color: #7B1B2A;
    display: flex; flex-direction: column;
    min-height: 100vh; height: 100%;
    color: white; flex-shrink: 0;
">
    <div style="padding: 1.75rem 1.5rem 1.25rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800; letter-spacing: 0.05em; margin: 0; line-height: 1.2;">SIMI</h1>
        <p style="margin: 0.3rem 0 0; font-size: 0.75rem; opacity: 0.65; line-height: 1.4;">PK IMM Siti Munjiyah</p>
    </div>

    <div style="height: 1px; background: rgba(255,255,255,0.2); margin: 0 1.25rem;"></div>

    <nav style="padding: 1rem 0.75rem; flex: 1; display: flex; flex-direction: column; gap: 0.25rem;">

        @php $activeDash = request()->routeIs('user.dashboard'); @endphp
        <a href="{{ route('user.dashboard') }}" style="
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: {{ $activeDash ? '700' : '500' }};
            text-decoration: none;
            background: {{ $activeDash ? '#FACC15' : 'transparent' }};
            color: {{ $activeDash ? '#111' : 'white' }};
        "
        @if(!$activeDash)
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='transparent'"
        @endif>
            <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            Dashboard
        </a>

        @php $activeKatalog = request()->routeIs('user.katalog'); @endphp
        <a href="{{ route('user.katalog') }}" style="
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: {{ $activeKatalog ? '700' : '500' }};
            text-decoration: none;
            background: {{ $activeKatalog ? '#FACC15' : 'transparent' }};
            color: {{ $activeKatalog ? '#111' : 'white' }};
        "
        @if(!$activeKatalog)
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='transparent'"
        @endif>
            <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
            Katalog Inventaris
        </a>

        {{-- DIPERBAIKI: route diubah ke user.ajukan --}}
        @php $activeAjukan = request()->routeIs('user.ajukan*'); @endphp
        <a href="{{ route('user.ajukan') }}" style="
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: {{ $activeAjukan ? '700' : '500' }};
            text-decoration: none;
            background: {{ $activeAjukan ? '#FACC15' : 'transparent' }};
            color: {{ $activeAjukan ? '#111' : 'white' }};
        "
        @if(!$activeAjukan)
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='transparent'"
        @endif>
            <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 7h11"/>
            </svg>
            Ajukan Peminjaman
        </a>

        @php $activeRiwayat = request()->routeIs('user.riwayat'); @endphp
        <a href="{{ route('user.riwayat') }}" style="
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: {{ $activeRiwayat ? '700' : '500' }};
            text-decoration: none;
            background: {{ $activeRiwayat ? '#FACC15' : 'transparent' }};
            color: {{ $activeRiwayat ? '#111' : 'white' }};
        "
        @if(!$activeRiwayat)
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='transparent'"
        @endif>
            <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Riwayat Peminjaman
        </a>

    </nav>

    <div style="height: 1px; background: rgba(255,255,255,0.2); margin: 0 1.25rem;"></div>

    <div style="padding: 1rem 1.25rem 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
            <div style="width:2.25rem; height:2.25rem; border-radius:9999px; background:rgba(255,255,255,0.15); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <svg style="width:1rem; height:1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p style="margin:0; font-size:0.7rem; opacity:0.6; line-height:1.3;">Logged in as</p>
                <p style="margin:0; font-size:0.875rem; font-weight:700; color:white; line-height:1.3;">{{ auth()->user()->name ?? 'user' }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="display:flex; align-items:center; gap:0.6rem; width:100%; padding:0.5rem 0.75rem; background:transparent; border:none; color:rgba(255,255,255,0.7); font-size:0.875rem; font-weight:500; border-radius:0.5rem; cursor:pointer;"
                onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='white'"
                onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.7)'">
                <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>
</aside>
