<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\Labels;

use Medas\Charts\Image\{Drawers\FilledRectangleDrawer, Drawers\TextDrawer, Pixelator};
use Medas\Charts\Number;
use Medas\Charts\Rendering\Job;
use Medas\Charts\Text\BoundingBoxFactory;
use Medas\Core\Attributes\Service;

#[Service]
readonly class LabelDrawer
{
    public function __construct(
        private Pixelator             $pixelator,
        private LabelController       $labelController,
        private BoundingBoxFactory    $boundingBoxFactory,
        private FilledRectangleDrawer $filledRectangleDrawer,
        private TextDrawer            $textDrawer,
    )
    {
    }

    public function draw(Job $job): void
    {
        $this->drawXAxisLabels($job);
        $this->drawYAxisLabels($job);
    }

    private function drawXAxisLabels(Job $job): void
    {
        $axis = $job->chart->xAxis;
        $grid = $job->chart->grid;
        $labelSettings = $axis->settings->labelSettings;
        $y = $this->pixelator->valueToCoordinate($job->chart->yAxis, 0);

        if (!Number::isBetweenInclusive($grid->yo, $y, $grid->yo)) {
            $y = $grid->yo;
        }

        $semiTransparentColor = clone $job->chart->imageSettings->backgroundColor;

        $semiTransparentColor->opacity = .7;

        foreach ($this->labelController->labels($axis) as $label) {
            $x = $this->pixelator->valueToCoordinate($axis, $label->value);
            $bbox = $this->boundingBoxFactory->create($label->formatted, $labelSettings);

            $this->filledRectangleDrawer->draw(
                $job->image,
                $x + $bbox->height / 2 + 1,
                $y + $axis->settings->tickLength + $axis->settings->tickMargin + $bbox->width + 1,
                $x - $bbox->height / 2 - 1,
                $y + $axis->settings->tickLength + $axis->settings->tickMargin - 1,
                $semiTransparentColor
            );

            $this->textDrawer->draw(
                $job->image,
                $label->formatted,
                $x + $bbox->height / 2,
                $y + $axis->settings->tickLength + $axis->settings->tickMargin + $bbox->width,
                $labelSettings,
            );
        }
    }

    private function drawYAxisLabels(Job $job): void
    {
        $axis = $job->chart->yAxis;
        $grid = $job->chart->grid;
        $labelSettings = $axis->settings->labelSettings;
        $x = $this->pixelator->valueToCoordinate($job->chart->xAxis, 0);

        if (!Number::isBetweenInclusive($grid->xo, $x, $grid->xo)) {
            $x = $grid->xo;
        }

        $semiTransparentColor = clone $job->chart->imageSettings->backgroundColor;

        $semiTransparentColor->opacity = .7;

        foreach ($this->labelController->labels($axis) as $label) {
            $y = $this->pixelator->valueToCoordinate($axis, $label->value);
            $bbox = $this->boundingBoxFactory->create($label->formatted, $labelSettings);

            $this->filledRectangleDrawer->draw(
                $job->image,
                $x - $axis->settings->tickLength - $axis->settings->tickMargin - $bbox->width - 1,
                $y + $bbox->height / 2 + 1,
                $x - $axis->settings->tickLength - $axis->settings->tickMargin + 1,
                $y - $bbox->height / 2 - 1,
                $semiTransparentColor
            );

            $this->textDrawer->draw(
                $job->image,
                $label->formatted,
                $x - $axis->settings->tickLength - $axis->settings->tickMargin - $bbox->width,
                $y + $bbox->height / 2,
                $labelSettings,
            );
        }
    }
}
