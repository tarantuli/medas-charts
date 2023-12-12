<?php

declare(strict_types=1);

use Medas\Charts\ChartsPackage;
use Medas\ServiceManager\{ServiceConfig, ServiceManager};

chdir(__DIR__);

new ServiceManager(function (): ServiceConfig {
    $config = new ServiceConfig();

    $config->addPackages([
        ChartsPackage::instance(),
    ]);

    return $config;
});
