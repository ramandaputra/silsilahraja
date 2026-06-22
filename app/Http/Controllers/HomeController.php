<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // ======================
    // HALAMAN HOME (BERANDA)
    // ======================
    public function index(Request $request)
    {
        // 1. Pencarian Tokoh
        $query = $request->input('search');
        $results = null;

        if ($query) {
            $results = Person::where('nama_lengkap', 'like', '%' . $query . '%')->get();
        }

        // 2. Statistik Riil Database
        $totalNodes = Person::count();
        $totalLeluhur = Person::whereNull('father_id')
                             ->whereNull('mother_id')
                             ->count();

        // 3. Tokoh Utama (Menampilkan yang memiliki foto profil)
        $featuredPeople = Person::whereNotNull('foto')
                                ->latest()
                                ->take(3)
                                ->get();

        // Jika data yang memiliki foto kurang dari 3, ambil tokoh terbaru secara umum sebagai cadangan
        if ($featuredPeople->count() < 3) {
            $featuredPeople = Person::latest()->take(3)->get();
        }

        // 4. Pembaruan Tokoh Terakhir
        $recentUpdates = Person::latest()
                               ->take(3)
                               ->get();

        return view('public.index', compact(
            'totalNodes',
            'totalLeluhur',
            'featuredPeople',
            'recentUpdates',
            'results'
        ));
    }

    // ======================
    // HALAMAN TRAH (SILSILAH)
    // ======================
    public function trah($id)
    {
        // 1. Ambil data subjek fokus yang dipilih
        $person = Person::findOrFail($id);

        // 2. Lacak ke atas mencari leluhur puncak (Generasi 1)
        $rootAncestor = $person;

        while ($rootAncestor->father_id !== null) {
            $nextAncestor = Person::find($rootAncestor->father_id);

            // Safety: jika data ayah terdaftar tapi barisnya sudah terhapus di DB, hentikan perulangan
            if (!$nextAncestor) {
                break;
            }
            
            $rootAncestor = $nextAncestor;
        }

        // 3. Ambil anak-anak pertama dari leluhur puncak tersebut (Jalur Ayah atau Ibu)
        // Kita tidak perlu menggunakan ->with('children') karena pencabangan generasi 2 sampai 6
        // akan digambar secara dinamis dan mandiri oleh komponen 'trah_node.blade.php'
        $rootChildren = Person::where('father_id', $rootAncestor->id)
                            ->orWhere('mother_id', $rootAncestor->id)
                            ->orderBy('tanggal_lahir', 'asc')
                            ->get();

        // 4. Kirim data ke halaman bagan silsilah
        return view('public.trah', compact(
            'person',
            'rootAncestor',
            'rootChildren'
        ));
    }
}