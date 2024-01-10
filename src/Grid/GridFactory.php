<?php

declare(strict_types=1);

namespace Medas\Charts\Grid;

use Medas\Core\Attributes\Service;

#[Service]
readonly class GridFactory
{
    public function create(): Grid
    {
        return new Grid();
    }
}
