<?php

declare(strict_types=1);

namespace Medas\Charts\Axes\Labels;

use Medas\Charts\Axes\{Axis, IntervalTypes\IterationType};
use Medas\Charts\Number;
use Medas\Core\Attributes\Service;

#[Service]
readonly class SubLabelController
{
    /** @return Label[] */
    public function labels(Axis $axis, float $mainValue): array
    {
        $labels = [];
        $subIndex = 1;

        do {
            switch ($axis->iterationType) {
                case IterationType::Linear:
                    $value = $axis->minValue + $mainValue + $subIndex * $axis->subgridInterval;

                    break;

                case IterationType::Daily:
                    $value = mktime(
                        0,
                        0,
                        0,
                        (int) date('m', $axis->minValue),
                        (int) (((int) date(
                            'd',
                            $axis->minValue
                        )) + $mainValue + $subIndex * $axis->subgridInterval / Number::ONE_DAY),
                        (int) date('Y', $axis->minValue)
                    );

                    break;

                case IterationType::Monthly:
                    $month = (int) (((int) date('m', $axis->minValue)) + $mainValue + $subIndex * $axis->subgridInterval);
                    $value = mktime(0, 0, 0, $month, 1, (int) date('Y', $axis->minValue));

                    break;

                case IterationType::Yearly:
                    $year = (int) (((int) date('Y', $axis->minValue)) + $mainValue + $subIndex * $axis->subgridInterval);
                    $value = mktime(0, 0, 0, 1, 1, $year);

                    break;

                /** @noinspection PhpUnusedSwitchBranchInspection */
                default:
                    throw new \Exception('unhandled IterationType ' . $axis->iterationType->name);
            }

            ++$subIndex;

            if (!$this->isValid($axis, $subIndex)) {
                break;
            }

            $labels[] = new Label($value);
        } while (true);

        return $labels;
    }

    private function isValid(Axis $axis, int $subIndex): bool
    {
        if ($axis->hasZeroRange && is_nihil($axis->hasZeroRangeAt)) {
            return false;
        }

        return $subIndex <= $axis->subgridCount;
    }
}
