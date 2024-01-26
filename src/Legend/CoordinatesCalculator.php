<?php

declare(strict_types=1);

namespace Medas\Charts\Legend;

use Medas\Charts\{Axes\CrossWidthCalculator, Rendering\Job};
use Medas\Core\Attributes\Service;

#[Service]
readonly class CoordinatesCalculator
{
    public function __construct(
        private CrossWidthCalculator $crossWidthCalculator,
        private DimensionsCalculator $dimensionsCalculator,
    )
    {
    }

    public function calculate(Job $job): LegendDrawer\Coordinates
    {
        $xo = $job->chart->grid->xo;
        $yo = $job->chart->grid->yo;
        $xm = $job->chart->grid->xm;
        $ym = $job->chart->grid->ym;
        $width = $this->dimensionsCalculator->width($job->chart);
        $height = $this->dimensionsCalculator->height($job->chart);

        // Determine the top left coordinates of the legend box
        $margins = $job->chart->legendSettings->margin;
        $x = null;
        $y = null;

        switch ($job->chart->legendSettings->location) {
            case Location::BottomLeft:
                $x = $xo + $margins->left;
                $y = $yo - $margins->bottom - $height;

                break;

            case Location::TopLeft:
                $x = $xo + $margins->left;
                $y = $ym + $margins->top;

                break;

            case Location::BottomRight:
                $x = $xm - $margins->right - $width;
                $y = $yo - $margins->bottom - $height;

                break;

            case Location::TopRight:
                $x = $xm - $margins->right - $width;
                $y = $ym + $margins->top;

                break;

            case Location::RightMargin:
                $y2AxisWidth = $this->crossWidthCalculator->calculate($job->chart->y2Axis);
                $x = $xm + $y2AxisWidth + $margins->right;
                $y = $ym;

                break;

            case Location::LeftMargin:
                $yAxisWidth = $this->crossWidthCalculator->calculate($job->chart->yAxis);
                $x = $xo - $yAxisWidth - $margins->right;
                $y = $ym;

                break;
        }

        return new LegendDrawer\Coordinates($x, $y, $width, $height);
    }
}
