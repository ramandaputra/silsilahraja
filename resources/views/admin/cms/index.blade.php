<x-app-layout>
    <div class="container py-4">
        <h2 class="fw-bold text-dark mb-1">Pengaturan Teks Beranda (CMS)</h2>
        <p class="text-muted mb-4">Ubah isi konten teks halaman depan web silsilah Anda tanpa perlu menyentuh kode program.</p>

        @if(session('success'))
            <div class="alert alert-success shadow-sm mb-4">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <form action="{{ route('admin.cms.update') }}" method="POST">
                    @csrf

                    <h5 class="fw-bold text-secondary border-b pb-2 mb-3">1. Bagian Banner Atas (Hero Section)</h5>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Utama Web (Gunakan \n untuk baris baru)</label>
                        <textarea name="hero_title" class="form-control" rows="2">{{ \App\Models\Setting::get('hero_title', "Temukan Akar & \n Warisan Agung Keluarga Raja") }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Sub-Judul (Deskripsi Singkat)</label>
                        <input type="text" name="hero_subtitle" class="form-control" value="{{ \App\Models\Setting::get('hero_subtitle', 'Arsip digital silsilah keturunan ningrat yang aman, terstruktur, dan terverifikasi.') }}">
                    </div>

                    <h5 class="fw-bold text-secondary border-b pb-2 mb-3 mt-4">2. Bagian Teks Sejarah</h5>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Judul Sejarah</label>
                        <input type="text" name="history_title" class="form-control" value="{{ \App\Models\Setting::get('history_title', 'Sejarah & Warisan Agung Keluarga Raja') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Isi Paragraf Sejarah</label>
                        <textarea name="history_body_1" class="form-control" rows="5">{{ \App\Models\Setting::get('history_body_1', 'Perjalanan sejarah keluarga raja bukan sekadar silsilah nama, melainkan sebuah narasi agung tentang kepemimpinan, pengabdian, dan identitas budaya nusantara.') }}</textarea>
                    </div>

                    <div class="text-end border-top pt-3 mt-4">
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Perubahan Teks</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>