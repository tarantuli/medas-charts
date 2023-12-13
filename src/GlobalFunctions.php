<?php

declare(strict_types=1);

use Medas\Charts\Number;

// This file should be in the global namespace
function is_nihil(float $value): bool
{
    return Number::SMALL_NEGATIVE < $value && $value < Number::SMALL_POSITIVE;
}
