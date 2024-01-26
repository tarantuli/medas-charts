<?php

declare(strict_types=1);

namespace Medas\Charts\Image\Colors;

use Medas\Charts\Image\Image;
use Medas\Core\Attributes\Service;
use Medas\ImageManager\Color;

#[Service]
readonly class ColorManager
{
    public function resolve(Image $image, Color $color): int
    {
        $hexString = str_pad(dechex((int) round(255 * $color->red)), 2, '0', STR_PAD_LEFT)
            . str_pad(dechex((int) round(255 * $color->green)), 2, '0', STR_PAD_LEFT)
            . str_pad(dechex((int) round(255 * $color->blue)), 2, '0', STR_PAD_LEFT)
            . str_pad(dechex((int) round(255 * $color->opacity)), 2, '0', STR_PAD_LEFT);

        if (isset($image->colors[$hexString])) {
            return $image->colors[$hexString];
        }

        return $image->colors[$hexString] = imagecolorallocatealpha(
            $image->resource,
            (int) round(255 * $color->red),
            (int) round(255 * $color->green),
            (int) round(255 * $color->blue),
            (int) round(127 - 127 * $color->opacity),
        );
    }
}
