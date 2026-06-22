<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $defaultSettings = [
            'site_title' => 'Silsilah Keluarga - Pusat Data Genealogi Digital',
            'nav_brand' => 'Silsilah Raja',
            'hero_title' => "Temukan Akar &\nWarisan Agung Keluarga Raja",
            'hero_subtitle' => 'Arsip digital silsilah keturunan ningrat yang aman, terstruktur, dan terverifikasi untuk menjaga sejarah leluhur agung lintas generasi.',
            'history_title' => 'Sejarah & Warisan Agung Keluarga Raja',
            'history_body_1' => 'Perjalanan sejarah keluarga raja bukan sekadar silsilah nama, melainkan sebuah narasi agung tentang kepemimpinan, pengabdian, dan identitas budaya nusantara. Melalui berabad-abad masa kepemimpinan, setiap garis keturunan membawa amanah untuk menjaga kelestarian nilai-nilai luhur yang telah diletakkan oleh para leluhur agung sebagai pilar kebudayaan bangsa.',
        ];

        foreach ($defaultSettings as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}