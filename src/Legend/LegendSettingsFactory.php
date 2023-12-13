<?php

declare(strict_types=1);

namespace Medas\Charts\Legend;

use Medas\Charts\General\{FourSides, TextSettings};
use Medas\Core\Attributes\Service;
use Medas\ImageManager\ColorManager;

#[Service]
readonly class LegendSettingsFactory
{
    public function __construct(
        private ColorManager $colorManager,
    )
    {
    }

    public function create(): LegendSettings
    {
        $settings = new LegendSettings();

        $settings->backgroundColor = $this->colorManager->fromHtmlString('#dfff');
        $settings->margin = new FourSides(5);
        $settings->padding = new FourSides(3);
        $settings->lineSpacing = 5;

        $settings->labelSettings = new TextSettings(
            font: 'arial',
            size: 9,
            margin: 0,
            color: $this->colorManager->fromHtmlString('#000'),
        );

        $settings->marker = '&#9632;';

        $settings->markerSettings = new TextSettings(
            font: 'arial',
            size: 8,
            margin: 3,
        );

        $settings->location = Location::TopLeft;

        return $settings;
    }
}
