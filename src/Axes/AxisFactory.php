<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

use Medas\Core\Attributes\Service;
use Medas\ImageDrawer\Colors\ColorFactory;
use Medas\ImageDrawer\Text\Alignment\{Alignment, Horizontal};
use Medas\ImageDrawer\TextSettings;

#[Service]
readonly class AxisFactory
{
    public function __construct(
        private ColorFactory $colorFactory,
    )
    {
    }

    public function createSettings(): AxisSettings
    {
        $settings = new AxisSettings();

        $settings->color = $this->colorFactory->fromHtmlString('#000');
        $settings->showTicks = true;
        $settings->tickLength = 3.0;
        $settings->tickMargin = 3.0;
        $settings->showLabels = true;
        $settings->showTitle = true;

        $settings->titleSettings = new TextSettings(
            font: 'Rubik-Regular',
            size: 12,
            margin: 5,
            color: $this->colorFactory->fromHtmlString('#000'),
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
        $axis->settings->titleSettings->alignment = new Alignment(Horizontal::Center);

        $axis->settings->labelSettings = new TextSettings(
            font: 'Rubik-Regular',
            size: 10,
            color: $this->colorFactory->fromHtmlString('#000'),
            angle: 90,
        );

        $axis->iterationType = IntervalTypes\IterationType::Linear;
        $axis->hasZeroRange = false;

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
            font: 'Rubik-Regular',
            size: 10,
            color: $this->colorFactory->fromHtmlString('#000')
        );

        $axis->settings->titleSettings->angle = 90;
        $axis->iterationType = IntervalTypes\IterationType::Linear;
        $axis->hasZeroRange = false;

        return $axis;
    }
}
