<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use DateTimeImmutable;
use InvalidArgumentException;

final class AdIrrelevantSince
{
    public function __construct(private readonly DateTimeImmutable $value)
    {
        $now = new DateTimeImmutable();
        if ($this->value > $now) {
            throw new InvalidArgumentException('IrrelevantSince date cannot be in the future.');
        }
    }

    public function value(): DateTimeImmutable
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value->format('Y-m-d H:i:s');
    }
}