<?php

declare(strict_types=1);

namespace Medas\Charts\Legend;

use Medas\Charts\Chart;
use Medas\Core\Attributes\Service;
use Medas\ImageDrawer\Text\BoundingBoxFactory;

#[Service]
readonly class DimensionsCalculator
{
    public function __construct(
        private BoundingBoxFactory $boundingBoxFactory,
    )
    {
    }

    public function width(Chart $chart): float
    {
        $maxLabelLength = $this->maxLabelLength($chart);

        return $chart->legendSettings->padding->left
            + $chart->legendSettings->markerSettings->size
            + $chart->legendSettings->markerSettings->margin
            + $maxLabelLength
            + $chart->legendSettings->padding->right;
    }

    private function maxLabelLength(Chart $chart): mixed
    {
        $maxLength = 0;

        foreach ($chart->dataSeries as $name => $series) {
            $length = $this->boundingBoxFactory->create(
                $name,
                $chart->legendSettings->labelSettings
            )->width;

            $maxLength = max($maxLength, $length);
        }

        return $maxLength;
    }

    public function height(Chart $chart): float
    {
        $graphCount = count($chart->graphs);

        return $chart->legendSettings->padding->top
            + $graphCount * max(
                $chart->legendSettings->labelSettings->size,
                $chart->legendSettings->markerSettings->size
            )
            + ($graphCount - 1) * $chart->legendSettings->lineSpacing
            + $chart->legendSettings->padding->bottom;
    }
}
