<?php

declare(strict_types=1);

namespace Medas\Charts\Colors;

use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;
use Medas\ImageManager\Color;

#[Service]
readonly class ColorGenerator
{
    public function __construct(
        private Excel2007\Generator $excel2007Generator,
    )
    {
    }

    public function generate(Job $job): Color
    {
        if ($job->chart->chartSettings->colorScheme instanceof Excel2007\Excel2007) {
            return $this->excel2007Generator->generate($job);
        }

        throw new \Exception('not implemented ' . $job->chart->chartSettings->colorScheme::class);
    }
}
