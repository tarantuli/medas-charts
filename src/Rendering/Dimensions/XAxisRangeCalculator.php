<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering\Dimensions;

use Medas\Charts\Axes\CrossWidthCalculator;
use Medas\Charts\Chart;
use Medas\Charts\Image\SizeLock;
use Medas\Charts\Legend\DimensionsCalculator;
use Medas\Charts\Rendering\Exceptions\ImageNotWideEnough;
use Medas\Core\Attributes\Service;

#[Service]
readonly class XAxisRangeCalculator
{
    public function __construct(
        private CrossWidthCalculator $crossWidthCalculator,
        private DimensionsCalculator $legendDimensionsCalculator,
    )
    {
    }

    public function calculate(Chart $chart): void
    {
        /*
         * The width consists of:
         *  - Left padding
         *  - Y axis width
         *  - Chart width
         *  - Secondary Y axis with if applicable
         *  - Legend width if it's positioned in the right margin
         *  - Left padding
         */
        $leftPadding = $chart->imageSettings->padding->left;
        $yAxisWidth = $this->crossWidthCalculator->totalWidth($chart->yAxis);
        $y2AxisWidth = $this->crossWidthCalculator->totalWidth($chart->y2Axis);
        $legendWidth = $this->legendDimensionsCalculator->getWidthInRightMargin($chart);
        $rightPadding = $chart->imageSettings->padding->right;

        if ($chart->imageSettings->sizeLock === SizeLock::ImageSize) {
            $imageWidth = $chart->imageSettings->width;

            $chartWidth = $imageWidth
                - $leftPadding
                - $yAxisWidth
                - $y2AxisWidth
                - $legendWidth
                - $rightPadding;

            if ($chartWidth < 1) {
                throw new ImageNotWideEnough();
            }

            $chart->chartSettings->width = $chartWidth;
        }
        else {
            $chartWidth = $chart->chartSettings->width;

            $imageWidth = $leftPadding
                + $yAxisWidth
                + $y2AxisWidth
                + $chartWidth
                + $legendWidth
                + $rightPadding;

            $chart->imageSettings->width = $imageWidth;
        }

        $chart->grid->xo = $leftPadding + $yAxisWidth;
        $chart->grid->xm = $leftPadding + $yAxisWidth + $chartWidth;
    }
}
