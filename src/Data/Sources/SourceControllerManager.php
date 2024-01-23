<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources;

use Medas\Core\{Attributes\Service, Interfaces\CacheManager, Interfaces\ImplementorFinder};

#[Service]
readonly class SourceControllerManager
{
    public function __construct(
        private CacheManager      $cacheManager,
        private ImplementorFinder $implementorFinder,
    )
    {
    }

    public function controller(Source $source): SourceController
    {
        foreach ($this->get() as $controller) {
            if ($controller->canHandle($source)) {
                return $controller;
            }
        }

        throw new \Exception('no source controller found for ' . $source::class);
    }

    /** @return SourceController[] */
    public function get(): array
    {
        return $this->cacheManager->get()->get(
            __CLASS__,
            fn() => $this->implementorFinder->find(SourceController::class)
        );
    }
}
