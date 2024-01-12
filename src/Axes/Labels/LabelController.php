<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\Labels;

use Medas\Charts\Axes\{Axis, IntervalTypes\IterationType};
use Medas\Charts\Number;
use Medas\Core\Attributes\Service;

#[Service]
readonly class LabelController
{
    /** @return Label[] */
    public function labels(Axis $axis): array
    {
        if (isset($axis->labels)) {
            return $axis->labels;
        }

        return $axis->labels = $this->generate($axis);
    }

    /** @return Label[] */
    private function generate(Axis $axis): array
    {
        $labels = [];
        $i = 0;

        do {
            switch ($axis->iterationType) {
                case IterationType::Linear:
                    $value = $axis->min + $i * $axis->interval;

                    break;

                case IterationType::Daily:
                    $value = mktime(
                        0,
                        0,
                        0,
                        (int) date('m', $axis->min),
                        ((int) date('d', $axis->min)) + $i * $axis->interval / Number::ONE_DAY,
                        (int) date('Y', $axis->min)
                    );

                    break;

                case IterationType::Monthly:
                    $month = ((int) date('m', $axis->min)) + $i * $axis->interval;
                    $value = mktime(0, 0, 0, $month, 1, (int) date('Y', $axis->min));

                    break;

                case IterationType::Yearly:
                    $year = ((int) date('Y', $axis->min)) + $i * $axis->interval;
                    $value = mktime(0, 0, 0, 1, 1, $year);

                    break;

                /** @noinspection PhpUnusedSwitchBranchInspection */
                default:
                    throw new \Exception('unhandled IterationType ' . $axis->iterationType->name);
            }

            if (!$this->isValid($axis, $value)) {
                break;
            }

            $labels[] = new Label($value);

            ++$i;
        } while (true);

        return $labels;
    }

    private function isValid(Axis $axis, int|float $value): bool
    {
        if ($axis->hasZeroRange && is_nihil($axis->hasZeroRangeAt)) {
            return false;
        }

        return Number::isLessThanOrEqual($value, $axis->max);
    }
}
