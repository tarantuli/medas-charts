<?php

declare(strict_types=1);

namespace Medas\Charts\Data;

use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;

#[Service]
readonly class IntervalCalculator
{
    public function __construct(
        private SeriesManager $seriesManager,
    )
    {
    }

    public function calculate(Job $job, string $seriesName): float
    {
        if (isset($job->seriesIntervals[$seriesName])) {
            return $job->seriesIntervals[$seriesName];
        }

        $intervals = [];
        $previousX = null;

        foreach ($this->seriesManager->getData($job->chart, $seriesName) as $datum) {
            if ($previousX !== null) {
                $i = (string) ($datum->key - $previousX);

                if ($i === '0') {
                    continue;
                }

                if (!isset($intervals[$i])) {
                    $intervals[$i] = 0;
                }

                ++$intervals[$i];
            }

            $previousX = $datum->key;
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

        return $job->seriesIntervals[$seriesName] = (float) $interval;
    }
}
