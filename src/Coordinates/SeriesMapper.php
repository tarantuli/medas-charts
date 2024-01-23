<?php

declare(strict_types=1);

namespace Medas\Charts\Coordinates;

use Medas\Charts\Axes\{XAxis, Y2Axis, YAxis};
use Medas\Charts\Data\Sources\Series;
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class SeriesMapper
{
    public function __construct(
        private Mapper $mapper,
    )
    {
    }

    public function mapToCoordinates(
        Job          $job,
        XAxis        $xAxis,
        Y2Axis|YAxis $yAxis,
        Series       $series,
        float        $subcurveWidth
    ): array
    {
        if (is_nihil($subcurveWidth)) {
            return $this->mapStraightForwardly($job, $series, $xAxis, $yAxis);
        }
        else {
            return $this->usingSubCurveWidth($job, $series, $xAxis, $yAxis, $subcurveWidth);
        }
    }

    private function mapStraightForwardly(Job $job, Series $series, XAxis $xAxis, Y2Axis|YAxis $yAxis): array
    {
        $values = [];

        foreach ($job->chart->seriesControllers[$series]->getValues($series) as $key => $value) {
            $x = $this->mapper->valueToCoordinate($xAxis, $key);
            $y = $this->mapper->valueToCoordinate($yAxis, $value);
            $values[] = [$x, $y];
        }

        return $values;
    }

    private function usingSubCurveWidth(
        Job          $job,
        Series       $series,
        XAxis        $xAxis,
        Y2Axis|YAxis $yAxis,
        float        $subcurveWidth
    ): array
    {
        $values = [];
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

        return $values;
    }
}
