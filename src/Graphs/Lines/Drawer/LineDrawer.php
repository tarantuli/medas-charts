<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

use Medas\Charts\Axes\{XAxis, Y2Axis, YAxis};
use Medas\Charts\Colors\ColorGenerator;
use Medas\Charts\Data\{IntervalCalculator, Sources\Series};
use Medas\Charts\Graphs\{Lines\LineGraph, Markers\MarkerDrawer, YAxisType};
use Medas\Charts\Image\{Drawers\LineDrawer as ImageLineDrawer, Mapper};
use Medas\Charts\Number;
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class LineDrawer
{
    public function __construct(
        private ColorGenerator     $colorGenerator,
        private ImageLineDrawer    $imageLineDrawer,
        private IntervalCalculator $intervalCalculator,
        private MarkerDrawer       $markerDrawer,
        private Mapper             $mapper,
    )
    {
    }

    public function draw(Job $job, LineGraph $graph): void
    {
        if ($graph->lineSettings->drawSmoothLine ?? $job->chart->lineSettings->drawSmoothLine) {
            $this->drawSmoothLine($job, $graph);
        }
        else {
            $this->drawStraightLine($job, $graph);
        }
    }

    private function drawSmoothLine(Job $job, LineGraph $graph): void
    {
        // TODO
    }

    private function drawStraightLine(Job $job, LineGraph $graph): void
    {
        $chart = $job->chart;
        $xAxis = $chart->xAxis;
        $yAxis = $graph->YAxisType === YAxisType::Y ? $chart->yAxis : $chart->y2Axis;
        $series = $chart->dataSeries[$graph->seriesName];
        $image = $job->image;
        $drawSquaredLine = $graph->lineSettings->drawSquaredLine ?? $chart->lineSettings->drawSquaredLine;
        $graph->color = $color = $graph->lineSettings->color ?? $graph->color ?? $this->colorGenerator->generate($job);

        // State variables
        $state = new LineDrawerState();

        $values = $this->determineValues(
            $job,
            $graph->lineSettings->subCurveWidth ?? $chart->lineSettings->subCurveWidth,
            $xAxis,
            $series,
            $yAxis
        );

        $gapLimit = $this->determineGapLimit($job, $graph);

        foreach ($values as $set) {
            [$x, $y] = $set;

            if ($state->prevX !== null
                    && $state->prevY !== null
                    && ($gapLimit === null || $x - $state->prevX <= $gapLimit)) {
                if ($drawSquaredLine) {
                    $this->imageLineDrawer->draw(
                        $image,
                        $state->prevX,
                        $state->prevY,
                        $x,
                        $state->prevY,
                        $color
                    );

                    $this->imageLineDrawer->draw($image, $x, $state->prevY, $x, $y, $color);
                }
                else {
                    $this->imageLineDrawer->draw(
                        $image,
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

    private function determineValues(
        Job          $job,
        float        $subcurveWidth,
        XAxis        $xAxis,
        Series       $series,
        Y2Axis|YAxis $yAxis
    ): array
    {
        $values = [];

        if (Number::isMoreThanZero($subcurveWidth)) {
            $newValues = [];
            $halfwidth = $subcurveWidth / 2;

            $spread = $this->mapper->valueToCoordinate($xAxis, $subcurveWidth)
                - $this->mapper->valueToCoordinate($xAxis, 0);

            $maxHeight = 2 / $spread;

            foreach ($job->chart->seriesControllers[$series]->getValues($series) as $key => $value) {
                $center = $this->mapper->valueToCoordinate($xAxis, $key);
                $from = $this->mapper->valueToCoordinate($xAxis, $key - $halfwidth);
                $to = $this->mapper->valueToCoordinate($xAxis, $key + $halfwidth);

                for ($x = ceil($from); $x <= floor($to); ++$x) {
                    $x = (int) $x;

                    if (!isset($newValues[$x])) {
                        $newValues[$x] = 0.0;
                    }

                    $newValues[$x] += $value * $maxHeight * (1 - abs($center - $x) / $spread);
                }
            }

            foreach ($newValues as $x => $value) {
                $values[] = [
                    $x,
                    $this->mapper->valueToCoordinate($yAxis, $value),
                ];
            }
        }
        else {
            foreach ($job->chart->seriesControllers[$series]->getValues($series) as $key => $value) {
                $x = $this->mapper->valueToCoordinate($xAxis, $key);
                $y = $this->mapper->valueToCoordinate($yAxis, $value);
                $values[] = [$x, $y];
            }
        }

        return $values;
    }

    private function determineGapLimit(Job $job, LineGraph $graph): float|null
    {
        $gapLimit = $graph->lineSettings->gapLimit ?? $job->chart->lineSettings->gapLimit;

        if (is_nihil($gapLimit)) {
            return null;
        }

        try {
            return $this->mapper->valueToCoordinate(
                $job->chart->xAxis,
                $gapLimit * $this->intervalCalculator->calculate($job, $graph->seriesName)
            );
        }
        catch (\Exception) {
            return null;
        }
    }
}
