<?php

declare(strict_types=1);

namespace Medas\Charts\Data\DataManager;

use Medas\Charts\Chart;
use Medas\Core\Attributes\Service;

#[Service]
readonly class GenericNameGenerator
{
    public function generate(Chart $chart): string
    {
        $counter = 1;

        do {
            $name = 'Data ' . $counter++;
        } while (array_key_exists($name, $chart->dataSeries));

        return $name;
    }
}
