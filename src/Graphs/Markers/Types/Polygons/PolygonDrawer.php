<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Types\Polygons;

use Medas\Charts\Colors\ColorGenerator;
use Medas\Charts\Graphs\Lines\LineGraph;
use Medas\Charts\Graphs\Markers\Types\{MarkerType, TypeDrawer};
use Medas\Charts\Image\Drawers\FilledPolygonDrawer;
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class PolygonDrawer implements TypeDrawer
{
    public function __construct(
        private ColorGenerator      $colorGenerator,
        private FilledPolygonDrawer $filledPolygonDrawer,
    )
    {
    }

    public function priority(): int
    {
        return 0;
    }

    public function handle(Job $job, LineGraph $graph, MarkerType $type, float $x, float $y): bool
    {
        if (!$type instanceof Polygon) {
            return false;
        }

        $size = $graph->markerSettings->size ?? $job->chart->markerSettings->size;
        $color = $graph->markerSettings->color ?? $graph->color ?? $this->colorGenerator->generate($job);

        $this->filledPolygonDrawer->draw($job->image, $type->points, $x, $y, .6 * $size, $color);

        return true;
    }
}
