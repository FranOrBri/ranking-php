<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class AdScore
{
    public function __construct(private int $score)
    {
        $this->score = max(0, min(100, $score));
    }

    public function value(): int
    {
        return $this->score;
    }

    public function __toString(): string
    {
        return (string)$this->score;
    }
}
