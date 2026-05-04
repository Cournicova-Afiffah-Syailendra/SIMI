<aside style="
    width: 240px;
    min-width: 240px;
    background-color: #7B1B2A;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    height: 100%;
    color: white;
    flex-shrink: 0;
">

    {{-- Branding --}}
    <div style="padding: 1.75rem 1.5rem 1.25rem;">
        <h1 style="font-size: 1.5rem; font-weight: 800; letter-spacing: 0.05em; margin: 0; line-height: 1.2;">SIMI</h1>
        <p style="margin: 0.3rem 0 0; font-size: 0.75rem; opacity: 0.65; line-height: 1.4;">PK IMM Siti Munjiyah</p>
    </div>

    {{-- Separator --}}
    <div style="height: 1px; background: rgba(255,255,255,0.2); margin: 0 1.25rem;"></div>

    {{-- Navigation --}}
    <nav style="padding: 1rem 0.75rem; flex: 1; display: flex; flex-direction: column; gap: 0.25rem;">

        {{-- Dashboard --}}
        @php $activeDashboard = request()->routeIs('dashboard'); @endphp
        <a href="{{ route('dashboard') }}" style="
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: {{ $activeDashboard ? '700' : '500' }};
            text-decoration: none;
            background: {{ $activeDashboard ? '#FACC15' : 'transparent' }};
            color: {{ $activeDashboard ? '#111' : 'white' }};
        "
        @if(!$activeDashboard)
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='transparent'"
        @endif
        >
            <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
            </svg>
            Dashboard
        </a>

        {{-- Data Inventaris --}}
        @php $activeInventory = request()->routeIs('inventories.*'); @endphp
        <a href="{{ route('inventories.index') }}" style="
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: {{ $activeInventory ? '700' : '500' }};
            text-decoration: none;
            background: {{ $activeInventory ? '#FACC15' : 'transparent' }};
            color: {{ $activeInventory ? '#111' : 'white' }};
        "
        @if(!$activeInventory)
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='transparent'"
        @endif
        >
            <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10"/>
            </svg>
            Data Inventaris
        </a>

        {{-- Peminjaman --}}
        @php $activeLoan = request()->routeIs('loan-requests.*'); @endphp
        <a href="{{ route('loan-requests.index') }}" style="
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: {{ $activeLoan ? '700' : '500' }};
            text-decoration: none;
            background: {{ $activeLoan ? '#FACC15' : 'transparent' }};
            color: {{ $activeLoan ? '#111' : 'white' }};
        "
        @if(!$activeLoan)
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='transparent'"
        @endif
        >
            <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 7h11"/>
            </svg>
            Peminjaman
        </a>

        {{-- Pengembalian --}}
        @php $activeReturn = request()->routeIs('returns.*'); @endphp
        <a href="{{ route('returns.index') }}" style="
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: {{ $activeReturn ? '700' : '500' }};
            text-decoration: none;
            background: {{ $activeReturn ? '#FACC15' : 'transparent' }};
            color: {{ $activeReturn ? '#111' : 'white' }};
        "
        @if(!$activeReturn)
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='transparent'"
        @endif
        >
            <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Pengembalian
        </a>

        {{-- Laporan --}}
        @php $activeReport = request()->routeIs('reports.*'); @endphp
        <a href="{{ route('reports.index') }}" style="
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: {{ $activeReport ? '700' : '500' }};
            text-decoration: none;
            background: {{ $activeReport ? '#FACC15' : 'transparent' }};
            color: {{ $activeReport ? '#111' : 'white' }};
        "
        @if(!$activeReport)
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='transparent'"
        @endif
        >
            <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            Laporan
        </a>

        {{-- Manajemen User --}}
        @php $activeUser = request()->routeIs('users.*'); @endphp
        <a href="{{ route('users.index') }}" style="
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.6rem 0.75rem; border-radius: 0.5rem;
            font-size: 0.875rem; font-weight: {{ $activeUser ? '700' : '500' }};
            text-decoration: none;
            background: {{ $activeUser ? '#FACC15' : 'transparent' }};
            color: {{ $activeUser ? '#111' : 'white' }};
        "
        @if(!$activeUser)
            onmouseover="this.style.background='rgba(255,255,255,0.1)'"
            onmouseout="this.style.background='transparent'"
        @endif
        >
            <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197"/>
            </svg>
            Manajemen User
        </a>

    </nav>

    {{-- Separator --}}
    <div style="height: 1px; background: rgba(255,255,255,0.2); margin: 0 1.25rem;"></div>

    {{-- Footer: Logged in as + Logout --}}
    <div style="padding: 1rem 1.25rem 1.5rem;">
        <div style="display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem;">
            <div style="
                width: 2.25rem; height: 2.25rem; border-radius: 9999px;
                background: rgba(255,255,255,0.15);
                display: flex; align-items: center; justify-content: center;
                flex-shrink: 0;
            ">
                <svg style="width:1rem; height:1rem; color:white;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div>
                <p style="margin:0; font-size: 0.7rem; opacity: 0.6; line-height: 1.3;">Logged in as</p>
                <p style="margin:0; font-size: 0.875rem; font-weight: 700; color: white; line-height: 1.3;">
                    {{ auth()->user()->name ?? 'admin' }}
                </p>
            </div>
        </div>

        {{-- Tombol Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="
                display: flex; align-items: center; gap: 0.6rem;
                width: 100%; padding: 0.5rem 0.75rem;
                background: transparent; border: none;
                color: rgba(255,255,255,0.7); font-size: 0.875rem; font-weight: 500;
                border-radius: 0.5rem; cursor: pointer; text-align: left;
            "
            onmouseover="this.style.background='rgba(255,255,255,0.1)'; this.style.color='white'"
            onmouseout="this.style.background='transparent'; this.style.color='rgba(255,255,255,0.7)'">
                <svg style="width:1rem; height:1rem; flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Logout
            </button>
        </form>
    </div>

</aside>
