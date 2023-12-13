<?php

declare(strict_types=1);

namespace Medas\Charts\Settings;

use Medas\Core\Attributes\Service;

#[Service]
readonly class FontSettingsFactory
{
    public function create(): FontSettings
    {
        $settings = new FontSettings();

        $settings->directory = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN'
            ? 'C:\\Windows\\Fonts'
            : '/usr/share/fonts';

        return $settings;
    }
}
