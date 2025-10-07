<?php

declare(strict_types=1);

namespace App\Infrastructure\Controllers;

use App\Application\UseCases\CalculateScoreUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CalculateScoreController extends AbstractController
{
    public function __construct(
        private readonly CalculateScoreUseCase $calculateScoreUseCase
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $qualityAdsDTO = $this->calculateScoreUseCase->execute();

        $response = array_map(fn($qualityAdDTO) => $qualityAdDTO->toArray(), $qualityAdsDTO);

        return new JsonResponse($response, Response::HTTP_OK);
    }
}
