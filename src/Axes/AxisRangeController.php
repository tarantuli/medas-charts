<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

use Medas\Charts\{Chart, Graphs\GraphController};
use Medas\Core\Attributes\Service;

#[Service]
readonly class AxisRangeController
{
    public function __construct(
        private GraphController                     $graphController,
        private IntervalTypes\NumericController     $numericController,
        private IntervalTypes\CategorizedController $categorizedController,
        private IntervalTypes\DateTimeController    $dateTimeController,
    )
    {
    }

    public function calculate(Chart $chart, Axis $axis): void
    {
        if ($axis->min !== null) {
            return;
        }

        $this->determineMin($chart, $axis);

        if ($axis instanceof Y2Axis && $axis->min === null) {
            return;
        }

        $this->determineMax($chart, $axis);
        $this->checkZeroRange($axis);
        $this->checkForBlockGraphs($axis);
        $this->applyIntervalType($chart, $axis);

        $axis->range = $axis->max - $axis->min;
    }

    private function determineMin(Chart $chart, Axis $axis): void
    {
        if ($axis->min !== null) {
            return;
        }

        $mins = [];

        foreach ($chart->graphs as $graph) {
            $min = $this->graphController->determineMin($chart, $graph, $axis);

            if ($min !== null) {
                $mins[] = $min;
            }
        }

        $axis->min = $mins ? min($mins) : null;
    }

    private function determineMax(Chart $chart, Axis $axis): void
    {
        if ($axis->max !== null) {
            return;
        }

        $maxs = [];

        foreach ($chart->graphs as $graph) {
            $max = $this->graphController->determineMax($chart, $graph, $axis);

            if ($max !== null) {
                $maxs[] = $max;
            }
        }

        $axis->max = $maxs ? max($maxs) : null;
    }

    private function checkZeroRange(Axis $axis): void
    {
        if (is_nihil($axis->max - $axis->min)) {
            $axis->hasZeroRange = true;
            $axis->hasZeroRangeAt = $axis->max;

            ++$axis->max;
        }
    }

    private function checkForBlockGraphs(Axis $axis): void
    {
        // If the X axis contains block graphs, barOffset should be 1 (to add additional space for bar rectangles)
        $axis->barOffset = 0;
    }

    private function applyIntervalType(Chart $chart, Axis $axis): void
    {
        match ($axis->settings->intervalType) {
            IntervalTypes\IntervalType::Numeric => $this->numericController->determineMinMax($axis),
            IntervalTypes\IntervalType::DateTime => $this->dateTimeController->determineMinMax($axis),
            IntervalTypes\IntervalType::Categorized => $this->categorizedController->determineMinMax(
                $chart,
                $axis
            ),
        };
    }
}
