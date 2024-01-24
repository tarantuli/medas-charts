<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources;

abstract class BaseSeries implements Series
{
    public function __construct(
        public string|null $name = null,
    )
    {
    }

    public function name(): string|null
    {
        return $this->name;
    }
}
