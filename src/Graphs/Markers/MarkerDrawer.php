<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers;

use Medas\Charts\Data\SeriesManager;
use Medas\Charts\Graphs\{Lines\LineGraph, YAxisType};
use Medas\Charts\Image\Mapper;
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class MarkerDrawer
{
    /** @var Types\TypeDrawer[] */
    private array $typeDrawers;

    public function __construct(
        private SeriesManager   $seriesManager,
        private Mapper          $mapper,
        Types\TypeDrawerManager $drawerManager,
    )
    {
        $this->typeDrawers = $drawerManager->get();
    }

    public function draw(Job $job, LineGraph $graph): void
    {
        $xAxis = $job->chart->xAxis;
        $yAxis = $graph->YAxisType === YAxisType::Y ? $job->chart->yAxis : $job->chart->y2Axis;
        $values = $this->seriesManager->getValues($job->chart, $graph->seriesName);

        foreach ($values as $key => $value) {
            $x = $this->mapper->valueToCoordinate($xAxis, $key);
            $y = $this->mapper->valueToCoordinate($yAxis, $value);

            $this->drawMarker($job, $graph, $x, $y);
        }
    }

    public function drawMarker(Job $job, LineGraph $graph, float $x, float $y): void
    {
        $type = $graph->markerSettings->type ?? $job->chart->markerSettings->type;

        foreach ($this->typeDrawers as $typeDrawer) {
            if ($typeDrawer->handle($job, $graph, $type, $x, $y)) {
                return;
            }
        }

        throw new Exceptions\NoHandlerForMarkerTypeFound($type);
    }
}
