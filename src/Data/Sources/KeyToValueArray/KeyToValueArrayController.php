<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources\KeyToValueArray;

use Medas\Charts\Data\{Range2D, Sources\Series, Sources\SeriesController};
use Medas\Core\Attributes\Service;

#[Service]
readonly class KeyToValueArrayController implements SeriesController
{
    public function canHandle(Series $series): bool
    {
        return $series instanceof KeyToValueArray;
    }

    /** @var KeyToValueArray $series */
    public function getRange2D(Series $series): Range2D
    {
        return new Range2D(
            min(array_keys($series->data())),
            max(array_keys($series->data())),
            min($series->data()),
            max($series->data()),
        );
    }

    /** @var KeyToValueArray $series */
    public function getKeys(Series $series): iterable
    {
        $xs = [];

        foreach ($series->values() as $x => $y) {
            $xs[] = $x;
        }

        return $xs;
    }

    /** @var KeyToValueArray $series */
    public function getValues(Series $series): iterable
    {
        return $series->values();
    }
}
