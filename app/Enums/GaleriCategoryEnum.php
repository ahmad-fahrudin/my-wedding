<?php

namespace App\Enums;

enum GaleriCategoryEnum: string
{
    case HERO = 'hero';
    case COUPLE = 'couple';
    case STORY = 'story';
    case GALLERY = 'gallery';

    public function label(): string
    {
        return match ($this) {
            self::HERO => 'Hero',
            self::COUPLE => 'Couple',
            self::STORY => 'Story',
            self::GALLERY => 'Gallery',
        };
    }
}
