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
        private IntervalTypes\CategorizedController $categorizedController,
        private IntervalTypes\DateTimeController    $dateTimeController,
        private IntervalTypes\NumericController     $numericController,
    )
    {
    }

    public function calculate(Chart $chart, Axis $axis): void
    {
        if ($axis->minValue !== null) {
            return;
        }

        $this->determineMin($chart, $axis);

        if ($axis instanceof Y2Axis && $axis->minValue === null) {
            return;
        }

        $this->determineMax($chart, $axis);
        $this->checkZeroRange($axis);
        $this->checkForBlockGraphs($axis);
        $this->applyIntervalType($chart, $axis);

        $axis->valueRange = $axis->maxValue - $axis->minValue;
    }

    private function determineMin(Chart $chart, Axis $axis): void
    {
        if ($axis->minValue !== null) {
            return;
        }

        $mins = [];

        foreach ($chart->graphs as $graph) {
            $min = $this->graphController->determineMin($chart, $graph, $axis);

            if ($min !== null) {
                $mins[] = $min;
            }
        }

        $axis->minValue = $mins ? min($mins) : null;
    }

    private function determineMax(Chart $chart, Axis $axis): void
    {
        if ($axis->maxValue !== null) {
            return;
        }

        $maxs = [];

        foreach ($chart->graphs as $graph) {
            $max = $this->graphController->determineMax($chart, $graph, $axis);

            if ($max !== null) {
                $maxs[] = $max;
            }
        }

        $axis->maxValue = $maxs ? max($maxs) : null;
    }

    private function checkZeroRange(Axis $axis): void
    {
        if (is_nihil($axis->maxValue - $axis->minValue)) {
            $axis->hasZeroRange = true;
            $axis->hasZeroRangeAt = $axis->maxValue ?? 0.0;

            ++$axis->maxValue;
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
