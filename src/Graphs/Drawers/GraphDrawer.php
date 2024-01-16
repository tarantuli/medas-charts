<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Drawers;

use Medas\Charts\{Graphs\Graph, Rendering\Job};

interface GraphDrawer
{
    /** Higher values are checked first */
    public function priority(): int;

    public function handle(Job $job, Graph $graph): bool;
}
