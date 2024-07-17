<?php

declare(strict_types=1);

namespace Medas\Charts\Colors\Excel2007;

use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;
use Medas\ImageDrawer\Colors\{Color, ColorFactory};

#[Service]
readonly class Generator
{
    private const EXCEL2007_COLORS_LIST = [
        '#4572a7',
        '#aa4643',
        '#89a54e',
        '#71588f',
        '#4198af',
        '#db843d',
        '#93a9cf',
        '#d19392',
        '#b9cd96',
        '#a99bbd',
    ];
    private const COLOR_COUNT = 10;

    public function __construct(
        private ColorFactory $colorFactory,
    )
    {
    }

    public function generate(Job $job): Color
    {
        $index = $job->generatedColorCounter++ % self::COLOR_COUNT;

        return $this->colorFactory->fromHtmlString(self::EXCEL2007_COLORS_LIST[$index]);
    }
}
