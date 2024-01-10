<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering;

use Medas\Charts\{Axes\AxisRangeController, Chart};
use Medas\Core\Attributes\Service;

#[Service]
readonly class DimensionsCalculator
{
    public function __construct(
        private AxisRangeController             $axisRangeController,
        private Dimensions\XAxisRangeCalculator $XAxisRangeCalculator,
        private Dimensions\YAxisRangeCalculator $YAxisRangeCalculator,
    )
    {
    }

    public function calculate(Chart $chart): void
    {
        // X-axis
        $this->axisRangeController->calculate($chart, $chart->xAxis);
        $this->XAxisRangeCalculator->calculate($chart);

        // Y-axes
        $this->axisRangeController->calculate($chart, $chart->yAxis);
        $this->axisRangeController->calculate($chart, $chart->y2Axis);
        $this->YAxisRangeCalculator->calculate($chart);
    }
}
