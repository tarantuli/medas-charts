<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\IntervalTypes;

use Medas\Charts\{Axes\Axis, Chart, Data\DataController};
use Medas\Core\Attributes\Service;

#[Service]
readonly class CategorizedController
{
    public function __construct(
        private DataController $dataController,
    )
    {
    }

    public function determineMinMax(Chart $chart, Axis $axis): void
    {
        $axis->categories = $this->dataController->getXs($chart);
        $axis->min = 0;
        $axis->max = count($axis->categories) + 1;
        $axis->interval = 1;
        $axis->subgridInterval = 1;
        $axis->hasZeroRange = false;
    }
}
