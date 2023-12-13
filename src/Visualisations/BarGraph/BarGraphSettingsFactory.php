<?php

declare(strict_types=1);

namespace Medas\Charts\Visualisations\BarGraph;

use Medas\Core\Attributes\Service;

#[Service]
readonly class BarGraphSettingsFactory
{
    public function create(): BarGraphSettings
    {
        $settings = new BarGraphSettings();

        $settings->innerMargin = 1.0;
        $settings->outerMargin = 7.0;
        $settings->minimumWidth = 4.0;
        $settings->maximumWidth = 12.0;

        return $settings;
    }
}
