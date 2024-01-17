<?php

declare(strict_types=1);

namespace Medas\Charts\Image\Drawers;

use Medas\Charts\Image\{Colors\ColorManager, Image};
use Medas\Core\Attributes\Service;
use Medas\ImageManager\Color;

#[Service]
readonly class FilledCircleDrawer
{
    public function __construct(
        private ColorManager $colorManager,
    )
    {
    }

    public function draw(
        Image $image,
        float $x,
        float $y,
        float $radius,
        Color $color,
        float $excentricity = 1.0
    ): void
    {
        imagefilledarc(
            $image->resource,
            (int) round($x * $image->scalingFactor),
            (int) round($y * $image->scalingFactor),
            (int) round(2 * $radius * $image->scalingFactor),
            (int) round(2 * $radius * $excentricity * $image->scalingFactor),
            0,
            360,
            $this->colorManager->resolve($image, $color),
            IMG_ARC_PIE
        );
    }
}
