<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class AdDescription
{
    public function __construct(private readonly string $description)
    {
    }

    public function value(): string
    {
        return $this->description;
    }

    public function __toString(): string
    {
        return $this->description;
    }
}