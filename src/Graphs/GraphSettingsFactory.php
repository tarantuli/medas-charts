<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs;

use Medas\Core\Attributes\Service;

#[Service]
readonly class GraphSettingsFactory
{
    public function __construct(
        private Lines\LineGraph $lineGraph,
    )
    {
    }

    public function create(): GraphSettings
    {
        $settings = new GraphSettings();

        $settings->drawSmoothLines = false;
        $settings->drawSquaredLines = false;
        $settings->defaultGraph = $this->lineGraph;

        return $settings;
    }
}
