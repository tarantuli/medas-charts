<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs;

use Medas\Charts\Data\Range2D;
use Medas\ImageDrawer\Colors\Color;

abstract class Graph
{
    public Range2D $range2D;
    public Color $color;

    public function __construct(
        public YAxisType   $YAxisType,
        public string      $seriesName,
        public string|null $xName = null,
        public string|null $yName = null,
    )
    {
    }
}
