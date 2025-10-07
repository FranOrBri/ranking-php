<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

enum AdTypology: string
{
    case CHALET = 'CHALET';
    case FLAT = 'FLAT';
    case GARAGE = 'GARAGE';

    public function label(): string
    {
        return match ($this) {
            self::CHALET => 'Chalet',
            self::FLAT => 'Flat',
            self::GARAGE => 'Garage'
        };
    }
}