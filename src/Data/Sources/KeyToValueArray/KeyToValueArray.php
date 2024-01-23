<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources\KeyToValueArray;

use Medas\Charts\Data\Sources\Series;
use Medas\Core\Collections\BasicCollection;

class KeyToValueArray extends BasicCollection implements Series
{
    public function __construct(
        array              $data,
        public string|null $name = null,
    )
    {
        parent::__construct($data);
    }

    public function name(): string|null
    {
        return $this->name;
    }

    public function data(): array
    {
        return $this->data;
    }
}
