<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\Labels;

class Label
{
    public string $formatted;

    public function __construct(
        public mixed $value,
    )
    {
    }
}
