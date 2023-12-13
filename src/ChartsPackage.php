<?php

declare(strict_types=1);

namespace Medas\Charts;

use Medas\Core\AsSingleton;
use Medas\ImageManager\ImageManagerPackage;
use Medas\ServiceManager\{BasePackage, ServiceConfig};

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

    public function initialize(ServiceConfig $config): void
    {
        parent::initialize($config);

        require_once __DIR__ . '/GlobalFunctions.php';
    }
}
