<?php

declare(strict_types=1);

namespace App\Infrastructure\Controllers;

use App\Application\UseCases\PublicListingUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class PublicListingController extends AbstractController
{
    public function __construct(
        private readonly PublicListingUseCase $publicListingUseCase
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $publicAdsDTO = $this->publicListingUseCase->execute();

        $response = array_map(fn($publicAdDTO) => $publicAdDTO->toArray(), $publicAdsDTO);
        return new JsonResponse($response, Response::HTTP_OK);
    }
}
