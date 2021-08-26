<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\FrameworkConfig;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (FrameworkConfig $framework, ContainerConfigurator $container): void {
    $framework
        ->secret(env('APP_SECRET'))
        ->httpMethodOverride(false)
    ;

    $framework->session()
        ->handlerId(null)
        ->cookieSecure('auto')
        ->cookieSamesite('lax')
        ->storageFactoryId('session.storage.factory.native')
    ;

    $framework->phpErrors()
        ->log(true)
    ;

    if ($container->env() === 'test') {
        $framework->test(true);

        $framework->session()
            ->storageFactoryId('session.storage.factory.mock_file')
        ;
    }
};
