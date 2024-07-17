<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Types\Circles;

use Medas\Charts\Colors\ColorGenerator;
use Medas\Charts\Graphs\Lines\LineGraph;
use Medas\Charts\Graphs\Markers\Types\{MarkerType, TypeDrawer};
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;
use Medas\ImageDrawer\Drawers\FilledCircleDrawer;

#[Service]
readonly class CircleDrawer implements TypeDrawer
{
    public function __construct(
        private ColorGenerator     $colorGenerator,
        private FilledCircleDrawer $filledCircleDrawer,
    )
    {
    }

    public function priority(): int
    {
        return 0;
    }

    public function handle(Job $job, LineGraph $graph, MarkerType $type, float $x, float $y): bool
    {
        if (!$type instanceof Circle) {
            return false;
        }

        $size = $graph->markerSettings->size ?? $job->chart->markerSettings->size;
        $color = $graph->markerSettings->color ?? $graph->color ?? $this->colorGenerator->generate($job);

        $this->filledCircleDrawer->draw($job->image, $x, $y, .5 * $size, $color);

        return true;
    }
}
