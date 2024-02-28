<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources;

use Medas\Charts\Data\Datum;
use Medas\Core\Attributes\Service;

#[Service]
readonly class MinMaxFinder
{
    /**
     * @param Datum[] $data
     *
     * @return array(min,max)
     */
    public function find(array $data): array
    {
        $min = null;
        $max = null;

        foreach ($data as $datum) {
            if ($min === null || $datum->value < $min) {
                $min = $datum->value;
            }

            if ($max === null || $datum->value > $max) {
                $max = $datum->value;
            }
        }

        return [$min, $max];
    }
}
