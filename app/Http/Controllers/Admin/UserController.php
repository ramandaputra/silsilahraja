<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ActivityLog;
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
        // 1. Cek paksa: Apakah sudah ada Superadmin di database?
        if ($request->role === 'superadmin') {
            $superadminExists = User::where('role', 'superadmin')->exists();
            if ($superadminExists) {
                return back()->with('error', 'Gagal! Sistem didesain hanya untuk memiliki 1 Superadmin.');
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:superadmin,admin',
        ]);

        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        ActivityLog::record('CREATE', 'Manajemen Pengguna', "Menambahkan akun pengguna baru: {$newUser->name} ({$newUser->email}) sebagai {$newUser->role}");

        return redirect()->route('admin.users.index')->with('success', 'Akun baru berhasil ditambahkan.');
    }

    public function update(Request $request, User $user)
    {
        // 2. Cek paksa saat update: Jangan biarkan admin diubah menjadi Superadmin kedua
        if ($request->role === 'superadmin' && $user->role !== 'superadmin') {
            $superadminExists = User::where('role', 'superadmin')->exists();
            if ($superadminExists) {
                return back()->with('error', 'Gagal! Tidak dapat mengubah pengguna menjadi Superadmin karena kuota posisi Superadmin sudah penuh (Maksimal 1).');
            }
        }

        // 3. Mencegah satu-satunya superadmin mengubah dirinya sendiri menjadi admin
        if ($user->role === 'superadmin' && $request->role === 'admin') {
            return back()->with('error', 'Gagal! Anda adalah satu-satunya Superadmin. Anda tidak boleh menurunkan peran Anda sendiri menjadi Admin.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:superadmin,admin',
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

        ActivityLog::record('UPDATE', 'Manajemen Pengguna', "Memperbarui data akun pengguna: {$user->name} ({$user->email})");

        return redirect()->route('admin.users.index')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri yang sedang aktif.');
        }

        if ($user->role === 'superadmin') {
            return back()->with('error', 'Gagal! Akun Superadmin tidak dapat dihapus.');
        }

        $deletedName = $user->name;
        $deletedEmail = $user->email;
        $user->delete();

        ActivityLog::record('DELETE', 'Manajemen Pengguna', "Menghapus akun pengguna: {$deletedName} ({$deletedEmail})");

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}