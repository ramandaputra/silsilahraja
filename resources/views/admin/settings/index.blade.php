<x-app-layout>
    @slot('page-title') Pengaturan Aplikasi @endslot

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

        <!-- Header Ringkasan & Konfigurasi -->
        <div class="bento-card p-4 sm:p-6 md:p-8 bg-gradient-to-r from-surface-container-lowest to-surface-container-low flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 sm:gap-4 border-l-4 border-primary">
            <div class="space-y-1">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-xl sm:text-2xl">settings</span>
                    <h2 class="font-headline-md text-lg sm:text-xl font-black text-primary">Pengaturan Aplikasi & Konten</h2>
                </div>
                <p class="font-body-md text-xs sm:text-sm text-on-surface-variant max-w-2xl leading-relaxed">
                    Kelola konfigurasi teks halaman beranda, profil sejarah tentang kami, serta manajemen susunan slot tim pengembang dan tim ahli secara terpusat.
                </p>
            </div>
        </div>

        @if(session('success'))
        <div class="p-4 bg-white border-2 border-emerald-500 rounded-xl flex items-center gap-3 shadow-md text-xs sm:text-sm font-semibold text-on-background">
            <span class="material-symbols-outlined text-emerald-600 text-xl shrink-0">check_circle</span>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        @if($errors->any())
        <div class="p-4 bg-white border-2 border-red-500 rounded-xl space-y-2 shadow-md text-xs sm:text-sm font-semibold text-red-600">
            <div class="flex items-center gap-2"><span class="material-symbols-outlined">error</span> Terjadi Kesalahan Validasi:</div>
            <ul class="list-disc pl-5 font-normal text-xs text-on-surface-variant">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4 sm:space-y-6">
            @csrf
            @method('PUT')

            <div class="space-y-3 sm:space-y-4">
                <div class="flex items-center gap-2 px-1">
                    <span class="material-symbols-outlined text-secondary font-bold">home</span>
                    <h2 class="font-headline-md text-sm sm:text-base font-bold text-primary uppercase tracking-wider">Konten Halaman Beranda</h2>
                </div>

                <div class="bento-card p-4 sm:p-6 rounded-xl space-y-3 bg-white border border-outline-variant/60">
                    <h3 class="text-base sm:text-lg font-bold text-primary border-b border-outline-variant/60 pb-2 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-secondary">language</span> Pengaturan Umum
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Judul Situs (Meta Title)</label>
                        <input type="text" name="site_title" value="{{ old('site_title', $settings['site_title'] ?? '') }}" class="w-full border border-outline-variant text-on-surface rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    </div>
                </div>

                <div class="bento-card p-4 sm:p-6 rounded-xl space-y-3.5 bg-white border border-outline-variant/60">
                    <h3 class="text-base sm:text-lg font-bold text-primary border-b border-outline-variant/60 pb-2 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-secondary">view_frontpage</span> Hero Banner Beranda
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Judul Utama Hero</label>
                        <textarea name="hero_title" rows="2" class="w-full border border-outline-variant text-on-surface rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('hero_title', $settings['hero_title'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Subjudul Hero</label>
                        <textarea name="hero_subtitle" rows="3" class="w-full border border-outline-variant text-on-surface rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Gambar Latar Belakang Beranda</label>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center p-3 sm:p-4 bg-surface-container-low border border-outline-variant rounded-xl">
                            <div class="sm:col-span-4">
                                @if(!empty($settings['hero_background']))
                                    <img src="{{ asset('storage/' . $settings['hero_background']) }}" class="w-full h-24 object-cover rounded-xl border border-outline-variant shadow-sm">
                                @else
                                    <div class="w-full h-24 bg-primary rounded-xl flex flex-col items-center justify-center text-white/40 text-[10px] px-2 text-center">
                                        <span class="material-symbols-outlined text-lg mb-1">landscape</span> Gradient Asli
                                    </div>
                                @endif
                            </div>
                            <div class="sm:col-span-8 space-y-2">
                                <input type="file" name="hero_background" accept="image/*" class="w-full text-xs text-on-surface-variant file:mr-3 file:py-2 file:px-3 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-secondary file:text-white hover:file:bg-primary file:cursor-pointer transition-all">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-3 sm:space-y-4 pt-4 border-t border-outline-variant/40">
                <div class="flex items-center gap-2 px-1">
                    <span class="material-symbols-outlined text-secondary font-bold">info</span>
                    <h2 class="font-headline-md text-sm sm:text-base font-bold text-primary uppercase tracking-wider">Konten Teks Halaman Tentang Kami</h2>
                </div>

                <div class="bento-card p-4 sm:p-6 rounded-xl space-y-3 bg-white border border-outline-variant/60">
                    <h3 class="text-base sm:text-lg font-bold text-primary border-b border-outline-variant/60 pb-2 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-secondary">person_book</span> Teks Banner Profil Penyusun
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Deskripsi Sub-Hero (Di bawah tulisan "Profil Penyusun")</label>
                        <textarea name="about_hero_description" rows="3" class="w-full border border-outline-variant text-on-surface rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('about_hero_description', $settings['about_hero_description'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="bento-card p-4 sm:p-6 rounded-xl space-y-3 bg-white border border-outline-variant/60">
                    <h3 class="text-base sm:text-lg font-bold text-primary border-b border-outline-variant/60 pb-2 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-secondary">history_edu</span> Teks Blok Dedikasi & Integritas
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Judul Sejarah/Dedikasi</label>
                        <input type="text" name="about_history_title" value="{{ old('about_history_title', $settings['about_history_title'] ?? '') }}" class="w-full border border-outline-variant text-on-surface rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Paragraf Sejarah 1</label>
                        <textarea name="about_history_body_1" rows="3" class="w-full border border-outline-variant text-on-surface rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('about_history_body_1', $settings['about_history_body_1'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Paragraf Sejarah 2</label>
                        <textarea name="about_history_body_2" rows="3" class="w-full border border-outline-variant text-on-surface rounded-xl px-3 sm:px-4 py-2.5 sm:py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('about_history_body_2', $settings['about_history_body_2'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="w-full sm:w-auto px-6 py-3 bg-primary text-white font-bold text-xs sm:text-sm rounded-xl shadow-md hover:bg-secondary active:scale-95 transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">save</span> Simpan Konfigurasi Teks
                </button>
            </div>
        </form>

        <div class="space-y-4 pt-6 border-t border-outline-variant/40">
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 px-1">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary font-bold">badge</span>
                    <h2 class="font-headline-md text-sm sm:text-base font-bold text-primary uppercase tracking-wider">Daftar Slot Anggota Tim</h2>
                </div>
                <button onclick="document.getElementById('modal-tambah-tim').classList.remove('hidden')" class="px-4 py-2 bg-primary text-white text-xs font-bold rounded-lg hover:bg-secondary active:scale-95 transition-all flex items-center justify-center gap-1.5 shadow-xs">
                    <span class="material-symbols-outlined text-[16px]">add</span> Tambah Anggota Baru
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5 sm:gap-4">
                @forelse($teams as $member)
                <div class="bento-card p-3.5 sm:p-4 rounded-xl bg-white border border-outline-variant/60 flex gap-3 sm:gap-4 items-start">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full overflow-hidden shrink-0 border border-outline-variant bg-gray-100 flex items-center justify-center">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-gray-400 text-2xl">person</span>
                        @endif
                    </div>
                    <div class="space-y-1 flex-1 min-w-0">
                        <div class="flex items-center justify-between gap-1">
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider {{ $member->category === 'developer' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $member->category === 'developer' ? 'Pengembang' : 'Tim Ahli' }}
                            </span>
                            <div class="flex items-center gap-1">
                                <button onclick="bukaModalEdit({{ json_encode($member) }})" class="p-1 text-gray-500 hover:text-secondary rounded" title="Edit Anggota"><span class="material-symbols-outlined text-[18px]">edit</span></button>
                                <form action="{{ route('admin.settings.team.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slot personil ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1 text-red-500 hover:text-red-700 rounded flex items-center" title="Hapus Anggota"><span class="material-symbols-outlined text-[18px]">delete</span></button>
                                </form>
                            </div>
                        </div>
                        <h4 class="text-sm font-bold text-primary truncate">{{ $member->name }}</h4>
                        <p class="text-xs font-semibold text-secondary truncate">{{ $member->role }}</p>
                        <p class="text-[11px] text-on-surface-variant line-clamp-2">{{ $member->description }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-8 bg-surface-container-low rounded-xl border border-dashed text-gray-400 text-xs">
                    Belum ada slot tim ahli maupun pengembang yang ditambahkan.
                </div>
                @endforelse
            </div>
        </div>

    </div>

    <!-- MODAL: TAMBAH TIM -->
    <div id="modal-tambah-tim" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
        <div class="bg-white rounded-xl p-4 sm:p-6 w-full max-w-md space-y-4 shadow-xl my-auto max-h-[92vh] flex flex-col">
            <div class="flex items-center justify-between border-b pb-2 shrink-0">
                <h3 class="font-bold text-primary text-sm sm:text-base flex items-center gap-1.5"><span class="material-symbols-outlined text-[20px]">person_add</span> Tambah Slot Anggota</h3>
                <button onclick="document.getElementById('modal-tambah-tim').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1"><span class="material-symbols-outlined text-[20px]">close</span></button>
            </div>
            <form action="{{ route('admin.settings.team.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3 overflow-y-auto">
                @csrf
                <div class="space-y-3">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Kategori</label>
                        <select name="category" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none">
                            <option value="ahli">Tim Ahli & Penyusun</option>
                            <option value="developer">Tim Pengembang Teknologi</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Jabatan / Tugas</label>
                        <input type="text" name="role" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none" placeholder="cth: Lead Developer / Arsiparis">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Deskripsi Ringkas</label>
                        <textarea name="description" rows="3" class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none"></textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Foto Profil</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-gray-500">
                    </div>
                </div>
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 pt-2 border-t">
                    <button type="button" onclick="document.getElementById('modal-tambah-tim').classList.add('hidden')" class="px-3 py-2 border rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 text-center">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white text-xs font-bold rounded-lg hover:bg-secondary text-center">Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDIT TIM -->
    <div id="modal-edit-tim" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-3 sm:p-4 overflow-y-auto">
        <div class="bg-white rounded-xl p-4 sm:p-6 w-full max-w-md space-y-4 shadow-xl my-auto max-h-[92vh] flex flex-col">
            <div class="flex items-center justify-between border-b pb-2 shrink-0">
                <h3 class="font-bold text-primary text-sm sm:text-base flex items-center gap-1.5"><span class="material-symbols-outlined text-[20px]">edit_square</span> Edit Data Personil</h3>
                <button onclick="document.getElementById('modal-edit-tim').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 p-1"><span class="material-symbols-outlined text-[20px]">close</span></button>
            </div>
            <form id="form-edit-tim" action="" method="POST" enctype="multipart/form-data" class="space-y-3 overflow-y-auto">
                @csrf
                @method('PUT')
                <div class="space-y-3">
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Kategori</label>
                        <select id="edit-category" name="category" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none">
                            <option value="ahli">Tim Ahli & Penyusun</option>
                            <option value="developer">Tim Pengembang Teknologi</option>
                        </select>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Nama Lengkap & Gelar</label>
                        <input type="text" id="edit-name" name="name" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Jabatan / Tugas</label>
                        <input type="text" id="edit-role" name="role" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Deskripsi Ringkas</label>
                        <textarea id="edit-description" name="description" rows="3" class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none"></textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Ganti Foto Profil <span class="text-[10px] text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-gray-500">
                    </div>
                </div>
                <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 pt-2 border-t">
                    <button type="button" onclick="document.getElementById('modal-edit-tim').classList.add('hidden')" class="px-3 py-2 border rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50 text-center">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white text-xs font-bold rounded-lg hover:bg-secondary shadow-xs text-center">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function bukaModalEdit(data) {
            // Pasang action URL rute update secara dinamis sesuai id data
            const form = document.getElementById('form-edit-tim');
            form.action = `/admin/settings/team/${data.id}`;

            // Isi nilai input modal edit berdasarkan data yang di-klik
            document.getElementById('edit-category').value = data.category;
            document.getElementById('edit-name').value = data.name;
            document.getElementById('edit-role').value = data.role;
            document.getElementById('edit-description').value = data.description ?? '';

            // Tampilkan modal edit ke layar
            document.getElementById('modal-edit-tim').classList.remove('hidden');
        }
    </script>
</x-app-layout>