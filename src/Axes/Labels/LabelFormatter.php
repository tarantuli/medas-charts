<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\Labels;

use Medas\Charts\Axes\{Axis, IntervalTypes\IntervalType};
use Medas\Core\Attributes\Service;

#[Service]
readonly class LabelFormatter
{
    public function format(Axis $axis, Label $label, Label|null $previousLabel = null): string
    {
        if (isset($label->formatted)) {
            return $label->formatted;
        }

        if ($axis->settings->intervalType === IntervalType::Numeric) {
            if ($axis->settings->labelFormat !== null) {
                $value = sprintf($axis->settings->labelFormat, $label->value);
            }
            else {
                $formatter = new \NumberFormatter(locale_get_default(), \NumberFormatter::DECIMAL);

                $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, $axis->decimalCount);

                $value = $formatter->format($label->value);
            }

            return $label->formatted = $value;
        }

        if ($axis->settings->intervalType === IntervalType::DateTime) {
            $pattern = $axis->dateLabelFormat;

            if ($previousLabel !== null && str_contains($pattern, 'dd')) {
                if (date('Ymd', $previousLabel->value) === date('Ymd', $label->value)) {
                    $pattern = 'HH:mm';
                }
            }

            $formatter = new \IntlDateFormatter(locale_get_default(), pattern: $pattern);

            return $label->formatted = $formatter->format($label->value);
        }

        throw new \Exception('unhandled case');
    }
}
