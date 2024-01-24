<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources\KeyToValueArray;

use Medas\Charts\Data\{Datum, Sources\Series};

class KeyToValueArray implements Series
{
    /** @var Datum[] */
    public array $data;

    public function __construct(
        public array       $pairs,
        public string|null $name = null,
    )
    {
    }

    public function name(): string|null
    {
        return $this->name;
    }
}
