<?php

declare(strict_types=1);

namespace Medas\Charts\Legend;

use Medas\Charts\Image\Drawers\{FilledRectangleDrawer, TextDrawer};
use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class LegendDrawer
{
    public function __construct(
        private FilledRectangleDrawer $filledRectangleDrawer,
        private CoordinatesCalculator $coordinatesCalculator,
        private TextDrawer            $textDrawer,
    )
    {
    }

    public function drawBox(Job $job): void
    {
        $coordinates = $this->coordinatesCalculator->calculate($job);

        $this->filledRectangleDrawer->draw(
            $job->image,
            $coordinates->x,
            $coordinates->y,
            $coordinates->x + $coordinates->width,
            $coordinates->y + $coordinates->height,
            $job->chart->legendSettings->backgroundColor
        );
    }

    public function drawLabels(Job $job): void
    {
        $settings = $job->chart->legendSettings;
        $calculate = $this->coordinatesCalculator->calculate($job);
        $counter = 0;

        foreach ($job->chart->graphs as $graph) {
            ++$counter;

            $markerSettings = clone $settings->markerSettings;

            $markerSettings->color = $graph->color;

            $this->textDrawer->draw(
                $job->image,
                $settings->marker,
                $calculate->x + $settings->padding->left,
                $calculate->y
                    + $settings->padding->top
                    + $counter * $settings->labelSettings->size
                    + ($counter - 1) * $settings->lineSpacing
                    - 2,
                $markerSettings
            );

            $this->textDrawer->draw(
                $job->image,
                $graph->seriesName,
                $calculate->x
                    + $settings->padding->left
                    + $settings->labelSettings->size
                    + $settings->markerSettings->margin,
                $calculate->y
                    + $settings->padding->top
                    + $counter * $settings->labelSettings->size
                    + ($counter - 1) * $settings->lineSpacing,
                $settings->labelSettings
            );
        }
    }
}
