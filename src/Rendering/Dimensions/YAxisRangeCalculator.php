<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering\Dimensions;

use Medas\Charts\Axes\CrossWidthCalculator;
use Medas\Charts\Chart;
use Medas\Charts\Image\SizeLock;
use Medas\Charts\Rendering\Exceptions\ImageNotHighEnough;
use Medas\Core\Attributes\Service;

#[Service]
readonly class YAxisRangeCalculator
{
    public function __construct(
        private CrossWidthCalculator        $crossWidthCalculator,
        private Chart\TitleHeightCalculator $titleHeightCalculator,
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
        $xAxisHeight = $this->crossWidthCalculator->totalWidth($chart->xAxis);
        $bottomPadding = $chart->imageSettings->padding->bottom;

        if ($chart->imageSettings->sizeLock === SizeLock::ImageSize) {
            $imageHeight = $chart->imageSettings->height;

            $chartHeight = $imageHeight
                - $topPadding
                - $chartTitleHeight
                - $xAxisHeight
                - $bottomPadding;

            if ($chartHeight < 1) {
                throw new ImageNotHighEnough();
            }

            $chart->chartSettings->height = $chartHeight;
        }
        else {
            $chartHeight = $chart->chartSettings->height;

            $imageHeight = $topPadding
                + $chartTitleHeight
                + $chartHeight
                + $xAxisHeight
                + $bottomPadding;

            $chart->imageSettings->height = $imageHeight;
        }

        $chart->grid->yo = $topPadding + $chartTitleHeight + $chartHeight;
        $chart->grid->ym = $topPadding + $chartTitleHeight;
    }
}
