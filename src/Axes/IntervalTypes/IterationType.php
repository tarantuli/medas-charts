<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\IntervalTypes;

enum IterationType
{
    case Daily;
    case Linear;
    case Monthly;
    case Yearly;
}
