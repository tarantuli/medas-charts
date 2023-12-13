<?php

declare(strict_types=1);

namespace Medas\Charts;

class Number
{
    public const SMALL_POSITIVE = +1e-10;
    public const SMALL_NEGATIVE = -1e-10;

    // Durations in seconds
    public const ONE_DAY = 86400;
    public const ONE_HOUR = 3600;
    public const ONE_MINUTE = 60;
    public const ONE_MONTH = 2678400;
    public const ONE_WEEK = 604800;
    public const ONE_YEAR = 31622400;

    public static function isMoreThanOrEqual(float $a, float $b): bool
    {
        return $a > $b || is_nihil($a - $b);
    }

    public static function isLessThanOrEqual(float $a, float $b): bool
    {
        return $a < $b || is_nihil($a - $b);
    }

    public static function areEqual(float $a, float $b): bool
    {
        return is_nihil($a - $b);
    }

    public static function isZeroOrLess(float $a): bool
    {
        return $a < 0 || is_nihil($a);
    }
}
