<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class AdGardenSize
{
    public function __construct(private readonly int $gardenSize)
    {
        if ($gardenSize < 0) {
            throw new InvalidArgumentException('Garden size cannot be negative.');
        }
    }

    public function value(): int
    {
        return $this->gardenSize;
    }

    public function __toString(): string
    {
        return (string)$this->gardenSize;
    }
}