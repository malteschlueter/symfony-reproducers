<?php

declare(strict_types=1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Config\ArtprimaPrometheusMetricsConfig;
use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

return static function (ArtprimaPrometheusMetricsConfig $artprimaPrometheusMetrics, ContainerConfigurator $container): void {
    $artprimaPrometheusMetrics
        ->namespace('myapp')
        ->type('redis')
        ->ignoredRoutes([
            'prometheus_bundle_prometheus',
            '_wdt',
        ])
        ->redis()
            ->host(env('REDIS_HOST'))
    ;

    if ($container->env() === 'test') {
        $artprimaPrometheusMetrics
            ->type('in_memory')
        ;
    }
};
