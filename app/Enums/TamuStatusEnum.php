<?php

namespace App\Enums;

enum TamuStatusEnum: string
{
    case DIUNDANG = 'diundang';
    case HADIR = 'hadir';
    case TIDAKHADIR = 'tidakhadir';

    public function label(): string
    {
        return match ($this) {
            self::DIUNDANG => 'Diundang',
            self::HADIR => 'Hadir',
            self::TIDAKHADIR => 'Tidak Hadir',
        };
    }
}
