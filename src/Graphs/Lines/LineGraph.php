<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines;

use Medas\Charts\Graphs\{Graph, YAxisType};

class LineGraph extends Graph
{
    public LineSettings $settings;

    public function __construct(
        YAxisType   $YAxisType,
        string      $dataName,
        string|null $xName = null,
        string|null $yName = null,
    )
    {
        parent::__construct($YAxisType, $dataName, $xName, $yName);

        $this->settings = new LineSettings();
    }
}
