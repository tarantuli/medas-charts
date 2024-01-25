<?php

declare(strict_types=1);

namespace Medas\Charts\Chart;

use Medas\Charts\Image\Drawers\TextDrawer;
use Medas\Charts\Rendering\Job;
use Medas\Charts\Text\BoundingBoxFactory;
use Medas\Core\Attributes\Service;

#[Service]
readonly class TitleDrawer
{
    public function __construct(
        private BoundingBoxFactory $boundingBoxFactory,
        private TextDrawer         $textDrawer,
    )
    {
    }

    public function draw(Job $job): void
    {
        $this->drawChartTitle($job);
        $this->drawXAxisTitle($job);
        $this->drawYAxisTitle($job);
    }

    private function drawChartTitle(Job $job): void
    {
        $settings = $job->chart->chartSettings;

        if ($settings->title === null || $settings->showTitle === false) {
            return;
        }

        $x = ($job->chart->grid->xo + $job->chart->grid->xm) / 2;
        $y = $job->chart->grid->ym - $settings->titleSettings->margin;

        $this->textDrawer->draw($job->image, $settings->title, $x, $y, $settings->titleSettings);
    }

    private function drawXAxisTitle(Job $job): void
    {
        $xAxis = $job->chart->xAxis;
        $settings = $xAxis->settings;

        if ($settings->title === null || $settings->showTitle === false) {
            return;
        }

        $bbox = $this->boundingBoxFactory->create($settings->title, $settings->titleSettings);
        $x = ($job->chart->grid->xo + $job->chart->grid->xm) / 2;

        $y = $job->chart->grid->yo
            + $settings->tickLength
            + $settings->labelSettings->size
            + $settings->titleSettings->margin
            + $bbox->height;

        $this->textDrawer->draw($job->image, $settings->title, $x, $y, $settings->titleSettings);
    }

    private function drawYAxisTitle(Job $job): void
    {
        $yAxis = $job->chart->yAxis;
        $settings = $yAxis->settings;

        if ($settings->title === null || $settings->showTitle === false) {
            return;
        }

        $bbox = $this->boundingBoxFactory->create($settings->title, $settings->titleSettings);

        $x = $job->chart->grid->xo
            - $settings->tickLength
            - $settings->labelSettings->size
            - $settings->titleSettings->margin
            - $bbox->height;

        $y = ($job->chart->grid->yo + $job->chart->grid->ym) / 2 + $bbox->width / 2;

        $this->textDrawer->draw($job->image, $settings->title, $x, $y, $settings->titleSettings);
    }
}
