<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

use Medas\Charts\General\TextSettings;

abstract class Axis
{
    public float|null $min = null;
    public float|null $max = null;
    public float|null $range;

    // Title
    public string|null $title = null;
    public TextSettings $titleSettings;

    // Interval and labels
    public IntervalType $intervalType;
    public float $desiredIntervalCount;
    public float $roughInterval;
    public float $interval;
    public int $subgridCount;
    public float $subgridInterval;
    public int $decimalCount;
    public IterationType $iterationType;

    /** @var int[] */
    public array $normalizationBases;

    public TextSettings $labelSettings;
    public string|null $labelFormat = null;
    public string|null $dateLabelFormat = null;

    // Zero range
    public bool $hasZeroRange;
    public float $hasZeroRangeAt;

    // Block graphs
    public int $barOffset;

    // Categories
    /** @var float[] */
    public array $categories;
}
