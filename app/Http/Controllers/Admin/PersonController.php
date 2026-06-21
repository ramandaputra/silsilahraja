<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    // 1. Tampilan Daftar Tokoh (Index)
    public function index()
    {
        $people = Person::latest()->paginate(10);
        return view('admin.people.index', compact('people'));
    }

    // 2. Tampilan Form Tambah Anggota (Create)
    public function create()
    {
        // Mengambil semua data tokoh untuk pilihan Ayah & Ibu di dropdown form
        $allPeople = Person::all(); 
        
        return view('admin.people.create', compact('allPeople'));
    }

    // 3. Proses Simpan Data ke Database (Store)
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        // Proses upload foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('people_photos', 'public');
        }

        Person::create($data);

        return redirect()->route('admin.people.index')->with('success', 'Anggota keluarga berhasil ditambahkan!');
    }

    // 4. Tampilan Form Edit (Edit)
    public function edit($id)
    {
        $person = Person::findOrFail($id);
        $allPeople = Person::where('id', '!=', $id)->get(); // Biar tidak bisa memilih diri sendiri sebagai ortu
        
        return view('admin.people.edit', compact('person', 'allPeople'));
    }

    // 5. Proses Perbarui Data (Update)
    public function update(Request $request, $id)
    {
        $person = Person::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('people_photos', 'public');
        }

        $person->update($data);

        return redirect()->route('admin.people.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    // 6. Proses Hapus Data (Destroy)
    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $person->delete();

        return redirect()->route('admin.people.index')->with('success', 'Data berhasil dihapus!');
    }
} // <-- Kurung kurawal penutup Class harus berada di paling bawah file!