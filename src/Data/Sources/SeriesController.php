<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources;

use Medas\Charts\Data\Range2D;

interface SeriesController
{
    public function canHandle(Series $series): bool;

    public function getRange2D(Series $series): Range2D;

    /** @return float[] */
    public function getKeys(Series $series): iterable;

    /** @return float[] */
    public function getValues(Series $series): iterable;
}
