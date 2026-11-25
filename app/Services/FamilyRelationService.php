<?php

namespace App\Services;

use App\Models\Person;

class FamilyRelationService
{
    /**
     * Istilah generasi ke bawah (Keturunan)
     */
    private array $generationTermsDown = [
        1 => ['title' => 'Anak Kandung', 'label' => 'Anak'],
        2 => ['title' => 'Cucu', 'label' => 'Cucu'],
        3 => ['title' => 'Cicit', 'label' => 'Cicit'],
        4 => ['title' => 'Piut (Canggah)', 'label' => 'Piut / Canggah'],
        5 => ['title' => 'Wareng', 'label' => 'Wareng'],
        6 => ['title' => 'Udek-udek', 'label' => 'Udek-udek'],
        7 => ['title' => 'Gantung Siwur', 'label' => 'Gantung Siwur'],
    ];

    /**
     * Istilah generasi ke atas (Leluhur)
     */
    private array $generationTermsUp = [
        1 => ['L' => 'Ayah Kandung', 'P' => 'Ibu Kandung'],
        2 => ['L' => 'Datuk (Kakek)', 'P' => 'Nenek'],
        3 => ['L' => 'Moyang (Buyut)', 'P' => 'Moyang (Buyut)'],
        4 => ['L' => 'Moyang Canggah', 'P' => 'Moyang Canggah'],
        5 => ['L' => 'Moyang Wareng', 'P' => 'Moyang Wareng'],
    ];

