<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\IntervalTypes;

use Medas\Charts\{Axes\Axis, Chart, Data\DataManager};
use Medas\Core\Attributes\Service;

#[Service]
readonly class CategorizedController
{
    public function __construct(
        private DataManager $dataManager,
    )
    {
    }

    public function determineMinMax(Chart $chart, Axis $axis): void
    {
        $axis->categories = $this->dataManager->getKeys($chart);
        $axis->minValue = 0;
        $axis->maxValue = count($axis->categories) + 1;
        $axis->interval = 1;
        $axis->subgridInterval = 1;
        $axis->hasZeroRange = false;
    }
}
