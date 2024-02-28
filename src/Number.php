<?php

declare(strict_types=1);

namespace Medas\Charts;

class Number
{
    /** A very small positive float that's used to compare numbers to zero */
    public const SMALL_POSITIVE = +1e-10;

    /** A very small negative float that's used to compare numbers to zero */
    public const SMALL_NEGATIVE = -1e-10;

    /** The number of seconds in one day */
    public const ONE_DAY = 86400;

    /** The number of seconds in one hour */
    public const ONE_HOUR = 3600;

    /** The number of seconds in one minute */
    public const ONE_MINUTE = 60;

    /** The number of seconds in 31 days */
    public const ONE_MONTH = 2678400;

    /** The number of seconds in one week */
    public const ONE_WEEK = 604800;

    /** The number of seconds in 366 days */
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

    public static function isZeroOrMore(float $a): bool
    {
        return $a > 0 || is_nihil($a);
    }

    public static function isBetweenInclusive(float $left, float $value, float $right): bool
    {
        return self::isMoreThanOrEqual($value, min($left, $right))
            && self::isLessThanOrEqual($value, max($left, $right));
    }

    public static function isMoreThanZero(float $a): bool
    {
        return !is_nihil($a) && $a > 0;
    }
}
