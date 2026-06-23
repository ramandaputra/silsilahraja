<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class RelationController extends Controller
{
    private $relasiLabel = [
        'AYAH' => 'Ayah', 'IBU' => 'Ibu', 'KAKEK' => 'Datuk', 'NENEK' => 'Nenek', 'BUYUT' => 'Moyang',
        'ANAK' => 'Anak', 'CUCU' => 'Cucu', 'CICIT' => 'Cicit',
        'ABANG' => 'Abang', 'KAKAK' => 'Kakak', 'ADIK' => 'Adik',
        'PAMAN_TUA' => 'Pak Long', 'PAMAN_TENGAH' => 'Pak Ngah', 'PAMAN_MUDA' => 'Pak Cik',
        'BIBI_TUA' => 'Mak Long', 'BIBI_TENGAH' => 'Mak Ngah', 'BIBI_MUDA' => 'Mak Cik',
        'SEPUPU' => 'Sepupu', 'KEPONAKAN' => 'Keponakan',
        'SUAMI' => 'Suami', 'ISTRI' => 'Istri', 'MERTUA' => 'Mertua', 'MENANTU' => 'Menantu', 
        'IPAR' => 'Ipar', 'BESAN' => 'Besan'
    ];

    public function index()
    {
        $people = Person::orderBy('nama_lengkap', 'asc')->get();
        return view('public.relation.index', compact('people'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'person_a_id' => 'required|exists:people,id',
            'person_b_id' => 'required|exists:people,id',
        ]);

        $personA = Person::findOrFail($request->person_a_id);
        $personB = Person::findOrFail($request->person_b_id);

        if ($personA->id == $personB->id) {
            return back()->with('error', 'Tokoh A dan Tokoh B tidak boleh orang yang sama.');
        }

        $relationLabel = $this->determineRelationBFS($personA, $personB);

        $people = Person::orderBy('nama_lengkap', 'asc')->get();
        return view('public.relation.index', compact('people', 'personA', 'personB', 'relationLabel'));
    }

    private function determineRelationBFS($start, $target)
    {
        // Antrean BFS menyimpan [id_sekarang, [jalur_hubungan]]
        $queue = [[$start->id, []]];
        $visited = [$start->id => true];

        // Cache relasi anak & pasangan untuk mempercepat proses
        $allPeople = Person::all();
        $childrenMap = [];
        $spouseMap = [];

        foreach ($allPeople as $p) {
            if ($p->father_id) $childrenMap[$p->father_id][] = $p->id;
            if ($p->mother_id) $childrenMap[$p->mother_id][] = $p->id;
            
            // Pencocokan nama pasangan secara fleksibel
            if ($p->status_pernikahan === 'Menikah' && $p->nama_pasangan) {
                $partner = $allPeople->first(function($item) use ($p) {
                    return str_contains(strtolower($p->nama_pasangan), strtolower($item->nama_lengkap)) 
                        || str_contains(strtolower($item->nama_pasangan), strtolower($p->nama_lengkap));
                });
                if ($partner) {
                    $spouseMap[$p->id] = $partner->id;
                    $spouseMap[$partner->id] = $p->id;
                }
            }
        }

        while (!empty($queue)) {
            [$currentId, $path] = array_shift($queue);

            if ($currentId == $target->id) {
                return $this->translatePathToLabel($path, $start, $target);
            }

            $currentPerson = $allPeople->firstWhere('id', $currentId);
            if (!$currentPerson) continue;

            // Tetangga 1: Ayah Kandung
            if ($currentPerson->father_id && !isset($visited[$currentPerson->father_id])) {
                $visited[$currentPerson->father_id] = true;
                $newPath = $path; $newPath[] = ['rel' => 'UP_FATHER', 'id' => $currentPerson->father_id];
                $queue[] = [$currentPerson->father_id, $newPath];
            }

            // Tetangga 2: Ibu Kandung
            if ($currentPerson->mother_id && !isset($visited[$currentPerson->mother_id])) {
                $visited[$currentPerson->mother_id] = true;
                $newPath = $path; $newPath[] = ['rel' => 'UP_MOTHER', 'id' => $currentPerson->mother_id];
                $queue[] = [$currentPerson->mother_id, $newPath];
            }

            // Tetangga 3: Anak-anak
            if (isset($childrenMap[$currentId])) {
                foreach ($childrenMap[$currentId] as $childId) {
                    if (!isset($visited[$childId])) {
                        $visited[$childId] = true;
                        $newPath = $path; $newPath[] = ['rel' => 'DOWN', 'id' => $childId];
                        $queue[] = [$childId, $newPath];
                    }
                }
            }

            // Tetangga 4: Pasangan (Suami/Istri)
            if (isset($spouseMap[$currentId])) {
                $spouseId = $spouseMap[$currentId];
                if (!isset($visited[$spouseId])) {
                    $visited[$spouseId] = true;
                    $newPath = $path; $newPath[] = ['rel' => 'SPOUSE', 'id' => $spouseId];
                    $queue[] = [$spouseId, $newPath];
                }
            }
        }

        return 'Hubungan Jauh / Belum Terdefinisi';
    }

    private function translatePathToLabel($path, $start, $target)
    {
        $steps = array_column($path, 'rel');
        $stepCount = count($steps);

        // 1. Hubungan Langsung ke Atas
        if ($steps === ['UP_FATHER']) return $this->relasiLabel['AYAH'];
        if ($steps === ['UP_MOTHER']) return $this->relasiLabel['IBU'];
        if ($stepCount === 2 && $steps[0] === 'UP_FATHER' && $steps[1] === 'UP_FATHER') return $this->relasiLabel['KAKEK'];
        if ($stepCount === 2 && str_starts_with($steps[0], 'UP_') && str_starts_with($steps[1], 'UP_')) return $this->relasiLabel['NENEK'];
        if ($stepCount === 3 && str_starts_with($steps[0], 'UP_') && str_starts_with($steps[1], 'UP_') && str_starts_with($steps[2], 'UP_')) return $this->relasiLabel['BUYUT'];

        // 2. Hubungan Langsung ke Bawah
        if ($steps === ['DOWN']) return $this->relasiLabel['ANAK'];
        if ($steps === ['DOWN', 'DOWN']) return $this->relasiLabel['CUCU'];
        if ($steps === ['DOWN', 'DOWN', 'DOWN']) return $this->relasiLabel['CICIT'];

        // 3. Pernikahan Langsung
        if ($steps === ['SPOUSE']) {
            return $target->jenis_kelamin === 'L' ? $this->relasiLabel['SUAMI'] : $this->relasiLabel['ISTRI'];
        }

        // 4. Jalur Horizontal Saudara Kandung (Naik ke Orang Tua -> Turun ke Anak Orang Tua)
        if ($stepCount === 2 && str_starts_with($steps[0], 'UP_') && $steps[1] === 'DOWN') {
            if ($target->tanggal_lahir && $start->tanggal_lahir) {
                if ($target->tanggal_lahir < $start->tanggal_lahir) {
                    return $target->jenis_kelamin === 'L' ? $this->relasiLabel['ABANG'] : $this->relasiLabel['KAKAK'];
                }
            }
            return $this->relasiLabel['ADIK'];
        }

        // 5. Paman & Bibi Adat Melayu (Naik ke Kakek/Nenek -> Turun ke Saudara Orang Tua)
        if ($stepCount === 3 && str_starts_with($steps[0], 'UP_') && str_starts_with($steps[1], 'UP_') && $steps[2] === 'DOWN') {
            return $this->getMalayUncleAuntLabel($path[1]['id'], $target);
        }

        // 6. Keponakan (Naik ke Orang Tua -> Turun ke Saudara -> Turun ke Anak Saudara)
        if ($stepCount === 3 && str_starts_with($steps[0], 'UP_') && $steps[1] === 'DOWN' && $steps[2] === 'DOWN') {
            return $this->relasiLabel['KEPONAKAN'];
        }

        // 7. Sepupu (Naik ke Orang Tua -> Naik ke Kakek/Nenek -> Turun ke Paman/Bibi -> Turun ke Anak Paman/Bibi)
        if ($stepCount === 4 && str_starts_with($steps[0], 'UP_') && str_starts_with($steps[1], 'UP_') && $steps[2] === 'DOWN' && $steps[3] === 'DOWN') {
            return $this->relasiLabel['SEPUPU'];
        }

        // 8. Mertua, Menantu, Ipar (Melibatkan 1 langkah Pasangan/SPOUSE)
        if (in_array('SPOUSE', $steps)) {
            if ($steps[0] === 'SPOUSE' && str_starts_with($steps[1], 'UP_')) return $this->relasiLabel['MERTUA'];
            if (str_ends_with(end($steps), 'DOWN') && $steps[$stepCount-2] === 'SPOUSE') return $this->relasiLabel['MENANTU'];
            if ($steps[0] === 'SPOUSE' && str_starts_with($steps[1], 'UP_') && $steps[2] === 'DOWN') return $this->relasiLabel['IPAR'];
            if (str_starts_with($steps[0], 'UP_') && $steps[1] === 'DOWN' && $steps[2] === 'SPOUSE') return $this->relasiLabel['IPAR'];
        }

        return 'Hubungan Jauh / Belum Terdefinisi';
    }

    private function getMalayUncleAuntLabel($parentId, $target)
    {
        // Ambil semua saudara sekandung dari orang tua target berdasarkan data kakek/nenek
        $parent = Person::find($parentId);
        if (!$parent || !$parent->father_id) {
            return $target->jenis_kelamin === 'L' ? $this->relasiLabel['PAMAN_MUDA'] : $this->relasiLabel['BIBI_MUDA'];
        }

        $siblings = Person::where('father_id', $parent->father_id)
            ->orderBy('tanggal_lahir', 'asc')
            ->get();
            
        $total = $siblings->count();
        $targetIndex = 0;

        foreach ($siblings as $index => $sib) {
            if ($sib->id == $target->id) {
                $targetIndex = $index + 1;
                break;
            }
        }

        if ($target->jenis_kelamin === 'L') {
            if ($targetIndex === 1) return $this->relasiLabel['PAMAN_TUA'];
            if ($total > 2 && $targetIndex === (int)ceil($total / 2)) return $this->relasiLabel['PAMAN_TENGAH'];
            return $this->relasiLabel['PAMAN_MUDA'];
        } else {
            if ($targetIndex === 1) return $this->relasiLabel['BIBI_TUA'];
            if ($total > 2 && $targetIndex === (int)ceil($total / 2)) return $this->relasiLabel['BIBI_TENGAH'];
            return $this->relasiLabel['BIBI_MUDA'];
        }
    }
}