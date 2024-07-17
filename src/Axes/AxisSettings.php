<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

use Medas\ImageDrawer\{Colors\Color, TextSettings};

class AxisSettings
{
    public Color $color;

    // Title
    public string|null $title = null;
    public bool $showTitle;
    public TextSettings $titleSettings;

    // Interval
    public IntervalTypes\IntervalType $intervalType;
    public float $desiredIntervalCount;
    public /** @var int[] */ array $normalizationBases;

    // Ticks
    public bool $showTicks;
    public float $tickLength;
    public float $tickMargin;

    // Labels
    public TextSettings $labelSettings;
    public string|null $labelFormat = null;
    public bool $showLabels;
}
