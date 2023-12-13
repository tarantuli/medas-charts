<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\IntervalTypes;

use Medas\Charts\{Axes\Axis, Number};
use Medas\Core\Attributes\Service;

#[Service]
readonly class NumericController
{
    public function determineMinMax(Axis $axis): void
    {
        $axis->interval = $this->normalizeInterval($axis);
        $axis->subgridInterval = $axis->interval / $axis->subgridCount;

        if (is_nihil($axis->interval)) {
            return;
        }

        $axis->min = (floor($axis->min / $axis->interval + Number::SMALL_POSITIVE) - $axis->barOffset)
            * $axis->interval;

        $axis->max = (floor($axis->max / $axis->interval - Number::SMALL_POSITIVE) + $axis->barOffset + 1)
            * $axis->interval;

        /*
        If both min and max are positive numbers, and min is 20% of max or less, set min to 0
        Likewise if both are negative numbers
        */
        if ($axis->min > 0 && $axis->max > 0 && 5 * $axis->min <= $axis->max) {
            $axis->min = 0;
        }

        if ($axis->min < 0 && $axis->max < 0 && 5 * $axis->max <= $axis->min) {
            $axis->max = 0;
        }
    }

    private function normalizeInterval(Axis $axis): float
    {
        $range = $axis->max - $axis->min;

        if (Number::isZeroOrLess($range)) {
            $axis->subgridCount = 1;

            return 1;
        }

        $power = floor(log($range / $axis->desiredIntervalCount, 10));
        $factor = pow(10, $power);
        $base = null;

        foreach ($axis->normalizationBases as $base) {
            if (Number::isLessThanOrEqual($range, $axis->desiredIntervalCount * $base * $factor)) {
                break;
            }
        }

        if ($range > $axis->desiredIntervalCount * $base * $factor) {
            $base = $axis->normalizationBases[0];
            $factor *= 10;
        }

        $axis->decimalCount = max(0, (int) - log10($factor));
        $axis->subgridCount = $base > 1 ? $base : 2;

        return $base * $factor;
    }
}
