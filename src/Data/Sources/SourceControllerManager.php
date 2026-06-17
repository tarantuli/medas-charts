<?php

declare(strict_types=1);

namespace Medas\Charts\Data\Sources;

use Medas\Core\{Attributes\Service, CachedImplementorList};

#[Service]
readonly class SourceControllerManager
{
    private CachedImplementorList $cachedImplementorList;

    public function __construct()
    {
        $this->cachedImplementorList = new CachedImplementorList(SourceController::class);
    }

    public function controller(Source $source): SourceController
    {
        foreach ($this->cachedImplementorList->get() as $controller) {
            /** @var SourceController $controller */
            if ($controller->canHandle($source)) {
                return $controller;
            }
        }

        throw new \Exception('no source controller found for ' . $source::class);
    }
}
