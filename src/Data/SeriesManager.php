<?php

declare(strict_types=1);

namespace Medas\Charts\Data;

use Medas\Charts\Chart;
use Medas\Core\Attributes\Service;

#[Service]
readonly class SeriesManager
{
    public function getRange2D(Chart $chart, string $name): Range2D
    {
        if (!array_key_exists($name, $chart->dataSeries)) {
            throw new Exceptions\SeriesNotFoundByName($name);
        }

        $series = $chart->dataSeries[$name];

        return $chart->seriesControllers[$series]->getRange2D($series);
    }

    /** @return float[] */
    public function getKeys(Chart $chart, string $name): iterable
    {
        if (!array_key_exists($name, $chart->dataSeries)) {
            throw new Exceptions\SeriesNotFoundByName($name);
        }

        $series = $chart->dataSeries[$name];
        $controller = $chart->seriesControllers[$series];

        return $controller instanceof Sources\ArrayOfArrays\ArrayOfArraysController
            ? $controller->getKeys($series)
            : [];
    }

    /** @return Datum[] */
    public function getData(Chart $chart, string $name): iterable
    {
        if (!array_key_exists($name, $chart->dataSeries)) {
            throw new Exceptions\SeriesNotFoundByName($name);
        }

        $series = $chart->dataSeries[$name];

        return $chart->seriesControllers[$series]->getData($series);
    }
}
