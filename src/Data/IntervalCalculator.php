<?php

declare(strict_types=1);

namespace Medas\Charts\Data;

use Medas\Core\Attributes\Service;

#[Service]
readonly class IntervalCalculator
{
    public function calculate(Data $data): float
    {
        if (isset($data->interval)) {
            return $data->interval;
        }

        $intervals = [];
        $previousX = null;

        foreach ($data as $x => $y) {
            if ($previousX !== null) {
                $i = (string) ($x - $previousX);

                if ($i === '0') {
                    continue;
                }

                if (!isset($intervals[$i])) {
                    $intervals[$i] = 0;
                }

                ++$intervals[$i];
            }

            $previousX = $x;
        }

        if (!count($intervals)) {
            throw new \Exception('not enough data');
        }

        $maxCount = max($intervals);
        $interval = array_search($maxCount, $intervals);

        unset($intervals[$interval]);

        if (count($intervals)) {
            $nextMaxCount = max($intervals);
            $nextInterval = array_search($nextMaxCount, $intervals);

            if ($nextMaxCount / $maxCount >= .8 && $nextInterval > $interval) {
                $interval = $nextInterval;
            }
        }

        return $data->interval = $interval;
    }
}
