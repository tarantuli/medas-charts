<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

enum IntervalType
{
    case Numeric;
    case DateTime;
    case Categories;
}
