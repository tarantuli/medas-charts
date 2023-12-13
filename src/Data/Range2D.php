<?php

declare(strict_types=1);

namespace Medas\Charts\Data;

class Range2D
{
    public function __construct(
        public float|null $minX,
        public float|null $maxX,
        public float|null $minY,
        public float|null $maxY,
    )
    {
    }
}
