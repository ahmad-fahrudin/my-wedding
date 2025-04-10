<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Undangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_memelai_1',
        'nama_memelai_2',
        'tanggal_acara',
        'waktu_acara',
        'tempat',
        'url_maps',
        'rekening_gift',
    ];

    public function tamu(): HasMany
    {
        return $this->hasMany(Tamu::class);
    }

    public function galeri(): HasMany
    {
        return $this->hasMany(Galeri::class);
    }

    public function ucapan(): HasMany
    {
        return $this->hasMany(Ucapan::class);
    }
}
