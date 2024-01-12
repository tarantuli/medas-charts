<?php

declare(strict_types=1);

namespace Medas\Charts\Legend;

use Medas\Charts\{Chart, Text\BoundingBoxFactory};
use Medas\Core\Attributes\Service;

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

        foreach ($chart->data as $dataset) {
            $length = $this->boundingBoxFactory->create(
                $dataset->getName(),
                $chart->legendSettings->labelSettings->font,
                $chart->legendSettings->labelSettings->size,
            )->width;

            $maxLength = max($maxLength, $length);
        }

        return $maxLength;
    }
}
