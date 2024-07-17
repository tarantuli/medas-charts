<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers;

use Medas\Core\Attributes\Service;
use Medas\ImageDrawer\Colors\ColorFactory;

#[Service]
readonly class MarkerSettingsFactory
{
    public function __construct(
        private ColorFactory $colorFactory,
    )
    {
    }

    public function create(): MarkerSettings
    {
        $settings = new MarkerSettings();

        $settings->size = 6;
        $settings->type = new Types\Circles\Circle();
        $settings->color = $this->colorFactory->fromHtmlString('#4572A7');

        return $settings;
    }
}
