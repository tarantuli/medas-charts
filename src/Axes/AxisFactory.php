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

    public function createAxisSettings(): AxisSettings
    {
        $settings = new AxisSettings();

        $settings->color = $this->colorManager->fromHtmlString('#000');
        $settings->isOnY2NameMarker = ' &#9658;';
        $settings->showTicks = true;
        $settings->tickLength = 2.0;
        $settings->tickMargin = 5.0;
        $settings->showLabels = true;
        $settings->showTitle = true;

        return $settings;
    }

    public function createXAxis(): XAxis
    {
        $axis = new XAxis();

        $axis->titleSettings = new TextSettings(
            font: 'trebuc',
            size: 10,
            margin: 5,
            color: $this->colorManager->fromHtmlString('#000'),
        );

        $axis->intervalType = IntervalType::Numeric;
        $axis->desiredIntervalCount = 8;
        $axis->normalizationBases = [1, 2, 5];

        $axis->labelSettings = new TextSettings(
            font: 'calibri',
            size: 8,
            color: $this->colorManager->fromHtmlString('#000'),
            angle: 90,
        );

        return $axis;
    }

    public function createYAxis(): YAxis
    {
        return $this->createBaseYAxis(new YAxis());
    }

    public function createY2Axis(): Y2Axis
    {
        return $this->createBaseYAxis(new Y2Axis());
    }

    private function createBaseYAxis(YAxis|Y2Axis $axis): YAxis|Y2Axis
    {
        $axis->titleSettings = new TextSettings(
            font: 'trebuc',
            size: 10,
            margin: 5,
            color: $this->colorManager->fromHtmlString('#000'),
        );

        $axis->intervalType = IntervalType::Numeric;
        $axis->desiredIntervalCount = 6;
        $axis->normalizationBases = [1, 2, 5];

        $axis->labelSettings = new TextSettings(
            font: 'calibri',
            size: 8,
            color: $this->colorManager->fromHtmlString('#000')
        );

        return $axis;
    }
}
