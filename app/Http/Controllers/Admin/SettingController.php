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
     * Menggabungkan data untuk halaman Beranda dan Tentang Kami.
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
        ];

        // diarahkan ke view satu halaman terpusat yang baru
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Memproses pembaruan data massal baik untuk Beranda maupun Tentang Kami.
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
        ]);

        // Menyimpan Pengaturan Halaman Beranda
        Setting::set('site_title', $request->site_title);
        Setting::set('hero_title', $request->hero_title);
        Setting::set('hero_subtitle', $request->hero_subtitle);

        // Menyimpan Pengaturan Halaman Tentang Kami (about.blade.php)
        Setting::set('about_hero_description', $request->about_hero_description);
        Setting::set('about_history_title', $request->about_history_title);
        Setting::set('about_history_body_1', $request->about_history_body_1);
        Setting::set('about_history_body_2', $request->about_history_body_2);

        // Manajemen Berkas Gambar Latar Belakang Beranda
        if ($request->hasFile('hero_background')) {
            $oldImage = Setting::get('hero_background');
            
            // Hapus gambar lama jika ada di dalam storage public
            if ($oldImage && Storage::disk('public')->exists($oldImage)) {
                Storage::disk('public')->delete($oldImage);
            }
            
            $path = $request->file('hero_background')->store('settings', 'public');
            Setting::set('hero_background', $path);
        }

        return redirect()->back()->with('success', 'Seluruh pengaturan aplikasi berhasil diperbarui!');
    }
}