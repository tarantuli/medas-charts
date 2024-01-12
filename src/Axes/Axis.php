<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

abstract class Axis
{
    public AxisSettings $settings;

    // Range
    public float|null $min = null;
    public float|null $max = null;
    public float|null $range;

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
