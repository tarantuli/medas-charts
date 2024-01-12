<?php

declare(strict_types=1);

namespace Medas\Charts\Grid;

use Medas\Charts\Axes\Labels\{LabelController, SubLabelController};
use Medas\Charts\Image\{Drawers\LineDrawer, Pixelator};
use Medas\Charts\Number;
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class GridDrawer
{
    public function __construct(
        private LabelController    $labelController,
        private LineDrawer         $lineDrawer,
        private SubLabelController $subLabelController,
        private Pixelator          $pixelator,
    )
    {
    }

    public function draw(Job $job): void
    {
        $this->drawXAxisSubGridLines($job);
        $this->drawYAxisSubGridLines($job);
        $this->drawXAxisMainGridLines($job);
        $this->drawYAxisMainGridLines($job);
    }

    private function drawXAxisSubGridLines(Job $job): void
    {
        $chart = $job->chart;
        $xAxis = $chart->xAxis;

        foreach ($this->labelController->labels($xAxis) as $label) {
            foreach ($this->subLabelController->labels($xAxis, $label->value - $xAxis->minValue) as $subLabel) {
                $x = $this->pixelator->valueToCoordinate($xAxis, $subLabel->value);

                if (Number::isMoreThanOrEqual($x, $chart->grid->xm)) {
                    break;
                }

                $this->lineDrawer->draw(
                    $job->image,
                    $x,
                    $chart->grid->yo,
                    $x,
                    $chart->grid->ym,
                    $chart->chartSettings->subGridColor,
                    .5
                );
            }
        }
    }

    private function drawYAxisSubGridLines(Job $job): void
    {
        $chart = $job->chart;
        $yAxis = $chart->yAxis;

        foreach ($this->labelController->labels($yAxis) as $label) {
            foreach ($this->subLabelController->labels($yAxis, $label->value - $yAxis->minValue) as $subLabel) {
                $y = $this->pixelator->valueToCoordinate($yAxis, $subLabel->value);

                $this->lineDrawer->draw(
                    $job->image,
                    $chart->grid->xo,
                    $y,
                    $chart->grid->xm,
                    $y,
                    $chart->chartSettings->subGridColor,
                    .5
                );
            }
        }
    }

    private function drawXAxisMainGridLines(Job $job): void
    {
        $chart = $job->chart;
        $xAxis = $chart->xAxis;

        foreach ($this->labelController->labels($xAxis) as $label) {
            $x = $this->pixelator->valueToCoordinate($xAxis, $label->value);

            $this->lineDrawer->draw(
                $job->image,
                $x,
                $chart->grid->yo,
                $x,
                $chart->grid->ym,
                $chart->chartSettings->gridColor
            );
        }
    }

    private function drawYAxisMainGridLines(Job $job): void
    {
        $chart = $job->chart;
        $yAxis = $chart->yAxis;

        foreach ($this->labelController->labels($yAxis) as $label) {
            $y = $this->pixelator->valueToCoordinate($yAxis, $label->value);

            $this->lineDrawer->draw(
                $job->image,
                $chart->grid->xo,
                $y,
                $chart->grid->xm,
                $y,
                $chart->chartSettings->gridColor
            );
        }
    }
}
