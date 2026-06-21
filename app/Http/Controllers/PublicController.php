<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    // 1. Fungsi untuk Halaman Pencarian (Ala PDDIKTI)
    public function index(Request $request): View
    {
        $query = $request->input('q');

        // Menggunakan query builder agar lebih fleksibel
        $people = Person::query();

        if ($query) {
            $people->where('nama_lengkap', 'like', "%{$query}%");
        }

        // Kita kirim sebagai 'results' agar cocok dengan file index.blade.php
        return view('public.index', [
            'results' => $people->get(),
            'query' => $query,
        ]);
    }

    // 2. Fungsi untuk Halaman Detail Profil & Silsilah
    public function show(int $id): View
    {
        // Mengambil data orang beserta ayah, ibu, dan anak-anaknya sekaligus
        $person = Person::with(['father', 'mother', 'children'])->findOrFail($id);

        return view('public.show', compact('person'));
    }
}