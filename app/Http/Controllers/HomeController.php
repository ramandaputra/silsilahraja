<?php

namespace App\Http\Controllers;

use App\Models\Person;

class HomeController extends Controller
{
    public function trah($id)
    {
        // 1. Cari data tokoh yang sedang dipilih/diklik
        $person = Person::findOrFail($id);

        // 2. Lacak ke atas untuk mencari Leluhur Paling Pertama (Generasi 1)
        $rootAncestor = $person;
        while ($rootAncestor->father_id !== null) {
            $rootAncestor = Person::findOrFail($rootAncestor->father_id);
        }

        // 3. Muat semua anak-anak dari Leluhur Pertama tersebut beserta relasi children di bawahnya
        $rootChildren = Person::with('children')
                              ->where('father_id', $rootAncestor->id)
                              ->orderBy('tanggal_lahir', 'asc')
                              ->get();

        // 4. Kirim variabel $person (subjek fokus) dan $rootAncestor (leluhur pertama) ke view
        return view('public.trah', compact('person', 'rootAncestor', 'rootChildren'));
    }
}
