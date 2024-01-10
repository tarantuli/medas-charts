<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

use Medas\Charts\Text\BoundingBoxFactory;
use Medas\Core\Attributes\Service;

#[Service]
readonly class CrossWidthCalculator
{
    public function __construct(
        private BoundingBoxFactory $boundingBoxFactory,
    )
    {
    }

    public function totalWidth(Axis $axis): float
    {
        if (isset($axis->crossWidth)) {
            return $axis->crossWidth;
        }

        if ($axis->settings->showTitle && strlen($axis->settings->title) >= 1) {
            $height = $this->boundingBoxFactory->create(
                $axis->settings->title,
                $axis->settings->titleSettings->font,
                $axis->settings->titleSettings->size,
            )->height;

            $titleWidth = $height + $axis->settings->titleSettings->margin;
        }
        else {
            $titleWidth = 0;
        }

        $labelWidth = $this->labelWidth();

        return $axis->crossWidth = $this->tickWidth($axis) + $labelWidth + $titleWidth;
    }

    public function tickWidth(Axis $axis): float
    {
        if ($axis->settings->showTicks) {
            return $axis->settings->tickLength + $axis->settings->tickMargin;
        }

        return 0.0;
    }

    public function labelWidth(): float
    {
        // Todo
        return 0.0;
    }
}
