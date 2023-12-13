<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering;

use Medas\Charts\Chart;
use Medas\Core\Attributes\Service;
use Medas\ImageManager\Image;

#[Service]
readonly class Renderer
{
    public function render(Chart $chart): Image
    {
        diedump($chart);
    }
}
