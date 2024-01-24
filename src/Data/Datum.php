<?php

declare(strict_types=1);

namespace Medas\Charts\Data;

class Datum
{
    public function __construct(
        public float $key,
        public float $value,
    )
    {
    }
}
