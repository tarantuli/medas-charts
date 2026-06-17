<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Drawers;

use Medas\Charts\{Graphs\Graph, Rendering\Job};
use Medas\Core\Interfaces\DeclaresPriority;

interface GraphDrawer extends DeclaresPriority
{
    public function handle(Job $job, Graph $graph): bool;
}
