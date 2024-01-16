<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Drawers;

use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class GraphsDrawer
{
    public function __construct(
        private DrawerManager $drawerManager,
    )
    {
    }

    public function draw(Job $job): void
    {
        $handlers = $this->drawerManager->get();

        foreach ($job->chart->graphs as $graph) {
            foreach ($handlers as $handler) {
                if ($handler->handle($job, $graph)) {
                    continue 2;
                }
            }

            throw new Exceptions\NoDrawerFoundForGraph($graph);
        }
    }
}
