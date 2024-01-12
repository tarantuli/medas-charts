<?php

declare(strict_types=1);

namespace Medas\Charts\Image;

use Medas\Charts\{Chart, Number};
use Medas\Core\Attributes\Service;

#[Service]
readonly class ImageFactory
{
    public function __construct(
        private Drawers\FilledRectangleDrawer $rectangleFiller,
    )
    {
    }

    public function create(Chart $chart): Image
    {
        $scalingFactor = $chart->imageSettings->scalingFactor;

        $resource = imagecreatetruecolor(
            $chart->imageSettings->width * $scalingFactor,
            $chart->imageSettings->height * $scalingFactor,
        );

        if (Number::areEqual($scalingFactor, 1)) {
            imageantialias($resource, true);
        }
        else {
            imagesetthickness($resource, $scalingFactor);
        }

        imagealphablending($resource, false);

        imagesavealpha($resource, true);

        $image = new Image($resource, $scalingFactor);

        $this->rectangleFiller->draw(
            $image,
            0,
            0,
            $chart->imageSettings->width,
            $chart->imageSettings->height,
            $chart->imageSettings->backgroundColor
        );

        return $image;
    }
}
