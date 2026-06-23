<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman satu atap untuk seluruh pengaturan situs.
     * Menggabungkan data untuk halaman Beranda, Tentang Kami, dan Tim Ahli.
     */
    public function index()
    {
        $settings = [
            // Konten Halaman Beranda
            'site_title'             => Setting::get('site_title', 'Silsilah Keluarga - Pusat Data Genealogi Digital'),
            'hero_title'             => Setting::get('hero_title', "Temukan Akar & \n Warisan Agung Keluarga Raja"),
            'hero_subtitle'          => Setting::get('hero_subtitle', 'Arsip digital silsilah keturunan Kesultanan Riau-Lingga yang aman, terstruktur, dan terverifikasi.'),
            'hero_background'        => Setting::get('hero_background'),

            // Konten Halaman Tentang Kami (about.blade.php)
            'about_hero_description' => Setting::get('about_hero_description', 'Mendedikasikan teknologi untuk melestarikan memori kolektif bangsa melalui dokumentasi silsilah keluarga yang akurat, sistematis, dan terintegrasi secara digital. Kami percaya bahwa memahami akar adalah langkah awal membangun masa depan.'),
            'about_history_title'    => Setting::get('about_history_title', 'Dedikasi terhadap Integritas Genealogi'),
            'about_history_body_1'   => Setting::get('about_history_body_1', 'Berawal dari sebuah inisiatif penelitian sejarah lisan di lingkungan akademis, proyek Silsilah Keluarga tumbuh menjadi sebuah platform institusional yang mengedepankan akurasi data. Kami menyadari bahwa sejarah keluarga bukan sekadar daftar nama, melainkan warisan budaya yang membutuhkan sistem penyimpanan yang aman dan terstruktur.'),
            'about_history_body_2'   => Setting::get('about_history_body_2', 'Melalui metodologi yang diadaptasi dari standar arsip nasional, setiap fitur dalam aplikasi ini dirancang untuk meminimalisir redundansi data dan memastikan hubungan antar-generasi tercatat secara logis. Fokus kami adalah memberikan kemudahan bagi setiap keluarga Indonesia untuk membangun repositori sejarah mereka sendiri dengan standar profesional.'),

            // DATA TIM BARU: Anggota Tim 1
            'team_name_1'            => Setting::get('team_name_1', 'Dr. Handoko Wiratama'),
            'team_role_1'            => Setting::get('team_role_1', 'Ketua Arsiparis'),
            'team_desc_1'            => Setting::get('team_desc_1', 'Pakar dokumentasi sejarah dengan pengalaman lebih dari 15 tahun di lembaga kearsipan nasional.'),

            // DATA TIM BARU: Anggota Tim 2
            'team_name_2'            => Setting::get('team_name_2', 'Siti Aminah, M.Kom'),
            'team_role_2'            => Setting::get('team_role_2', 'Pengembang Sistem'),
            'team_desc_2'            => Setting::get('team_desc_2', 'Arsitek sistem informasi yang fokus pada integritas data dan keamanan basis data digital terdistribusi.'),

            // DATA TIM BARU: Anggota Tim 3
            'team_name_3'            => Setting::get('team_name_3', 'Prof. Baskoro Jati'),
            'team_role_3'            => Setting::get('team_role_3', 'Peneliti Sejarah'),
            'team_desc_3'            => Setting::get('team_desc_3', 'Konsultan utama untuk validasi metodologi penelusuran garis keturunan dan konteks sejarah lokal.'),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Memproses pembaruan data massal menggunakan updateOrCreate standar Laravel Eloquent.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_title'              => 'required|string|max:255',
            'hero_title'              => 'required|string',
            'hero_subtitle'           => 'required|string',
            'about_hero_description'  => 'required|string',
            'about_history_title'     => 'required|string|max:255',
            'about_history_body_1'    => 'required|string',
            'about_history_body_2'    => 'required|string',
            'hero_background'         => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',

            // Validasi Form Tim
            'team_name_1'             => 'required|string|max:255',
            'team_role_1'             => 'required|string|max:255',
            'team_desc_1'             => 'required|string',
            'team_name_2'             => 'required|string|max:255',
            'team_role_2'             => 'required|string|max:255',
            'team_desc_2'             => 'required|string',
            'team_name_3'             => 'required|string|max:255',
            'team_role_3'             => 'required|string|max:255',
            'team_desc_3'             => 'required|string',
        ]);

        // Ambil semua input teks kecuali file background
        $inputs = $request->except('hero_background');

        // Lakukan perulangan untuk menyimpan setiap key menggunakan updateOrCreate standar Laravel
        foreach ($inputs as $key => $value) {
            // Abaikan token CSRF dan Method PUT bawaan form HTML
            if (in_array($key, ['_token', '_method'])) {
                continue;
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        // Manajemen Berkas Gambar Latar Belakang Beranda
        if ($request->hasFile('hero_background')) {
            // Ambil data lama
            $oldSetting = Setting::where('key', 'hero_background')->first();
            
            if ($oldSetting && $oldSetting->value && Storage::disk('public')->exists($oldSetting->value)) {
                Storage::disk('public')->delete($oldSetting->value);
            }
            
            $path = $request->file('hero_background')->store('settings', 'public');
            
            Setting::updateOrCreate(
                ['key' => 'hero_background'],
                ['value' => $path]
            );
        }

        return redirect()->back()->with('success', 'Seluruh pengaturan aplikasi dan tim ahli berhasil diperbarui!');
    }
}