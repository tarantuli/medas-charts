<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering\Dimensions;

use Medas\Charts\Axes\CrossWidthCalculator;
use Medas\Charts\Chart;
use Medas\Charts\Image\SizeLock;
use Medas\Charts\Rendering\Exceptions\ImageNotHighEnough;
use Medas\Core\Attributes\Service;

#[Service]
readonly class ImageChartHeightCalculator
{
    public function __construct(
        private Chart\TitleHeightCalculator $titleHeightCalculator,
        private CrossWidthCalculator        $crossWidthCalculator,
    )
    {
    }

    public function calculate(Chart $chart): void
    {
        /*
         * The height consists of:
         *  - Top padding
         *  - Chart title height
         *  - Chart height
         *  - X axis height
         *  - Bottom padding
         */
        $topPadding = $chart->imageSettings->padding->top;
        $chartTitleHeight = $this->titleHeightCalculator->calculate($chart);
        $xAxisHeight = $this->crossWidthCalculator->calculate($chart->xAxis);
        $bottomPadding = $chart->imageSettings->padding->bottom;

        if ($chart->sizeLock === SizeLock::ImageSize) {
            $imageHeight = $chart->imageSettings->height;

            $chartHeight = $imageHeight
                - $topPadding
                - $chartTitleHeight
                - $xAxisHeight
                - $bottomPadding;

            if ($chartHeight < 1) {
                throw new ImageNotHighEnough($imageHeight, $chartHeight);
            }

            $chart->chartSettings->height = (int) $chartHeight;
        }
        else {
            $chartHeight = $chart->chartSettings->height;

            $imageHeight = $topPadding
                + $chartTitleHeight
                + $chartHeight
                + $xAxisHeight
                + $bottomPadding;

            $chart->imageSettings->height = (int) $imageHeight;
        }

        $chart->yAxis->pixelAtOrigin = $chart->grid->yo = $topPadding
            + $chartTitleHeight
            + $chartHeight;

        $chart->yAxis->pixelAtMaxValue = $chart->grid->ym = $topPadding + $chartTitleHeight;
        $chart->yAxis->pixelWidth = $chart->yAxis->pixelAtMaxValue - $chart->yAxis->pixelAtOrigin;
    }
}
