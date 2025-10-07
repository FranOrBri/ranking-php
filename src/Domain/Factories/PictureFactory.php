<?php

declare(strict_types=1);

namespace App\Domain\Factories;

use App\Domain\Entities\Picture;
use App\Domain\ValueObjects\PictureId;
use App\Domain\ValueObjects\PictureQuality;
use App\Domain\ValueObjects\PictureUrl;

final class PictureFactory
{
    public static function create(
        int $id,
        string $url,
        string $quality
    ): Picture {
        return new Picture(
            new PictureId($id),
            new PictureUrl($url),
            PictureQuality::from($quality)
        );
    }
}