<?php

declare(strict_types=1);

namespace Medas\Charts\Settings;

use Medas\Core\Attributes\Service;

#[Service]
readonly class ColorSettingsFactory
{
    public function create(): ColorSettings
    {
        return new ColorSettings();
    }
}
