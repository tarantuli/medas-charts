<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

class LineDrawerState
{
    public float|null $prevX = null;
    public float|null $prevY = null;
    public float|null $prevKey = null;
    public bool $prevXIsUnconnected = false;
}
