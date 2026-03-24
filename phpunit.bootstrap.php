<?php

declare(strict_types=1);

use Medas\Charts\ChartsPackage;
use Medas\ConfigManager\ConfigManagerPackage;
use Medas\ConfigOptions\ConfigOptionsPackage;
use Medas\ObjectInstantiator\ObjectInstantiator;
use Medas\ObjectInstantiator\ObjectInstantiatorPackage;
use Medas\ServiceManager\{ServiceConfig, ServiceManager};

chdir(__DIR__);

new ServiceManager(function (): ServiceConfig {
    $config = new ServiceConfig(ObjectInstantiator::class);

    $config->addPackages([
        ChartsPackage::instance(),
        ConfigManagerPackage::instance(),
        ConfigOptionsPackage::instance(),
        ObjectInstantiatorPackage::instance(),
    ]);

    return $config;
});
