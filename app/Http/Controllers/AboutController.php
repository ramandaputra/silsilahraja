<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class AboutController extends Controller
{
    public function index()
    {
        // Mengambil statistik riil dari database untuk ditampilkan di bagian counter bawah
        $totalNodes = Person::count();
        $totalFamilies = Person::whereNull('father_id')->whereNull('mother_id')->count();

        return view('public.about', compact('totalNodes', 'totalFamilies'));
    }
}