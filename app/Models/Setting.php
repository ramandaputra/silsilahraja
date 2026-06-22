<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function get($key, $default = null)
    {
        // PENGAMAN: Jika tabel belum ada di database, langsung kembalikan nilai default (agar tidak crash)
        if (!Schema::hasTable('settings')) {
            return $default;
        }

        $setting = self::where('key', $key)->first();
        
        // Jika kuncinya ada tapi nilainya kosong di database, pakai nilai default
        return ($setting && !empty($setting->value)) ? $setting->value : $default;
    }
}