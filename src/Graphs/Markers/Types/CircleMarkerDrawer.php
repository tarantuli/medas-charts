<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Types;

use Medas\Charts\Graphs\Lines\LineGraph;
use Medas\Charts\Image\Drawers\FilledCircleDrawer;
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class CircleMarkerDrawer
{
    public function __construct(
        private FilledCircleDrawer $filledCircleDrawer,
    )
    {
    }

    public function draw(Job $job, LineGraph $graph, float $x, float $y): void
    {
        $size = $graph->markerSettings->size ?? $job->chart->markerSettings->size;
        $color = $graph->markerSettings->color ?? $job->chart->markerSettings->color;

        $this->filledCircleDrawer->draw($job->image, $x, $y, $size / 2, $color);
    }
}
