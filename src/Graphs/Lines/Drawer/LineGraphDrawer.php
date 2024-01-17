<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

use Medas\Charts\Graphs\{Drawers\GraphDrawer, Graph, Lines\LineGraph};
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class LineGraphDrawer implements GraphDrawer
{
    public function __construct(
        private LineDrawer   $lineDrawer,
        private MarkerDrawer $markerDrawer,
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
            $this->lineDrawer->draw($job, $graph);
        }

        if ($graph->showMarkers) {
            $this->markerDrawer->draw($job, $graph);
        }

        return true;
    }
}
