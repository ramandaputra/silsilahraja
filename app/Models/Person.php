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
        'gelar_pembeda',
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

    /**
     * Cache internal request untuk daftar nama yang memiliki duplikasi (kembar).
     */
    protected static ?array $cachedDuplicateNames = null;

    /**
     * Cek apakah nama tokoh ini memiliki nama kembar 100% sama dengan tokoh lain.
     */
    public function getHasDuplicateNameAttribute(): bool
    {
        if (static::$cachedDuplicateNames === null) {
            static::$cachedDuplicateNames = static::selectRaw('LOWER(TRIM(nama_lengkap)) as clean_name')
                ->groupBy('clean_name')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('clean_name')
                ->toArray();
        }

        $clean = strtolower(trim($this->nama_lengkap ?? ''));
        return in_array($clean, static::$cachedDuplicateNames, true);
    }

    /**
     * Mengambil daftar tokoh lain yang memiliki nama 100% sama persis.
     */
    public function getTokohNamaSamaAttribute()
    {
        if (!$this->has_duplicate_name) {
            return collect();
        }

        return static::with(['father', 'mother'])
            ->whereRaw('LOWER(TRIM(nama_lengkap)) = ?', [strtolower(trim($this->nama_lengkap))])
            ->where('id', '!=', $this->id)
            ->get();
    }

    /**
     * Nasab tokoh berdasarkan garis keturunan (bin / binti).
     * Contoh: "bin Raja Haji Fisabilillah" atau "binti Raja Ali".
     */
    public function getNasabAttribute(): ?string
    {
        $partikel = ($this->jenis_kelamin === 'P') ? 'binti' : 'Bin';

        if ($this->father && !empty($this->father->nama_lengkap)) {
            return "{$partikel} {$this->father->nama_lengkap}";
        }

        if (!empty($this->nama_ibu_non_raja)) {
            return "{$partikel} {$this->nama_ibu_non_raja}";
        }

        if ($this->mother && !empty($this->mother->nama_lengkap)) {
            return "{$partikel} {$this->mother->nama_lengkap}";
        }

        return null;
    }

    /**
     * Nama lengkap disertai nasab (contoh: "Raja Ja'far bin Raja Haji Fisabilillah").
     */
    public function getNamaNasabAttribute(): string
    {
        if ($this->nasab) {
            return "{$this->nama_lengkap} {$this->nasab}";
        }

        return $this->nama_lengkap;
    }

    /**
     * Pembeda ringkas untuk seleksi di dropdown atau form (contoh: "Bin Raja Haji Fisabilillah" tanpa kurung).
     */
    public function getPembedaRingkasAttribute(): string
    {
        if ($this->nasab) {
            return "{$this->nasab}";
        }

        return "";
    }

    /**
     * Nama tampil dinamis: jika namanya 100% sama dengan tokoh lain,
     * otomatis menyertakan nasab bin/binti (contoh: "Raja Ja'far bin Raja Haji Fisabilillah").
     */
    public function getNamaTampilAttribute(): string
    {
        if ($this->has_duplicate_name && $this->nasab) {
            return "{$this->nama_lengkap} {$this->nasab}";
        }

        return $this->nama_lengkap;
    }

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

    // Helper koleksi anak kandung yang terhubung
    public function getChildrenListAttribute()
    {
        return Person::where('father_id', $this->id)
                     ->orWhere('mother_id', $this->id)
                     ->orderBy('tanggal_lahir', 'asc')
                     ->get();
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
