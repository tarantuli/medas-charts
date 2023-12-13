<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines;

use Medas\Core\Attributes\Service;

#[Service]
readonly class LineSettingsFactory
{
    public function create(): LineSettings
    {
        $settings = new LineSettings();

        $settings->disconnectLimit = 2;
        $settings->thickness = 1;
        $settings->subCurveWidth = 0;

        return $settings;
    }
}
