<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources;

interface SourceController
{
    public function canHandle(Source $source): bool;

    /** @return Series[] */
    public function getSeries(Source $source): array;
}
