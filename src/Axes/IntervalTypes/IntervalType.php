<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\IntervalTypes;

enum IntervalType
{
    case Numeric;
    case DateTime;
    case Categorized;
}
