<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user')->latest();

        // Filter kata kunci pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                  ->orWhere('user_name', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        // Filter berdasarkan modul
        if ($request->filled('module')) {
            $query->where('module', $request->module);
        }

        // Filter berdasarkan aksi
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        $logs = $query->paginate(15)->withQueryString();

        $modules = ActivityLog::distinct()->pluck('module');
        $actions = ActivityLog::distinct()->pluck('action');

        return view('admin.logs.index', compact('logs', 'modules', 'actions'));
    }

    public function clear()
    {
        ActivityLog::truncate();
        return redirect()->route('admin.logs.index')->with('success', 'Seluruh catatan riwayat log aktivitas berhasil dibersihkan.');
    }
}

