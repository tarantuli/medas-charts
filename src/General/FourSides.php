<?php

declare(strict_types=1);

namespace Medas\Charts\General;

class FourSides
{
    public float $top;
    public float $right;
    public float $bottom;
    public float $left;

    public function __construct(
        float $top,
        float $right = null,
        float $bottom = null,
        float $left = null,
    )
    {
        $this->top = $top;
        $this->right = $right === null ? $this->top : $right;
        $this->bottom = $bottom === null ? $this->top : $bottom;
        $this->left = $left === null ? $this->right : $left;
    }
}
