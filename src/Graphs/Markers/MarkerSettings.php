<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers;

use Medas\ImageDrawer\Colors\Color;

class MarkerSettings
{
    public float|int $size;
    public Types\MarkerType $type;
    public Color $color;
}
