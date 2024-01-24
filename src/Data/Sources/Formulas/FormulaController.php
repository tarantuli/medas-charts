<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources\Formulas;

use Medas\Charts\Coordinates\Mapper;
use Medas\Charts\Data\{
    Datum,
    Range2D,
    Sources\MinMaxFinder,
    Sources\Series,
    Sources\SeriesController
};
use Medas\Core\Attributes\Service;

#[Service]
readonly class FormulaController implements SeriesController
{
    public function __construct(
        private Mapper       $mapper,
        private MinMaxFinder $minMaxFinder,
    )
    {
    }

    public function canHandle(Series $series): bool
    {
        return $series instanceof Formula;
    }

    /** @var Formula $series */
    public function getRange2D(Series $series): Range2D
    {
        if (isset($series->chart->xAxis->pixelAtOrigin)) {
            $data = $this->getData($series);
        }
        else {
            $data = $this->estimateData($series);
        }

        [$min, $max] = $this->minMaxFinder->find($data);

        return new Range2D($data[0]->key, $data[count($data) - 1]->key, $min, $max);
    }

    /** @return Datum[] */
    private function estimateData(Formula $series): array
    {
        $values = [];
        $range = ($series->to - $series->from) / 100;

        for ($p = 0; $p <= 100; $p += 10) {
            $key = $series->from + $p * $range;
            $values[] = new Datum($key, ($series->formula)($key, $series->chart));
        }

        return $values;
    }

    /** @var Formula $series */
    public function getData(Series $series): array
    {
        if (isset($series->values)) {
            return $series->values;
        }

        $fromX = floor($this->mapper->valueToCoordinate($series->chart->xAxis, $series->from));
        $toX = ceil($this->mapper->valueToCoordinate($series->chart->xAxis, $series->to));
        $series->values = [];

        for ($x = $fromX; $x <= $toX; ++$x) {
            $key = $this->mapper->coordinateToValue($series->chart->xAxis, $x);
            $series->values[] = new Datum($key, ($series->formula)($key, $series->chart));
        }

        return $series->values;
    }
}
