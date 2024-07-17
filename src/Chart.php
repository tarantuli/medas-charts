<?php

declare(strict_types=1);

namespace Medas\Charts;

use Medas\ImageDrawer\ImageSettings;

class Chart
{
    // Elements
    public Axes\XAxis $xAxis;
    public Axes\YAxis $yAxis;
    public Axes\Y2Axis $y2Axis;
    public Grid\Grid $grid;

    // Settings
    public ImageSettings $imageSettings;
    public Chart\ChartSettings $chartSettings;
    public Settings\FontSettings $fontSettings;
    public Settings\ColorSettings $colorSettings;
    public Legend\LegendSettings $legendSettings;
    public Image\SizeLock $sizeLock;

    // Data settings
    public Data\DataSettings $dataSettings;

    // Graph settings
    public Graphs\GraphSettings $graphSettings;
    public Graphs\BarGraph\BarGraphSettings $barGraphSettings;
    public Graphs\Histogram\HistogramSettings $histogramSettings;
    public Graphs\Lines\LineSettings $lineSettings;
    public Graphs\Markers\MarkerSettings $markerSettings;

    // Titles
    public float $titleHeight;

    // Data
    /** @var Data\Sources\Series[] */
    public array $dataSeries = [];

    /**
     * @var Data\Sources\SeriesController[]
     * @noinspection PhpDocFieldTypeMismatchInspection
     */
    public \SplObjectStorage $seriesControllers;

    public Data\Range2D $range2D;

    // Graphs
    /** @var Graphs\Graph[] */
    public array $graphs = [];
}
