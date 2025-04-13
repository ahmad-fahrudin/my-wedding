<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UndanganContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'undangan_id',
        'description_mempelai_1',
        'description_mempelai_2',
        'story_1',
        'story_2',
        'story_3',
        'tgl_story_1',
        'tgl_story_2',
        'tgl_story_3',
        'music'
    ];

    public function undangan()
    {
        return $this->belongsTo(Undangan::class);
    }
}
