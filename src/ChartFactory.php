<?php

declare(strict_types=1);

namespace Medas\Charts;

use Medas\Core\Attributes\Service;

#[Service]
readonly class ChartFactory
{
    public function __construct(
        private Axes\AxisFactory                                  $axisFactory,
        private Data\DataSettingsFactory                          $dataSettingsFactory,
        private Image\ImageSettingsFactory                        $imageSettingsFactory,
        private Legend\LegendSettingsFactory                      $legendSettingsFactory,
        private Settings\ChartSettingsFactory                     $chartSettingsFactory,
        private Settings\ColorSettingsFactory                     $colorSettingsFactory,
        private Settings\FontSettingsFactory                      $fontSettingsFactory,
        private Visualisations\BarGraph\BarGraphSettingsFactory   $barGraphSettingsFactory,
        private Visualisations\Histogram\HistogramSettingsFactory $histogramSettingsFactory,
        private Visualisations\Lines\LineSettingsFactory          $lineSettingsFactory,
        private Visualisations\Markers\MarkerSettingsFactory      $markerSettingsFactory,
        private Visualisations\VisualisationSettingsFactory       $visualisationSettingsFactory,
    )
    {
    }

    public function create(): Chart
    {
        $chart = new Chart();

        // Elements
        $chart->xAxis = $this->axisFactory->createXAxis();
        $chart->yAxis = $this->axisFactory->createYAxis();
        $chart->y2Axis = $this->axisFactory->createY2Axis();
        $chart->legendSettings = $this->legendSettingsFactory->create();

        // Settings
        $chart->imageSettings = $this->imageSettingsFactory->create();
        $chart->chartSettings = $this->chartSettingsFactory->create();
        $chart->fontSettings = $this->fontSettingsFactory->create();
        $chart->colorSettings = $this->colorSettingsFactory->create();
        $chart->axisSettings = $this->axisFactory->createAxisSettings();

        // Data settings
        $chart->dataSettings = $this->dataSettingsFactory->create();

        // Visualisation settings
        $chart->visualisationSettings = $this->visualisationSettingsFactory->create();
        $chart->barGraphSettings = $this->barGraphSettingsFactory->create();
        $chart->histogramSettings = $this->histogramSettingsFactory->create();
        $chart->lineSettings = $this->lineSettingsFactory->create();
        $chart->markerSettings = $this->markerSettingsFactory->create();

        return $chart;
    }
}
