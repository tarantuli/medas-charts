<?php

declare(strict_types=1);

namespace Medas\Charts\General;

use Medas\ImageManager\Color;

class TextSettings
{
    public function __construct(
        public string|null $font,
        public float       $size,
        public float       $margin = 0.0,
        public Color|null  $color = null,
        public float       $angle = 0.0,
    )
    {
    }
}
