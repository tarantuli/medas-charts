<?php

declare(strict_types=1);

namespace Medas\Charts\Chart;

use Medas\Charts\{Chart, Text\BoundingBoxFactory};
use Medas\Core\Attributes\Service;

#[Service]
readonly class TitleHeightCalculator
{
    public function __construct(
        private BoundingBoxFactory $boundingBoxFactory,
    )
    {
    }

    public function calculate(Chart $chart): float
    {
        if (isset($chart->titleHeight)) {
            return $chart->titleHeight;
        }

        if (!$chart->chartSettings->showTitle || strlen($chart->chartSettings->title ?? '') === 0) {
            return $chart->titleHeight = 0.0;
        }

        $height = $this->boundingBoxFactory->create(
            $chart->chartSettings->title,
            $chart->chartSettings->titleSettings
        )->height;

        return $chart->titleHeight = $height + $chart->chartSettings->titleSettings->margin;
    }
}
