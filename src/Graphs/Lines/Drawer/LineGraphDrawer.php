<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

use Medas\Charts\Graphs\{Drawers\GraphDrawer, Graph, Lines\LineGraph, Markers\MarkerDrawer};
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class LineGraphDrawer implements GraphDrawer
{
    public function __construct(
        private SmoothLineDrawer   $smoothLineDrawer,
        private StraightLineDrawer $straightLineDrawer,
        private MarkerDrawer       $markerDrawer,
    )
    {
    }

    public function priority(): int
    {
        return 100;
    }

    public function handle(Job $job, Graph $graph): bool
    {
        if (!$graph instanceof LineGraph) {
            return false;
        }

        if ($graph->showLine) {
            if ($graph->lineSettings->drawSmoothLine ?? $job->chart->lineSettings->drawSmoothLine) {
                $this->smoothLineDrawer->draw($job, $graph);
            }
            else {
                $this->straightLineDrawer->draw($job, $graph);
            }
        }

        if ($graph->showMarkers) {
            $this->markerDrawer->draw($job, $graph);
        }

        return true;
    }
}
