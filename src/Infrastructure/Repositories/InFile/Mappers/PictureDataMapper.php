<?php

declare(strict_types=1);

namespace App\Infrastructure\Repositories\InFile\Mappers;

use App\Domain\Entities\Picture;
use App\Domain\Factories\PictureFactory;

final class PictureDataMapper
{
    public static function map(array $rawPicture): Picture
    {
        return PictureFactory::create(
            $rawPicture['id'],
            $rawPicture['url'],
            $rawPicture['quality'],
        );
    }
}