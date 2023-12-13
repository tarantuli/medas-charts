<?php

declare(strict_types=1);

namespace Medas\ChartsTest\Functional;

use Medas\Charts\{Chart, ChartFactory};
use PHPUnit\Framework\TestCase;

class ChartFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $chart = service(ChartFactory::class)->create();

        self::assertInstanceOf(Chart::class, $chart);
    }
}
