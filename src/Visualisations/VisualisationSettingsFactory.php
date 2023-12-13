<?php

declare(strict_types=1);

namespace Medas\Charts\Visualisations;

use Medas\Core\Attributes\Service;

#[Service]
readonly class VisualisationSettingsFactory
{
    public function __construct(
        private Lines\LineVisualisation $lineVisualisation,
    )
    {
    }

    public function create(): VisualisationSettings
    {
        $settings = new VisualisationSettings();

        $settings->drawSmoothLines = false;
        $settings->drawSquaredLines = false;
        $settings->defaultVisualisation = $this->lineVisualisation;

        return $settings;
    }
}
