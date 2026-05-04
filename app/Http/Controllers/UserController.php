<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'username'     => 'required|string|unique:users,username|max:255',
            'email'        => 'required|email|unique:users,email|max:255',
            'organization' => 'nullable|string|max:255',
            'role'         => 'required|in:admin,user',
            'password'     => 'required|string|min:6',
        ]);

        User::create([
            'name'         => $request->name,
            'username'     => $request->username,
            'email'        => $request->email,
            'organization' => $request->organization,
            'role'         => $request->role,
            'password'     => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'username'     => 'required|string|unique:users,username,' . $user->id . '|max:255',
            'email'        => 'required|email|unique:users,email,' . $user->id . '|max:255',
            'organization' => 'nullable|string|max:255',
            'role'         => 'required|in:admin,user',
            'password'     => 'nullable|string|min:6',
        ]);

        $data = [
            'name'         => $request->name,
            'username'     => $request->username,
            'email'        => $request->email,
            'organization' => $request->organization,
            'role'         => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->user()->id) {
            return redirect()->route('users.index')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
