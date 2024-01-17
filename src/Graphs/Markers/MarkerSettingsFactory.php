<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers;

use Medas\Core\Attributes\Service;
use Medas\ImageManager\ColorManager;

#[Service]
readonly class MarkerSettingsFactory
{
    public function __construct(
        private ColorManager $colorManager,
    )
    {
    }

    public function create(): MarkerSettings
    {
        $settings = new MarkerSettings();

        $settings->size = 8;
        $settings->type = new Types\Circles\Circle();
        $settings->color = $this->colorManager->fromHtmlString('#4572A7');

        return $settings;
    }
}
