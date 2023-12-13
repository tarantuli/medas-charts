<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering;

use Medas\Charts\Chart;
use Medas\Core\Attributes\Service;
use Medas\ImageManager\Image;

#[Service]
readonly class Renderer
{
    public function __construct(
        private DimensionsCalculator $dimensionsCalculator,
    )
    {
    }

    public function render(Chart $chart): Image
    {
        $job = new Job($chart);

        $this->dimensionsCalculator->calculate($chart);

        funcdump($job);

        return $job->image;
    }
}
