<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources\ArrayOfArrays;

use Medas\Charts\Data\Sources\BaseSeries;

class ArrayOfArrays extends BaseSeries
{
    public function __construct(
        public array $data,
        string|null  $name = null,
    )
    {
        parent::__construct($name);
    }
}
