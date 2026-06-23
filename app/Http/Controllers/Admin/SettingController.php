<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    /**
     * Menampilkan halaman satu atap untuk seluruh pengaturan situs.
     * Menggabungkan data untuk halaman Beranda, Tentang Kami, dan Daftar Tim Ahli.
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

        // Mengambil seluruh data slot tim ahli dinamis untuk dikelola di halaman yang sama
        $teams = Team::orderBy('order_position', 'asc')->get();

        return view('admin.settings.index', compact('settings', 'teams'));
    }

    /**
     * Memproses pembaruan data konfigurasi teks global situs.
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_title'             => 'required|string|max:255',
            'hero_title'             => 'required|string',
            'hero_subtitle'          => 'required|string',
            'about_hero_description' => 'required|string',
            'about_history_title'    => 'required|string|max:255',
            'about_history_body_1'   => 'required|string',
            'about_history_body_2'   => 'required|string',
            'hero_background'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        // Ambil semua input teks kecuali file background
        $inputs = $request->except('hero_background');

        // Lakukan perulangan untuk menyimpan setiap key konfigurasi teks
        foreach ($inputs as $key => $value) {
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

        return redirect()->back()->with('success', 'Seluruh konfigurasi halaman berhasil diperbarui!');
    }

    /**
     * Menyimpan slot data anggota tim ahli baru beserta unggahan fotonya.
     */
    public function storeTeam(Request $request) 
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'role'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048', // Maksimal berkas 2MB
        ]);

        $data = $request->only(['name', 'role', 'description']);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('teams', 'public');
            $data['photo'] = $path;
        }

        Team::create($data);

        return redirect()->back()->with('success', 'Anggota tim baru berhasil ditambahkan ke dalam daftar slot!');
    }

    /**
     * Menghapus slot anggota tim ahli dan membersihkan berkas gambar terkait di storage.
     */
    public function destroyTeam(Team $team)
    {
        if ($team->photo && Storage::disk('public')->exists($team->photo)) {
            Storage::disk('public')->delete($team->photo);
        }

        $team->delete();

        return redirect()->back()->with('success', 'Slot anggota tim berhasil dihapus dari halaman.');
    }
}