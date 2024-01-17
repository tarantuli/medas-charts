<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Types\Polygons;

class Square extends Polygon
{
    public function __construct()
    {
        parent::__construct(4);
    }
}
