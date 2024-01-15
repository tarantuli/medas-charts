<?php

declare(strict_types=1);

namespace Medas\Charts\Axes;

use Medas\Charts\Text\BoundingBoxFactory;
use Medas\Core\Attributes\Service;

#[Service]
readonly class CrossWidthCalculator
{
    public function __construct(
        private BoundingBoxFactory     $boundingBoxFactory,
        private Labels\LabelController $labelController,
        private Labels\LabelFormatter  $labelFormatter,
    )
    {
    }

    public function calculate(Axis $axis): float
    {
        if (isset($axis->crossWidth)) {
            return $axis->crossWidth;
        }

        if ($axis instanceof Y2Axis && $axis->minValue === null) {
            return $axis->crossWidth = 0.0;
        }

        $titleWidth = $this->titleWidth($axis);
        $labelWidth = $this->labelWidth($axis);

        return $axis->crossWidth = $this->tickWidth($axis) + $labelWidth + $titleWidth;
    }

    public function titleWidth(Axis $axis): int|float
    {
        if ($axis->settings->showTitle && strlen($axis->settings->title ?? '') >= 1) {
            $height = $this->boundingBoxFactory->create(
                $axis->settings->title,
                $axis->settings->titleSettings
            )->height;

            $titleWidth = $height + $axis->settings->titleSettings->margin;
        }
        else {
            $titleWidth = 0;
        }

        return $titleWidth;
    }

    public function labelWidth(Axis $axis): float
    {
        $maxWidth = 0;
        $previousLabel = null;

        foreach ($this->labelController->labels($axis) as $label) {
            $text = $this->labelFormatter->format($axis, $label, $previousLabel);

            $width = $this->boundingBoxFactory->create(
                $text,
                $axis->settings->labelSettings
            )->width;

            if ($width > $maxWidth) {
                $maxWidth = $width;
            }

            $previousLabel = $label;
        }

        return $maxWidth;
    }

    public function tickWidth(Axis $axis): float
    {
        if ($axis->settings->showTicks) {
            return $axis->settings->tickLength + $axis->settings->tickMargin;
        }

        return 0.0;
    }
}
