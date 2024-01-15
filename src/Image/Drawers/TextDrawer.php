<?php

declare(strict_types=1);

namespace Medas\Charts\Image\Drawers;

use Medas\Charts\General\TextSettings;
use Medas\Charts\Image\{Colors\ColorManager, Image};
use Medas\Charts\Text\FontResolver;
use Medas\Core\Attributes\Service;

#[Service]
readonly class TextDrawer
{
    public function __construct(
        private ColorManager $colorManager,
        private FontResolver $fontResolver,
    )
    {
    }

    public function draw(
        Image        $image,
        string       $text,
        float        $x,
        float        $y,
        TextSettings $settings,
    ): void
    {
        $xOffset = 0;
        $yOffset = 0;
        $colorId = $this->colorManager->resolve($image, $settings->color);

        imagettftext(
            $image->resource,
            $settings->size * $image->scalingFactor,
            $settings->angle,
            (int) round($x * $image->scalingFactor + $xOffset),
            (int) round($y * $image->scalingFactor + $yOffset),
            $colorId,
            $this->fontResolver->resolve($settings->font),
            $text
        );
    }
}
