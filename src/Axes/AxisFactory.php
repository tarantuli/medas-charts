<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

use Medas\Charts\General\TextSettings;
use Medas\Core\Attributes\Service;
use Medas\ImageManager\ColorManager;

#[Service]
readonly class AxisFactory
{
    public function __construct(
        private ColorManager $colorManager,
    )
    {
    }

    public function createSettings(): AxisSettings
    {
        $settings = new AxisSettings();

        $settings->color = $this->colorManager->fromHtmlString('#000');
        $settings->showTicks = true;
        $settings->tickLength = 2.0;
        $settings->tickMargin = 5.0;
        $settings->showLabels = true;

        $settings->titleSettings = new TextSettings(
            font: 'trebuc',
            size: 10,
            margin: 5,
            color: $this->colorManager->fromHtmlString('#000'),
        );

        $settings->intervalType = IntervalTypes\IntervalType::Numeric;
        $settings->normalizationBases = [1, 2, 5];

        return $settings;
    }

    public function createXAxis(): XAxis
    {
        $axis = new XAxis();

        $axis->settings = $this->createSettings();
        $axis->settings->desiredIntervalCount = 8;

        $axis->settings->labelSettings = new TextSettings(
            font: 'calibri',
            size: 8,
            color: $this->colorManager->fromHtmlString('#000'),
            angle: 90,
        );

        $axis->iterationType = IntervalTypes\IterationType::Linear;

        return $axis;
    }

    public function createYAxis(): YAxis
    {
        return $this->initializeBaseYAxis(new YAxis());
    }

    public function createY2Axis(): Y2Axis
    {
        return $this->initializeBaseYAxis(new Y2Axis());
    }

    private function initializeBaseYAxis(YAxis|Y2Axis $axis): YAxis|Y2Axis
    {
        $axis->settings = $this->createSettings();
        $axis->settings->desiredIntervalCount = 6;

        $axis->settings->labelSettings = new TextSettings(
            font: 'calibri',
            size: 8,
            color: $this->colorManager->fromHtmlString('#000')
        );

        $axis->iterationType = IntervalTypes\IterationType::Linear;

        return $axis;
    }
}
