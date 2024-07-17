<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Types\Squares;

use Medas\Charts\Colors\ColorGenerator;
use Medas\Charts\Graphs\Lines\LineGraph;
use Medas\Charts\Graphs\Markers\Types\{MarkerType, TypeDrawer};
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;
use Medas\ImageDrawer\Drawers\FilledRectangleDrawer;

#[Service]
readonly class SquareDrawer implements TypeDrawer
{
    public function __construct(
        private ColorGenerator        $colorGenerator,
        private FilledRectangleDrawer $filledRectangleDrawer,
    )
    {
    }

    public function priority(): int
    {
        return 0;
    }

    public function handle(Job $job, LineGraph $graph, MarkerType $type, float $x, float $y): bool
    {
        if (!$type instanceof Square) {
            return false;
        }

        $size = $graph->markerSettings->size ?? $job->chart->markerSettings->size;
        $color = $graph->markerSettings->color ?? $graph->color ?? $this->colorGenerator->generate($job);

        $this->filledRectangleDrawer->draw(
            $job->image,
            $x - $size / 2,
            $y - $size / 2,
            $x + $size / 2,
            $y + $size / 2,
            $color
        );

        return true;
    }
}
