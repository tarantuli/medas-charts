<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Drawers;

use Medas\Charts\{Graphs\Graph, Rendering\Job};
use Medas\Core\Attributes\Service;

#[Service]
readonly class GraphsDrawer
{
    private array $handlers;

    public function __construct(
        DrawerManager $drawerManager,
    )
    {
        $this->handlers = $drawerManager->get();
    }

    public function draw(Job $job): void
    {
        foreach ($job->chart->graphs as $graph) {
            $this->handleGraph($job, $graph);
        }
    }

    private function handleGraph(Job $job, Graph $graph): void
    {
        if (array_any($this->handlers, fn($handler) => $handler->handle($job, $graph))) {
            return;
        }

        throw new Exceptions\NoDrawerFoundForGraph($graph);
    }
}
