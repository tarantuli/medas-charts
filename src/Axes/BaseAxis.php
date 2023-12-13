<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

use Medas\Charts\General\TextSettings;

abstract class BaseAxis
{
    public float|null $min = null;
    public float|null $max = null;

    // Title
    public string|null $title = null;
    public TextSettings $titleSettings;

    // Interval and labels
    public IntervalType $intervalType;
    public float $desiredIntervalCount;

    /** @var int[] */
    public array $normalizationBases;

    public TextSettings $labelSettings;
    public string|null $labelFormat = null;
}
