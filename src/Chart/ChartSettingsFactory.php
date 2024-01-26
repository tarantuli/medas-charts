<?php

declare(strict_types=1);

namespace Medas\Charts\Chart;

use Medas\Charts\Alignment\{Alignment, Horizontal, Vertical};
use Medas\Charts\Colors\Excel2007\Excel2007;
use Medas\Charts\General\TextSettings;
use Medas\Core\Attributes\Service;
use Medas\ImageManager\ColorManager;

#[Service]
readonly class ChartSettingsFactory
{
    public function __construct(
        private ColorManager $manager,
    )
    {
    }

    public function create(): ChartSettings
    {
        $settings = new ChartSettings();

        $settings->height = 200;
        $settings->width = 300;
        $settings->locale = locale_get_default();
        $settings->title = null;

        $settings->titleSettings = new TextSettings(
            font: 'Rubik-Regular',
            size: 14,
            margin: 20,
            color: $this->manager->fromHtmlString('#000'),
            alignment: new Alignment(Horizontal::Center, Vertical::Middle)
        );

        $settings->allowedDataGridOverflow = 5.0;
        $settings->colorScheme = new Excel2007();
        $settings->gridColor = $this->manager->fromHtmlString('#c0c0d1');
        $settings->subGridColor = $this->manager->fromHtmlString('#dfdff2');
        $settings->showTitle = true;
        $settings->showLegend = false;
        $settings->isOnY2NameMarker = /** ► */ ' &#9658;';

        return $settings;
    }
}
