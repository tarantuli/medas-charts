<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines;

use Medas\Core\Attributes\Service;
use Medas\ImageDrawer\Colors\ColorFactory;

#[Service]
readonly class LineSettingsFactory
{
    public function __construct(
        private ColorFactory $colorFactory,
    )
    {
    }

    public function create(): LineSettings
    {
        $settings = new LineSettings();

        $settings->color = $this->colorFactory->fromHtmlString('#4572A7');
        $settings->disconnectLimit = 2;
        $settings->thickness = 1;
        $settings->subCurveWidth = 0;
        $settings->gapLimit = 2;
        $settings->drawSmoothLine = false;
        $settings->drawSquaredLine = false;

        return $settings;
    }
}
