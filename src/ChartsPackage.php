<?php

declare(strict_types=1);

namespace Medas\Charts;

use Medas\Core\AsSingleton;
use Medas\ImageManager\ImageManagerPackage;
use Medas\ServiceManager\BasePackage;

class ChartsPackage extends BasePackage
{
    use AsSingleton;

    public function dependencies(): array
    {
        return [
            ImageManagerPackage::instance(),
        ];
    }

    public function sourceDirectory(): string
    {
        return __DIR__;
    }
}
