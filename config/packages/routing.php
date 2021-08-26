<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;

return static function (FrameworkConfig $framework, ContainerConfigurator $container): void {
    $router = $framework->router();

    $router->utf8(true);

    if ($container->env() === 'prod') {
        $router->strictRequirements(null);
    }
};
