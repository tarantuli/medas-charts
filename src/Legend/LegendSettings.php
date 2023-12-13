<?php

declare(strict_types=1);

namespace Medas\Charts\Legend;

use Medas\Charts\General\{FourSides, TextSettings};
use Medas\ImageManager\Color;

class LegendSettings
{
    public Color $backgroundColor;
    public FourSides $margin;
    public FourSides $padding;
    public int $lineSpacing;
    public TextSettings $labelSettings;
    public string $marker;
    public TextSettings $markerSettings;
    public Location $location;
}
