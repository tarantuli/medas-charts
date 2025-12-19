<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

use Medas\Charts\Colors\ColorGenerator;
use Medas\Charts\Coordinates\SeriesMapper;
use Medas\Charts\Graphs\{Lines\LineGraph, Markers\MarkerDrawer, YAxisType};
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;
use Medas\ImageDrawer\Drawers\LineDrawer as ImageLineDrawer;

#[Service]
readonly class StraightLineDrawer
{
    public function __construct(
        private ColorGenerator     $colorGenerator,
        private GapLimitCalculator $gapLimitCalculator,
        private ImageLineDrawer    $imageLineDrawer,
        private MarkerDrawer       $markerDrawer,
        private SeriesMapper       $seriesMapper,
    )
    {
    }

    public function draw(Job $job, LineGraph $graph): void
    {
        $chart = $job->chart;
        $drawSquaredLine = $graph->lineSettings->drawSquaredLine ?? $chart->lineSettings->drawSquaredLine;
        $graph->color = $color = $graph->lineSettings->color ?? $graph->color ?? $this->colorGenerator->generate($job);
        $state = new StraightLineDrawerState();

        $coordinates = $this->seriesMapper->mapToCoordinates(
            $job,
            $chart->xAxis,
            $graph->YAxisType === YAxisType::Y ? $chart->yAxis : $chart->y2Axis,
            $chart->dataSeries[$graph->seriesName],
            $graph->lineSettings->subCurveWidth ?? $chart->lineSettings->subCurveWidth
        );

        $gapLimit = $this->gapLimitCalculator->calculate($job, $graph);

        foreach ($coordinates as [$x, $y]) {
            if ($state->prevX !== null
                    && $state->prevY !== null
                    && ($gapLimit === null || $x - $state->prevX <= $gapLimit)) {
                if ($drawSquaredLine) {
                    $this->imageLineDrawer->draw(
                        $job->image,
                        $state->prevX,
                        $state->prevY,
                        $x,
                        $state->prevY,
                        $color
                    );

                    $this->imageLineDrawer->draw($job->image, $x, $state->prevY, $x, $y, $color);
                }
                else {
                    $this->imageLineDrawer->draw(
                        $job->image,
                        $state->prevX,
                        $state->prevY,
                        $x,
                        $y,
                        $color
                    );
                }

                $state->prevXIsUnconnected = false;
            }
            else {
                if ($state->prevXIsUnconnected) {
                    $this->markerDrawer->drawMarker($job, $graph, $state->prevX, $state->prevY);
                }

                $state->prevXIsUnconnected = true;
            }

            $state->prevX = $x;
            $state->prevY = $y;
        }

        if ($state->prevXIsUnconnected) {
            $this->markerDrawer->drawMarker($job, $graph, $state->prevX, $state->prevY);
        }
    }
}
