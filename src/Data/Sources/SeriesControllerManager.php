<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources;

use Medas\Core\{Attributes\Service, CachedImplementorList};

#[Service]
readonly class SeriesControllerManager
{
    private CachedImplementorList $cachedImplementorList;

    public function __construct()
    {
        $this->cachedImplementorList = new CachedImplementorList(SeriesController::class);
    }

    public function controller(Series $series): SeriesController
    {
        foreach ($this->cachedImplementorList->get() as $controller) {
            /** @var SeriesController $controller */
            if ($controller->canHandle($series)) {
                return $controller;
            }
        }

        throw new \Exception('no series controller found for ' . $series::class);
    }
}
