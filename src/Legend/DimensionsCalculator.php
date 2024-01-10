<?php

declare(strict_types=1);

namespace Medas\Charts\Legend;

use Medas\Charts\Chart;
use Medas\Core\Attributes\Service;

#[Service]
readonly class DimensionsCalculator
{
    public function getWidthInRightMargin(Chart $chart): float
    {
        // Todo
        return 0.0;
    }
}
