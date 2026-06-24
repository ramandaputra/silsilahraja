<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Person;
use App\Models\Team;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    /**
     * Menampilkan halaman Tentang Kami untuk publik.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. SETTINGS (Dinamis dengan Teks Fallback Default)
        |--------------------------------------------------------------------------
        */
        $settings = [
            'about_hero_description' => Setting::get(
                'about_hero_description',
                'Mendedikasikan teknologi untuk melestarikan memori kolektif bangsa melalui dokumentasi silsilah keluarga yang akurat, sistematis, dan terintegrasi secara digital. Kami percaya bahwa memahami akar adalah langkah awal membangun masa depan.'
            ),

            'about_history_title' => Setting::get(
                'about_history_title',
                'Dedikasi terhadap Integritas Genealogi'
            ),

            'about_history_body_1' => Setting::get(
                'about_history_body_1',
                'Berawal dari sebuah inisiatif penelitian sejarah lisan di lingkungan akademis, proyek Silsilah Keluarga tumbuh menjadi sebuah platform institusional yang mengedepankan akurasi data.'
            ),

            'about_history_body_2' => Setting::get(
                'about_history_body_2',
                'Melalui metodologi berbasis standar arsip nasional, setiap fitur dirancang untuk memastikan hubungan antar-generasi tercatat secara logis dan minim redundansi.'
            ),
        ];

        /*
        |--------------------------------------------------------------------------
        | 2. STATISTIK (Menghitung Jumlah Data Silsilah)
        |--------------------------------------------------------------------------
        */
        $totalFamilies = Person::count();
        $totalNodes    = Person::count();

        /*
        |--------------------------------------------------------------------------
        | 3. DATA TIM (Dipisah Berdasarkan Kategori & Diurutkan Berdasar Posisi)
        |--------------------------------------------------------------------------
        */
        $ahli = Team::where('category', 'ahli')
                    ->orderBy('order_position')
                    ->get();

        $developers = Team::where('category', 'developer')
                          ->orderBy('order_position')
                          ->get();

        /*
        |--------------------------------------------------------------------------
        | 4. VIEW (Mengarahkan ke folder resources/views/public/about.blade.php)
        |--------------------------------------------------------------------------
        */
        return view('public.about', compact(
            'settings',
            'totalFamilies',
            'totalNodes',
            'ahli',
            'developers'
        ));
    }
}