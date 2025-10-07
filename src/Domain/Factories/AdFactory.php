<?php

declare(strict_types=1);

namespace App\Domain\Factories;

use App\Domain\Entities\Ad;
use App\Domain\ValueObjects\AdDescription;
use App\Domain\ValueObjects\AdGardenSize;
use App\Domain\ValueObjects\AdHouseSize;
use App\Domain\ValueObjects\AdId;
use App\Domain\ValueObjects\AdIrrelevantSince;
use App\Domain\ValueObjects\AdScore;
use App\Domain\ValueObjects\AdTypology;
use DateTimeImmutable;

final class AdFactory
{
    public static function create(
        int                $id,
        string             $typology,
        string             $description,
        array              $pictures,
        int                $houseSize,
        ?int               $gardenSize = null,
        ?int               $score = null,
        ?DateTimeImmutable $irrelevantSince = null
    ): Ad
    {
        return new Ad(
            new AdId($id),
            AdTypology::from($typology),
            new AdDescription($description),
            $pictures,
            new AdHouseSize($houseSize),
            $gardenSize !== null ? new AdGardenSize($gardenSize) : null,
            $score !== null ? new AdScore($score) : null,
            $irrelevantSince !== null ? new AdIrrelevantSince($irrelevantSince) : null
        );
    }
}