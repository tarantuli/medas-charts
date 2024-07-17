<?php

declare(strict_types=1);

namespace Medas\Charts\Legend;

use Medas\Core\RectangleSides;
use Medas\ImageDrawer\{Colors\Color, TextSettings};

class LegendSettings
{
    public Color $backgroundColor;
    public RectangleSides $margin;
    public RectangleSides $padding;
    public int $lineSpacing;
    public TextSettings $labelSettings;
    public string $marker;
    public TextSettings $markerSettings;
    public Location $location;
}
