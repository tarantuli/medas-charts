<?php

declare(strict_types=1);

namespace Medas\Charts\Data;

use Medas\Core\Attributes\Service;

#[Service]
readonly class DataSettingsFactory
{
    public function create(): DataSettings
    {
        $settings = new DataSettings();

        $settings->setMissingXToZero = false;

        return $settings;
    }
}
