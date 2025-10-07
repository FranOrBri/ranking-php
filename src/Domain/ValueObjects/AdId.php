<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

final class AdId
{
    public function __construct(private readonly int $id)
    {
    }

    public function value(): int
    {
        return $this->id;
    }

    public function __toString(): string
    {
        return (string)$this->id;
    }
}