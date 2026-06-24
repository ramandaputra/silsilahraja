<x-app-layout>
    @section('page-title', 'Pengaturan Situs')

    <div class="max-w-4xl mx-auto space-y-lg pb-xl">
        
        <div class="flex items-center justify-between border-b border-outline-variant/60 pb-sm">
            <p class="text-on-surface-variant text-sm md:text-base">Kelola konten dinamis untuk Halaman Utama, Halaman Profil Penyusun, dan Tim Pengembang secara terpusat.</p>
        </div>

        @if(session('success'))
        <div class="p-5 bg-white border-2 border-emerald-500 rounded-xl flex items-center gap-md shadow-md text-sm font-semibold text-on-background">
            <span class="material-symbols-outlined text-emerald-600 text-2xl shrink-0">check_circle</span>
            <div>{{ session('success') }}</div>
        </div>
        @endif

        @if($errors->any())
        <div class="p-5 bg-white border-2 border-red-500 rounded-xl space-y-2 shadow-md text-sm font-semibold text-red-600">
            <div class="flex items-center gap-2"><span class="material-symbols-outlined">error</span> Terjadi Kesalahan Validasi:</div>
            <ul class="list-disc pl-5 font-normal text-xs text-on-surface-variant">
                @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-lg">
            @csrf
            @method('PUT')

            <div class="space-y-md">
                <div class="flex items-center gap-xs px-xs">
                    <span class="material-symbols-outlined text-secondary font-bold">home</span>
                    <h2 class="font-headline-md text-base font-bold text-primary uppercase tracking-wider">Konten Halaman Beranda</h2>
                </div>

                <div class="bento-card p-6 rounded-xl space-y-4 bg-white border border-outline-variant/60">
                    <h3 class="text-lg font-bold text-primary border-b border-outline-variant/60 pb-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-secondary">language</span> Pengaturan Umum
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Judul Situs (Meta Title)</label>
                        <input type="text" name="site_title" value="{{ old('site_title', $settings['site_title'] ?? '') }}" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    </div>
                </div>

                <div class="bento-card p-6 rounded-xl space-y-4 bg-white border border-outline-variant/60">
                    <h3 class="text-lg font-bold text-primary border-b border-outline-variant/60 pb-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-secondary">view_frontpage</span> Hero Banner Beranda
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Judul Utama Hero</label>
                        <textarea name="hero_title" rows="2" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('hero_title', $settings['hero_title'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Subjudul Hero</label>
                        <textarea name="hero_subtitle" rows="3" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('hero_subtitle', $settings['hero_subtitle'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Gambar Latar Belakang Beranda</label>
                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-sm items-center p-4 bg-surface-container-low border border-outline-variant rounded-xl">
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
                                <input type="file" name="hero_background" accept="image/*" class="w-full text-xs text-on-surface-variant file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-secondary file:text-white hover:file:bg-primary file:cursor-pointer transition-all">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="space-y-md pt-md border-t border-outline-variant/40">
                <div class="flex items-center gap-xs px-xs">
                    <span class="material-symbols-outlined text-secondary font-bold">info</span>
                    <h2 class="font-headline-md text-base font-bold text-primary uppercase tracking-wider">Konten Teks Halaman Tentang Kami</h2>
                </div>

                <div class="bento-card p-6 rounded-xl space-y-4 bg-white border border-outline-variant/60">
                    <h3 class="text-lg font-bold text-primary border-b border-outline-variant/60 pb-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-secondary">person_book</span> Teks Banner Profil Penyusun
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Deskripsi Sub-Hero (Di bawah tulisan "Profil Penyusun")</label>
                        <textarea name="about_hero_description" rows="3" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('about_hero_description', $settings['about_hero_description'] ?? '') }}</textarea>
                    </div>
                </div>

                <div class="bento-card p-6 rounded-xl space-y-4 bg-white border border-outline-variant/60">
                    <h3 class="text-lg font-bold text-primary border-b border-outline-variant/60 pb-xs flex items-center gap-1">
                        <span class="material-symbols-outlined text-secondary">history_edu</span> Teks Blok Dedikasi & Integritas
                    </h3>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Judul Sejarah/Dedikasi</label>
                        <input type="text" name="about_history_title" value="{{ old('about_history_title', $settings['about_history_title'] ?? '') }}" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Paragraf Sejarah 1</label>
                        <textarea name="about_history_body_1" rows="3" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('about_history_body_1', $settings['about_history_body_1'] ?? '') }}</textarea>
                    </div>
                    <div class="space-y-1">
                        <label class="block text-xs font-bold uppercase tracking-wider text-on-surface-variant">Paragraf Sejarah 2</label>
                        <textarea name="about_history_body_2" rows="3" class="w-full border border-outline-variant text-on-surface rounded-xl px-4 py-3 text-sm focus:ring-4 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">{{ old('about_history_body_2', $settings['about_history_body_2'] ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-3 bg-primary text-white font-bold text-sm rounded-xl shadow-md hover:bg-primary/90 transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">save</span> Simpan Konfigurasi Teks
                </button>
            </div>
        </form>

        <div class="space-y-md pt-lg border-t border-outline-variant/40">
            <div class="flex items-center justify-between px-xs">
                <div class="flex items-center gap-xs">
                    <span class="material-symbols-outlined text-secondary font-bold">badge</span>
                    <h2 class="font-headline-md text-base font-bold text-primary uppercase tracking-wider">Daftar Slot Anggota Tim</h2>
                </div>
                <button onclick="document.getElementById('modal-tambah-tim').classList.remove('hidden')" class="px-4 py-2 bg-secondary text-white text-xs font-bold rounded-lg hover:bg-secondary/90 transition-all flex items-center gap-1">
                    <span class="material-symbols-outlined text-xs">add</span> Tambah Anggota Baru
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-md">
                @forelse($teams as $member)
                <div class="bento-card p-4 rounded-xl bg-white border border-outline-variant/60 flex gap-md items-start">
                    <div class="w-16 h-16 rounded-full overflow-hidden shrink-0 border border-outline-variant bg-gray-100 flex items-center justify-center">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" class="w-full h-full object-cover">
                        @else
                            <span class="material-symbols-outlined text-gray-400 text-2xl">person</span>
                        @endif
                    </div>
                    <div class="space-y-1 flex-1">
                        <div class="flex items-center justify-between">
                            <span class="text-[10px] px-2 py-0.5 rounded-full font-bold uppercase tracking-wider {{ $member->category === 'developer' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                {{ $member->category === 'developer' ? 'Pengembang' : 'Tim Ahli' }}
                            </span>
                            <div class="flex items-center gap-1">
                                <button onclick="bukaModalEdit({{ json_encode($member) }})" class="text-gray-500 hover:text-secondary"><span class="material-symbols-outlined text-lg">edit</span></button>
                                <form action="{{ route('admin.settings.team.destroy', $member->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus slot personil ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 flex items-center"><span class="material-symbols-outlined text-lg">delete</span></button>
                                </form>
                            </div>
                        </div>
                        <h4 class="text-sm font-bold text-primary">{{ $member->name }}</h4>
                        <p class="text-xs font-semibold text-secondary">{{ $member->role }}</p>
                        <p class="text-[11px] text-on-surface-variant line-clamp-2">{{ $member->description }}</p>
                    </div>
                </div>
                @empty
                <div class="col-span-full text-center py-6 bg-surface-container-low rounded-xl border border-dashed text-gray-400 text-xs">
                    Belum ada slot tim ahli maupun pengembang yang ditambahkan.
                </div>
                @endforelse
            </div>
        </div>

    </div>

    <div id="modal-tambah-tim" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4 animate-fade-in">
        <div class="bg-white rounded-xl p-6 w-full max-w-md space-y-4 shadow-xl">
            <div class="flex items-center justify-between border-b pb-xs">
                <h3 class="font-bold text-primary text-base flex items-center gap-1"><span class="material-symbols-outlined">person_add</span> Tambah Slot Anggota</h3>
                <button onclick="document.getElementById('modal-tambah-tim').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form action="{{ route('admin.settings.team.store') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                <div class="grid grid-cols-2 gap-2">
                    <div class="space-y-1 col-span-2">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Kategori Kategori</label>
                        <select name="category" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none">
                            <option value="ahli">Tim Ahli & Penyusun</option>
                            <option value="developer">Tim Pengembang Teknologi</option>
                        </select>
                    </div>
                    <div class="space-y-1 col-span-2">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Nama Lengkap & Gelar</label>
                        <input type="text" name="name" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none">
                    </div>
                    <div class="space-y-1 col-span-2">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Jabatan / Tugas</label>
                        <input type="text" name="role" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none" placeholder="cth: Lead Developer / Arsiparis">
                    </div>
                    <div class="space-y-1 col-span-2">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Deskripsi Ringkas</label>
                        <textarea name="description" rows="3" class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none"></textarea>
                    </div>
                    <div class="space-y-1 col-span-2">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Foto Profil</label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-gray-500">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-xs border-t">
                    <button type="button" onclick="document.getElementById('modal-tambah-tim').classList.add('hidden')" class="px-3 py-2 border rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-primary text-white text-xs font-bold rounded-lg hover:bg-primary/90">Simpan Anggota</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modal-edit-tim" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl p-6 w-full max-w-md space-y-4 shadow-xl">
            <div class="flex items-center justify-between border-b pb-xs">
                <h3 class="font-bold text-primary text-base flex items-center gap-1"><span class="material-symbols-outlined">edit_square</span> Edit Data Personil</h3>
                <button onclick="document.getElementById('modal-edit-tim').classList.add('hidden')" class="text-gray-400 hover:text-gray-600"><span class="material-symbols-outlined">close</span></button>
            </div>
            <form id="form-edit-tim" action="" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-2">
                    <div class="space-y-1 col-span-2">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Kategori</label>
                        <select id="edit-category" name="category" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none">
                            <option value="ahli">Tim Ahli & Penyusun</option>
                            <option value="developer">Tim Pengembang Teknologi</option>
                        </select>
                    </div>
                    <div class="space-y-1 col-span-2">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Nama Lengkap & Gelar</label>
                        <input type="text" id="edit-name" name="name" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none">
                    </div>
                    <div class="space-y-1 col-span-2">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Jabatan / Tugas</label>
                        <input type="text" id="edit-role" name="role" required class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none">
                    </div>
                    <div class="space-y-1 col-span-2">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Deskripsi Ringkas</label>
                        <textarea id="edit-description" name="description" rows="3" class="w-full border border-outline-variant rounded-lg px-3 py-2 text-xs focus:ring-2 focus:ring-secondary outline-none"></textarea>
                    </div>
                    <div class="space-y-1 col-span-2">
                        <label class="text-[11px] font-bold text-gray-600 uppercase">Ganti Foto Profil <span class="text-[10px] text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                        <input type="file" name="photo" accept="image/*" class="w-full text-xs text-gray-500">
                    </div>
                </div>
                <div class="flex justify-end gap-2 pt-xs border-t">
                    <button type="button" onclick="document.getElementById('modal-edit-tim').classList.add('hidden')" class="px-3 py-2 border rounded-lg text-xs font-bold text-gray-600 hover:bg-gray-50">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-secondary text-white text-xs font-bold rounded-lg hover:bg-secondary/90">Simpan Perubahan</button>
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