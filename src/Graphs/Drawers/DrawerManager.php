<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Drawers;

use Medas\Core\{Attributes\Service, Interfaces\CacheManager, Interfaces\ImplementorFinder};

#[Service]
readonly class DrawerManager
{
    public function __construct(
        private CacheManager      $cacheManager,
        private ImplementorFinder $implementorFinder,
    )
    {
    }

    /** @return GraphDrawer[] */
    public function get(): array
    {
        return $this->cacheManager->get()->get(__CLASS__, fn() => $this->determine());
    }

    /** @return GraphDrawer[] */
    private function determine(): array
    {
        $services = $this->implementorFinder->find(GraphDrawer::class);

        usort(
            $services,
            fn(GraphDrawer $a, GraphDrawer $b) => -1 * ($a->priority() <=> $b->priority())
        );

        return $services;
    }
}
