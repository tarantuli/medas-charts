<?php

declare(strict_types=1);

namespace Medas\Charts;

use Medas\Core\{AsSingleton, BasePackage};
use Medas\ImageDrawer\ImageDrawerPackage;

class ChartsPackage extends BasePackage
{
    use AsSingleton;

    public function dependencies(): array
    {
        return [
            ImageDrawerPackage::instance(),
        ];
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }
}
