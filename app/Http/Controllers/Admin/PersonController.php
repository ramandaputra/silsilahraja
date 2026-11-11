<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Person;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class PersonController extends Controller
{
    // 1. Tampilan Daftar Tokoh (Index)
    public function index()
    {
        $people = Person::with(['father', 'mother'])->latest()->paginate(10);
        return view('admin.people.index', compact('people'));
    }

    // 2. Tampilan Form Tambah Anggota (Create)
    public function create(Request $request)
    {
        // Mengambil semua data tokoh untuk pilihan Ayah & Ibu di dropdown form (eager load father & mother)
        $allPeople = Person::with(['father', 'mother'])->orderBy('nama_lengkap', 'asc')->get(); 
        
        $asChildOfId = $request->query('as_child_of'); // ID Orang Tua jika menambah anak ke bawah
        $asParentOfId = $request->query('as_parent_of'); // ID Anak jika menambah orang tua ke atas
        
        $prefilledParent = $asChildOfId ? Person::with(['father', 'mother'])->find($asChildOfId) : null;
        $prefilledChild = $asParentOfId ? Person::with(['father', 'mother'])->find($asParentOfId) : null;
        
        return view('admin.people.create', compact('allPeople', 'prefilledParent', 'prefilledChild'));
    }

    // 3. Proses Simpan Data ke Database (Store)
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'gelar_pembeda' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'status_pernikahan' => 'required|in:Belum Menikah,Menikah',
            'nama_pasangan' => 'nullable|string|max:255',
            'nama_ibu_non_raja' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'father_id' => 'nullable|exists:people,id',
            'mother_id' => 'nullable|exists:people,id',
            'children_ids' => 'nullable|array',
            'children_ids.*' => 'exists:people,id',
        ]);

        $data = $request->except(['children_ids', '_token']);

        // Proses upload foto jika ada
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('people_photos', 'public');
        }

        $person = Person::create($data);

        // Jika alur dari generasi terakhir ke atas (menghubungkan ke anak yang dipilih):
        $childrenIds = $request->input('children_ids', []);
        if (!empty($childrenIds)) {
            $field = ($person->jenis_kelamin === 'L') ? 'father_id' : 'mother_id';
            Person::whereIn('id', $childrenIds)->update([$field => $person->id]);
            
            $childrenNames = Person::whereIn('id', $childrenIds)->pluck('nama_lengkap')->join(', ');
            ActivityLog::record('CREATE', 'Silsilah Tokoh', "Menambahkan tokoh baru: {$person->nama_lengkap} (dihubungkan sebagai orang tua dari: {$childrenNames})");
        } else {
            ActivityLog::record('CREATE', 'Silsilah Tokoh', "Menambahkan tokoh silsilah baru: {$person->nama_lengkap}");
        }

        return redirect()->route('admin.people.index')->with('success', 'Anggota keluarga berhasil ditambahkan!');
    }

    // 4. Tampilan Form Edit (Edit)
    public function edit($id)
    {
        $person = Person::with(['father', 'mother'])->findOrFail($id);
        $allPeople = Person::with(['father', 'mother'])->where('id', '!=', $id)->orderBy('nama_lengkap', 'asc')->get(); // Biar tidak bisa memilih diri sendiri sebagai ortu
        
        // Ambil ID anak-anak yang saat ini terhubung dengan tokoh ini
        $field = ($person->jenis_kelamin === 'L') ? 'father_id' : 'mother_id';
        $currentChildrenIds = Person::where($field, $person->id)->pluck('id')->toArray();
        
        return view('admin.people.edit', compact('person', 'allPeople', 'currentChildrenIds'));
    }

    // 5. Proses Perbarui Data (Update)
    public function update(Request $request, $id)
    {
        $person = Person::findOrFail($id);

        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'gelar_pembeda' => 'nullable|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'status_pernikahan' => 'required|in:Belum Menikah,Menikah',
            'nama_pasangan' => 'nullable|string|max:255',
            'nama_ibu_non_raja' => 'nullable|string|max:255',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'father_id' => 'nullable|exists:people,id',
            'mother_id' => 'nullable|exists:people,id',
            'children_ids' => 'nullable|array',
            'children_ids.*' => 'exists:people,id',
        ]);

        $data = $request->except(['children_ids', 'sync_children', '_token', '_method']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('people_photos', 'public');
        }

        $oldGender = $person->jenis_kelamin;
        $person->update($data);

        // Sinkronisasi relasi anak jika checkbox/pilihan anak diikutsertakan
        if ($request->has('sync_children')) {
            $newGender = $person->jenis_kelamin;
            $newField = ($newGender === 'L') ? 'father_id' : 'mother_id';
            $oldField = ($oldGender === 'L') ? 'father_id' : 'mother_id';
            
            $selectedChildren = $request->input('children_ids', []);

            // Jika gender tokoh berubah, bersihkan relasi di field lama
            if ($oldGender !== $newGender) {
                Person::where($oldField, $person->id)->update([$oldField => null]);
            }

            // Lepaskan anak yang sebelumnya terhubung tetapi sekarang tidak dicentang
            Person::where($newField, $person->id)
                ->whereNotIn('id', $selectedChildren)
                ->update([$newField => null]);

            // Tautkan anak-anak yang baru dicentang
            if (!empty($selectedChildren)) {
                Person::whereIn('id', $selectedChildren)->update([$newField => $person->id]);
            }
        }

        ActivityLog::record('UPDATE', 'Silsilah Tokoh', "Memperbarui data tokoh silsilah: {$person->nama_lengkap}");

        return redirect()->route('admin.people.index')->with('success', 'Data anggota berhasil diperbarui!');
    }

    // 6. Proses Hapus Data (Destroy)
    public function destroy($id)
    {
        $person = Person::findOrFail($id);
        $nama = $person->nama_lengkap;
        $person->delete();

        ActivityLog::record('DELETE', 'Silsilah Tokoh', "Menghapus data tokoh silsilah: {$nama}");

        return redirect()->route('admin.people.index')->with('success', 'Data berhasil dihapus!');
    }
} // <-- Kurung kurawal penutup Class harus berada di paling bawah file!