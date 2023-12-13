<?php

declare(strict_types=1);

namespace Medas\Charts\Data\KeyToValueArray;

use Medas\Charts\Data\Range2D;
use Medas\Core\Attributes\Service;

#[Service]
readonly class KeyToValueArrayController
{
    public function getRange2D(KeyToValueArray $data): Range2D
    {
        return new Range2D(
            $data->minX(),
            $data->maxX(),
            $data->minY(),
            $data->maxY(),
        );
    }

    public function getXs(KeyToValueArray $data): array
    {
        $xs = [];

        foreach ($data as $x => $y) {
            $xs[] = $x;
        }

        return $xs;
    }
}
