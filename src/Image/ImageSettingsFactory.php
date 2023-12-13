<?php

declare(strict_types=1);

namespace Medas\Charts\Image;

use Medas\Charts\General\FourSides;
use Medas\Core\Attributes\Service;
use Medas\ImageManager\ColorManager;

#[Service]
readonly class ImageSettingsFactory
{
    public function __construct(
        private ColorManager $colorManager,
    )
    {
    }

    public function create(): ImageSettings
    {
        $settings = new ImageSettings();

        $settings->height = 400;
        $settings->width = 600;
        $settings->backgroundColor = $this->colorManager->fromHtmlString('#0fff');
        $settings->padding = new FourSides(15);
        $settings->sizeLock = SizeLock::ImageSize;

        return $settings;
    }
}
