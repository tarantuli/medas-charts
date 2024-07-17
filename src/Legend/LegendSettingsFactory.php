<?php

declare(strict_types=1);

namespace Medas\Charts\Legend;

use Medas\Core\{Attributes\Service, RectangleSides};
use Medas\ImageDrawer\{Colors\ColorFactory, TextSettings};

#[Service]
readonly class LegendSettingsFactory
{
    public function __construct(
        private ColorFactory $colorFactory,
    )
    {
    }

    public function create(): LegendSettings
    {
        $settings = new LegendSettings();

        $settings->backgroundColor = $this->colorFactory->fromHtmlString('#dfff');
        $settings->margin = new RectangleSides(5);
        $settings->padding = new RectangleSides(3);
        $settings->lineSpacing = 5;

        $settings->labelSettings = new TextSettings(
            font: 'Rubik-Regular',
            size: 10,
            margin: 0,
            color: $this->colorFactory->fromHtmlString('#000'),
        );

        $settings->marker = '&#x25ac;';

        $settings->markerSettings = new TextSettings(
            font: 'Arimo-Regular',
            size: 9,
            margin: 6,
        );

        $settings->location = Location::TopLeft;

        return $settings;
    }
}
