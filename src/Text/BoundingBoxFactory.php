<?php

declare(strict_types=1);

namespace Medas\Charts\Text;

use Medas\Core\Attributes\Service;

#[Service]
readonly class BoundingBoxFactory
{
    public function create(string $text, string $font, float $size, float $angle = 0.0): BoundingBox
    {
        $bbox = imageftbbox($size, $angle, $font, $text);

        return new BoundingBox(
            $bbox[Coordinate::LowerLeftX->value],
            $bbox[Coordinate::LowerLeftY->value],
            $bbox[Coordinate::LowerRightX->value],
            $bbox[Coordinate::LowerRightY->value],
            $bbox[Coordinate::UpperRightX->value],
            $bbox[Coordinate::UpperRightY->value],
            $bbox[Coordinate::UpperLeftX->value],
            $bbox[Coordinate::UpperLeftY->value],
            $bbox[Coordinate::LowerRightX->value] - $bbox[Coordinate::LowerLeftX->value],
            $bbox[Coordinate::LowerLeftY->value] - $bbox[Coordinate::UpperLeftY->value],
        );
    }
}
