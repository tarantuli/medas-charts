<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering;

use Medas\Charts\Chart;
use Medas\ImageDrawer\Image;

class Job
{
    public Image $image;
    public int $generatedColorCounter = 0;
    public array $seriesIntervals = [];

    public function __construct(
        public readonly Chart $chart,
    )
    {
    }
}
