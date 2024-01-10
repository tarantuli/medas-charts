<?php

declare(strict_types=1);

namespace Medas\Charts;

class Chart
{
    // Elements
    public Axes\XAxis $xAxis;
    public Axes\YAxis $yAxis;
    public Axes\Y2Axis $y2Axis;
    public Grid\Grid $grid;

    // Settings
    public Image\ImageSettings $imageSettings;
    public Settings\ChartSettings $chartSettings;
    public Settings\FontSettings $fontSettings;
    public Settings\ColorSettings $colorSettings;
    public Legend\LegendSettings $legendSettings;

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
    public /** @var Data\Data[] */ array $data = [];
    public Data\Range2D $range2D;

    // Graphs
    public /** @var Graphs\Graph[] */ array $graphs = [];
}
