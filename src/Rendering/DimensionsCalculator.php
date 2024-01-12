<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering;

use Medas\Charts\{Axes\AxisRangeController, Chart};
use Medas\Core\Attributes\Service;

#[Service]
readonly class DimensionsCalculator
{
    public function __construct(
        private AxisRangeController                   $axisRangeController,
        private Dimensions\ImageChartWidthCalculator  $imageChartWidthCalculator,
        private Dimensions\ImageChartHeightCalculator $imageChartHeightCalculator,
    )
    {
    }

    public function calculate(Chart $chart): void
    {
        // X-axis
        $this->axisRangeController->calculate($chart, $chart->xAxis);

        // Y-axes
        $this->axisRangeController->calculate($chart, $chart->yAxis);
        $this->axisRangeController->calculate($chart, $chart->y2Axis);

        // Image and chart width and height
        $this->imageChartWidthCalculator->calculate($chart);
        $this->imageChartHeightCalculator->calculate($chart);
    }
}
