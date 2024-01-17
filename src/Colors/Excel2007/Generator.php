<?php

declare(strict_types=1);

namespace Medas\Charts\Colors\Excel2007;

use Medas\Charts\Rendering\Job;
use Medas\Core\Attributes\Service;
use Medas\ImageManager\{Color, ColorManager};

#[Service]
readonly class Generator
{
    private const EXCEL2007_COLORS_LIST = [
        '#4572A7',
        '#AA4643',
        '#89A54E',
        '#71588F',
        '#4198AF',
        '#DB843D',
        '#93A9CF',
        '#D19392',
        '#B9CD96',
        '#A99BBD',
    ];
    private const COLOR_COUNT = 10;

    public function __construct(
        private ColorManager $colorManager,
    )
    {
    }

    public function generate(Job $job): Color
    {
        $index = $job->generatedColorCounter++ % self::COLOR_COUNT;

        return $this->colorManager->fromHtmlString(self::EXCEL2007_COLORS_LIST[$index]);
    }
}
