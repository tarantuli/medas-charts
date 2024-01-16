<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

use Medas\Charts\Axes\{XAxis, Y2Axis, YAxis};
use Medas\Charts\Chart;
use Medas\Charts\Data\{Data, IntervalCalculator};
use Medas\Charts\Graphs\{Lines\LineGraph, YAxisType};
use Medas\Charts\Image\{Drawers\LineDrawer as ImageLineDrawer, Pixelator};
use Medas\Charts\Number;
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class LineDrawer
{
    public function __construct(
        private ImageLineDrawer    $imageLineDrawer,
        private IntervalCalculator $intervalCalculator,
        private MarkerDrawer       $markerDrawer,
        private Pixelator          $pixelator,
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
        $data = $chart->data[$graph->dataName];
        $image = $job->image;
        $drawSquaredLine = $graph->lineSettings->drawSquaredLine ?? $chart->lineSettings->drawSquaredLine;
        $color = $graph->lineSettings->color ?? $chart->lineSettings->color;

        // State variables
        $state = new LineDrawerState();

        $values = $this->determineValues(
            $graph->lineSettings->subCurveWidth ?? $chart->lineSettings->subCurveWidth,
            $xAxis,
            $data,
            $yAxis
        );

        $gapLimit = $this->determineGapLimit($graph, $chart, $data);

        foreach ($values as $set) {
            [$key, , $x, $y] = $set;

            if ($state->prevX !== null && $state->prevY !== null && (!$gapLimit || $key - $state->prevKey <= $gapLimit)) {
                if ($drawSquaredLine) {
                    $this->imageLineDrawer->draw($image, $state->prevX, $state->prevY, $x, $state->prevY, $color);
                    $this->imageLineDrawer->draw($image, $x, $state->prevY, $x, $y, $color);
                }
                else {
                    $this->imageLineDrawer->draw($image, $state->prevX, $state->prevY, $x, $y, $color);
                }

                $state->prevXIsUnconnected = false;
            }
            else {
                if ($state->prevXIsUnconnected) {
                    $this->markerDrawer->drawMarker($state->prevX, $state->prevY);
                }

                $state->prevXIsUnconnected = true;
            }

            $state->prevX = $x;
            $state->prevY = $y;
            $state->prevKey = $key;
        }

        if ($state->prevXIsUnconnected) {
            $this->markerDrawer->drawMarker($state->prevX, $state->prevY);
        }
    }

    private function determineValues(float $subcurveWidth, XAxis $xAxis, Data $data, Y2Axis|YAxis $yAxis): array
    {
        $values = [];

        if (Number::isMoreThanZero($subcurveWidth)) {
            $newValues = [];
            $halfwidth = $subcurveWidth / 2;

            $spread = $this->pixelator->valueToCoordinate($xAxis, $subcurveWidth)
                - $this->pixelator->valueToCoordinate($xAxis, 0);

            $maxHeight = 2 / $spread;

            foreach ($data->values() as $key => $value) {
                if ($value === 0) {
                    continue;
                }

                $center = $this->pixelator->valueToCoordinate($xAxis, $key);
                $from = $this->pixelator->valueToCoordinate($xAxis, $key - $halfwidth);
                $to = $this->pixelator->valueToCoordinate($xAxis, $key + $halfwidth);

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
                    $this->pixelator->coordinateToValue($xAxis, $x),
                    $value,
                    $x,
                    $this->pixelator->valueToCoordinate($yAxis, $value),
                ];
            }
        }
        else {
            foreach ($data->values() as $key => $value) {
                $x = $this->pixelator->valueToCoordinate($xAxis, $key);
                $y = $this->pixelator->valueToCoordinate($yAxis, $value);
                $values[] = [$key, $value, $x, $y];
            }
        }

        return $values;
    }

    private function determineGapLimit(LineGraph $graph, Chart $chart, Data $data): float|false
    {
        $gapLimit = $graph->lineSettings->gapLimit ?? $chart->lineSettings->gapLimit;

        if (is_nihil($gapLimit)) {
            return false;
        }
        else {
            try {
                return $gapLimit * $this->intervalCalculator->calculate($data);
            }
            catch (\Exception) {
                return 0;
            }
        }
    }
}
