<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering;

use Medas\Charts\{Axes\AxisRangeController, Chart};
use Medas\Core\Attributes\Service;

#[Service]
readonly class DimensionsCalculator
{
    public function __construct(
        private AxisRangeController $axisRangeController,
    )
    {
    }

    public function calculate(Chart $chart): void
    {
        $this->axisRangeController->calculate($chart, $chart->xAxis);
        $this->axisRangeController->calculate($chart, $chart->yAxis);
        $this->axisRangeController->calculate($chart, $chart->y2Axis);
    }
}
