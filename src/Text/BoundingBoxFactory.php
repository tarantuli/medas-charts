<?php

declare(strict_types=1);

namespace Medas\Charts\Text;

use Medas\Charts\General\TextSettings;
use Medas\Core\Attributes\Service;

#[Service]
readonly class BoundingBoxFactory
{
    public function __construct(
        private FontResolver $fontResolver,
    )
    {
    }

    public function create(string $text, TextSettings $settings): BoundingBox
    {
        $font = $this->fontResolver->resolve($settings->font);

        try {
            $bbox = imageftbbox($settings->size, 0, $font, $text);
        }
        catch (\ErrorException $exception) {
            throw new \Exception('ErrorException ' . $exception->getMessage() . ' when bboxing ' . $font);
        }

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
