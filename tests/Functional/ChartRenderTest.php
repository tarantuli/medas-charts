<?php

declare(strict_types=1);

namespace Medas\ChartsTest\Functional;

use Medas\Charts\ChartFactory;
use Medas\Charts\Data\KeyToValueArray\KeyToValueArray;
use Medas\Charts\Graphs\Lines\LineGraph;
use Medas\Charts\Image\Image;
use Medas\Charts\Rendering\Renderer;
use Medas\ImageManager\ColorManager;
use PHPUnit\Framework\TestCase;

class ChartRenderTest extends TestCase
{
    public function testRender(): void
    {
        $chart = service(ChartFactory::class)->create(
            new KeyToValueArray([1 => .1, 4 => 1.2, 5 => 2.8]),
            LineGraph::class
        );

        $chart->imageSettings->backgroundColor = service(ColorManager::class)->fromHtmlString('#fff');

        $image = service(Renderer::class)->render($chart);

        self::assertInstanceOf(Image::class, $image);

        imagepng($image->resource, 'var/test-output.png');
    }
}
