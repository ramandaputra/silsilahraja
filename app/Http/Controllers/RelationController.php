<?php

namespace App\Http\Controllers;

use App\Models\Person;
use App\Services\FamilyRelationService;
use Illuminate\Http\Request;

class RelationController extends Controller
{
    protected FamilyRelationService $relationService;

    public function __construct(FamilyRelationService $relationService)
    {
        $this->relationService = $relationService;
    }

    public function index()
    {
        $people = Person::with(['father', 'mother'])->orderBy('nama_lengkap', 'asc')->get();
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

        $analysis = $this->relationService->analyze($personA, $personB);
        $relationLabel = $analysis['primary_label'] ?? 'Hubungan Jauh';

        $people = Person::with(['father', 'mother'])->orderBy('nama_lengkap', 'asc')->get();
        return view('public.relation.index', compact('people', 'personA', 'personB', 'relationLabel', 'analysis'));
    }
}
