<?php

declare(strict_types=1);

namespace Medas\Charts\Data;

use Medas\Charts\Chart;
use Medas\Core\Attributes\Service;

#[Service]
readonly class DataController
{
    public function add(Chart $chart, Data $data, string $name = null): string
    {
        $name = $this->determineName($chart, $name);
        $chart->data[$name] = $data;

        return $name;
    }

    private function determineName(Chart $chart, ?string $name): string
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
}
