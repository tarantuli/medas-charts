<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

abstract class Axis
{
    public AxisSettings $settings;

    // Values
    public float|null $minValue = null;
    public float|null $maxValue = null;
    public float|null $valueRange;

    // Pixels
    public float $pixelAtOrigin;
    public float $pixelAtMaxValue;
    public float $pixelWidth;

    // Interval
    public float $roughInterval;
    public IntervalTypes\IterationType $iterationType;
    public float $interval;

    // Subgrid interval
    public int $subgridCount;
    public float $subgridInterval;

    // Labels
    public int $decimalCount;
    public string|null $dateLabelFormat;
    public /** @var Labels\Label[] */ array $labels;

    // Zero range
    public bool $hasZeroRange;
    public float $hasZeroRangeAt;

    // Block graphs
    public int $barOffset;

    // Categories
    public /** @var float[] */ array $categories;

    // Dimensions
    public float $crossWidth;
}
