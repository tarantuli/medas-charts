<?php

declare(strict_types=1);

namespace Medas\Charts\Chart;

use Medas\Charts\Colors\ColorScheme;
use Medas\ImageDrawer\{Colors\Color, TextSettings};

class ChartSettings
{
    public int $height;
    public int $width;
    public string $locale;
    public string|null $title;
    public TextSettings $titleSettings;
    public float $allowedDataGridOverflow;
    public ColorScheme $colorScheme;
    public Color $gridColor;
    public Color $subGridColor;
    public string $isOnY2NameMarker;

    // Show toggles
    public bool $showTitle;
    public bool $showLegend;
}
