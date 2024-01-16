<?php

declare(strict_types=1);

namespace Medas\Charts\Data;

use Medas\Core\Collections\BasicCollection;

abstract class Data extends BasicCollection
{
    public float $interval;
}
