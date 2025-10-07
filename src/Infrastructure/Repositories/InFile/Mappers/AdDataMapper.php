<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\InFile\Mappers;

use App\Domain\Entities\Ad;
use App\Domain\Entities\Picture;
use App\Domain\Factories\AdFactory;
use DateTimeImmutable;
use Exception;

final class AdDataMapper
{
    /** @param Picture[] $allPictures */
    public static function map(array $rawAd, array $allPictures): Ad
    {
        $pictures = [];
        foreach ($rawAd['pictures'] as $pictureId) {
            $pictures[] = $allPictures[$pictureId];
        }

        $irrelevantSince = null;
        if (null !== $rawAd['irrelevantSince']) {
            try {
                $irrelevantSince = new DateTimeImmutable($rawAd['irrelevantSince']);
            } catch (Exception $e) {
            }
        }

        return AdFactory::create(
            $rawAd['id'],
            $rawAd['typology'],
            $rawAd['description'] ?? '',
            $pictures,
            $rawAd['houseSize'],
            $rawAd['gardenSize'] ?? null,
            $rawAd['score'] ?? null,
            $irrelevantSince
        );
    }
}
