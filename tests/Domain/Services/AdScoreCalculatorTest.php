<?php

declare(strict_types=1);

namespace App\Tests\Domain\Services;

use App\Domain\Factories\AdFactory;
use App\Domain\Factories\PictureFactory;
use App\Domain\Services\AdScoreCalculator;
use App\Domain\ValueObjects\AdScore;
use PHPUnit\Framework\TestCase;

final class AdScoreCalculatorTest extends TestCase
{
    private AdScoreCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new AdScoreCalculator();
    }

    /** @dataProvider adDataProvider */
    public function testCalculateScore(array $adData, int $expectedScore): void
    {
        $pictures = [];
        foreach ($adData['pictures'] as $pic) {
            $pictures[] = PictureFactory::create(
                $pic['id'],
                $pic['url'],
                $pic['quality']
            );
        }

        $ad = AdFactory::create(
            $adData['id'],
            $adData['typology'],
            $adData['description'],
            $pictures,
            $adData['houseSize'],
            $adData['gardenSize'] ?? null
        );

        $score = $this->calculator->calculate($ad);

        $this->assertSame($expectedScore, (new AdScore($score))->value());
    }

    public static function adDataProvider(): array
    {
        return [
            [
                [
                    'id' => 1,
                    'typology' => 'CHALET',
                    'description' => 'Este piso es una ganga, compra, compra, COMPRA!!!!!',
                    'pictures' => [],
                    'houseSize' => 300,
                    'gardenSize' => null,
                ],
                5
            ],
            [
                [
                    'id' => 2,
                    'typology' => 'FLAT',
                    'description' => 'Nuevo ático céntrico recién reformado. No deje pasar la oportunidad y adquiera este ático de lujo',
                    'pictures' => [
                        ['id' => 4, 'url' => 'https://example.com/4.jpg', 'quality' => 'HD']
                    ],
                    'houseSize' => 300,
                    'gardenSize' => null,
                ],
                15
            ],
            [
                [
                    'id' => 3,
                    'typology' => 'CHALET',
                    'description' => '',
                    'pictures' => [
                        ['id' => 2, 'url' => 'https://example.com/2.jpg', 'quality' => 'HD']
                    ],
                    'houseSize' => 300,
                    'gardenSize' => null,
                ],
                0
            ],
        ];
    }
}
