<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class AdHouseSize
{
    public function __construct(private readonly int $houseSize)
    {
        if ($houseSize < 0) {
            throw new InvalidArgumentException('Garden size cannot be negative.');
        }
    }

    public function value(): int
    {
        return $this->houseSize;
    }

    public function __toString(): string
    {
        return (string)$this->houseSize;
    }
}