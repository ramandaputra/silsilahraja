<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Person;
use App\Models\Team;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | 1. SETTINGS (DINAMIS)
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
        | 2. STATISTIK
        |--------------------------------------------------------------------------
        */
        $totalFamilies = Person::count();
        $totalNodes    = Person::count();

        /*
        |--------------------------------------------------------------------------
        | 3. DATA TIM
        |--------------------------------------------------------------------------
        */
        $teams = Team::orderBy('order_position')->get();

        /*
        |--------------------------------------------------------------------------
        | 4. VIEW
        |--------------------------------------------------------------------------
        */
        return view('public.about', compact(
            'settings',
            'totalFamilies',
            'totalNodes',
            'teams'
        ));
    }
}