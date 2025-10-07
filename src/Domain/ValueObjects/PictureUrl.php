<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

use InvalidArgumentException;

final class PictureUrl
{
    public function __construct(private readonly string $url)
    {
        $url = trim($url);
        if ('' === $url) {
            throw new InvalidArgumentException("Empty url.");
        }
    }

    public function value(): string
    {
        return $this->url;
    }

    public function __toString(): string
    {
        return $this->url;
    }
}