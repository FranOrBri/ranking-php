<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTOs\QualityAdDTO;
use App\Domain\Repositories\AdRepositoryInterface;
use App\Domain\Services\AdScoreCalculator;
use App\Domain\ValueObjects\AdIrrelevantSince;
use App\Domain\ValueObjects\AdScore;
use DateTimeImmutable;

final class CalculateScoreUseCase
{
    public function __construct(
        private readonly AdRepositoryInterface $adRepository,
        private readonly AdScoreCalculator     $adScoreCalculator
    )
    {
    }

    /** @return QualityAdDTO[] */
    public function execute(): array
    {
        $ads = $this->adRepository->findAll();

        foreach ($ads as $ad) {
            $score = $this->adScoreCalculator->calculate($ad);
            $ad->setScore(new AdScore($score));
            if ($score < 40) {
                $ad->setIrrelevantSince(new AdIrrelevantSince(new DateTimeImmutable()));
            }

            $this->adRepository->update($ad);
        }

        return array_map(fn($ad) => QualityAdDTO::fromEntity($ad), $ads);
    }
}