    /**
     * Analisis hubungan kekerabatan lengkap antara Tokoh A (Start) dan Tokoh B (Target).
     */
    public function analyze(Person $start, Person $target): array
    {
        $allPeople = Person::all()->keyBy('id');
        $childrenMap = [];
        $spouseMap = [];

        foreach ($allPeople as $p) {
            if ($p->father_id) $childrenMap[$p->father_id][] = $p->id;
            if ($p->mother_id) $childrenMap[$p->mother_id][] = $p->id;

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

        // BFS: [$currentId, $path]
        $queue = [[$start->id, []]];
        $visited = [$start->id => true];
        $foundPath = null;

        while (!empty($queue)) {
            [$currentId, $path] = array_shift($queue);

            if ($currentId == $target->id) {
                $foundPath = $path;
                break;
            }

            $currentPerson = $allPeople[$currentId] ?? null;
            if (!$currentPerson) continue;

            // 1. Ayah Kandung (UP_FATHER)
            if ($currentPerson->father_id && !isset($visited[$currentPerson->father_id])) {
                $visited[$currentPerson->father_id] = true;
                $newPath = $path;
                $newPath[] = ['from_id' => $currentId, 'to_id' => $currentPerson->father_id, 'rel' => 'UP_FATHER'];
                $queue[] = [$currentPerson->father_id, $newPath];
            }

            // 2. Ibu Kandung (UP_MOTHER)
            if ($currentPerson->mother_id && !isset($visited[$currentPerson->mother_id])) {
                $visited[$currentPerson->mother_id] = true;
                $newPath = $path;
                $newPath[] = ['from_id' => $currentId, 'to_id' => $currentPerson->mother_id, 'rel' => 'UP_MOTHER'];
                $queue[] = [$currentPerson->mother_id, $newPath];
            }

            // 3. Anak-anak (DOWN)
            if (isset($childrenMap[$currentId])) {
                foreach ($childrenMap[$currentId] as $childId) {
                    if (!isset($visited[$childId])) {
                        $visited[$childId] = true;
                        $newPath = $path;
                        $newPath[] = ['from_id' => $currentId, 'to_id' => $childId, 'rel' => 'DOWN'];
                        $queue[] = [$childId, $newPath];
                    }
                }
            }

            // 4. Pasangan (SPOUSE)
            if (isset($spouseMap[$currentId])) {
                $spouseId = $spouseMap[$currentId];
                if (!isset($visited[$spouseId])) {
                    $visited[$spouseId] = true;
                    $newPath = $path;
                    $newPath[] = ['from_id' => $currentId, 'to_id' => $spouseId, 'rel' => 'SPOUSE'];
                    $queue[] = [$spouseId, $newPath];
                }
            }
        }

        if (!$foundPath) {
            return [
                'status' => 'not_found',
                'primary_label' => 'Hubungan Jauh / Belum Terhubung',
                'sub_label' => 'Jalur Belum Terdata',
                'generation_text' => 'Tidak Terdefinisi',
                'generation_number' => null,
                'category' => 'Belum Terdefinisi',
                'lineage_line' => 'Tidak ditemukan mata rantai nasab langsung antara kedua tokoh dalam arsip silsilah saat ini.',
                'reciprocal_label' => 'Hubungan Jauh',
                'connecting_figure' => null,
                'common_ancestor' => null,
                'breadcrumbs' => [],
            ];
        }

        return $this->synthesize($start, $target, $foundPath, $allPeople);
    }

    /**
     * Membangun narasi silsilah dan data terstruktur dari jalur BFS.
     */
    private function synthesize(Person $start, Person $target, array $path, $allPeople): array
    {
        $stepRels = array_column($path, 'rel');
        $stepCount = count($stepRels);
        $genderTarget = $target->jenis_kelamin;
        $genderStart = $start->jenis_kelamin;
        $genderTargetWord = $genderTarget === 'L' ? 'Laki-laki' : 'Perempuan';

        // 1. Bangun Visual Rute Breadcrumbs
        $breadcrumbs = [];
        $breadcrumbs[] = [
            'person' => $start,
            'role_label' => 'Tokoh Utama (Titik Tolak)',
            'step_badge' => 'Awal',
            'transition_text' => null,
            'is_start' => true,
            'is_target' => false,
        ];

        foreach ($path as $idx => $step) {
            $toPerson = $allPeople[$step['to_id']];
            $trans = '';

            if ($step['rel'] === 'UP_FATHER') {
                $trans = 'Ayah Kandung';
            } elseif ($step['rel'] === 'UP_MOTHER') {
                $trans = 'Ibu Kandung';
            } elseif ($step['rel'] === 'DOWN') {
                // Tentukan konteks anak
                $prevPerson = $allPeople[$step['from_id']];
                $trans = $toPerson->jenis_kelamin === 'L' ? 'Anak Laki-laki' : 'Anak Perempuan';
            } elseif ($step['rel'] === 'SPOUSE') {
                $trans = $toPerson->jenis_kelamin === 'L' ? 'Suami' : 'Istri';
            }

            $breadcrumbs[] = [
                'person' => $toPerson,
                'transition_text' => $trans,
                'rel' => $step['rel'],
                'is_start' => false,
                'is_target' => ($idx === $stepCount - 1),
            ];
        }

        // 2. Analisis Pola Jalur (Path Patterns)
        $isPureDown = true;
        foreach ($stepRels as $r) {
            if ($r !== 'DOWN') { $isPureDown = false; break; }
        }

        $isPureUp = true;
        foreach ($stepRels as $r) {
            if (!str_starts_with($r, 'UP_')) { $isPureUp = false; break; }
        }

        $hasSpouse = in_array('SPOUSE', $stepRels);

        // KASUS 1: KETURUNAN LANGSUNG (ANAK, CUCU, CICIT, DSB.)
        if ($isPureDown) {
            $genLevel = $stepCount;
            $term = $this->generationTermsDown[$genLevel]['title'] ?? "Keturunan Generasi ke-{$genLevel}";
            $connectingChild = $allPeople[$path[0]['to_id']];
            $connectingRelation = $connectingChild->jenis_kelamin === 'L' ? 'anak laki-laki' : 'anak perempuan';

            $lineageDetail = "";
            if ($genLevel === 1) {
                $lineageDetail = "Anak kandung langsung dari {$start->nama_lengkap}.";
            } elseif ($genLevel === 2) {
                $lineageDetail = "Cucu (Generasi ke-2) melalui {$connectingRelation} bernama {$connectingChild->nama_lengkap}.";
            } elseif ($genLevel === 3) {
                $parentOfTarget = $allPeople[$path[$stepCount - 2]['to_id']];
                $lineageDetail = "Cicit (Generasi ke-3) melalui jalur anak: {$connectingChild->nama_lengkap} dan orang tua: {$parentOfTarget->nama_lengkap}.";
            } else {
                $lineageDetail = "Keturunan generasi ke-{$genLevel} ({$term}) dari garis keturunan {$connectingChild->nama_lengkap}.";
            }

            $reciprocal = $genderStart === 'L'
                ? ($genLevel === 1 ? 'Ayah Kandung' : ($genLevel === 2 ? 'Datuk (Kakek)' : 'Moyang (Buyut)'))
                : ($genLevel === 1 ? 'Ibu Kandung' : ($genLevel === 2 ? 'Nenek' : 'Moyang (Buyut)'));

            return [
                'status' => 'success',
                'primary_label' => "{$term} ({$genderTargetWord})",
                'sub_label' => "Keturunan Generasi ke-{$genLevel}",
                'generation_text' => "Generasi ke-{$genLevel} di bawah Tokoh Utama",
                'generation_number' => -$genLevel,
                'category' => 'Garis Keturunan Langsung',
                'lineage_line' => $lineageDetail,
                'reciprocal_label' => $reciprocal,
                'connecting_figure' => $connectingChild,
                'common_ancestor' => $start,
                'breadcrumbs' => $breadcrumbs,
            ];
        }

        // KASUS 2: LELUHUR LANGSUNG (AYAH, IBU, DATUK, MOYANG)
        if ($isPureUp) {
            $genLevel = $stepCount;
            $term = $this->generationTermsUp[$genLevel][$genderTarget] ?? "Leluhur Generasi ke-{$genLevel} ke Atas";
            $isFatherLine = ($path[0]['rel'] === 'UP_FATHER');
            $lineageName = $isFatherLine ? "Garis Ayah (Patrilineal)" : "Garis Ibu (Matrilineal)";
            $connectingParent = $allPeople[$path[0]['to_id']];

            $lineageDetail = "";
            if ($genLevel === 1) {
                $lineageDetail = "Orang tua kandung langsung ({$lineageName}).";
            } elseif ($genLevel === 2) {
                $lineageDetail = "Datuk/Nenek (Generasi ke-2 ke atas) dari pihak {$lineageName} melalui {$connectingParent->nama_lengkap}.";
            } else {
                $lineageDetail = "Leluhur generasi ke-{$genLevel} ke atas ({$term}) dari pihak {$lineageName}.";
            }

            $reciprocal = $this->generationTermsDown[$genLevel]['label'] ?? "Keturunan Generasi ke-{$genLevel}";

            return [
                'status' => 'success',
                'primary_label' => $term,
                'sub_label' => "Leluhur Generasi ke-{$genLevel} ke Atas ({$lineageName})",
                'generation_text' => "Generasi ke-{$genLevel} di atas Tokoh Utama",
                'generation_number' => $genLevel,
                'category' => 'Garis Leluhur Langsung',
                'lineage_line' => $lineageDetail,
                'reciprocal_label' => $reciprocal,
                'connecting_figure' => $connectingParent,
                'common_ancestor' => $target,
                'breadcrumbs' => $breadcrumbs,
            ];
        }

        // KASUS 3: HUBUNGAN DARAH MENYAMPING (KOLATERAL: SAUDARA, KEPONAKAN, PAMAN/BIBI, SEPUPU)
        if (!$hasSpouse && str_starts_with($stepRels[0], 'UP_')) {
            $upCount = 0;
            while ($upCount < $stepCount && str_starts_with($stepRels[$upCount], 'UP_')) {
                $upCount++;
            }
            $downCount = $stepCount - $upCount;
            $allRestDown = true;
            for ($i = $upCount; $i < $stepCount; $i++) {
                if ($stepRels[$i] !== 'DOWN') { $allRestDown = false; break; }
            }

            if ($allRestDown) {
                // A. SAUDARA (1 UP, 1 DOWN)
                if ($upCount === 1 && $downCount === 1) {
                    $parent = $allPeople[$path[0]['to_id']];
                    $sibling = $target;
                    $siblingType = $this->getSiblingType($start, $sibling);
                    $siblingStatus = $this->getSiblingBiologicalStatus($start, $sibling);
                    $lineageDetail = "{$siblingType} ({$siblingStatus}), terhubung melalui orang tua bersama: {$parent->nama_lengkap}.";
                    $reciprocalType = $this->getSiblingType($sibling, $start);

                    return [
                        'status' => 'success',
                        'primary_label' => $siblingType,
                        'sub_label' => $siblingStatus,
                        'generation_text' => 'Generasi yang Sama (Seangkatan)',
                        'generation_number' => 0,
                        'category' => 'Saudara Kandung / Sebapa / Seibu',
                        'lineage_line' => $lineageDetail,
                        'reciprocal_label' => $reciprocalType,
                        'common_ancestor' => $parent,
                        'connecting_figure' => $parent,
                        'breadcrumbs' => $breadcrumbs,
                    ];
                }

                // B. KEPONAKAN LANGSUNG (1 UP, 2 DOWN) -> "Ponakan garis siapa?"
                if ($upCount === 1 && $downCount === 2) {
                    $parent = $allPeople[$path[0]['to_id']];
                    $sibling = $allPeople[$path[1]['to_id']];
                    $siblingType = $this->getSiblingType($start, $sibling);
                    $siblingStatus = $this->getSiblingBiologicalStatus($start, $sibling);
                    $reciprocal = $this->getMalayUncleAuntTitle($sibling, $start);

                    $lineageDetail = "Keponakan dari garis {$siblingType} ({$siblingStatus}): anak kandung dari {$sibling->nama_lengkap}.";

                    return [
                        'status' => 'success',
                        'primary_label' => "Keponakan ({$genderTargetWord})",
                        'sub_label' => "Garis {$siblingType}: {$sibling->nama_lengkap}",
                        'generation_text' => '1 Generasi di bawah Tokoh Utama',
                        'generation_number' => -1,
                        'category' => 'Kerabat Menyamping (Garis Saudara)',
                        'lineage_line' => $lineageDetail,
                        'reciprocal_label' => $reciprocal,
                        'connecting_figure' => $sibling,
                        'common_ancestor' => $parent,
                        'breadcrumbs' => $breadcrumbs,
                    ];
                }

                // C. CUCU KEPONAKAN (1 UP, 3 DOWN)
                if ($upCount === 1 && $downCount === 3) {
                    $parent = $allPeople[$path[0]['to_id']];
                    $sibling = $allPeople[$path[1]['to_id']];
                    $childOfSibling = $allPeople[$path[2]['to_id']];
                    $siblingType = $this->getSiblingType($start, $sibling);

                    $lineageDetail = "Cucu Keponakan (Generasi ke-2): cucu dari {$sibling->nama_lengkap} ({$siblingType} dari {$start->nama_lengkap}), melalui anaknya: {$childOfSibling->nama_lengkap}.";

                    return [
                        'status' => 'success',
                        'primary_label' => "Cucu Keponakan ({$genderTargetWord})",
                        'sub_label' => "Keturunan Generasi ke-2 dari Garis {$sibling->nama_lengkap}",
                        'generation_text' => '2 Generasi di bawah Tokoh Utama',
                        'generation_number' => -2,
                        'category' => 'Kerabat Menyamping (Keturunan Saudara)',
                        'lineage_line' => $lineageDetail,
                        'reciprocal_label' => $genderStart === 'L' ? 'Datuk Saudara (Kakek Paman)' : 'Nenek Saudara',
                        'connecting_figure' => $sibling,
                        'common_ancestor' => $parent,
                        'breadcrumbs' => $breadcrumbs,
                    ];
                }

                // D. CICIT KEPONAKAN (1 UP, 4 DOWN)
                if ($upCount === 1 && $downCount === 4) {
                    $parent = $allPeople[$path[0]['to_id']];
                    $sibling = $allPeople[$path[1]['to_id']];
                    $siblingType = $this->getSiblingType($start, $sibling);

                    $lineageDetail = "Cicit Keponakan (Generasi ke-3): cicit dari {$sibling->nama_lengkap} ({$siblingType} dari {$start->nama_lengkap}).";

                    return [
                        'status' => 'success',
                        'primary_label' => "Cicit Keponakan ({$genderTargetWord})",
                        'sub_label' => "Keturunan Generasi ke-3 dari Garis {$sibling->nama_lengkap}",
                        'generation_text' => '3 Generasi di bawah Tokoh Utama',
                        'generation_number' => -3,
                        'category' => 'Kerabat Menyamping (Keturunan Saudara)',
                        'lineage_line' => $lineageDetail,
                        'reciprocal_label' => 'Moyang Saudara',
                        'connecting_figure' => $sibling,
                        'common_ancestor' => $parent,
                        'breadcrumbs' => $breadcrumbs,
                    ];
                }

                // E. PAMAN / BIBI ADAT MELAYU (2 UP, 1 DOWN)
                if ($upCount === 2 && $downCount === 1) {
                    $parent = $allPeople[$path[0]['to_id']];
                    $grandparent = $allPeople[$path[1]['to_id']];
                    $uncleAunt = $target;
                    $side = ($path[0]['rel'] === 'UP_FATHER') ? 'Garis Ayah (Paternal)' : 'Garis Ibu (Maternal)';
                    $uncleAuntLabel = $this->getMalayUncleAuntTitle($parent, $uncleAunt);
                    $lineageDetail = "Saudara kandung dari {$parent->nama_lengkap} ({$side}). Titik temu pada Datuk/Nenek: {$grandparent->nama_lengkap}.";

                    return [
                        'status' => 'success',
                        'primary_label' => $uncleAuntLabel,
                        'sub_label' => "Paman/Bibi {$side}",
                        'generation_text' => '1 Generasi di atas Tokoh Utama',
                        'generation_number' => 1,
                        'category' => 'Paman / Bibi (Saudara Orang Tua)',
                        'lineage_line' => $lineageDetail,
                        'reciprocal_label' => 'Keponakan',
                        'connecting_figure' => $parent,
                        'common_ancestor' => $grandparent,
                        'breadcrumbs' => $breadcrumbs,
                    ];
                }

                // F. SEPUPU SEKALI (2 UP, 2 DOWN)
                if ($upCount === 2 && $downCount === 2) {
                    $parent = $allPeople[$path[0]['to_id']];
                    $grandparent = $allPeople[$path[1]['to_id']];
                    $uncleAunt = $allPeople[$path[2]['to_id']];
                    $side = ($path[0]['rel'] === 'UP_FATHER') ? 'Garis Ayah' : 'Garis Ibu';
                    $lineageDetail = "Sepupu Sekali: anak kandung dari {$uncleAunt->nama_lengkap} (saudara dari {$parent->nama_lengkap} pihak {$side}). Titik temu nasab pada Datuk/Nenek bersama: {$grandparent->nama_lengkap}.";

                    return [
                        'status' => 'success',
                        'primary_label' => "Sepupu Sekali ({$genderTargetWord})",
                        'sub_label' => "Garis {$uncleAunt->nama_lengkap} ({$side})",
                        'generation_text' => 'Generasi yang Sama (Seangkatan)',
                        'generation_number' => 0,
                        'category' => 'Kerabat Sepupu (Keturunan Paman/Bibi)',
                        'lineage_line' => $lineageDetail,
                        'reciprocal_label' => "Sepupu Sekali",
                        'connecting_figure' => $uncleAunt,
                        'common_ancestor' => $grandparent,
                        'breadcrumbs' => $breadcrumbs,
                    ];
                }

                // G. KEPONAKAN SEPUPU / ANAK SEPUPU (2 UP, 3 DOWN)
                if ($upCount === 2 && $downCount === 3) {
                    $parent = $allPeople[$path[0]['to_id']];
                    $grandparent = $allPeople[$path[1]['to_id']];
                    $cousin = $allPeople[$path[3]['to_id']];
                    $lineageDetail = "Keponakan Sepupu (Generasi ke-1 di bawah): anak kandung dari sepupu Anda: {$cousin->nama_lengkap}.";

                    return [
                        'status' => 'success',
                        'primary_label' => "Keponakan Sepupu ({$genderTargetWord})",
                        'sub_label' => "Anak dari Sepupu: {$cousin->nama_lengkap}",
                        'generation_text' => '1 Generasi di bawah Tokoh Utama',
                        'generation_number' => -1,
                        'category' => 'Kerabat Sepupu',
                        'lineage_line' => $lineageDetail,
                        'reciprocal_label' => 'Paman Sepupu / Bibi Sepupu',
                        'connecting_figure' => $cousin,
                        'common_ancestor' => $grandparent,
                        'breadcrumbs' => $breadcrumbs,
                    ];
                }

                // H. DATUK SAUDARA / GRAND-UNCLE (3 UP, 1 DOWN)
                if ($upCount === 3 && $downCount === 1) {
                    $parent = $allPeople[$path[0]['to_id']];
                    $grandparent = $allPeople[$path[1]['to_id']];
                    $greatGrandparent = $allPeople[$path[2]['to_id']];
                    $label = $genderTarget === 'L' ? 'Datuk Saudara (Paman Datuk)' : 'Nenek Saudara (Bibi Nenek)';
                    $lineageDetail = "Saudara kandung dari Datuk/Nenek Anda ({$grandparent->nama_lengkap}).";

                    return [
                        'status' => 'success',
                        'primary_label' => $label,
                        'sub_label' => "Garis Leluhur {$grandparent->nama_lengkap}",
                        'generation_text' => '2 Generasi di atas Tokoh Utama',
                        'generation_number' => 2,
                        'category' => 'Kerabat Leluhur Menyamping',
                        'lineage_line' => $lineageDetail,
                        'reciprocal_label' => 'Cucu Saudara (Cucu Keponakan)',
                        'connecting_figure' => $grandparent,
                        'common_ancestor' => $greatGrandparent,
                        'breadcrumbs' => $breadcrumbs,
                    ];
                }

                // I. SEPUPU DUA KALI (3 UP, 3 DOWN)
                if ($upCount === 3 && $downCount === 3) {
                    $greatGrandparent = $allPeople[$path[2]['to_id']];
                    $lineageDetail = "Sepupu Dua Kali: terhubung melalui Moyang (Buyut) bersama: {$greatGrandparent->nama_lengkap}.";

                    return [
                        'status' => 'success',
                        'primary_label' => "Sepupu Dua Kali ({$genderTargetWord})",
                        'sub_label' => "Moyang Bersama: {$greatGrandparent->nama_lengkap}",
                        'generation_text' => 'Generasi yang Sama (Seangkatan)',
                        'generation_number' => 0,
                        'category' => 'Kerabat Sepupu (Garis Moyang)',
                        'lineage_line' => $lineageDetail,
                        'reciprocal_label' => 'Sepupu Dua Kali',
                        'common_ancestor' => $greatGrandparent,
                        'breadcrumbs' => $breadcrumbs,
                    ];
                }
            }
        }

        // KASUS 4: HUBUNGAN PERKAWINAN (AFINITAS / SEMENDA)
        if ($hasSpouse) {
            // Suami / Istri Langsung
            if ($stepCount === 1 && $stepRels[0] === 'SPOUSE') {
                $label = $genderTarget === 'L' ? 'Suami' : 'Istri';
                return [
                    'status' => 'success',
                    'primary_label' => $label,
                    'sub_label' => 'Pasangan Pernikahan Resmi',
                    'generation_text' => 'Generasi yang Sama (Pasangan Hidup)',
                    'generation_number' => 0,
                    'category' => 'Hubungan Perkawinan',
                    'lineage_line' => "Pasangan perkawinan resmi dari {$start->nama_lengkap}.",
                    'reciprocal_label' => $genderStart === 'L' ? 'Suami' : 'Istri',
                    'breadcrumbs' => $breadcrumbs,
                ];
            }

            // Mertua (SPOUSE -> UP)
            if ($stepCount === 2 && $stepRels[0] === 'SPOUSE' && str_starts_with($stepRels[1], 'UP_')) {
                $spouse = $allPeople[$path[0]['to_id']];
                $label = $genderTarget === 'L' ? 'Ayah Mertua' : 'Ibu Mertua';
                return [
                    'status' => 'success',
                    'primary_label' => $label,
                    'sub_label' => "Orang Tua dari {$spouse->nama_lengkap}",
                    'generation_text' => '1 Generasi di atas Tokoh Utama',
                    'generation_number' => 1,
                    'category' => 'Hubungan Perkawinan (Semenda)',
                    'lineage_line' => "Orang tua kandung dari pasangan Anda ({$spouse->nama_lengkap}).",
                    'reciprocal_label' => 'Menantu',
                    'connecting_figure' => $spouse,
                    'breadcrumbs' => $breadcrumbs,
                ];
            }

            // Menantu (DOWN -> SPOUSE)
            if ($stepCount === 2 && $stepRels[0] === 'DOWN' && $stepRels[1] === 'SPOUSE') {
                $child = $allPeople[$path[0]['to_id']];
                $childWord = $child->jenis_kelamin === 'L' ? 'anak laki-laki' : 'anak perempuan';
                return [
                    'status' => 'success',
                    'primary_label' => 'Menantu',
                    'sub_label' => "Pasangan dari {$child->nama_lengkap}",
                    'generation_text' => '1 Generasi di bawah Tokoh Utama',
                    'generation_number' => -1,
                    'category' => 'Hubungan Perkawinan (Semenda)',
                    'lineage_line' => "Suami/Istri dari {$childWord} Anda ({$child->nama_lengkap}).",
                    'reciprocal_label' => $genderStart === 'L' ? 'Ayah Mertua' : 'Ibu Mertua',
                    'connecting_figure' => $child,
                    'breadcrumbs' => $breadcrumbs,
                ];
            }

            // Ipar (SPOUSE -> UP -> DOWN) atau (UP -> DOWN -> SPOUSE)
            if (
                ($stepCount === 3 && $stepRels[0] === 'SPOUSE' && str_starts_with($stepRels[1], 'UP_') && $stepRels[2] === 'DOWN') ||
                ($stepCount === 3 && str_starts_with($stepRels[0], 'UP_') && $stepRels[1] === 'DOWN' && $stepRels[2] === 'SPOUSE')
            ) {
                return [
                    'status' => 'success',
                    'primary_label' => 'Ipar',
                    'sub_label' => 'Hubungan Saudara Semenda',
                    'generation_text' => 'Generasi yang Sama (Seangkatan)',
                    'generation_number' => 0,
                    'category' => 'Hubungan Perkawinan (Semenda)',
                    'lineage_line' => 'Saudara dari pasangan Anda, atau pasangan dari saudara kandung Anda.',
                    'reciprocal_label' => 'Ipar',
                    'breadcrumbs' => $breadcrumbs,
                ];
            }

            // Besan (DOWN -> SPOUSE -> UP)
            if ($stepCount === 3 && $stepRels[0] === 'DOWN' && $stepRels[1] === 'SPOUSE' && str_starts_with($stepRels[2], 'UP_')) {
                return [
                    'status' => 'success',
                    'primary_label' => 'Besan',
                    'sub_label' => 'Orang Tua dari Menantu',
                    'generation_text' => 'Generasi yang Sama (Besan)',
                    'generation_number' => 0,
                    'category' => 'Hubungan Perkawinan (Semenda)',
                    'lineage_line' => 'Orang tua kandung dari menantu Anda.',
                    'reciprocal_label' => 'Besan',
                    'breadcrumbs' => $breadcrumbs,
                ];
            }
        }

        // KASUS UMUM / DEFAULT (JIKA TIDAK MASUK POLA KHUSUS DI ATAS)
        $netGen = 0;
        foreach ($stepRels as $r) {
            if (str_starts_with($r, 'UP_')) $netGen++;
            if ($r === 'DOWN') $netGen--;
        }

        $genSummary = $netGen === 0 ? 'Generasi yang Sama' : ($netGen > 0 ? "{$netGen} Generasi di Atas" : abs($netGen) . " Generasi di Bawah");

        return [
            'status' => 'success',
            'primary_label' => 'Kerabat Keluarga Silsilah',
            'sub_label' => 'Terhubung Jalur Kekerabatan',
            'generation_text' => $genSummary,
            'generation_number' => $netGen,
            'category' => 'Hubungan Kekerabatan Silsilah',
            'lineage_line' => "Terhubung melalui rantai hubungan silsilah ({$stepCount} langkah nasab).",
            'reciprocal_label' => 'Kerabat Keluarga',
            'breadcrumbs' => $breadcrumbs,
        ];
    }

    /**
     * Menentukan sebutan saudara (Abang / Kakak / Adik) berdasarkan usia/urutan.
     */
    private function getSiblingType(Person $from, Person $to): string
    {
        $gender = $to->jenis_kelamin;
        if ($from->tanggal_lahir && $to->tanggal_lahir) {
            if ($to->tanggal_lahir < $from->tanggal_lahir) {
                return $gender === 'L' ? 'Abang' : 'Kakak';
            } else {
                return $gender === 'L' ? 'Adik Laki-laki' : 'Adik Perempuan';
            }
        }
        if ($to->id < $from->id) {
            return $gender === 'L' ? 'Abang (Saudara Lebih Tua)' : 'Kakak (Saudara Lebih Tua)';
        }
        return $gender === 'L' ? 'Adik Laki-laki' : 'Adik Perempuan';
    }

    /**
     * Menentukan status biologis saudara (Sekandung, Sebapa, Seibu).
     */
    private function getSiblingBiologicalStatus(Person $a, Person $b): string
    {
        $sameFather = ($a->father_id && $b->father_id && $a->father_id == $b->father_id);
        $sameMother = ($a->mother_id && $b->mother_id && $a->mother_id == $b->mother_id);

        if ($sameFather && $sameMother) return 'Saudara Sekandung (Satu Ayah, Satu Ibu)';
        if ($sameFather && !$sameMother) return 'Saudara Sebapa (Satu Ayah, Beda Ibu)';
        if (!$sameFather && $sameMother) return 'Saudara Seibu (Satu Ibu, Beda Ayah)';
        return 'Saudara Satu Garis';
    }

    /**
     * Menentukan panggilan paman / bibi berdasarkan adat Melayu (Pak Long/Mak Long, Pak Ngah/Mak Ngah, Pak Cik/Mak Cik).
     */
    private function getMalayUncleAuntTitle(Person $parent, Person $uncleAunt): string
    {
        $isMale = ($uncleAunt->jenis_kelamin === 'L');
        if (!$parent->father_id) {
            return $isMale ? 'Pak Cik (Paman)' : 'Mak Cik (Bibi)';
        }

        $siblings = Person::where('father_id', $parent->father_id)
            ->orderBy('tanggal_lahir', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        $total = $siblings->count();
        $targetIndex = 0;
        foreach ($siblings as $idx => $s) {
            if ($s->id == $uncleAunt->id) {
                $targetIndex = $idx + 1;
                break;
            }
        }

        if ($isMale) {
            if ($targetIndex === 1) return 'Pak Long (Paman Tertua / Sulung)';
            if ($total > 2 && $targetIndex === (int)ceil($total / 2)) return 'Pak Ngah (Paman Tengah)';
            return 'Pak Cik (Paman Termuda / Bungsu)';
        } else {
            if ($targetIndex === 1) return 'Mak Long (Bibi Tertua / Sulung)';
            if ($total > 2 && $targetIndex === (int)ceil($total / 2)) return 'Mak Ngah (Bibi Tengah)';
            return 'Mak Cik (Bibi Termuda / Bungsu)';
        }
    }
}
