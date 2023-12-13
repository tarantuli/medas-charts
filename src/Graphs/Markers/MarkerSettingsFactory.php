<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers;

use Medas\Core\Attributes\Service;

#[Service]
readonly class MarkerSettingsFactory
{
    public function __construct(
        private Types\SquareMarker $squareMarker,
    )
    {
    }

    public function create(): MarkerSettings
    {
        $settings = new MarkerSettings();

        $settings->size = 4;
        $settings->type = $this->squareMarker;

        return $settings;
    }
}
