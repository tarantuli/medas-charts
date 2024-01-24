<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources\Formulas;

use Medas\Charts\Chart;
use Medas\Charts\Data\Sources\BaseSeries;

class Formula extends BaseSeries
{
    public array $values;

    public function __construct(
        public Chart       $chart,
        public \Closure    $formula,
        public float       $from,
        public float       $to,
        public string|null $name = null,
    )
    {
        parent::__construct($this->name);
    }
}
