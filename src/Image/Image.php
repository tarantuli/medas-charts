<?php

declare(strict_types=1);

namespace Medas\Charts\Image;

class Image
{
    public array $colors = [];

    public function __construct(
        public \GdImage $resource,
        public float    $scalingFactor,
    )
    {
    }
}
