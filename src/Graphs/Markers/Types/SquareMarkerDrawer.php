<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Types;

use Medas\Charts\Graphs\Lines\LineGraph;
use Medas\Charts\Image\Drawers\FilledRectangleDrawer;
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class SquareMarkerDrawer
{
    public function __construct(
        private FilledRectangleDrawer $filledRectangleDrawer,
    )
    {
    }

    public function draw(Job $job, LineGraph $graph, float $x, float $y): void
    {
        $size = $graph->markerSettings->size ?? $job->chart->markerSettings->size;
        $color = $graph->markerSettings->color ?? $job->chart->markerSettings->color;

        $this->filledRectangleDrawer->draw(
            $job->image,
            $x - $size / 2,
            $y - $size / 2,
            $x + $size / 2,
            $y + $size / 2,
            $color
        );
    }
}
