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
        // 1. Cari data tokoh yang sedang dibuka profilnya beserta ayah dan ibunya
        $person = Person::with(['father', 'mother'])->findOrFail($id);

        // 2. Ambil data anak-anak dari tokoh ini (menggunakan relasi children yang sudah kita perbaiki)
        $children = $person->children;

        // 3. Cari Leluhur Paling Atas (Untuk kebutuhan bagan multi-generasi Anda sebelumnya)
        $rootAncestor = $person;
        while ($rootAncestor->father_id !== null) {
            $rootAncestor = Person::findOrFail($rootAncestor->father_id);
        }
        $rootAncestor->load('children');

        // 4. Pastikan variabel $person, $children, dan $rootAncestor semuanya dikirim ke view
        return view('public.show', compact('person', 'children', 'rootAncestor'));
    }
}