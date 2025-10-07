<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\AdDescription;
use App\Domain\ValueObjects\AdGardenSize;
use App\Domain\ValueObjects\AdHouseSize;
use App\Domain\ValueObjects\AdId;
use App\Domain\ValueObjects\AdIrrelevantSince;
use App\Domain\ValueObjects\AdScore;
use App\Domain\ValueObjects\AdTypology;

final class Ad
{
    /** @param Picture[] $pictures */
    public function __construct(
        private readonly AdId      $id,
        private AdTypology         $typology,
        private AdDescription      $description,
        private array              $pictures,
        private AdHouseSize        $houseSize,
        private ?AdGardenSize      $gardenSize = null,
        private ?AdScore           $score = null,
        private ?AdIrrelevantSince $irrelevantSince = null
    )
    {
    }

    public function getId(): AdId
    {
        return $this->id;
    }

    public function getTypology(): AdTypology
    {
        return $this->typology;
    }

    public function setTypology(AdTypology $typology): void
    {
        $this->typology = $typology;
    }

    public function getDescription(): AdDescription
    {
        return $this->description;
    }

    public function setDescription(AdDescription $description): void
    {
        $this->description = $description;
    }

    public function getPictures(): array
    {
        return $this->pictures;
    }

    public function setPictures(array $pictures): void
    {
        $this->pictures = $pictures;
    }

    public function getHouseSize(): AdHouseSize
    {
        return $this->houseSize;
    }

    public function setHouseSize(AdHouseSize $houseSize): void
    {
        $this->houseSize = $houseSize;
    }

    public function getGardenSize(): ?AdGardenSize
    {
        return $this->gardenSize;
    }

    public function setGardenSize(?AdGardenSize $gardenSize): void
    {
        $this->gardenSize = $gardenSize;
    }

    public function getScore(): ?AdScore
    {
        return $this->score;
    }

    public function setScore(?AdScore $score): void
    {
        $this->score = $score;
    }

    public function getIrrelevantSince(): ?AdIrrelevantSince
    {
        return $this->irrelevantSince;
    }

    public function setIrrelevantSince(?AdIrrelevantSince $irrelevantSince): void
    {
        $this->irrelevantSince = $irrelevantSince;
    }

    public function hasPictures(): bool
    {
        return [] === $this->pictures;
    }

    public function hasDescription(): bool
    {
        return trim($this->description?->value() ?? '') !== '';
    }

    public function hasHouseSize(): bool
    {
        return $this->houseSize?->value() !== null;
    }

    public function hasGardenSize(): bool
    {
        return $this->gardenSize?->value() !== null;
    }

    public function isComplete(): bool
    {
        return match ($this->typology->value) {
            'FLAT'   => $this->hasPictures() && $this->hasDescription() && $this->hasHouseSize(),
            'CHALET' => $this->hasPictures() && $this->hasDescription() && $this->hasHouseSize() && $this->hasGardenSize(),
            'GARAGE' => $this->hasPictures(),
            default  => false,
        };
    }
}
