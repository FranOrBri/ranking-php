<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTOs\QualityAdDTO;
use App\Domain\Repositories\AdRepositoryInterface;

final class QualityListingUseCase
{
    public function __construct(private readonly AdRepositoryInterface $adRepository)
    {
    }

    /** @return QualityAdDTO[] */
    public function execute(): array
    {
        $irrelevantAds = $this->adRepository->findAllIrrelevantAds();

        return array_map(fn($irrelevantAd) => QualityAdDTO::fromEntity($irrelevantAd), $irrelevantAds);
    }
}
