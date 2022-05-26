<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Symfony\Rector\ClassMethod\AddRouteAnnotationRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src'
    ]);

    // register a single rule
    $rectorConfig->rule(AddRouteAnnotationRector::class);
    $rectorConfig->symfonyContainerPhp(__DIR__ . '/tests/symfony-container.php');
};
