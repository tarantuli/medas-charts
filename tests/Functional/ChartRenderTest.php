<?php

declare(strict_types=1);

namespace Medas\ChartsTest\Functional;

use Medas\Charts\ChartFactory;
use Medas\Charts\Data\DataManager;
use Medas\Charts\Data\Sources\KeyToValueArray\KeyToValueArray;
use Medas\Charts\Graphs\GraphController;
use Medas\Charts\Graphs\Lines\LineGraphFactory;
use Medas\Charts\Graphs\Markers\Types\{Polygons\Pentagon, Squares\Square};
use Medas\Charts\Graphs\YAxisType;
use Medas\Charts\Image\Image;
use Medas\Charts\Rendering\Renderer;
use Medas\ImageManager\ColorManager;
use PHPUnit\Framework\TestCase;

class ChartRenderTest extends TestCase
{
    public function testRender(): void
    {
        $chart = service(ChartFactory::class)->create();
        $dataManager = service(DataManager::class);

        // Circle markers
        $dataName = $dataManager->addSeries(
            $chart,
            new KeyToValueArray([0 => 0, 1 => .1, 3 => 1.2, 4 => 1.2, 5 => 2.8])
        );

        $squareMarkerGraph = service(LineGraphFactory::class)->create(YAxisType::Y, $dataName);

        service(GraphController::class)->add($chart, $squareMarkerGraph);

        // Square markers
        $dataName = $dataManager->addSeries(
            $chart,
            new KeyToValueArray([0 => 0, 1 => 1.1, 3 => 1.2, 4 => 0.2, 5 => .8])
        );

        $squareMarkerGraph = service(LineGraphFactory::class)->create(YAxisType::Y, $dataName);

        $squareMarkerGraph->markerSettings->type = new Square();
        $squareMarkerGraph->lineSettings->drawSquaredLine = true;

        service(GraphController::class)->add($chart, $squareMarkerGraph);

        // Pentagons markers
        $dataName = $dataManager->addSeries(
            $chart,
            new KeyToValueArray([0 => 0, 1 => 2.1, 3 => 1.2, 4 => 2.2, 5 => 1.8])
        );

        $pentagonMarkerGraph = service(LineGraphFactory::class)->create(YAxisType::Y, $dataName);

        $pentagonMarkerGraph->markerSettings->type = new Pentagon();
        $pentagonMarkerGraph->lineSettings->drawSmoothLine = true;

        service(GraphController::class)->add($chart, $pentagonMarkerGraph);

        $chart->imageSettings->backgroundColor = service(ColorManager::class)->fromHtmlString('#fff');
        $image = service(Renderer::class)->render($chart);

        self::assertInstanceOf(Image::class, $image);

        imagepng($image->resource, 'var/test-output.png');
    }
}
