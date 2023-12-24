<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\IntervalTypes;

use Medas\Charts\{Axes\Axis, Axes\IterationType, Number};
use Medas\Core\Attributes\Service;

#[Service]
readonly class DateTimeController
{
    public function determineMinMax(Axis $axis): void
    {
        $axis->roughInterval = ($axis->max - $axis->min) / $axis->desiredIntervalCount;

        if ($axis->roughInterval < Number::ONE_MINUTE) {
            $this->determineForLessThanAMinute($axis);
        }
        elseif ($axis->roughInterval < Number::ONE_HOUR) {
            $this->determineForLessThanAnHour($axis);
        }
        elseif ($axis->roughInterval < Number::ONE_DAY) {
            $this->determineForLessThanADay($axis);
        }
        elseif ($axis->roughInterval < Number::ONE_WEEK) {
            $this->determineForLessThanAWeek($axis);
        }
        elseif ($axis->roughInterval < Number::ONE_YEAR) {
            $this->determineForLessThanAYear($axis);
        }
        else {
            $this->determineForAYearOrMore($axis);
        }
    }

    private function determineForLessThanAMinute(Axis $axis): void
    {
        $axis->dateLabelFormat = (date('d', $axis->min) !== date('d', $axis->max))
            ? '%d %b %H:%M'
            : '%H:%M';

        $options = [
            1 => 1,
            2 => 2,
            5 => 5,
            10 => 5,
            30 => 3,
            60 => 6,
        ];

        $axis->interval = $this->getBestInterval($axis->roughInterval, $options);
        $axis->subgridCount = $options[$axis->interval];
        $axis->subgridInterval = $axis->interval / $axis->subgridCount;

        $axis->min = mktime(
            (int) date('H', $axis->min),
            (int) date('i', $axis->min),
            $axis->interval * floor(date('s', $axis->min) / $axis->interval - $axis->barOffset),
            (int) date('m', $axis->min),
            (int) date('d', $axis->min),
            (int) date('Y', $axis->min)
        );

        $axis->max = mktime(
            (int) date('H', $axis->max),
            (int) date('i', $axis->max),
            $axis->interval * floor(date('s', $axis->max) / $axis->interval + $axis->barOffset),
            (int) date('m', $axis->max),
            (int) date('d', $axis->max),
            (int) date('Y', $axis->max)
        );
    }

    private function determineForLessThanAnHour(Axis $axis): void
    {
        $axis->dateLabelFormat = (date('d', $axis->min) !== date('d', $axis->max))
            ? '%d %b %H:%M'
            : '%H:%M';

        $options = [
            60 => 6,
            120 => 4,
            300 => 5,
            600 => 5,
            1200 => 4,
            1800 => 3,
            3600 => 4,
        ];

        $axis->interval = $this->getBestInterval($axis->roughInterval, $options);
        $axis->subgridCount = $options[$axis->interval];
        $axis->subgridInterval = $axis->interval / $axis->subgridCount;

        $axis->min = mktime(
            (int) date('H', $axis->min),
            ($axis->interval / Number::ONE_MINUTE) * floor(date(
                'i',
                $axis->min
            ) / ($axis->interval / Number::ONE_MINUTE) - $axis->barOffset),
            0,
            (int) date('m', $axis->min),
            (int) date('d', $axis->min),
            (int) date('Y', $axis->min)
        );

        $axis->max = mktime(
            (int) date('H', $axis->max),
            ($axis->interval / Number::ONE_MINUTE) * ceil(date(
                'i',
                $axis->max
            ) / ($axis->interval / Number::ONE_MINUTE) + $axis->barOffset),
            0,
            (int) date('m', $axis->max),
            (int) date('d', $axis->max),
            (int) date('Y', $axis->max)
        );
    }

    private function determineForLessThanADay(Axis $axis): void
    {
        $axis->dateLabelFormat = (date('d', $axis->min) !== date('d', $axis->max))
            ? '%d %b %H:%M'
            : '%H:%M';

        $options = [
            3600 => 4,
            7200 => 4,
            14400 => 4,
            21600 => 6,
            43200 => 4,
            86400 => 4,
        ];

        $axis->interval = $this->getBestInterval($axis->roughInterval, $options);
        $axis->subgridCount = $options[$axis->interval];
        $axis->subgridInterval = $axis->interval / $axis->subgridCount;

        if (Number::areEqual($axis->interval / Number::ONE_HOUR, 24)) {
            $axis->dateLabelFormat = '%d %b';
        }

        $axis->min = mktime(
            ($axis->interval / Number::ONE_HOUR) * floor(date(
                'H',
                $axis->min
            ) / ($axis->interval / Number::ONE_HOUR) - $axis->barOffset),
            0,
            0,
            (int) date('m', $axis->min),
            (int) date('d', $axis->min),
            (int) date('Y', $axis->min)
        );

        $axis->max = mktime(
            ($axis->interval / Number::ONE_HOUR) * ceil(date(
                'H',
                $axis->max
            ) / ($axis->interval / Number::ONE_HOUR) + $axis->barOffset),
            0,
            0,
            (int) date('m', $axis->max),
            (int) date('d', $axis->max),
            (int) date('Y', $axis->max)
        );
    }

    private function determineForLessThanAWeek(Axis $axis): void
    {
        $axis->dateLabelFormat = (date('Y', $axis->min) !== date('Y', $axis->max))
            ? '%d %b %Y'
            : '%d %b';

        $options = [
            86400 => 4,
            172800 => 4,
            604800 => 7,
        ];

        $axis->iterationType = IterationType::Daily;
        $axis->interval = $this->getBestInterval($axis->roughInterval, $options);
        $axis->subgridCount = $options[$axis->interval];
        $axis->subgridInterval = $axis->interval / $axis->subgridCount;
        $weekdayMin = (int) date('w', $axis->min);
        $dtMin = $weekdayMin === 0 ? 6 : $weekdayMin - 1;

        $axis->min = mktime(
            0,
            0,
            0,
            (int) date('m', $axis->min),
            date('d', $axis->min) - $dtMin,
            (int) date('Y', $axis->min)
        );

        $dayOffset = (date('H:i:s', $axis->max) > '00:00:00') ? 1 : 0;

        $axis->max = mktime(
            0,
            0,
            0,
            (int) date('m', $axis->max),
            (int) date('d', $axis->max) + $axis->barOffset + $dayOffset,
            (int) date('Y', $axis->max)
        );
    }

    private function determineForLessThanAYear(Axis $axis): void
    {
        $axis->dateLabelFormat = (date('Y', $axis->min) !== date('Y', $axis->max))
            ? '%b %Y'
            : '1 %b';

        $axis->roughInterval /= Number::ONE_MONTH;

        $options = [
            1 => 1,
            2 => 2,
            3 => 3,
            4 => 4,
            6 => 3,
            12 => 4,
        ];

        $axis->interval = $this->getBestInterval($axis->roughInterval, $options);
        $axis->subgridCount = $options[$axis->interval];
        $axis->subgridInterval = $axis->interval / $axis->subgridCount;
        $axis->iterationType = IterationType::Monthly;

        $axis->min = mktime(
            0,
            0,
            0,
            date('m', $axis->min) - $axis->barOffset,
            1,
            (int) date('Y', $axis->min)
        );

        $axis->max = mktime(
            0,
            0,
            0,
            (int) date('m', $axis->max) + $axis->barOffset + 1,
            0,
            (int) date('Y', $axis->max)
        );
    }

    private function getBestInterval(float $interval, array $options): int
    {
        foreach ($options as $option => $dump) {
            if ($option > $interval) {
                return $option;
            }
        }

        return 1;
    }

    private function determineForAYearOrMore(Axis $axis): void
    {
        $axis->dateLabelFormat = '%Y';
        $axis->roughInterval /= Number::ONE_YEAR;
        $axis->interval = $this->normalizeInterval($axis, $axis->roughInterval);
        $axis->subgridInterval = $axis->interval / $axis->subgridCount;
        $axis->iterationType = IterationType::Yearly;
        $axis->min = mktime(0, 0, 0, 1, 1, date('Y', $axis->min) - $axis->barOffset);
        $axis->max = mktime(0, 0, 0, 1, 0, (int) date('Y', $axis->max) + $axis->barOffset + 1);
    }

    private function normalizeInterval(Axis $axis, float $range): float
    {
        if (Number::isZeroOrLess($range)) {
            $axis->subgridCount = 1;

            return 1;
        }

        $intervalCount = $axis->desiredIntervalCount;
        $bases = $axis->normalizationBases;
        $power = floor(log($range / $intervalCount, 10));
        $factor = pow(10, $power);
        $base = null;

        foreach ($bases as $base) {
            if (Number::isLessThanOrEqual($range, $intervalCount * $base * $factor)) {
                break;
            }
        }

        if ($range > $intervalCount * $base * $factor) {
            $base = $bases[0];
            $factor *= 10;
        }

        $axis->decimalCount = max(0, -log10($factor));
        $axis->subgridCount = $base > 1 ? $base : 2;

        return $base * $factor;
    }
}
