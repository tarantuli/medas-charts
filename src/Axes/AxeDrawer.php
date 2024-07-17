<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

use Medas\Charts\{Coordinates\Mapper, Rendering\Job};
use Medas\Core\{Attributes\Service, FloatingNumber};
use Medas\ImageDrawer\Drawers\LineDrawer;

#[Service]
readonly class AxeDrawer
{
    public function __construct(
        private Mapper                 $mapper,
        private LineDrawer             $lineDrawer,
        private Labels\LabelController $labelController,
    )
    {
    }

    public function draw(Job $job): void
    {
        $this->drawXAxisLineAndTicks($job);
        $this->drawYAxisLineAndTicks($job);
    }

    private function drawXAxisLineAndTicks(Job $job): void
    {
        $grid = $job->chart->grid;
        $xAxis = $job->chart->xAxis;
        $y = $this->mapper->valueToCoordinate($job->chart->yAxis, 0);

        if (!FloatingNumber::isBetweenInclusive($grid->yo, $y, $grid->yo)) {
            $y = $grid->yo;
        }

        $this->lineDrawer->draw($job->image, $grid->xo, $y, $grid->xm, $y, $xAxis->settings->color);

        if ($xAxis->settings->showTicks) {
            foreach ($this->labelController->labels($xAxis) as $label) {
                $x = $this->mapper->valueToCoordinate($xAxis, $label->value);

                $this->lineDrawer->draw(
                    $job->image,
                    $x,
                    $y,
                    $x,
                    $y + $xAxis->settings->tickLength,
                    $xAxis->settings->color
                );
            }
        }
    }

    private function drawYAxisLineAndTicks(Job $job): void
    {
        $grid = $job->chart->grid;
        $yAxis = $job->chart->yAxis;
        $x = $this->mapper->valueToCoordinate($job->chart->xAxis, 0);

        if (!FloatingNumber::isBetweenInclusive($grid->xo, $x, $grid->xo)) {
            $x = $grid->xo;
        }

        $this->lineDrawer->draw($job->image, $x, $grid->yo, $x, $grid->ym, $yAxis->settings->color);

        if ($yAxis->settings->showTicks) {
            foreach ($this->labelController->labels($yAxis) as $label) {
                $y = $this->mapper->valueToCoordinate($yAxis, $label->value);

                $this->lineDrawer->draw(
                    $job->image,
                    $x,
                    $y,
                    $x - $yAxis->settings->tickLength,
                    $y,
                    $yAxis->settings->color
                );
            }
        }
    }
}
