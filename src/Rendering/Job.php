<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering;

use Medas\Charts\{Chart, Image\Image};

class Job
{
    public Image $image;

    public function __construct(
        public readonly Chart $chart,
    )
    {
    }
}
