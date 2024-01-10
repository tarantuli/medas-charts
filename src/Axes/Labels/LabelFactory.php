<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\Labels;

use Medas\Core\Attributes\Service;

#[Service]
readonly class LabelFactory
{
    public function build(mixed $value): Label
    {
        return new Label($value);
    }
}
