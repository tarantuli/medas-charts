<?php

declare(strict_types=1);

namespace Medas\Charts\Image\Drawers;

use Medas\Charts\Image\{Colors\ColorManager, Image};
use Medas\Core\Attributes\Service;
use Medas\ImageManager\Color;

#[Service]
readonly class FilledRectangleDrawer
{
    public function __construct(
        private ColorManager $colorManager,
    )
    {
    }

    public function draw(Image $image, float $x1, float $y1, float $x2, float $y2, Color $color): void
    {
        imagefilledrectangle(
            $image->resource,
            (int) round($x1 * $image->scalingFactor),
            (int) round($y1 * $image->scalingFactor),
            (int) round($x2 * $image->scalingFactor),
            (int) round($y2 * $image->scalingFactor),
            $this->colorManager->resolve($image, $color),
        );
    }
}
