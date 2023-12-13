<?php

declare(strict_types=1);

namespace Medas\ChartsTest\Functional;

use Medas\Charts\ChartFactory;
use Medas\Charts\Data\KeyToValueArray\KeyToValueArray;
use Medas\Charts\Graphs\Lines\LineGraph;
use Medas\Charts\Rendering\Renderer;
use Medas\ImageManager\Image;
use PHPUnit\Framework\TestCase;

class ChartRenderTest extends TestCase
{
    public function testRender(): void
    {
        $chart = service(ChartFactory::class)->create(
            new KeyToValueArray([1 => 1, 4 => 2, 5 => 3]),
            LineGraph::class
        );

        $image = service(Renderer::class)->render($chart);

        self::assertInstanceOf(Image::class, $image);
    }
}
