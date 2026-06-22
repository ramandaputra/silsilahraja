<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    public function index()
    {
        return view('admin.cms.index');
    }

    public function update(Request $request)
    {
        $inputs = $request->except('_token');

        foreach ($inputs as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return back()->with('success', 'Teks halaman beranda berhasil diperbarui!');
    }
}