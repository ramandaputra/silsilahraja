<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class RelationController extends Controller
{
    private $relasiLabel = [
        'AYAH' => 'Ayah', 'IBU' => 'Ibu', 'KAKEK' => 'Datuk', 'NENEK' => 'Nenek', 'BUYUT' => 'Moyang',
        'ANAK' => 'Anak', 'CUCU' => 'Cucu', 'CICIT' => 'Cicit',
        'KAKAK_L' => 'Abang', 'KAKAK_P' => 'Kakak', 'ADIK' => 'Adik',
        'PAMAN_TUA' => 'Pak Long', 'PAMAN_TENGAH' => 'Pak Ngah', 'PAMAN_MUDA' => 'Pak Cik',
        'BIBI_TUA' => 'Mak Long', 'BIBI_TENGAH' => 'Mak Ngah', 'BIBI_MUDA' => 'Mak Cik',
        'SEPUPU' => 'Sepupu', 'KEPONAKAN' => 'Keponakan',
        'SUAMI' => 'Suami', 'ISTRI' => 'Istri', 'MERTUA' => 'Mertua', 'MENANTU' => 'Menantu', 'IPAR' => 'Ipar', 'BESAN' => 'Besan'
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

        $relationCode = $this->determineRelation($personA, $personB);
        $relationLabel = $this->relasiLabel[$relationCode] ?? 'Hubungan Jauh / Belum Terdefinisi';

        $people = Person::orderBy('nama_lengkap', 'asc')->get();
        return view('public.relation.index', compact('people', 'personA', 'personB', 'relationLabel'));
    }

    private function determineRelation($a, $b)
    {
        // 1. Pasangan (Suami/Istri)
        if ($a->status_pernikahan === 'Menikah' && $a->nama_pasangan && str_contains(strtolower($a->nama_pasangan), strtolower($b->nama_lengkap))) {
            return $b->jenis_kelamin === 'L' ? 'SUAMI' : 'ISTRI';
        }
        if ($b->status_pernikahan === 'Menikah' && $b->nama_pasangan && str_contains(strtolower($b->nama_pasangan), strtolower($a->nama_lengkap))) {
            return $b->jenis_kelamin === 'L' ? 'SUAMI' : 'ISTRI';
        }

        // 2. Jalur Atas (Ayah, Ibu, Datuk, Nenek, Moyang)
        if ($a->father_id == $b->id) return 'AYAH';
        if ($a->mother_id == $b->id) return 'IBU';

        if ($a->father && $a->father->father_id == $b->id) return 'KAKEK';
        if ($a->father && $a->father->mother_id == $b->id) return 'NENEK';
        if ($a->mother && $a->mother->father_id == $b->id) return 'KAKEK';
        if ($a->mother && $a->mother->mother_id == $b->id) return 'NENEK';

        if ($a->father && $a->father->father && $a->father->father->father_id == $b->id) return 'BUYUT';
        if ($a->father && $a->father->father && $a->father->father->mother_id == $b->id) return 'BUYUT';

        // 3. Jalur Bawah (Anak, Cucu, Cicit)
        if ($b->father_id == $a->id || $b->mother_id == $a->id) return 'ANAK';
        if ($b->father && ($b->father->father_id == $a->id || $b->father->mother_id == $a->id)) return 'CUCU';
        if ($b->father && $b->father->father && ($b->father->father->father_id == $a->id || $b->father->father->mother_id == $a->id)) return 'CICIT';

        // 4. Jalur Horizontal (Saudara Kandung)
        $isSaudara = false;
        if (($a->father_id && $a->father_id == $b->father_id) || ($a->mother_id && $a->mother_id == $b->mother_id)) {
            $isSaudara = true;
        }

        if ($isSaudara) {
            if ($b->tanggal_lahir && $a->tanggal_lahir) {
                if ($b->tanggal_lahir < $a->tanggal_lahir) {
                    return $b->jenis_kelamin === 'L' ? 'KAKAK_L' : 'KAKAK_P';
                } else {
                    return 'ADIK';
                }
            }
            return 'ADIK';
        }

        // 5. Jalur Paman & Bibi Adat Melayu (Pak Long, Pak Ngah, Pak Cik)
        $bIsSaudaraOrangTua = false;
        $orangTuaId = null;
        if ($a->father && (($a->father->father_id && $a->father->father_id == $b->father_id) || ($a->father->mother_id && $a->father->mother_id == $b->mother_id))) {
            $bIsSaudaraOrangTua = true;
            $orangTuaId = $a->father_id;
        } elseif ($a->mother && (($a->mother->father_id && $a->mother->father_id == $b->father_id) || ($a->mother->mother_id && $a->mother->mother_id == $b->mother_id))) {
            $bIsSaudaraOrangTua = true;
            $orangTuaId = $a->mother_id;
        }

        if ($bIsSaudaraOrangTua && $orangTuaId) {
            $saudaraSatuAyah = Person::where('father_id', $b->father_id)->orderBy('tanggal_lahir', 'asc')->get();
            $totalSaudara = $saudaraSatuAyah->count();
            
            $posisiB = 0;
            foreach ($saudaraSatuAyah as $key => $sdr) {
                if ($sdr->id == $b->id) { $posisiB = $key + 1; break; }
            }

            if ($b->jenis_kelamin === 'L') {
                if ($posisiB == 1) return 'PAMAN_TUA';
                if ($totalSaudara > 2 && $posisiB == (int)ceil($totalSaudara / 2)) return 'PAMAN_TENGAH';
                return 'PAMAN_MUDA';
            } else {
                if ($posisiB == 1) return 'BIBI_TUA';
                if ($totalSaudara > 2 && $posisiB == (int)ceil($totalSaudara / 2)) return 'BIBI_TENGAH';
                return 'BIBI_MUDA';
            }
        }

        // 6. Jalur Keponakan & Sepupu
        if ($a->father && $b->father && $a->father->father_id && $a->father->father_id == $b->father_id) return 'SEPUPU';
        if ($b->father && (($b->father->father_id && $b->father->father_id == $a->father_id) || ($b->father->mother_id && $b->father->mother_id == $a->mother_id))) return 'KEPONAKAN';

        return 'BELUM_TERDEFINISI';
    }
} // <-- Pastikan kurung kurawal penutup ini ikut tersimpan