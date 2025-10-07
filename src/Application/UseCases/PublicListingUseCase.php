<?php

declare(strict_types=1);

namespace App\Application\UseCases;

use App\Application\DTOs\PublicAdDTO;
use App\Domain\Repositories\AdRepositoryInterface;

final class PublicListingUseCase
{
    public function __construct(private readonly AdRepositoryInterface $adRepository)
    {
    }

    /** @return PublicAdDTO[] */
    public function execute(): array
    {
        $relevantAds = $this->adRepository->findAllRelevantAds();

        return array_map(fn($relevantAd) => PublicAdDTO::fromEntity($relevantAd), $relevantAds);
    }
}

