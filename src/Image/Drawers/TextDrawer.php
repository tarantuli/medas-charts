<?php

declare(strict_types=1);

namespace Medas\Charts\Image\Drawers;

use Medas\Charts\Alignment\{Horizontal, Vertical};
use Medas\Charts\General\TextSettings;
use Medas\Charts\Image\{Colors\ColorManager, Image};
use Medas\Charts\Text\{BoundingBoxFactory, FontResolver};
use Medas\Core\Attributes\Service;

#[Service]
readonly class TextDrawer
{
    public function __construct(
        private BoundingBoxFactory $boundingBoxFactory,
        private ColorManager       $colorManager,
        private FontResolver       $fontResolver,
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
        [$xOffset, $yOffset] = $this->determineOffsets($text, $settings);

        imagettftext(
            $image->resource,
            $settings->size * $image->scalingFactor,
            $settings->angle,
            (int) round($x * $image->scalingFactor + $xOffset),
            (int) round($y * $image->scalingFactor + $yOffset),
            $this->colorManager->resolve($image, $settings->color),
            $this->fontResolver->resolve($settings->font),
            $text
        );
    }

    private function determineOffsets(string $text, TextSettings $settings): array
    {
        if ($settings->alignment === null) {
            $xOffset = 0;
            $yOffset = 0;
        }
        else {
            $bbox = $this->boundingBoxFactory->create($text, $settings);

            if ($settings->alignment->horizontal === Horizontal::Left) {
                $xOffset = 0;
            }
            elseif ($settings->alignment->horizontal === Horizontal::Right) {
                $xOffset = -$bbox->width;
            }
            else {
                $xOffset = -$bbox->width / 2;
            }

            if ($settings->alignment->vertical === Vertical::Bottom) {
                $yOffset = 0;
            }
            elseif ($settings->alignment->vertical === Vertical::Top) {
                $yOffset = $bbox->height;
            }
            else {
                $yOffset = $bbox->height / 2;
            }
        }

        return [$xOffset, $yOffset];
    }
}
