<?php

declare(strict_types=1);

namespace Medas\Charts\Legend\LegendDrawer;

class Coordinates
{
    public function __construct(
        public float $x,
        public float $y,
        public float $width,
        public float $height,
    )
    {
    }
}
