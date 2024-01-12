<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\IntervalTypes;

use Medas\Charts\{Axes\Axis, Number};
use Medas\Core\Attributes\Service;

#[Service]
readonly class DateTimeController
{
    public function determineMinMax(Axis $axis): void
    {
        $axis->roughInterval = ($axis->maxValue - $axis->minValue)
            / $axis->settings->desiredIntervalCount;

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
        $axis->dateLabelFormat = (date('d', $axis->minValue) !== date('d', $axis->maxValue))
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

        $axis->minValue = mktime(
            (int) date('H', $axis->minValue),
            (int) date('i', $axis->minValue),
            $axis->interval * floor(date('s', $axis->minValue) / $axis->interval - $axis->barOffset),
            (int) date('m', $axis->minValue),
            (int) date('d', $axis->minValue),
            (int) date('Y', $axis->minValue)
        );

        $axis->maxValue = mktime(
            (int) date('H', $axis->maxValue),
            (int) date('i', $axis->maxValue),
            $axis->interval * floor(date('s', $axis->maxValue) / $axis->interval + $axis->barOffset),
            (int) date('m', $axis->maxValue),
            (int) date('d', $axis->maxValue),
            (int) date('Y', $axis->maxValue)
        );
    }

    private function determineForLessThanAnHour(Axis $axis): void
    {
        $axis->dateLabelFormat = (date('d', $axis->minValue) !== date('d', $axis->maxValue))
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

        $axis->minValue = mktime(
            (int) date('H', $axis->minValue),
            ($axis->interval / Number::ONE_MINUTE) * floor(date(
                'i',
                $axis->minValue
            ) / ($axis->interval / Number::ONE_MINUTE) - $axis->barOffset),
            0,
            (int) date('m', $axis->minValue),
            (int) date('d', $axis->minValue),
            (int) date('Y', $axis->minValue)
        );

        $axis->maxValue = mktime(
            (int) date('H', $axis->maxValue),
            ($axis->interval / Number::ONE_MINUTE) * ceil(date(
                'i',
                $axis->maxValue
            ) / ($axis->interval / Number::ONE_MINUTE) + $axis->barOffset),
            0,
            (int) date('m', $axis->maxValue),
            (int) date('d', $axis->maxValue),
            (int) date('Y', $axis->maxValue)
        );
    }

    private function determineForLessThanADay(Axis $axis): void
    {
        $axis->dateLabelFormat = (date('d', $axis->minValue) !== date('d', $axis->maxValue))
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

        $axis->minValue = mktime(
            ($axis->interval / Number::ONE_HOUR) * floor(date(
                'H',
                $axis->minValue
            ) / ($axis->interval / Number::ONE_HOUR) - $axis->barOffset),
            0,
            0,
            (int) date('m', $axis->minValue),
            (int) date('d', $axis->minValue),
            (int) date('Y', $axis->minValue)
        );

        $axis->maxValue = mktime(
            ($axis->interval / Number::ONE_HOUR) * ceil(date(
                'H',
                $axis->maxValue
            ) / ($axis->interval / Number::ONE_HOUR) + $axis->barOffset),
            0,
            0,
            (int) date('m', $axis->maxValue),
            (int) date('d', $axis->maxValue),
            (int) date('Y', $axis->maxValue)
        );
    }

    private function determineForLessThanAWeek(Axis $axis): void
    {
        $axis->dateLabelFormat = (date('Y', $axis->minValue) !== date('Y', $axis->maxValue))
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
        $weekdayMin = (int) date('w', $axis->minValue);
        $dtMin = $weekdayMin === 0 ? 6 : $weekdayMin - 1;

        $axis->minValue = mktime(
            0,
            0,
            0,
            (int) date('m', $axis->minValue),
            date('d', $axis->minValue) - $dtMin,
            (int) date('Y', $axis->minValue)
        );

        $dayOffset = (date('H:i:s', $axis->maxValue) > '00:00:00') ? 1 : 0;

        $axis->maxValue = mktime(
            0,
            0,
            0,
            (int) date('m', $axis->maxValue),
            (int) date('d', $axis->maxValue) + $axis->barOffset + $dayOffset,
            (int) date('Y', $axis->maxValue)
        );
    }

    private function determineForLessThanAYear(Axis $axis): void
    {
        $axis->dateLabelFormat = (date('Y', $axis->minValue) !== date('Y', $axis->maxValue))
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

        $axis->minValue = mktime(
            0,
            0,
            0,
            date('m', $axis->minValue) - $axis->barOffset,
            1,
            (int) date('Y', $axis->minValue)
        );

        $axis->maxValue = mktime(
            0,
            0,
            0,
            (int) date('m', $axis->maxValue) + $axis->barOffset + 1,
            0,
            (int) date('Y', $axis->maxValue)
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
        $axis->minValue = mktime(0, 0, 0, 1, 1, date('Y', $axis->minValue) - $axis->barOffset);

        $axis->maxValue = mktime(
            0,
            0,
            0,
            1,
            0,
            (int) date('Y', $axis->maxValue) + $axis->barOffset + 1
        );
    }

    private function normalizeInterval(Axis $axis, float $range): float
    {
        if (Number::isZeroOrLess($range)) {
            $axis->subgridCount = 1;

            return 1;
        }

        $intervalCount = $axis->settings->desiredIntervalCount;
        $bases = $axis->settings->normalizationBases;
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
