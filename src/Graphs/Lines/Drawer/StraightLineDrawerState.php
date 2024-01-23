<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Lines\Drawer;

class StraightLineDrawerState
{
    public float|null $prevX = null;
    public float|null $prevY = null;
    public bool $prevXIsUnconnected = false;
}
