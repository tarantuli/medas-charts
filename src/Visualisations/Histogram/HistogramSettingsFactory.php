<?php

declare(strict_types=1);

namespace Medas\Charts\Visualisations\Histogram;

use Medas\Core\Attributes\Service;

#[Service]
readonly class HistogramSettingsFactory
{
    public function create(): HistogramSettings
    {
        $settings = new HistogramSettings();

        $settings->barAmount = 8;

        return $settings;
    }
}
