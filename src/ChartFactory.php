<?php

declare(strict_types=1);

namespace Medas\Charts;

use Medas\Core\Attributes\Service;

#[Service]
readonly class ChartFactory
{
    public function __construct(
        private Axes\AxisFactory                          $axisFactory,
        private Data\DataSettingsFactory                  $dataSettingsFactory,
        private Graphs\BarGraph\BarGraphSettingsFactory   $barGraphSettingsFactory,
        private Graphs\GraphSettingsFactory               $graphSettingsFactory,
        private Graphs\Histogram\HistogramSettingsFactory $histogramSettingsFactory,
        private Graphs\Lines\LineSettingsFactory          $lineSettingsFactory,
        private Graphs\Markers\MarkerSettingsFactory      $markerSettingsFactory,
        private Grid\GridFactory                          $gridFactory,
        private Image\ImageSettingsFactory                $imageSettingsFactory,
        private Legend\LegendSettingsFactory              $legendSettingsFactory,
        private Settings\ChartSettingsFactory             $chartSettingsFactory,
        private Settings\ColorSettingsFactory             $colorSettingsFactory,
        private Settings\FontSettingsFactory              $fontSettingsFactory,
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
        $chart->grid = $this->gridFactory->create();

        // Settings
        $chart->imageSettings = $this->imageSettingsFactory->create();
        $chart->chartSettings = $this->chartSettingsFactory->create();
        $chart->fontSettings = $this->fontSettingsFactory->create();
        $chart->colorSettings = $this->colorSettingsFactory->create();
        $chart->legendSettings = $this->legendSettingsFactory->create();

        // Data settings
        $chart->dataSettings = $this->dataSettingsFactory->create();

        // Graph settings
        $chart->graphSettings = $this->graphSettingsFactory->create();
        $chart->barGraphSettings = $this->barGraphSettingsFactory->create();
        $chart->histogramSettings = $this->histogramSettingsFactory->create();
        $chart->lineSettings = $this->lineSettingsFactory->create();
        $chart->markerSettings = $this->markerSettingsFactory->create();

        return $chart;
    }
}
