<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

use Medas\ImageManager\Color;

class AxisSettings
{
    public Color $color;
    public string $isOnY2NameMarker;
    public bool $showTicks;
    public float $tickLength;
    public float $tickMargin;
    public bool $showLabels;
    public bool $showTitle;
}
