<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources\KeyToValueArray;

use Medas\Charts\Data\{
    Datum,
    Range2D,
    Sources\MinMaxFinder,
    Sources\Series,
    Sources\SeriesController
};
use Medas\Core\Attributes\Service;

#[Service]
readonly class KeyToValueArrayController implements SeriesController
{
    public function __construct(
        private MinMaxFinder $minMaxFinder,
    )
    {
    }

    public function canHandle(Series $series): bool
    {
        return $series instanceof KeyToValueArray;
    }

    /** @var KeyToValueArray $series */
    public function getRange2D(Series $series): Range2D
    {
        $data = $this->getData($series);
        [$min, $max] = $this->minMaxFinder->find($data);

        return new Range2D($data[0]->key, $data[count($data) - 1]->key, $min, $max);
    }

    /** @var KeyToValueArray $series */
    public function getData(Series $series): array
    {
        if (isset($series->data)) {
            return $series->data;
        }

        $series->data = [];

        foreach ($series->pairs as $key => $value) {
            $series->data[] = new Datum($key, $value);
        }

        return $series->data;
    }
}
