<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\PictureId;
use App\Domain\ValueObjects\PictureQuality;
use App\Domain\ValueObjects\PictureUrl;

final class Picture
{
    public function __construct(
        private readonly PictureId $id,
        private PictureUrl         $url,
        private PictureQuality     $quality
    )
    {
    }

    public function getId(): PictureId
    {
        return $this->id;
    }

    public function getUrl(): PictureUrl
    {
        return $this->url;
    }

    public function setUrl(PictureUrl $url): void
    {
        $this->url = $url;
    }

    public function getQuality(): PictureQuality
    {
        return $this->quality;
    }

    public function setQuality(PictureQuality $quality): void
    {
        $this->quality = $quality;
    }
}
