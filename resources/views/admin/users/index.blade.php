<x-app-layout>
    @slot('page-title') Kelola Akun Pengguna @endslot

    <div class="space-y-4 sm:space-y-6">
        
        <!-- Tombol Kembali -->
        <div class="mb-1">
            <a href="{{ route('admin.dashboard') }}" class="group inline-flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-bold text-white bg-primary hover:bg-secondary shadow-xs active:scale-95 transition-all">
                <span class="w-5 h-5 rounded-md bg-white/15 flex items-center justify-center text-white group-hover:-translate-x-0.5 transition-transform">
                    <span class="material-symbols-outlined text-[14px]">arrow_back</span>
                </span>
                <span>Kembali ke Dashboard</span>
            </a>
        </div>
        
        <!-- Status Notifikasi -->
        @if(session('success'))
            <div class="bg-emerald-50 text-emerald-800 border border-emerald-200 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm text-xs sm:text-sm">
                <span class="material-symbols-outlined text-emerald-600 shrink-0">check_circle</span>
                <span class="font-semibold">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="bg-rose-50 text-rose-800 border border-rose-200 px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm text-xs sm:text-sm">
                <span class="material-symbols-outlined text-rose-600 shrink-0">error</span>
                <span class="font-semibold">{{ session('error') }}</span>
            </div>
        @endif

        <!-- Header Ringkasan & Tambah Akun -->
        <div class="bento-card p-4 sm:p-6 md:p-8 bg-gradient-to-r from-surface-container-lowest to-surface-container-low flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4 border-l-4 border-primary">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl sm:text-2xl">manage_accounts</span>
                    <h2 class="font-headline-md text-lg sm:text-xl font-black text-primary">Kelola Akun Pengguna</h2>
                </div>
                <p class="font-body-md text-xs sm:text-sm text-on-surface-variant max-w-2xl leading-relaxed">
                    Manajemen hak akses pengguna dan administrator sistem (Superadmin & Admin).
                </p>
            </div>
            <button onclick="toggleModal('addModal')" class="px-4 py-2.5 bg-primary text-white hover:bg-secondary active:scale-95 rounded-xl font-label-md text-xs font-bold flex items-center justify-center gap-2 transition-all shadow-sm shrink-0">
                <span class="material-symbols-outlined text-[18px]">person_add</span> Tambah Akun Baru
            </button>
        </div>

        <!-- Bento Layout: Daftar Pengguna -->
        <div class="bento-card overflow-hidden">
            <div class="p-3.5 sm:p-4 border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
                <h3 class="font-title-lg text-xs sm:text-sm font-bold text-primary flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-gray-500 text-[18px]">group</span> Total Terdaftar ({{ $users->total() }})
                </h3>
            </div>

            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-left border-collapse min-w-[560px]">
                    <thead>
                        <tr class="bg-surface-container-lowest text-on-surface-variant text-[11px] font-bold uppercase tracking-wider border-b border-outline-variant/40">
                            <th class="py-3 px-4 sm:px-6">Nama Pengguna</th>
                            <th class="py-3 px-4 sm:px-6">Email</th>
                            <th class="py-3 px-4 sm:px-6">Hak Akses / Role</th>
                            <th class="py-3 px-4 sm:px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/30 text-xs text-on-surface font-body-md">
                        @foreach($users as $user)
                        <tr class="hover:bg-surface-container-lowest/80 transition-colors">
                            <td class="py-3.5 px-4 sm:px-6 font-bold text-primary">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-primary-container text-on-primary-container flex items-center justify-center font-bold text-xs shrink-0">
                                        {{ Str::substr($user->name, 0, 1) }}
                                    </div>
                                    <span>{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 text-on-surface-variant font-medium">{{ $user->email }}</td>
                            <td class="py-3.5 px-4 sm:px-6">
                                <span class="px-2.5 py-0.5 text-[10px] sm:text-xs font-semibold rounded-full uppercase tracking-wide
                                    {{ $user->role === 'superadmin' ? 'bg-amber-50 text-amber-700 border border-amber-200' : 'bg-blue-50 text-blue-700 border border-blue-200' }}">
                                    {{ $user->role === 'superadmin' ? 'Superadmin' : 'Admin' }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 sm:px-6 whitespace-nowrap">
                                <div class="flex justify-center items-center gap-3">
                                    <button onclick="openEditModal({{ json_encode($user) }})" class="text-blue-600 hover:text-blue-800 font-semibold inline-flex items-center gap-1 p-1">
                                        <span class="material-symbols-outlined text-[16px]">edit</span> Edit
                                    </button>
                                    @if(auth()->id() !== $user->id)
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?')" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold inline-flex items-center gap-1 p-1">
                                            <span class="material-symbols-outlined text-[16px]">delete</span> Hapus
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
            @if($users->hasPages())
            <div class="p-3.5 sm:p-4 border-t border-outline-variant/40 bg-surface-container-low">
                {{ $users->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- MODAL: TAMBAH USER -->
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm p-3 sm:p-4 overflow-y-auto flex items-center justify-center">
        <div class="bg-white rounded-xl max-w-md w-full shadow-2xl overflow-hidden border border-gray-100 my-auto max-h-[92vh] flex flex-col">
            <div class="px-4 sm:px-6 py-3.5 bg-gray-50 border-b border-gray-100 flex justify-between items-center shrink-0">
                <h3 class="font-bold text-gray-800 flex items-center gap-2 text-sm sm:text-base">
                    <span class="material-symbols-outlined text-primary text-[20px]">person_add</span>
                    Registrasi Akun Baru
                </h3>
                <button onclick="toggleModal('addModal')" class="material-symbols-outlined text-gray-400 hover:text-gray-600 p-1">close</button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST" class="p-4 sm:p-6 space-y-3.5 overflow-y-auto">
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
                        <option value="admin">Admin (Pengelola Data & Pengaturan)</option>
                        <option value="superadmin">Superadmin (Akses Penuh & Kelola Pengguna)</option>
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
                <div class="pt-2 flex flex-col-reverse sm:flex-row justify-end gap-2">
                    <button type="button" onclick="toggleModal('addModal')" class="px-4 py-2 border rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 text-center">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:opacity-90 text-center">Simpan Akun</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT USER -->
    <div id="editModal" class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm p-3 sm:p-4 overflow-y-auto flex items-center justify-center">
        <div class="bg-white rounded-xl max-w-md w-full shadow-2xl overflow-hidden border border-gray-100 my-auto max-h-[92vh] flex flex-col">
            <div class="px-4 sm:px-6 py-3.5 bg-gray-50 border-b border-gray-100 flex justify-between items-center shrink-0">
                <h3 class="font-bold text-gray-800 flex items-center gap-2 text-sm sm:text-base">
                    <span class="material-symbols-outlined text-secondary text-[20px]">edit</span>
                    Modifikasi Akun Pengguna
                </h3>
                <button onclick="toggleModal('editModal')" class="material-symbols-outlined text-gray-400 hover:text-gray-600 p-1">close</button>
            </div>
            <form id="editForm" method="POST" class="p-4 sm:p-6 space-y-3.5 overflow-y-auto">
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
                        <option value="admin">Admin (Pengelola Data & Pengaturan)</option>
                        <option value="superadmin">Superadmin (Akses Penuh & Kelola Pengguna)</option>
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
                <div class="pt-2 flex flex-col-reverse sm:flex-row justify-end gap-2">
                    <button type="button" onclick="toggleModal('editModal')" class="px-4 py-2 border rounded-lg text-sm font-medium text-gray-600 hover:bg-gray-50 text-center">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg text-sm font-medium hover:opacity-90 text-center">Perbarui Akun</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function openEditModal(user) {
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_role').value = user.role || 'admin';
            
            // Set action form secara dinamis ke route update
            document.getElementById('editForm').action = `/admin/users/${user.id}`;
            toggleModal('editModal');
        }
    </script>
</x-app-layout>
