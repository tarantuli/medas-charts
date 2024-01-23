<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines;

use Medas\Charts\Graphs\{Graph, Markers\MarkerSettings, YAxisType};

class LineGraph extends Graph
{
    public bool $showLine;
    public LineSettings $lineSettings;
    public bool $showMarkers;
    public MarkerSettings $markerSettings;

    public function __construct(
        YAxisType   $YAxisType,
        string      $seriesName,
        string|null $xName = null,
        string|null $yName = null,
    )
    {
        parent::__construct($YAxisType, $seriesName, $xName, $yName);
    }
}
