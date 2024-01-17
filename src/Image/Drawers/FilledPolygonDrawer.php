<?php

declare(strict_types=1);

namespace Medas\Charts\Image\Drawers;

use Medas\Charts\Image\{Colors\ColorManager, Image};
use Medas\Core\Attributes\Service;
use Medas\ImageManager\Color;

#[Service]
readonly class FilledPolygonDrawer
{
    public function __construct(
        private ColorManager $colorManager,
    )
    {
    }

    public function draw(Image $image, int $edges, float $x, float $y, float $radius, Color $color): void
    {
        $points = [];

        for ($e = 0; $e < $edges; ++$e) {
            $phi = $e * 2 * pi() / $edges;
            $points[] = ($x + $radius * sin($phi)) * $image->scalingFactor;
            $points[] = ($y - $radius * cos($phi)) * $image->scalingFactor;
        }

        imagefilledpolygon($image->resource, $points, $this->colorManager->resolve($image, $color));
    }
}
