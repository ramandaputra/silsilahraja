<?php

namespace App\Http\Controllers;

use App\Models\Setting; // Mengambil pengaturan dinamis situs & tim ahli
use App\Models\Person;  // Mengambil total entitas silsilah data
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // 1. Ambil data pengaturan dari database satu per satu (beserta nilai default-nya)
        $settings = [
            'about_hero_description' => Setting::get('about_hero_description', 'Mendedikasikan teknologi untuk melestarikan memori kolektif bangsa melalui dokumentasi silsilah keluarga yang akurat, sistematis, dan terintegrasi secara digital. Kami percaya bahwa memahami akar adalah langkah awal membangun masa depan.'),
            'about_history_title'    => Setting::get('about_history_title', 'Dedikasi terhadap Integritas Genealogi'),
            'about_history_body_1'   => Setting::get('about_history_body_1', 'Berawal dari sebuah inisiatif penelitian sejarah lisan di lingkungan akademis, proyek Silsilah Keluarga tumbuh menjadi sebuah platform institusional yang mengedepankan akurasi data. Kami menyadari bahwa sejarah keluarga bukan sekadar daftar nama, melainkan warisan budaya yang membutuhkan sistem penyimpanan yang aman dan terstruktur.'),
            'about_history_body_2'   => Setting::get('about_history_body_2', 'Melalui metodologi yang diadaptasi dari standar arsip nasional, setiap fitur dalam aplikasi ini dirancang untuk meminimalisir redundansi data dan memastikan hubungan antar-generasi tercatat secara logis. Fokus kami adalah memberikan kemudahan bagi setiap keluarga Indonesia untuk membangun repositori sejarah mereka sendiri dengan standar profesional.'),

            // Data Tim Dinamis dari Database
            'team_name_1'            => Setting::get('team_name_1', 'Dr. Handoko Wiratama'),
            'team_role_1'            => Setting::get('team_role_1', 'Ketua Arsiparis'),
            'team_desc_1'            => Setting::get('team_desc_1', 'Pakar dokumentasi sejarah dengan pengalaman lebih dari 15 tahun di lembaga kearsipan nasional.'),

            'team_name_2'            => Setting::get('team_name_2', 'Siti Aminah, M.Kom'),
            'team_role_2'            => Setting::get('team_role_2', 'Pengembang Sistem'),
            'team_desc_2'            => Setting::get('team_desc_2', 'Arsitek sistem informasi yang fokus pada integritas data dan keamanan basis data digital terdistribusi.'),

            'team_name_3'            => Setting::get('team_name_3', 'Prof. Baskoro Jati'),
            'team_role_3'            => Setting::get('team_role_3', 'Peneliti Sejarah'),
            'team_desc_3'            => Setting::get('team_desc_3', 'Konsultan utama untuk validasi metodologi penelusuran garis keturunan dan konteks sejarah lokal.'),
        ];

        // 2. Perbaikan Struktur Query Counter Statistik (Aman dari nama kolom apapun)
        $totalFamilies = Person::count(); // Menghitung total entitas dasar sebagai representasi data
        $totalNodes    = Person::count(); // Menghitung total seluruh baris di tabel people

        // GANTI MENJADI (Sesuaikan dengan lokasi folder file Anda)
        return view('public.about', compact('settings', 'totalFamilies', 'totalNodes'));
    }
}