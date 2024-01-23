<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

use Medas\Charts\Coordinates\Mapper;
use Medas\Charts\Data\IntervalCalculator;
use Medas\Charts\Graphs\Lines\LineGraph;
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class GapLimitCalculator
{
    public function __construct(
        private IntervalCalculator $intervalCalculator,
        private Mapper             $mapper,
    )
    {
    }

    public function calculate(Job $job, LineGraph $graph): float|null
    {
        $gapLimit = $graph->lineSettings->gapLimit ?? $job->chart->lineSettings->gapLimit;

        if (is_nihil($gapLimit)) {
            return null;
        }

        try {
            return $this->mapper->valueToCoordinate(
                $job->chart->xAxis,
                $gapLimit * $this->intervalCalculator->calculate($job, $graph->seriesName)
            );
        }
        catch (\Exception) {
            return null;
        }
    }
}
