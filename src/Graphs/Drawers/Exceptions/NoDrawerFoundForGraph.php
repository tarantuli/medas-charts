<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Drawers\Exceptions;

use Medas\Charts\Graphs\Graph;
use Medas\Core\Exceptions\BaseException;

class NoDrawerFoundForGraph extends BaseException
{
    public function __construct(Graph $graph)
    {
        parent::__construct($graph::class);
    }

    public function pattern(): string
    {
        return 'no drawer found that could implement graph of type %s';
    }
}
