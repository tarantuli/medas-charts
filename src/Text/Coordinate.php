<?php

declare(strict_types=1);

namespace Medas\Charts\Text;

enum Coordinate: int
{
    case LowerLeftX = 0;
    case LowerLeftY = 1;
    case LowerRightX = 2;
    case LowerRightY = 3;
    case UpperLeftX = 6;
    case UpperLeftY = 7;
    case UpperRightX = 4;
    case UpperRightY = 5;
}
