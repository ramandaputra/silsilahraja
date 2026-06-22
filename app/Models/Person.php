<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';

    protected $fillable = [
        'nama_lengkap',
        'jenis_kelamin',
        'status_pernikahan',
        'nama_pasangan',
        'tempat_lahir',
        'tanggal_lahir',
        'tanggal_wafat',
        'biografi',
        'foto',
        'father_id',
        'mother_id',
        'nama_ibu_non_raja',
    ];

    // 1. Relasi ke Ayah Kandung (Hanya SATU kali)
    public function father()
    {
        return $this->belongsTo(Person::class, 'father_id');
    }

    // 2. Relasi ke Ibu Kandung (Hanya SATU kali)
    public function mother()
    {
        return $this->belongsTo(Person::class, 'mother_id');
    }

    // 3. Relasi ke Anak-anak (Hanya SATU kali)
    public function children()
    {
        return $this->hasMany(Person::class, 'father_id')
                    ->orWhere('mother_id', $this->id)
                    ->orderBy('tanggal_lahir', 'asc');
    }

    // 4. Fitur Otomatis Mencari Nama Ibu jika Ibu dari Luar Kerajaan
    public function getNamaIbuKandungAttribute()
    {
        if ($this->mother) {
            return $this->mother->nama_lengkap;
        }

        if ($this->nama_ibu_non_raja) {
            return $this->nama_ibu_non_raja;
        }

        if ($this->father && $this->father->status_pernikahan === 'Menikah') {
            return $this->father->nama_pasangan;
        }

        return 'Tidak terdata';
    }
}
