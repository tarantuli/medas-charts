<?php

declare(strict_types=1);

namespace Medas\Charts\Data\KeyToValueArray;

use Medas\Charts\Data\Data;

class KeyToValueArray extends Data
{
    public function minX(): float
    {
        return min(array_keys($this->data));
    }

    public function maxX(): float
    {
        return max(array_keys($this->data));
    }

    public function minY(): float
    {
        return min($this->data);
    }

    public function maxY(): float
    {
        return max($this->data);
    }
}
