<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources;

use Medas\Core\{Attributes\Service, Interfaces\CacheManager, Interfaces\ImplementorFinder};

#[Service]
readonly class SeriesControllerManager
{
    public function __construct(
        private CacheManager      $cacheManager,
        private ImplementorFinder $implementorFinder,
    )
    {
    }

    public function controller(Series $series): SeriesController
    {
        foreach ($this->get() as $controller) {
            if ($controller->canHandle($series)) {
                return $controller;
            }
        }

        throw new \Exception('no series controller found for ' . $series::class);
    }

    /** @return SeriesController[] */
    public function get(): iterable
    {
        return $this->cacheManager->get()->get(
            __CLASS__,
            fn() => $this->implementorFinder->find(SeriesController::class)
        );
    }
}
