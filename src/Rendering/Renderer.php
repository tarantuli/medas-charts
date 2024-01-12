<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering;

use Medas\Charts\Axes\AxeDrawer;
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
        $this->gridDrawer->draw($job);
        $this->axeDrawer->draw($job);

        // Undo the scaling factor and turn on alpha blending before drawing text elements
        $this->resizer->undoScalingFactor($job->image);

        imagealphablending($job->image->resource, true);

        // Draw textual elements
        return $job->image;
    }
}
