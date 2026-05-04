@extends('layouts.app')

@section('content')
<div style="padding: 2rem; background: #f9fafb; min-height: 100vh;">

    <div style="background: #fff; border-radius: 0.75rem; box-shadow: 0 1px 3px rgba(0,0,0,0.06); overflow: hidden;">

        {{-- Header --}}
        <div style="padding: 1.25rem 1.5rem; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid #f3f4f6;">
            <h3 style="font-size: 1rem; font-weight: 700; color: #111827; margin: 0;">Manajemen User</h3>
            <button onclick="openModal('modalTambah')"
                style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.55rem 1.1rem; background: #FACC15; color: #111; font-weight: 700; font-size: 0.8rem; border: none; border-radius: 0.5rem; cursor: pointer;">
                <span style="font-size: 1rem; font-weight: 700;">+</span>
                Tambah User
            </button>
        </div>

        {{-- Notifikasi --}}
        @if(session('success'))
            <div style="margin: 1rem 1.5rem 0; padding: 0.75rem 1rem; background: #dcfce7; color: #15803d; border-radius: 0.5rem; font-size: 0.875rem;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="margin: 1rem 1.5rem 0; padding: 0.75rem 1rem; background: #fee2e2; color: #dc2626; border-radius: 0.5rem; font-size: 0.875rem;">
                {{ session('error') }}
            </div>
        @endif

        {{-- Search --}}
        <div style="padding: 1rem 1.5rem;">
            <div style="position: relative; max-width: 100%;">
                <span style="position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none;">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </span>
                <input type="text" id="searchInput" placeholder="Cari user..."
                    oninput="filterUsers()"
                    style="width: 100%; box-sizing: border-box; padding: 0.6rem 0.75rem 0.6rem 2.25rem; font-size: 0.875rem; color: #374151; border: 1px solid #e5e7eb; border-radius: 0.5rem; background: #f9fafb; outline: none;">
            </div>
        </div>

        {{-- Table --}}
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
                <thead>
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <th style="padding: 0.75rem 1.25rem; font-weight: 600; color: #374151;">Username</th>
                        <th style="padding: 0.75rem 1.25rem; font-weight: 600; color: #374151;">Nama Lengkap</th>
                        <th style="padding: 0.75rem 1.25rem; font-weight: 600; color: #374151;">Email</th>
                        <th style="padding: 0.75rem 1.25rem; font-weight: 600; color: #374151;">Organisasi</th>
                        <th style="padding: 0.75rem 1.25rem; font-weight: 600; color: #374151;">Role</th>
                        <th style="padding: 0.75rem 1.25rem; font-weight: 600; color: #374151; text-align: right;">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTable">
                    @forelse($users as $user)
                    <tr class="user-row" style="border-bottom: 1px solid #f9fafb;" onmouseover="this.style.background='#fafafa'" onmouseout="this.style.background='#fff'">
                        <td style="padding: 1rem 1.25rem; font-weight: 600; color: #111827;">{{ $user->username ?? '-' }}</td>
                        <td style="padding: 1rem 1.25rem; color: #374151;">{{ $user->name }}</td>
                        <td style="padding: 1rem 1.25rem; color: #6b7280;">{{ $user->email }}</td>
                        <td style="padding: 1rem 1.25rem; color: #374151;">{{ $user->organization ?? '-' }}</td>
                        <td style="padding: 1rem 1.25rem;">
                            @if($user->role === 'admin')
                                <span style="display: inline-flex; padding: 0.2rem 0.75rem; font-size: 0.75rem; font-weight: 700; color: #fff; background: #7f1d1d; border-radius: 9999px;">Admin</span>
                            @else
                                <span style="display: inline-flex; padding: 0.2rem 0.75rem; font-size: 0.75rem; font-weight: 600; color: #374151; background: #f3f4f6; border-radius: 9999px; border: 1px solid #e5e7eb;">User</span>
                            @endif
                        </td>
                        <td style="padding: 1rem 1.25rem; text-align: right;">
                            <div style="display: inline-flex; align-items: center; gap: 0.4rem;">
                                {{-- Edit --}}
                                <button
                                    onclick="openEditModal(
                                        '{{ route('users.update', $user) }}',
                                        '{{ addslashes($user->name) }}',
                                        '{{ addslashes($user->username ?? '') }}',
                                        '{{ addslashes($user->email) }}',
                                        '{{ addslashes($user->organization ?? '') }}',
                                        '{{ $user->role }}'
                                    )"
                                    title="Edit"
                                    style="width: 2.25rem; height: 2.25rem; display: inline-flex; align-items: center; justify-content: center; color: #2563eb; background: #fff; border: 1px solid #bfdbfe; border-radius: 0.5rem; cursor: pointer;"
                                    onmouseover="this.style.background='#eff6ff'" onmouseout="this.style.background='#fff'">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                </button>
                                {{-- Delete --}}
                                <form action="{{ route('users.destroy', $user) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus user ini?');" style="display:inline; margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" title="Hapus"
                                        style="width: 2.25rem; height: 2.25rem; display: inline-flex; align-items: center; justify-content: center; color: #dc2626; background: #fff; border: 1px solid #fecaca; border-radius: 0.5rem; cursor: pointer;"
                                        onmouseover="this.style.background='#fef2f2'" onmouseout="this.style.background='#fff'">
                                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding: 2rem; text-align: center; color: #9ca3af;">Belum ada user.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div id="modalTambah" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:9999; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; padding:1rem; box-sizing:border-box;">
    <div style="position:relative; width:100%; max-width:520px; background:#fff; border-radius:1rem; box-shadow:0 25px 50px rgba(0,0,0,0.3); margin:auto;">
        <button onclick="closeModal('modalTambah')"
            style="position:absolute; top:1.25rem; right:1.25rem; width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; border-radius:9999px; border:none; background:transparent; cursor:pointer; color:#9ca3af;">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div style="padding:2rem 2.5rem;">
            <h3 style="font-size:1.25rem; font-weight:700; color:#111827; margin:0 0 1.25rem;">Tambah User Baru</h3>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <div style="display:flex; flex-direction:column; gap:0.9rem;">
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Nama Lengkap</label>
                        <input type="text" name="name" required
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Username</label>
                        <input type="text" name="username" required
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Email</label>
                        <input type="email" name="email" required
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Organisasi</label>
                        <input type="text" name="organization"
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Role</label>
                        <select name="role"
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Password</label>
                        <input type="password" name="password" required
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div style="display:flex; gap:0.75rem; padding-top:0.5rem;">
                        <button type="submit"
                            style="flex:1; padding:0.8rem; background:#7f1d1d; color:#fff; font-weight:700; font-size:0.875rem; border:none; border-radius:0.5rem; cursor:pointer;">
                            Simpan
                        </button>
                        <button type="button" onclick="closeModal('modalTambah')"
                            style="padding:0.8rem 2rem; background:#fff; color:#374151; font-weight:700; font-size:0.875rem; border:1px solid #d1d5db; border-radius:0.5rem; cursor:pointer;">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL EDIT --}}
