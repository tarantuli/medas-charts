<?php

declare(strict_types=1);

namespace Medas\Charts\Text;

readonly class BoundingBox
{
    public function __construct(
        public int $lowerLeftX,
        public int $lowerLeftY,
        public int $lowerRightX,
        public int $lowerRightY,
        public int $upperRightX,
        public int $upperRightY,
        public int $upperLeftX,
        public int $upperLeftY,
        public int $width,
        public int $height,
    )
    {
    }
}
