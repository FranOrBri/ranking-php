<?php

declare(strict_types=1);

namespace App\Application\DTOs;

use App\Domain\Entities\Ad;
use DateTimeImmutable;

final class QualityAdDTO
{
    public function __construct(
        private readonly int                $id,
        private readonly string             $typology,
        private readonly string             $description,
        private readonly array              $pictureUrls,
        private readonly int                $houseSize,
        private readonly ?int               $gardenSize = null,
        private readonly ?int               $score = null,
        private readonly ?DateTimeImmutable $irrelevantSince = null,
    )
    {
    }

    public static function fromEntity(Ad $ad): self
    {
        $pictureUrls = array_map(fn($picture) => $picture->getUrl()->value(), $ad->getPictures());

        return new self(
            $ad->getId()->value(),
            $ad->getTypology()->label(),
            $ad->getDescription()->value(),
            $pictureUrls,
            $ad->getHouseSize()->value(),
            $ad->getGardenSize()?->value(),
            $ad->getScore()?->value(),
            $ad->getIrrelevantSince()?->value(),
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'typology' => $this->typology,
            'description' => $this->description,
            'pictureUrls' => $this->pictureUrls,
            'houseSize' => $this->houseSize,
            'gardenSize' => $this->gardenSize,
            'score' => $this->score,
            'irrelevantSince' => $this->irrelevantSince,
        ];
    }
}
