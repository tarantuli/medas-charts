<?php

declare(strict_types=1);

namespace Medas\Charts\Settings;

use Medas\Charts\{Colors\Excel2007, General\TextSettings};
use Medas\Core\Attributes\Service;
use Medas\ImageManager\ColorManager;

#[Service]
readonly class ChartSettingsFactory
{
    public function __construct(
        private ColorManager $manager,
        private Excel2007    $excel2007,
    )
    {
    }

    public function create(): ChartSettings
    {
        $settings = new ChartSettings();

        $settings->height = 200;
        $settings->width = 300;
        $settings->title = null;

        $settings->titleSettings = new TextSettings(
            font: 'trebucbd',
            size: 10,
            margin: 15,
            color: $this->manager->fromHtmlString('#000')
        );

        $settings->allowedDataGridOverflow = 5.0;
        $settings->colorScheme = $this->excel2007;
        $settings->gridColor = $this->manager->fromHtmlString('#c0c0d1');
        $settings->subGridColor = $this->manager->fromHtmlString('#dfdff2');
        $settings->pseudoAntialiasingFactor = 4;
        $settings->showTitle = true;
        $settings->showLegend = false;
        $settings->isOnY2NameMarker = ' &#9658;';

        return $settings;
    }
}
