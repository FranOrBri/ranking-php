<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Ad;

interface AdRepositoryInterface
{
    /** @return Ad[] */
    public function findAll(): array;

    /** @return Ad[] */
    public function findAllRelevantAds(): array;

    /** @return Ad[] */
    public function findAllIrrelevantAds(): array;

    public function update(Ad $ad): void;
}