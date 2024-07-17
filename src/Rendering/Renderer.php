<?php

declare(strict_types=1);

namespace Medas\Charts\Rendering;

use Medas\Charts\Axes\{AxeDrawer, Labels\LabelDrawer};
use Medas\Charts\Chart;
use Medas\Charts\Graphs\Drawers\GraphsDrawer;
use Medas\Charts\Grid\GridDrawer;
use Medas\Charts\Legend\LegendDrawer;
use Medas\Core\Attributes\{Entrypoint, Service};
use Medas\ImageDrawer\{Image, ImageFactory, Size\Resizer};

#[Service, Entrypoint]
readonly class Renderer
{
    public function __construct(
        private AxeDrawer            $axeDrawer,
        private Chart\TitleDrawer    $titleDrawer,
        private DimensionsCalculator $dimensionsCalculator,
        private GraphsDrawer         $graphsDrawer,
        private GridDrawer           $gridDrawer,
        private ImageFactory         $imageFactory,
        private LabelDrawer          $labelDrawer,
        private LegendDrawer         $legendDrawer,
        private Resizer              $resizer,
    )
    {
    }

    public function render(Chart $chart): Image
    {
        $job = new Job($chart);

        $this->dimensionsCalculator->calculate($chart);

        $job->image = $this->imageFactory->create(
            $chart->imageSettings->width,
            $chart->imageSettings->height,
            $chart->imageSettings->scalingFactor,
            $chart->imageSettings->backgroundColor
        );

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
        $this->graphsDrawer->draw($job);
        $this->legendDrawer->drawBox($job);
    }

    private function undoScalingFactor(Job $job): void
    {
        $this->resizer->undoScalingFactor($job->image);

        imagealphablending($job->image->resource, true);
    }

    private function drawTextualElements(Job $job): void
    {
        $this->labelDrawer->draw($job);
        $this->titleDrawer->draw($job);
        $this->legendDrawer->drawLabels($job);
    }
}
