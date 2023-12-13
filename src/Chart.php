<?php

declare(strict_types=1);

namespace Medas\Charts;

class Chart
{
    // Elements
    public Axes\XAxis $xAxis;
    public Axes\YAxis $yAxis;
    public Axes\Y2Axis $y2Axis;

    // Settings
    public Image\ImageSettings $imageSettings;
    public Settings\ChartSettings $chartSettings;
    public Settings\FontSettings $fontSettings;
    public Settings\ColorSettings $colorSettings;
    public Axes\AxisSettings $axisSettings;
    public Legend\LegendSettings $legendSettings;

    // Data settings
    public Data\DataSettings $dataSettings;

    // Visualisation settings
    public Visualisations\VisualisationSettings $visualisationSettings;
    public Visualisations\BarGraph\BarGraphSettings $barGraphSettings;
    public Visualisations\Histogram\HistogramSettings $histogramSettings;
    public Visualisations\Lines\LineSettings $lineSettings;
    public Visualisations\Markers\MarkerSettings $markerSettings;
}
