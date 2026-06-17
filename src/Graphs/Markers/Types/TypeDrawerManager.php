<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Markers\Types;

use Medas\Core\{Attributes\Service, CachedImplementorList, Lists\SortByPriority};

#[Service]
readonly class TypeDrawerManager
{
    private CachedImplementorList $cachedImplementorList;

    public function __construct()
    {
        $this->cachedImplementorList = new CachedImplementorList(
            TypeDrawer::class,
            SortByPriority::HighToLow
        );
    }

    /** @return TypeDrawer[] */
    public function get(): array
    {
        return $this->cachedImplementorList->get();
    }
}
