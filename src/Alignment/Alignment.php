<?php

declare(strict_types=1);

namespace Medas\Charts\Alignment;

class Alignment
{
    public function __construct(
        public Horizontal $horizontal = Horizontal::Left,
        public Vertical   $vertical = Vertical::Bottom,
    )
    {
    }
}
