<?php

declare(strict_types=1);

namespace App\Infrastructure\Controllers;

use App\Application\UseCases\QualityListingUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class QualityListingController extends AbstractController
{
    public function __construct(
        private readonly QualityListingUseCase $qualityListingUseCase
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $qualityAdsDTO = $this->qualityListingUseCase->execute();

        $response = array_map(fn($qualityAdDTO) => $qualityAdDTO->toArray(), $qualityAdsDTO);

        return new JsonResponse($response, Response::HTTP_OK);
    }
}
