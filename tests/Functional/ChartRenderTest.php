<?php

declare(strict_types=1);

namespace Medas\ChartsTest\Functional;

use Medas\Charts\ChartFactory;
use Medas\Charts\Data\{DataController, Types\KeyToValueArray};
use Medas\Charts\Rendering\Renderer;
use Medas\ImageManager\Image;
use PHPUnit\Framework\TestCase;

class ChartRenderTest extends TestCase
{
    public function testRender(): void
    {
        $chart = service(ChartFactory::class)->create();

        $dataName = service(DataController::class)->add($chart, new KeyToValueArray([1 => 1, 4 => 2, 5 => 3]));

        $image = service(Renderer::class)->render($chart);

        self::assertInstanceOf(Image::class, $image);
    }
}
