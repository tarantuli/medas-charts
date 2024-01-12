<?php

declare(strict_types=1);

namespace Medas\Charts\Image\Size;

use Medas\Charts\{Image\Image, Number};
use Medas\Core\Attributes\Service;

#[Service]
readonly class Resizer
{
    public function resize(Image $image, int $toWidth, int $toHeight): void
    {
        $resource = imagecreatetruecolor($toWidth, $toHeight);

        imageantialias($resource, true);

        imagealphablending($resource, false);

        imagesavealpha($resource, true);

        imagecopyresampled(
            $resource,
            $image->resource,
            0,
            0,
            0,
            0,
            $toWidth,
            $toHeight,
            imagesx($image->resource),
            imagesy($image->resource)
        );

        $image->resource = $resource;
    }

    public function undoScalingFactor(Image $image): void
    {
        if (Number::areEqual($image->scalingFactor, 1)) {
            return;
        }

        $this->resize(
            $image,
            (int) round(imagesx($image->resource) / $image->scalingFactor),
            (int) round(imagesy($image->resource) / $image->scalingFactor),
        );
    }
}