<div id="modalEdit" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; z-index:9999; background:rgba(0,0,0,0.5); align-items:center; justify-content:center; padding:1rem; box-sizing:border-box;">
    <div style="position:relative; width:100%; max-width:520px; background:#fff; border-radius:1rem; box-shadow:0 25px 50px rgba(0,0,0,0.3); margin:auto;">
        <button onclick="closeModal('modalEdit')"
            style="position:absolute; top:1.25rem; right:1.25rem; width:2rem; height:2rem; display:flex; align-items:center; justify-content:center; border-radius:9999px; border:none; background:transparent; cursor:pointer; color:#9ca3af;">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <div style="padding:2rem 2.5rem;">
            <h3 style="font-size:1.25rem; font-weight:700; color:#111827; margin:0 0 1.25rem;">Edit User</h3>
            <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div style="display:flex; flex-direction:column; gap:0.9rem;">
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Nama Lengkap</label>
                        <input type="text" id="editName" name="name" required
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Username</label>
                        <input type="text" id="editUsername" name="username" required
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Email</label>
                        <input type="email" id="editEmail" name="email" required
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Organisasi</label>
                        <input type="text" id="editOrganization" name="organization"
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Role</label>
                        <select id="editRole" name="role"
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                            <option value="user">User</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label style="display:block; font-size:0.8rem; font-weight:700; color:#1f2937; margin-bottom:0.35rem;">Password Baru <span style="font-weight:400; color:#9ca3af;">(kosongkan jika tidak diubah)</span></label>
                        <input type="password" name="password"
                            style="width:100%; box-sizing:border-box; padding:0.65rem 1rem; font-size:0.875rem; color:#374151; border:1px solid #e5e7eb; border-radius:0.5rem; background:#f9fafb; outline:none;">
                    </div>
                    <div style="display:flex; gap:0.75rem; padding-top:0.5rem;">
                        <button type="submit"
                            style="flex:1; padding:0.8rem; background:#7f1d1d; color:#fff; font-weight:700; font-size:0.875rem; border:none; border-radius:0.5rem; cursor:pointer;">
                            Simpan
                        </button>
                        <button type="button" onclick="closeModal('modalEdit')"
                            style="padding:0.8rem 2rem; background:#fff; color:#374151; font-weight:700; font-size:0.875rem; border:1px solid #d1d5db; border-radius:0.5rem; cursor:pointer;">
                            Batal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
    function openEditModal(actionUrl, name, username, email, organization, role) {
        document.getElementById('formEdit').action = actionUrl;
        document.getElementById('editName').value         = name;
        document.getElementById('editUsername').value     = username;
        document.getElementById('editEmail').value        = email;
        document.getElementById('editOrganization').value = organization;
        document.getElementById('editRole').value         = role;
        openModal('modalEdit');
    }
    function filterUsers() {
        var input = document.getElementById('searchInput').value.toLowerCase();
        var rows  = document.querySelectorAll('.user-row');
        rows.forEach(function(row) {
            var text = row.innerText.toLowerCase();
            row.style.display = text.includes(input) ? '' : 'none';
        });
    }
    ['modalTambah','modalEdit'].forEach(function(id) {
        document.getElementById(id).addEventListener('click', function(e) {
            if (e.target === this) closeModal(id);
        });
    });
</script>
@endsection
