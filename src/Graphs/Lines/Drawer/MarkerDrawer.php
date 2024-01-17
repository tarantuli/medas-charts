<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

use Medas\Charts\Graphs\Lines\LineGraph;
use Medas\Charts\Graphs\Markers\Types\{
    CircleMarker,
    CircleMarkerDrawer,
    SquareMarker,
    SquareMarkerDrawer
};
use Medas\Charts\Graphs\YAxisType;
use Medas\Charts\Image\Pixelator;
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class MarkerDrawer
{
    public function __construct(
        private CircleMarkerDrawer $circleMarkerDrawer,
        private Pixelator          $pixelator,
        private SquareMarkerDrawer $squareMarkerDrawer,
    )
    {
    }

    public function draw(Job $job, LineGraph $graph): void
    {
        $chart = $job->chart;
        $xAxis = $chart->xAxis;
        $yAxis = $graph->YAxisType === YAxisType::Y ? $chart->yAxis : $chart->y2Axis;
        $data = $chart->data[$graph->dataName];

        foreach ($data->values() as $key => $value) {
            $x = $this->pixelator->valueToCoordinate($xAxis, $key);
            $y = $this->pixelator->valueToCoordinate($yAxis, $value);

            $this->drawMarker($job, $graph, $x, $y);
        }
    }

    public function drawMarker(Job $job, LineGraph $graph, float $x, float $y): void
    {
        $type = $graph->markerSettings->type ?? $job->chart->markerSettings->type;

        match ($type::class) {
            CircleMarker::class => $this->circleMarkerDrawer->draw($job, $graph, $x, $y),
            SquareMarker::class => $this->squareMarkerDrawer->draw($job, $graph, $x, $y),
        };
    }
}
