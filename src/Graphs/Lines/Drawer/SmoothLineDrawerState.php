<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

class SmoothLineDrawerState
{
    public float|null $prevX = null;
    public float|null $prevY = null;
    public array $ys2;
    public array $us;
    public array $xs = [];
    public array $ys = [];

    public function __construct(
        public int $count,
    )
    {
        $this->ys2 = array_fill(0, $count, 0);
        $this->us = array_fill(0, $count, 0);
    }
}
