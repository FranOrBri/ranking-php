<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

enum PictureQuality: string
{
    case SD = 'SD';
    case HD = 'HD';

    public function label(): string
    {
        return match ($this) {
            self::SD => 'Standard Definition',
            self::HD => 'High Definition'
        };
    }
}