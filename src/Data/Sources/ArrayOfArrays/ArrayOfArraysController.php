<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources\ArrayOfArrays;

use Medas\Charts\Data\{Range2D, Sources\Series, Sources\SeriesController};
use Medas\Core\Attributes\Service;

#[Service]
readonly class ArrayOfArraysController implements SeriesController
{
    public function canHandle(Series $series): bool
    {
        return $series instanceof ArrayOfArrays;
    }

    /** @var ArrayOfArrays $series */
    public function getRange2D(Series $series): Range2D
    {
        $keys = $this->getKeys($series);
        $values = $this->getValues($series);

        return new Range2D(
            min($keys),
            max($values),
            min($values),
            max($values),
        );
    }

    /** @var ArrayOfArrays $series */
    public function getKeys(Series $series): iterable
    {
        return array_keys($this->getValues($series));
    }

    /** @var ArrayOfArrays $series */
    public function getValues(Series $series): array
    {
        return $series->data;
    }
}
