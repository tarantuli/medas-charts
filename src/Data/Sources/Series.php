<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources;

interface Series
{
    public function name(): string|null;
}
