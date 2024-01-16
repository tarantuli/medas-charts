<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines;

use Medas\ImageManager\Color;

class LineSettings
{
    public Color $color;
    public float $disconnectLimit;
    public float|int $thickness;
    public float $gapLimit;
    public float $subCurveWidth;
    public bool $drawSmoothLine;
    public bool $drawSquaredLine;
}
