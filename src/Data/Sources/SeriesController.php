<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources;

use Medas\Charts\Data\{Datum, Range2D};

interface SeriesController
{
    public function canHandle(Series $series): bool;

    public function getRange2D(Series $series): Range2D;

    /** @return Datum[] */
    public function getData(Series $series): iterable;
}
