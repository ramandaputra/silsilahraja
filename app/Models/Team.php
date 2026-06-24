<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    /**
     * Kolom-kolom yang diizinkan untuk diisi secara massal saat form disubmit.
     * Sesuai dengan form input nama, peran, deskripsi, foto, kategori, dan posisi urutan.
     */
    protected $fillable = [
        'name',
        'role',
        'description',
        'photo',
        'category',
        'order_position',
    ];
}