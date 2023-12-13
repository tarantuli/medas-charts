<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs;

use Medas\Core\Attributes\Service;

#[Service]
readonly class GraphSettingsFactory
{
    public function create(): GraphSettings
    {
        $settings = new GraphSettings();

        $settings->drawSmoothLines = false;
        $settings->drawSquaredLines = false;

        return $settings;
    }
}
