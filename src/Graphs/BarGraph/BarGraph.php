<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\BarGraph;

use Medas\Charts\Graphs\{Graph, YAxisType};

class BarGraph extends Graph
{
    public function __construct(
        YAxisType   $YAxisType,
        string      $dataName,
        string|null $xName = null,
        string|null $yName = null,
    )
    {
        parent::__construct($YAxisType, $dataName, $xName, $yName);
    }
}
