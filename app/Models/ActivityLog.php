<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'user_role',
        'action',
        'module',
        'description',
        'ip_address',
        'user_agent',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Catat aktivitas pengguna ke dalam database.
     */
    public static function record(string $action, string $module, string $description, ?User $user = null): ?self
    {
        try {
            $currentUser = $user ?? Auth::user();

            return self::create([
                'user_id'     => $currentUser?->id,
                'user_name'   => $currentUser?->name ?? 'Sistem / Anonim',
                'user_role'   => $currentUser?->role ?? 'tamu',
                'action'      => strtoupper($action),
                'module'      => $module,
                'description' => $description,
                'ip_address'  => Request::ip(),
                'user_agent'  => Request::userAgent(),
            ]);
        } catch (\Throwable $e) {
            // Jangan biarkan error logging menghentikan jalannya aplikasi
            report($e);
            return null;
        }
    }
}

