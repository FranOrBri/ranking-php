<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\InFile;

use App\Domain\Entities\Picture;
use App\Domain\Repositories\PictureRepositoryInterface;
use App\Infrastructure\Repositories\InFile\Mappers\PictureDataMapper;

final class InFilePictureRepository implements PictureRepositoryInterface
{
    private string $filePath;

    public function __construct(string $filePath = __DIR__ . '/Data/pictures.json')
    {
        $this->filePath = $filePath;
    }

    /** @return Picture[] */
    public function findAll(): array
    {
        $rawData = json_decode(file_get_contents($this->filePath), true);
        return array_map(fn(array $raw) => PictureDataMapper::map($raw), $rawData);
    }
}
