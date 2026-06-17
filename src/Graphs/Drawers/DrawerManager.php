<?php

declare(strict_types=1);

namespace Medas\Charts\Graphs\Drawers;

use Medas\Core\{Attributes\Service, CachedImplementorList, Lists\SortByPriority};

#[Service]
readonly class DrawerManager
{
    private CachedImplementorList $cachedImplementorList;

    public function __construct()
    {
        $this->cachedImplementorList = new CachedImplementorList(
            GraphDrawer::class,
            SortByPriority::HighToLow
        );
    }

    /** @return GraphDrawer[] */
    public function get(): array
    {
        return $this->cachedImplementorList->get();
    }
}
