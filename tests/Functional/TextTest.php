<?php

declare(strict_types=1);

namespace Medas\ChartsTest\Functional;

use Medas\Charts\ChartFactory;
use Medas\Charts\Data\DataManager;
use Medas\Charts\Data\Sources\{Formulas\Formula};
use Medas\Charts\Graphs\GraphController;
use Medas\Charts\Graphs\Lines\LineGraphFactory;
use Medas\Charts\Graphs\YAxisType;
use Medas\Charts\Image\Image;
use Medas\Charts\Rendering\Renderer;
use Medas\ImageManager\ColorManager;
use PHPUnit\Framework\TestCase;

class TextTest extends TestCase
{
    public function testRender(): void
    {
        $chart = service(ChartFactory::class)->create();
        $dataManager = service(DataManager::class);
        $graphController = service(GraphController::class);
        $lineGraphFactory = service(LineGraphFactory::class);
        $chart->imageSettings->backgroundColor = service(ColorManager::class)->fromHtmlString('#fff');
        $chart->chartSettings->title = 'Text test chart';
        $chart->xAxis->settings->title = 'x-axis';
        $chart->yAxis->settings->title = 'y-axis';
        $chart->y2Axis->settings->title = 'y2-axis';

        // Formula
        $formula = $dataManager->addSeries(
            $chart,
            new Formula($chart, fn($x) => sin($x) + 1.9, 0.2, 4.6)
        );

        $graph = $lineGraphFactory->create(YAxisType::Y, $formula);

        $graph->showMarkers = false;

        $graphController->add($chart, $graph);

        // Render
        $image = service(Renderer::class)->render($chart);

        self::assertInstanceOf(Image::class, $image);

        imagepng($image->resource, 'var/test-output-text.png');
    }
}
