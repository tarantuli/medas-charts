<?php

declare(strict_types=1);

namespace Medas\Charts\Image;

use Medas\Charts\Axes\Axis;
use Medas\Core\Attributes\Service;

#[Service]
readonly class Pixelator
{
    public function valueToCoordinate(Axis $axis, float $value): float
    {
        return $axis->pixelAtOrigin
            + $axis->pixelWidth * ($value - $axis->minValue) / $axis->valueRange;
    }

    public function coordinateToValue(Axis $axis, float $coordinate): float
    {
        return $axis->minValue
            + $axis->valueRange * ($coordinate - $axis->pixelAtOrigin) / $axis->pixelWidth;
    }
}
