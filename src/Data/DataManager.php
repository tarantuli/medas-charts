<?php

declare(strict_types=1);

namespace Medas\Charts\Data;

use Medas\Charts\Chart;
use Medas\Core\Attributes\Service;

#[Service]
readonly class DataManager
{
    public function __construct(
        private DataManager\GenericNameGenerator $genericNameGenerator,
        private Sources\SeriesControllerManager  $seriesManager,
        private Sources\SourceControllerManager  $sourceManager,
    )
    {
    }

    /**
     * @return  string[]  An array of names
     */
    public function addSource(Chart $chart, Sources\Source $source, bool $allowOverwrite = false): array
    {
        $sourceController = $this->sourceManager->controller($source);
        $names = [];

        foreach ($sourceController->getSeries($source) as $series) {
            $names[] = $this->addSeries($chart, $series, $allowOverwrite);
        }

        return $names;
    }

    public function addSeries(Chart $chart, Sources\Series $series, bool $allowOverwrite = false): string
    {
        $name = $series->name() ?? $this->genericNameGenerator->generate($chart);

        if (!$allowOverwrite && array_key_exists($name, $chart->dataSeries)) {
            throw new Exceptions\SeriesNameAlreadyInUse($name);
        }

        $chart->dataSeries[$name] = $series;
        $chart->seriesControllers[$series] = $this->seriesManager->controller($series);

        return $name;
    }

    public function getKeys(Chart $chart): array
    {
        $xs = [];

        foreach ($chart->dataSeries as $series) {
            $xs = array_merge(
                $xs,
                $this->returnKeys($chart->seriesControllers[$series]->getData($series))
            );
        }

        return array_unique($xs);
    }

    /** @var Datum[] $data */
    private function returnKeys(array $data): array
    {
        $keys = [];

        foreach ($data as $datum) {
            $keys[] = $datum->key;
        }

        return $keys;
    }
}
