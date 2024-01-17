<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Types\Polygons;

use Medas\Charts\Graphs\Markers\Types\MarkerType;

abstract class Polygon implements MarkerType
{
    public function __construct(
        public readonly int $points,
    )
    {
    }
}
