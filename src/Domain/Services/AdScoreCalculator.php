<?php

declare(strict_types=1);

namespace App\Domain\Services;

use App\Domain\Entities\Ad;

final class AdScoreCalculator
{
    private const KEYWORDS = ['luminoso', 'nuevo', 'céntrico', 'reformado', 'ático'];

    public function calculate(Ad $ad): int
    {
        $score = 0;

        $score += $this->getPicturesScore($ad);

        $score += $this->getDescriptionScore($ad);

        $score += $this->completeScore($ad);

        return $score;
    }

    private function getPicturesScore(Ad $ad): int
    {
        if (!$ad->hasPictures()) {
            return -10;
        }

        $picturesScore = 0;
        foreach ($ad->getPictures() as $picture) {
            $picturesScore += ($picture->getQuality()->value === 'HD') ? 20 : 10;
        }

        return $picturesScore;
    }

    private function getDescriptionScore(Ad $ad): int
    {
        if (!$ad->hasDescription()) {
            return 0;
        }

        $descriptionScore = 5;
        $description = mb_strtolower($ad->getDescription()->value());
        $wordCount = str_word_count($description);

        if ($ad->getTypology()->value === 'FLAT') {
            if ($wordCount >= 50) {
                $descriptionScore += 30;
            } elseif ($wordCount >= 20) {
                $descriptionScore += 10;
            }
        } elseif ($ad->getTypology()->value === 'CHALET') {
            if ($wordCount > 50) {
                $descriptionScore += 20;
            }
        }

        foreach (self::KEYWORDS as $word) {
            if (str_contains($description, mb_strtolower($word))) {
                $descriptionScore += 5;
            }
        }

        return $descriptionScore;
    }

    private function completeScore(Ad $ad): int
    {
        return $ad->isComplete() ? 40 : 0;
    }
}
