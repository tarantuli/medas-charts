<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\Labels;

use Medas\Core\Attributes\Service;

#[Service]
readonly class LabelFormatter
{
    public function format(Label $label): string
    {
        if (isset($label->formatted)) {
            return $label->formatted;
        }

        return $label->formatted = (string) $label->value;
    }
}
