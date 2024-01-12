<?php

declare(strict_types=1);

namespace Medas\Charts\Image\Drawers;

use Medas\Charts\Image\{Colors\ColorManager, Image};
use Medas\Charts\Number;
use Medas\Core\Attributes\Service;
use Medas\ImageManager\Color;

#[Service]
readonly class LineDrawer
{
    public function __construct(
        private ColorManager $colorManager,
    )
    {
    }

    public function draw(
        Image $image,
        float $x1,
        float $y1,
        float $x2,
        float $y2,
        Color $color,
        float $thickness = 1.0
    ): void
    {
        $colorId = $this->colorManager->resolve($image, $color);

        if (Number::areEqual($thickness, 1)) {
            $this->drawStraightLine($image, $x1, $y1, $x2, $y2, $colorId);

            return;
        }

        if (abs($x1 - $x2) < 1 || abs($y1 - $y2) < 1) {
            $this->drawRectangle($image, $x1, $y1, $x2, $y2, $thickness, $colorId);

            return;
        }

        $this->drawPolygon($image, $x1, $y1, $x2, $y2, $thickness, $colorId);
    }

    private function drawStraightLine(Image $image, float $x1, float $y1, float $x2, float $y2, int $colorId): void
    {
        imageline(
            $image->resource,
            (int) round($x1 * $image->scalingFactor),
            (int) round($y1 * $image->scalingFactor),
            (int) round($x2 * $image->scalingFactor),
            (int) round($y2 * $image->scalingFactor),
            $colorId
        );
    }

    private function drawRectangle(
        Image $image,
        float $x1,
        float $y1,
        float $x2,
        float $y2,
        float $thickness,
        int   $colorId
    ): void
    {
        $t = $thickness / 2 - 0.5;

        imagefilledrectangle(
            $image->resource,
            (int) round((min($x1, $x2) - $t) * $image->scalingFactor),
            (int) round((min($y1, $y2) - $t) * $image->scalingFactor),
            (int) round((max($x1, $x2) + $t) * $image->scalingFactor),
            (int) round((max($y1, $y2) + $t) * $image->scalingFactor),
            $colorId
        );
    }

    private function drawPolygon(
        Image $image,
        float $x1,
        float $y1,
        float $x2,
        float $y2,
        float $thickness,
        int   $colorId
    ): void
    {
        $t = $thickness / 2 - 0.5;

        // y = kx + q
        $k = ($y2 - $y1) / ($x2 - $x1);
        $a = $t / sqrt(1 + pow($k, 2)) * $image->scalingFactor;

        $points = [
            round($x1 - (1 + $k) * $a),
            round($y1 + (1 - $k) * $a),
            round($x1 - (1 - $k) * $a),
            round($y1 - (1 + $k) * $a),
            round($x2 + (1 + $k) * $a),
            round($y2 - (1 - $k) * $a),
            round($x2 + (1 - $k) * $a),
            round($y2 + (1 + $k) * $a),
        ];

        imagefilledpolygon($image->resource, $points, 4, $colorId);

        imagepolygon($image->resource, $points, 4, $colorId);
    }
}
