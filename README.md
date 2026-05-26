# medas-charts

Part of the [Medas framework](https://github.com/tarantuli/medas-core).

## Description

Renders data series as GD-based raster images. A `Chart` object acts as a configuration container holding axis settings, graph definitions, data series, legend settings, colours, and fonts. Once populated, `Renderer::render()` produces a `Image` value object that can be output as PNG, JPEG, or any other format supported by `medas-image-drawer`.

Supported graph types:

| Type | Class | Notes |
|---|---|---|
| Line | `LineGraph` | Optional smooth or straight interpolation; optional point markers |
| Bar | `BarGraph` | Vertical bars per category |
| Histogram | Histogram settings on a `BarGraph` | Bucket-based frequency distribution |

Data can be fed in through three source types:

| Source | Class | Shape |
|---|---|---|
| Key→value pairs | `KeyToValueArray` | `['label' => value, ...]` |
| Array of arrays | `ArrayOfArrays` | `[[$x, $y], ...]` |
| Formula (closure) | `Formula` | `fn(float $x): float` evaluated over a range |

Each graph references a named data series and is bound to either the primary (`YAxisType::Y`) or secondary (`YAxisType::Y2`) Y axis. Axes support numeric, datetime, and categorised interval types. Colours are assigned automatically from a `ColorScheme` or can be set explicitly per graph.

## Usage

### Package developer context

Register the package and inject `ChartFactory`, `DataManager`, `LineGraphFactory`, and `Renderer`:

```php
use Medas\Charts\ChartsPackage;
use Medas\Charts\ChartFactory;
use Medas\Charts\Data\DataManager;
use Medas\Charts\Data\Sources\KeyToValueArray\KeyToValueArray;
use Medas\Charts\Data\Sources\ArrayOfArrays\ArrayOfArrays;
use Medas\Charts\Data\Sources\Formulas\Formula;
use Medas\Charts\Graphs\Lines\LineGraphFactory;
use Medas\Charts\Graphs\BarGraph\BarGraph;
use Medas\Charts\Graphs\YAxisType;
use Medas\Charts\Image\SizeLock;
use Medas\Charts\Rendering\Renderer;
use Medas\Core\Attributes\Service;

// Register the package with the framework bootstrapper
ChartsPackage::instance();
```

**Line chart from key→value data:**

```php
#[Service]
readonly class SalesChartGenerator
{
    public function __construct(
        private ChartFactory     $chartFactory,
        private DataManager      $dataManager,
        private LineGraphFactory $lineGraphFactory,
        private Renderer         $renderer,
    ) {}

    public function generate(array $monthlySales): string
    {
        $chart = $this->chartFactory->create();

        // Configure the chart
        $chart->chartSettings->title = 'Monthly Sales';
        $chart->chartSettings->width = 900;
        $chart->chartSettings->height = 400;
        $chart->imageSettings->width = 900;
        $chart->imageSettings->height = 400;

        // Add a key→value data series: ['Jan' => 1200, 'Feb' => 980, ...]
        $series = new KeyToValueArray(pairs: $monthlySales, name: 'Sales');
        $this->dataManager->addSource($chart, $series);

        // Add a line graph bound to the primary Y axis
        $graph = $this->lineGraphFactory->create(
            YAxisType: YAxisType::Y,
            seriesName: 'Sales',
        );
        $chart->graphs[] = $graph;

        // Render and return as a PNG data URI
        $image = $this->renderer->render($chart);

        ob_start();
        imagepng($image->resource);

        return 'data:image/png;base64,' . base64_encode(ob_get_clean());
    }
}
```

**Bar chart from an array of [x, y] pairs:**

```php
#[Service]
readonly class ScoreChartGenerator
{
    public function __construct(
        private ChartFactory $chartFactory,
        private DataManager  $dataManager,
        private Renderer     $renderer,
    ) {}

    public function generate(array $xyPairs): \GdImage
    {
        $chart = $this->chartFactory->create();

        $chart->chartSettings->width = 800;
        $chart->chartSettings->height = 350;
        $chart->imageSettings->width = 800;
        $chart->imageSettings->height = 350;

        // $xyPairs: [[1, 42], [2, 87], [3, 65], ...]
        $series = new ArrayOfArrays(data: $xyPairs, name: 'Scores');
        $this->dataManager->addSeries($chart, $series);

        $chart->graphs[] = new BarGraph(
            YAxisType: YAxisType::Y,
            seriesName: 'Scores',
        );

        return $this->renderer->render($chart)->resource;
    }
}
```

**Formula-based line graph (e.g. a sine curve):**

```php
$chart = $this->chartFactory->create();

$chart->chartSettings->width = 700;
$chart->chartSettings->height = 300;
$chart->imageSettings->width = 700;
$chart->imageSettings->height = 300;

$formula = new Formula(
    chart: $chart,
    formula: fn(float $x): float => sin($x),
    from: 0,
    to: 2 * M_PI,
    name: 'sin(x)',
);
$this->dataManager->addSeries($chart, $formula);

$graph = $this->lineGraphFactory->create(YAxisType::Y, 'sin(x)');
$graph->showMarkers = false;
$chart->graphs[] = $graph;

$image = $this->renderer->render($chart);
```

**Dual-axis chart** — bind one series to `YAxisType::Y` and another to `YAxisType::Y2`:

```php
$this->dataManager->addSeries($chart, new KeyToValueArray($revenueData, 'Revenue'));
$this->dataManager->addSeries($chart, new KeyToValueArray($unitData, 'Units'));

$revenueGraph = $this->lineGraphFactory->create(YAxisType::Y, 'Revenue');
$unitsGraph   = $this->lineGraphFactory->create(YAxisType::Y2, 'Units');

$chart->graphs[] = $revenueGraph;
$chart->graphs[] = $unitsGraph;
```

**Locking chart vs image size:**

```php
// SizeLock::ImageSize (default) — the full image (including axes and legend)
// fits within imageSettings->width × imageSettings->height.
$chart->sizeLock = SizeLock::ImageSize;

// SizeLock::ChartSize — the plot area itself has the specified dimensions;
// the image grows to accommodate labels and legend around it.
$chart->sizeLock = SizeLock::ChartSize;
```

### Backend user context

Charts are typically built and rendered inside a controller or a dedicated chart-service class. The rendered `Image` can be saved to disk, streamed directly as an HTTP response, or converted to a data URI for embedding.

**Streaming a chart as an HTTP response:**

```php
$image = $renderer->render($chart);

header('Content-Type: image/png');
imagepng($image->resource);
exit;
```

**Saving a chart to a file:**

```php
$image = $renderer->render($chart);

imagepng($image->resource, '/var/www/html/charts/sales-2026-05.png');
imagedestroy($image->resource);
```

**Embedding a chart inline in HTML:**

```php
$image = $renderer->render($chart);

ob_start();
imagepng($image->resource);
$png = ob_get_clean();

echo '<img src="data:image/png;base64,' . base64_encode($png) . '" alt="Sales chart">';
```

**Customising axis labels and title:**

```php
$chart->chartSettings->title = 'Weekly Active Users';
$chart->chartSettings->showTitle = true;
$chart->chartSettings->showLegend = true;

$chart->xAxis->settings->title = 'Week';
$chart->xAxis->settings->showTitle = true;
$chart->xAxis->settings->showLabels = true;

$chart->yAxis->settings->title = 'Users';
$chart->yAxis->settings->showTitle = true;
$chart->yAxis->settings->labelFormat = '%d';
```
