<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers;

use Medas\Charts\Coordinates\Mapper;
use Medas\Charts\Data\SeriesManager;
use Medas\Charts\Graphs\{Lines\LineGraph, YAxisType};
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class MarkerDrawer
{
    /** @var Types\TypeDrawer[] */
    private array $typeDrawers;

    public function __construct(
        Types\TypeDrawerManager $drawerManager,
        private Mapper          $mapper,
        private SeriesManager   $seriesManager,
    )
    {
        $this->typeDrawers = $drawerManager->get();
    }

    public function draw(Job $job, LineGraph $graph): void
    {
        $xAxis = $job->chart->xAxis;
        $yAxis = $graph->YAxisType === YAxisType::Y ? $job->chart->yAxis : $job->chart->y2Axis;
        $data = $this->seriesManager->getData($job->chart, $graph->seriesName);

        foreach ($data as $datum) {
            $x = $this->mapper->valueToCoordinate($xAxis, $datum->key);
            $y = $this->mapper->valueToCoordinate($yAxis, $datum->value);

            $this->drawMarker($job, $graph, $x, $y);
        }
    }

    public function drawMarker(Job $job, LineGraph $graph, float $x, float $y): void
    {
        $type = $graph->markerSettings->type ?? $job->chart->markerSettings->type;

        if (array_any($this->typeDrawers, fn($typeDrawer) => $typeDrawer->handle($job, $graph, $type, $x, $y))) {
            return;
        }

        throw new Exceptions\NoHandlerForMarkerTypeFound($type);
    }
}
