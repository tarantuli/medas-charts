<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines;

use Medas\Core\Attributes\Service;
use Medas\ImageManager\ColorManager;

#[Service]
readonly class LineSettingsFactory
{
    public function __construct(
        private ColorManager $colorManager,
    )
    {
    }

    public function create(): LineSettings
    {
        $settings = new LineSettings();

        $settings->color = $this->colorManager->fromHtmlString('#4572A7');
        $settings->disconnectLimit = 2;
        $settings->thickness = 1;
        $settings->subCurveWidth = 0;
        $settings->gapLimit = 2;
        $settings->drawSmoothLine = false;
        $settings->drawSquaredLine = false;

        return $settings;
    }
}
