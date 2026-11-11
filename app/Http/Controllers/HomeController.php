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
            $results = Person::with(['father', 'mother'])->where('nama_lengkap', 'like', '%' . $query . '%')->get();
        }

        // 2. Statistik Riil Database
        $totalNodes = Person::count();
        $totalLeluhur = Person::whereNull('father_id')
                             ->whereNull('mother_id')
                             ->count();

        // 3. Tokoh Utama (Menampilkan yang memiliki foto profil)
        $featuredPeople = Person::with(['father', 'mother'])
                                ->whereNotNull('foto')
                                ->latest()
                                ->take(3)
                                ->get();

        // Jika data yang memiliki foto kurang dari 3, ambil tokoh terbaru secara umum sebagai cadangan
        if ($featuredPeople->count() < 3) {
            $featuredPeople = Person::with(['father', 'mother'])->latest()->take(3)->get();
        }

        // 4. Pembaruan Tokoh Terakhir
        $recentUpdates = Person::with(['father', 'mother'])
                               ->latest()
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

        // 2. Ambil seluruh data anggota untuk pemetaan graf relasi kekerabatan
        $allPeople = Person::all();

        // 3. Hitung relasi derajat <= 3 dari subjek fokus menggunakan BFS
        $relatives = $this->getRelativesWithinDegree($person->id, $allPeople, 3);

        // 4. Lacak ke atas mencari leluhur awal pohon (maksimal 3 generasi ke atas / Kakek-Nenek Buyut)
        $rootAncestor = $person;
        $current = $person;
        for ($i = 0; $i < 3; $i++) {
            $parentId = $current->father_id ?? $current->mother_id;
            if (!$parentId) {
                break;
            }
            $parent = $allPeople->firstWhere('id', $parentId);
            if (!$parent || !isset($relatives[$parent->id])) {
                break;
            }
            $rootAncestor = $parent;
            $current = $parent;
        }

        // 5. Susun struktur childrenMap (hanya anak yang berada dalam derajat <= 3)
        $relativeIds = array_keys($relatives);
        $childrenMap = [];
        $peopleById = $allPeople->keyBy('id');

        // Urutkan tokoh berdasarkan tanggal lahir agar susunan cabang anak konsisten
        $sortedPeople = $allPeople->sortBy('tanggal_lahir');

        foreach ($sortedPeople as $child) {
            if (!isset($relatives[$child->id])) {
                continue;
            }
            if ($child->father_id && in_array($child->father_id, $relativeIds)) {
                $childrenMap[$child->father_id][] = $child;
            } elseif ($child->mother_id && in_array($child->mother_id, $relativeIds)) {
                $childrenMap[$child->mother_id][] = $child;
            }
        }

        // Ambil keturunan langsung dari leluhur awal yang terpilih
        $rootChildren = collect($childrenMap[$rootAncestor->id] ?? []);

        // 6. Kirim data ke halaman bagan silsilah
        return view('public.trah', compact(
            'person',
            'rootAncestor',
            'rootChildren',
            'childrenMap',
            'relatives',
            'peopleById'
        ));
    }

    /**
     * Menghitung semua kerabat yang berada dalam batas derajat kekerabatan tertentu (default derajat 3).
     * Sesuai KUHPerdata / kaidah genealogi:
     * - Garis lurus: dihitung per kelahiran naik (ayah, kakek, buyut) atau turun (anak, cucu, cicit).
     * - Garis menyamping: naik ke leluhur bersama lalu turun ke kerabat (saudara kandung [2], paman/bibi [3], keponakan [3]).
     */
    private function getRelativesWithinDegree(int $personId, $peopleCollection, int $maxDegree = 3): array
    {
        $peopleById = [];
        $parentsMap = [];
        $childrenMap = [];

        foreach ($peopleCollection as $p) {
            $peopleById[$p->id] = $p;
            if (!empty($p->father_id)) {
                $parentsMap[$p->id][] = $p->father_id;
                $childrenMap[$p->father_id][] = $p->id;
            }
            if (!empty($p->mother_id)) {
                $parentsMap[$p->id][] = $p->mother_id;
                $childrenMap[$p->mother_id][] = $p->id;
            }
        }

        if (!isset($peopleById[$personId])) {
            return [];
        }

        // Antrean BFS menyimpan: [id_sekarang, jarak_derajat, [langkah_perjalanan]]
        $queue = [[$personId, 0, []]];
        $visited = [
            $personId => [
                'degree' => 0,
                'relation' => 'Subjek Fokus',
                'path' => []
            ]
        ];

        while (!empty($queue)) {
            [$currId, $dist, $path] = array_shift($queue);

            if ($dist >= $maxDegree) {
                continue;
            }

            $nextDist = $dist + 1;

            // 1. Telusuri Jalur Ke Atas (Orang Tua / Leluhur)
            // Dalam relasi sedarah, jika sudah pernah turun ke anak/saudara, tidak boleh naik lagi
            $hasDownInPath = in_array('DOWN', $path);

            if (!$hasDownInPath) {
                $parents = $parentsMap[$currId] ?? [];
                foreach ($parents as $parentId) {
                    if (!isset($visited[$parentId])) {
                        $newPath = array_merge($path, ['UP']);
                        $parentObj = $peopleById[$parentId] ?? null;
                        $relation = $this->determineKinshipLabel($newPath, $parentObj);
                        $visited[$parentId] = [
                            'degree' => $nextDist,
                            'relation' => $relation,
                            'path' => $newPath
                        ];
                        $queue[] = [$parentId, $nextDist, $newPath];
                    }
                }
            }

            // 2. Telusuri Jalur Ke Bawah (Keturunan)
            $children = $childrenMap[$currId] ?? [];
            foreach ($children as $childId) {
                if (!isset($visited[$childId])) {
                    $newPath = array_merge($path, ['DOWN']);
                    $childObj = $peopleById[$childId] ?? null;
                    $relation = $this->determineKinshipLabel($newPath, $childObj);
                    $visited[$childId] = [
                        'degree' => $nextDist,
                        'relation' => $relation,
                        'path' => $newPath
                    ];
                    $queue[] = [$childId, $nextDist, $newPath];
                }
            }
        }

        return $visited;
    }

    /**
     * Menerjemahkan rute langkah silsilah menjadi sebutan relasi keluarga
     */
    private function determineKinshipLabel(array $path, ?Person $person): string
    {
        $gender = $person ? $person->jenis_kelamin : 'L';

        if (empty($path)) {
            return 'Subjek Fokus';
        }

        // Garis Lurus Ke Atas (UP)
        if ($path === ['UP']) {
            return $gender === 'L' ? 'Ayah' : 'Ibu';
        }
        if ($path === ['UP', 'UP']) {
            return $gender === 'L' ? 'Kakek' : 'Nenek';
        }
        if ($path === ['UP', 'UP', 'UP']) {
            return $gender === 'L' ? 'Kakek Buyut' : 'Nenek Buyut';
        }

        // Garis Lurus Ke Bawah (DOWN)
        if ($path === ['DOWN']) {
            return 'Anak';
        }
        if ($path === ['DOWN', 'DOWN']) {
            return 'Cucu';
        }
        if ($path === ['DOWN', 'DOWN', 'DOWN']) {
            return 'Cicit';
        }

        // Garis Menyamping
        // 1 UP, 1 DOWN => Saudara Kandung (Derajat 2)
        if ($path === ['UP', 'DOWN']) {
            return 'Saudara Kandung';
        }
        // 2 UP, 1 DOWN => Paman / Bibi (Derajat 3)
        if ($path === ['UP', 'UP', 'DOWN']) {
            return $gender === 'L' ? 'Paman' : 'Bibi';
        }
        // 1 UP, 2 DOWN => Keponakan (Derajat 3)
        if ($path === ['UP', 'DOWN', 'DOWN']) {
            return 'Keponakan';
        }

        return 'Kerabat';
    }
}