<?php

declare(strict_types=1);

namespace Medas\Charts\Data;

use Medas\Charts\Chart;
use Medas\Core\Attributes\Service;

#[Service]
readonly class DataController
{
    public function __construct(
        private KeyToValueArray\KeyToValueArrayController $keyToValueArrayController,
    )
    {
    }

    public function add(Chart $chart, Data $data, string $name = null): string
    {
        $name = $this->determineName($chart, $name);
        $chart->data[$name] = $data;

        return $name;
    }

    private function determineName(Chart $chart, string|null $name): string
    {
        if ($name !== null) {
            return $name;
        }

        $counter = 1;

        do {
            $name = 'Data ' . $counter++;
        } while (array_key_exists($name, $chart->data));

        return $name;
    }

    public function getXs(Chart $chart): array
    {
        $xs = [];

        foreach ($chart->data as $data) {
            $xs = array_merge($xs, match ($data::class) {
                KeyToValueArray\KeyToValueArray::class => $this->keyToValueArrayController->getXs($data),
            });
        }

        return $xs;
    }

    public function determineRange2D(Chart $chart, string $dataName): Range2D
    {
        $data = $chart->data[$dataName];

        return match ($data::class) {
            KeyToValueArray\KeyToValueArray::class => $this->keyToValueArrayController->getRange2D($data),
        };
    }
}
