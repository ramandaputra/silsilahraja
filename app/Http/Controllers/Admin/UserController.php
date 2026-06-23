<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name', 'asc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function store(Request $request)
    {
        // 1. Cek paksa: Apakah sudah ada admin di database?
        if ($request->role === 'admin') {
            $adminExists = User::where('role', 'admin')->exists();
            if ($adminExists) {
                return back()->with('error', 'Gagal! Sistem didesain hanya untuk memiliki 1 Administrator Utama.');
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,operator',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Akun operator baru berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        // 2. Cek paksa saat update: Jangan biarkan operator diubah menjadi admin kedua
        if ($request->role === 'admin' && $user->role !== 'admin') {
            $adminExists = User::where('role', 'admin')->exists();
            if ($adminExists) {
                return back()->with('error', 'Gagal! Tidak dapat mengubah pengguna menjadi Admin karena kuota posisi Admin sudah penuh (Maksimal 1).');
            }
        }

        // 3. Mencegah satu-satunya admin mengubah dirinya sendiri menjadi operator (bisa mengunci sistem)
        if ($user->role === 'admin' && $request->role === 'operator') {
            return back()->with('error', 'Gagal! Anda adalah satu-satunya Admin. Anda tidak boleh menurunkan pangkat Anda sendiri menjadi Operator.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,operator',
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        return redirect()->route('admin.users.index')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}