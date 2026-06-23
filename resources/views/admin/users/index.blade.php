<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Kelola Akun Pengguna | SilsilahRaja Admin</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700&family=Inter:wght@400;500;600&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .bento-card {
            background: #ffffff;
            border: 1px solid #e1e4e8;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
    </style>
</head>
<body class="bg-[#fbf9f8] text-[#1b1c1c] min-h-screen flex flex-col pt-16">

    <!-- Navbar Admin -->
    <nav class="fixed top-0 w-full z-40 flex justify-between items-center px-10 bg-white shadow-sm border-b border-gray-200 h-20">
        <div class="flex items-center gap-2">
            <span class="material-symbols-outlined text-[#003366] text-3xl">manage_accounts</span>
            <span class="font-semibold text-xl text-[#003366] tracking-tight">SilsilahRaja Console</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm font-medium text-gray-600">Halo, {{ auth()->user()->name }}</span>
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-blue-600">Lihat Situs <i class="fa-solid fa-arrow-up-right-from-square ml-1 text-xs"></i></a>
        </div>
    </nav>

    <main class="flex-grow container mx-auto px-6 py-10">
        
        <!-- Header -->
        <header class="mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-[#001e40] font-['Montserrat']">Kelola Akun Pengguna</h1>
                <p class="text-sm text-gray-500">Manajemen hak akses institusi, operator data silsilah, dan administrator sistem.</p>
            </div>
            <button onclick="toggleModal('addModal')" class="inline-flex items-center gap-2 bg-[#0059bb] text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-[#004493] transition-colors shadow-sm">
                <span class="material-symbols-outlined text-sm">person_add</span>
                Tambah Akun Baru
            </button>
        </header>

        <!-- Status Notifikasi -->
        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-800 border border-emerald-200 p-4 rounded-xl mb-6 flex items-center gap-3 text-sm shadow-sm">
                <span class="material-symbols-outlined text-emerald-600">check_circle</span>
                <div>{{ session('success') }}</div>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 text-rose-800 border border-rose-200 p-4 rounded-xl mb-6 flex items-center gap-3 text-sm shadow-sm">
                <span class="material-symbols-outlined text-rose-600">error</span>
                <div>{{ session('error') }}</div>
            </div>
        @endif

        <!-- Bento Layout: Daftar Pengguna -->
        <div class="bento-card rounded-xl overflow-hidden shadow-sm">
            <div class="p-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="font-semibold text-gray-700 text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-gray-400">group</span> Total Terdaftar ({{ $users->total() }})
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-[11px] font-bold uppercase tracking-wider border-b border-gray-200">
                            <th class="py-3 px-6">Nama Pengguna</th>
                            <th class="py-3 px-6">Email</th>
                            <th class="py-3 px-6">Hak Akses / Role</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                        @foreach($users as $user)
                        <tr class="hover:bg-gray-50/70 transition-colors">
                            <td class="py-4 px-6 font-medium text-gray-900">{{ $user->name }}</td>
                            <td class="py-4 px-6 text-gray-500">{{ $user->email }}</td>
                            <td class="py-4 px-6">
                                <span class="px-2.5 py-1 text-xs font-semibold rounded-full uppercase tracking-wide
                                    {{ $user->role === 'admin' ? 'bg-amber-50 text-amber-700 border border-amber-200' : ($user->role === 'operator' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-gray-100 text-gray-700') }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex justify-center items-center gap-3">
                                    <button onclick="openEditModal({{ json_encode($user) }})" class="text-blue-600 hover:text-blue-800 font-medium inline-flex items-center gap-1">
                                        <span class="material-symbols-outlined text-base">edit</span> Edit
                                    </button>
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-medium inline-flex items-center gap-1">
                                            <span class="material-symbols-outlined text-base">delete</span> Hapus
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="p-4 border-t border-gray-100 bg-gray-50/30">
                {{ $users->links() }}
            </div>
        </div>
    </main>

    <!-- MODAL: TAMBAH USER -->
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full shadow-xl overflow-hidden border border-gray-100 animate-[fadeIn_0.2s_ease-out]">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Registrasi Akun Baru</h3>
                <button onclick="toggleModal('addModal')" class="material-symbols-outlined text-gray-400 hover:text-gray-600">close</button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" required class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Alamat Email</label>
                    <input type="email" name="email" required class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Role / Otoritas</label>
                    <select name="role" class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="viewer">Viewer (Hanya Melihat)</option>
                        <option value="operator">Operator Data (Entri Silsilah)</option>
                        <option value="admin">Administrator Sistem</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Password</label>
                    <input type="password" name="password" required class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('addModal')" class="px-4 py-2 border rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT USER -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/40 backdrop-blur-sm flex justify-center items-center p-4">
        <div class="bg-white rounded-xl max-w-md w-full shadow-xl overflow-hidden border border-gray-100">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-bold text-gray-800">Modifikasi Akun Pengguna</h3>
                <button onclick="toggleModal('editModal')" class="material-symbols-outlined text-gray-400 hover:text-gray-600">close</button>
            </div>
            <form id="editForm" method="POST" class="p-6 space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Nama Lengkap</label>
                    <input type="text" name="name" id="edit_name" required class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Alamat Email</label>
                    <input type="email" name="email" id="edit_email" required class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Role / Otoritas</label>
                    <select name="role" id="edit_role" class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="viewer">Viewer (Hanya Melihat)</option>
                        <option value="operator">Operator Data (Entri Silsilah)</option>
                        <option value="admin">Administrator Sistem</option>
                    </select>
                </div>
                <div class="p-3 bg-amber-50 rounded-lg border border-amber-100 text-xs text-amber-800">
                    Kosongkan kolom password di bawah jika tidak ingin mengganti password lama pengguna.
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Password Baru (Opsional)</label>
                    <input type="password" name="password" class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-600 uppercase mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="pt-2 flex justify-end gap-2">
                    <button type="button" onclick="toggleModal('editModal')" class="px-4 py-2 border rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700">Perbarui Akun</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.toggle('hidden');
        }

        function openEditModal(user) {
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_role').value = user.role || 'viewer';
            
            // Set action form secara dinamis ke route update
            document.getElementById('editForm').action = `/admin/users/${user.id}`;
            toggleModal('editModal');
        }
    </script>
</body>
</html>