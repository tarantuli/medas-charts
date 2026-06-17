<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Types;

use Medas\Charts\Graphs\Lines\LineGraph;
use Medas\Charts\Rendering\Job;
use Medas\Core\Interfaces\DeclaresPriority;

interface TypeDrawer extends DeclaresPriority
{
    public function handle(Job $job, LineGraph $graph, MarkerType $type, float $x, float $y): bool;
}
