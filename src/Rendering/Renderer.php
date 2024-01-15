<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering;

use Medas\Charts\Axes\{AxeDrawer, Labels\LabelDrawer};
use Medas\Charts\Chart;
use Medas\Charts\Grid\GridDrawer;
use Medas\Charts\Image\{Image, ImageFactory, Size\Resizer};
use Medas\Core\Attributes\Service;

#[Service]
readonly class Renderer
{
    public function __construct(
        private AxeDrawer            $axeDrawer,
        private DimensionsCalculator $dimensionsCalculator,
        private LabelDrawer          $labelDrawer,
        private ImageFactory         $imageFactory,
        private GridDrawer           $gridDrawer,
        private Resizer              $resizer,
    )
    {
    }

    public function render(Chart $chart): Image
    {
        $job = new Job($chart);

        $this->dimensionsCalculator->calculate($chart);

        $job->image = $this->imageFactory->create($chart);

        // Draw non-textual elements with alpha blending turned off
        $this->drawNonTextualElements($job);

        // Undo the scaling factor and turn on alpha blending before drawing text elements
        $this->undoScalingFactor($job);

        // Draw textual elements
        $this->drawTextualElements($job);

        return $job->image;
    }

    private function drawNonTextualElements(Job $job): void
    {
        $this->gridDrawer->draw($job);
        $this->axeDrawer->draw($job);
    }

    private function undoScalingFactor(Job $job): void
    {
        $this->resizer->undoScalingFactor($job->image);

        imagealphablending($job->image->resource, true);
    }

    private function drawTextualElements(Job $job): void
    {
        $this->labelDrawer->draw($job);
    }
}
