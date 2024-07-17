<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

use Medas\Charts\Colors\ColorGenerator;
use Medas\Charts\Coordinates\SeriesMapper;
use Medas\Charts\Graphs\{Lines\LineGraph, YAxisType};
use Medas\Charts\Rendering\Job;
use Medas\Core\{Attributes\Service, FloatingNumber};
use Medas\ImageDrawer\Drawers\LineDrawer as ImageLineDrawer;

#[Service]
readonly class SmoothLineDrawer
{
    public function __construct(
        private ColorGenerator  $colorGenerator,
        private ImageLineDrawer $imageLineDrawer,
        private SeriesMapper    $seriesMapper,
    )
    {
    }

    public function draw(Job $job, LineGraph $graph): void
    {
        // Draw cubic splines
        // Source: http://apps.nrbook.com/c/index.html (2011/09/26) -- Numerical Recipes in C, page 113
        $chart = $job->chart;
        $graph->color = $color = $graph->lineSettings->color ?? $graph->color ?? $this->colorGenerator->generate($job);

        $coordinates = $this->seriesMapper->mapToCoordinates(
            $job,
            $chart->xAxis,
            $graph->YAxisType === YAxisType::Y ? $chart->yAxis : $chart->y2Axis,
            $chart->dataSeries[$graph->seriesName],
            $graph->lineSettings->subCurveWidth ?? $chart->lineSettings->subCurveWidth
        );

        $state = new SmoothLineDrawerState(count($coordinates));

        foreach ($coordinates as [$x, $y]) {
            $state->xs[] = $x;
            $state->ys[] = $y;
        }

        for ($i = 1; $i <= $state->count - 2; ++$i) {
            if (FloatingNumber::areEqual($state->xs[$i], $state->xs[$i + 1])) {
                continue;
            }

            if (FloatingNumber::areEqual($state->xs[$i], $state->xs[$i - 1])) {
                continue;
            }

            if (FloatingNumber::areEqual($state->xs[$i - 1], $state->xs[$i + 1])) {
                continue;
            }

            $sig = ($state->xs[$i] - $state->xs[$i - 1])
                / ($state->xs[$i + 1] - $state->xs[$i - 1]);

            $p = $sig * $state->ys2[$i - 1] + 2.0;
            $state->ys2[$i] = ($sig - 1.0) / $p;

            $state->us[$i] = ($state->ys[$i + 1] - $state->ys[$i]) / ($state->xs[$i + 1] - $state->xs[$i])
                - ($state->ys[$i] - $state->ys[$i - 1]) / ($state->xs[$i] - $state->xs[$i - 1]);

            $state->us[$i]
                = (6.0 * $state->us[$i] / ($state->xs[$i + 1] - $state->xs[$i - 1]) - $sig * $state->us[$i - 1])
                    / $p;
        }

        for ($i = $state->count - 2; $i >= 1; --$i) {
            $state->ys2[$i] = $state->ys2[$i] * $state->ys2[$i + 1] + $state->us[$i];
        }

        $i = 0;
        $j = 1;

        for ($x = min($state->xs); $x < max($state->xs); ++$x) {
            if ($x >= $state->xs[$i + 1]) {
                ++$i;
                ++$j;
            }

            $h = $state->xs[$j] - $state->xs[$i];

            if (is_nihil($h)) {
                continue;
            }

            $a = ($state->xs[$j] - $x) / $h;
            $b = ($x - $state->xs[$i]) / $h;
            $aComponent = $a * $state->ys[$i];
            $bComponent = $b * $state->ys[$j];

            $mixComponent = (($a * $a * $a - $a) * $state->ys2[$i] + ($b * $b * $b - $b) * $state->ys2[$j])
                * ($h * $h) / 6.0;

            $y = $aComponent + $bComponent + $mixComponent;

            if ($state->prevX !== null && $state->prevY !== null) {
                $this->imageLineDrawer->draw(
                    $job->image,
                    $x,
                    $y,
                    $state->prevX,
                    $state->prevY,
                    $color
                );
            }

            $state->prevX = $x;
            $state->prevY = $y;
        }
    }
}
