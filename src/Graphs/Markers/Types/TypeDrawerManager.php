<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Types;

use Medas\Core\{Attributes\Service, Interfaces\CacheManager, Interfaces\ImplementorFinder};

#[Service]
readonly class TypeDrawerManager
{
    public function __construct(
        private CacheManager      $cacheManager,
        private ImplementorFinder $implementorFinder,
    )
    {
    }

    /** @return TypeDrawer[] */
    public function get(): array
    {
        return $this->cacheManager->get()->get(__CLASS__, fn() => $this->determine());
    }

    /** @return TypeDrawer[] */
    private function determine(): array
    {
        $services = $this->implementorFinder->find(TypeDrawer::class);

        usort(
            $services,
            fn(TypeDrawer $a, TypeDrawer $b) => -1 * ($a->priority() <=> $b->priority())
        );

        return $services;
    }
}
