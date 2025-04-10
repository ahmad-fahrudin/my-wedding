<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tamu extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'undangan_id',
        'nama_tamu',
        'status',
    ];

    public function undangan(): BelongsTo
    {
        return $this->belongsTo(Undangan::class);
    }
}
