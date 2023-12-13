<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs;

use Medas\Charts\{Axes\Axis, Axes\XAxis, Axes\Y2Axis, Axes\YAxis, Chart, Data\DataController};
use Medas\Core\Attributes\Service;

#[Service]
readonly class GraphController
{
    public function __construct(
        private DataController $dataController,
    )
    {
    }

    public function add(
        Chart     $chart,
        string    $dataName,
        string    $graphType,
        array     $graphArguments,
        YAxisType $YAxisType = YAxisType::Y
    ): void
    {
        $graph = new $graphType($YAxisType, $dataName, ...$graphArguments);
        $chart->graphs[] = $graph;
    }

    public function determineMin(Chart $chart, Graph $graph, Axis $axis): float|null
    {
        $this->determineRange2D($chart, $graph);

        if ($axis instanceof YAxis && $graph->YAxisType !== YAxisType::Y) {
            return null;
        }

        if ($axis instanceof Y2Axis && $graph->YAxisType !== YAxisType::Y2) {
            return null;
        }

        if ($axis instanceof XAxis) {
            return $graph->range2D->minX;
        }
        else {
            return $graph->range2D->minY;
        }
    }

    public function determineMax(Chart $chart, Graph $graph, Axis $axis): float|null
    {
        $this->determineRange2D($chart, $graph);

        if ($axis instanceof YAxis && $graph->YAxisType !== YAxisType::Y) {
            return null;
        }

        if ($axis instanceof Y2Axis && $graph->YAxisType !== YAxisType::Y2) {
            return null;
        }

        if ($axis instanceof XAxis) {
            return $graph->range2D->maxX;
        }
        else {
            return $graph->range2D->maxY;
        }
    }

    private function determineRange2D(Chart $chart, Graph $graph): void
    {
        if (isset($graph->range2D)) {
            return;
        }

        $graph->range2D = $this->dataController->determineRange2D($chart, $graph->dataName);
    }
}
