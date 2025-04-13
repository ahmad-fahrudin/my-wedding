<?php

namespace App\Models;

use App\Models\UndanganContent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Undangan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_mempelai_1',
        'nama_mempelai_2',
        'tanggal_acara',
        'waktu_acara',
        'tempat',
        'url_maps',
        'rekening',
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

    public function content()
    {
        return $this->hasOne(UndanganContent::class);
    }
}
