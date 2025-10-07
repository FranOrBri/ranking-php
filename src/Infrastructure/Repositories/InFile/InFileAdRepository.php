<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\InFile;

use App\Domain\Entities\Ad;
use App\Domain\Entities\Picture;
use App\Domain\Repositories\AdRepositoryInterface;
use App\Infrastructure\Repositories\InFile\Mappers\AdDataMapper;

final class InFileAdRepository implements AdRepositoryInterface
{
    private string $filePath;
    private InFilePictureRepository $picturesRepository;

    public function __construct(InFilePictureRepository $picturesRepository, string $filePath = __DIR__ . '/Data/ads.json')
    {
        $this->picturesRepository = $picturesRepository;
        $this->filePath = $filePath;
    }

    /** @return Ad[] */
    public function findAll(): array
    {
        $pictures = $this->loadPictures();
        $rawData = json_decode(file_get_contents($this->filePath), true);

        return array_map(fn(array $rawAd) => AdDataMapper::map($rawAd, $pictures), $rawData);
    }

    /** @return Picture[] */
    private function loadPictures(): array
    {
        $pictures = [];
        foreach ($this->picturesRepository->findAll() as $picture) {
            $pictures[$picture->getId()->value()] = $picture;
        }
        return $pictures;
    }

    /** @return Ad[] */
    public function findAllRelevantAds(): array
    {
        $ads = $this->findAll();
        $relevantAds = array_filter($ads, fn(Ad $ad) => ($ad->getScore()?->value() ?? 0) >= 40);
        usort($relevantAds, fn(Ad $a, Ad $b) => $b->getScore()->value() <=> $a->getScore()->value());
        return $relevantAds;
    }

    /** @return Ad[] */
    public function findAllIrrelevantAds(): array
    {
        $ads = $this->findAll();
        return array_filter($ads, fn(Ad $ad) => ($ad->getScore()?->value() ?? 0) < 40);
    }

    public function update(Ad $ad): void
    {
        $ads = [];
        foreach ($this->findAll() as $oldAd) {
            $ads[$oldAd->getId()->value()] = $oldAd;
        }
        $ads[$ad->getId()->value()] = $ad;

        $this->persist($ads);
    }

    /** @param Ad[] $ads */
    private function persist(array $ads): void
    {
        $data = array_map(fn(Ad $ad) => [
            'id' => $ad->getId()->value(),
            'typology' => $ad->getTypology()->value,
            'description' => $ad->getDescription()?->value() ?? '',
            'pictures' => array_map(fn(Picture $pic) => $pic->getId()->value(), $ad->getPictures()),
            'houseSize' => $ad->getHouseSize()?->value(),
            'gardenSize' => $ad->getGardenSize()?->value(),
            'score' => $ad->getScore()?->value(),
            'irrelevantSince' => $ad->getIrrelevantSince()?->value()?->format(DATE_ATOM),
        ], $ads);

        file_put_contents($this->filePath, json_encode(array_values($data), JSON_PRETTY_PRINT));
    }
}
