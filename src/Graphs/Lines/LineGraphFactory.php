<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines;

use Medas\Charts\Graphs\{Markers\MarkerSettings, YAxisType};
use Medas\Core\Attributes\Service;

#[Service]
readonly class LineGraphFactory
{
    public function create(
        YAxisType   $YAxisType,
        string      $dataName,
        string|null $xName = null,
        string|null $yName = null,
    ): LineGraph
    {
        $graph = new LineGraph($YAxisType, $dataName, $xName, $yName);

        $graph->showLine = true;
        $graph->lineSettings = new LineSettings();
        $graph->showMarkers = true;
        $graph->markerSettings = new MarkerSettings();

        return $graph;
    }
}
