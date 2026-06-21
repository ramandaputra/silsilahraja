<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $guarded = ['id'];

    // Ambil data Ayah
    public function father()
    {
        return $this->belongsTo(Person::class, 'father_id');
    }

    // Ambil data Ibu
    public function mother()
    {
        return $this->belongsTo(Person::class, 'mother_id');
    }

    // Ambil data Anak-anak
    public function children()
    {
        return $this->hasMany(Person::class, 'father_id')
            ->orWhere('mother_id', $this->id);
    }
}
