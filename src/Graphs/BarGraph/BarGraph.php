<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\BarGraph;

use Medas\Charts\Graphs\{Graph, YAxisType};

class BarGraph extends Graph
{
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
