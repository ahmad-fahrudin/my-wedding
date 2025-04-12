<?php

namespace App\Enums;

enum GaleriTypeEnum: string
{
    case TEMA1 = 'tema1';
    case TEMA2 = 'tema2';

    public function label(): string
    {
        return match ($this) {
            self::TEMA1 => 'Tema 1',
            self::TEMA2 => 'Tema 2',
        };
    }
}
