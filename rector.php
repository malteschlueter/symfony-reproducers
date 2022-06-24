<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\Symfony\Rector\ClassMethod\AddRouteAnnotationRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/src'
    ]);

    $parameters = $rectorConfig->parameters();

    $rectorConfig->importNames();
    $rectorConfig->importShortClasses(false);

    $parameters->set(Option::APPLY_AUTO_IMPORT_NAMES_ON_CHANGED_FILES_ONLY, true);

    // register a single rule
    $rectorConfig->rule(AddRouteAnnotationRector::class);
    $rectorConfig->symfonyContainerPhp(__DIR__ . '/tests/symfony-container.php');
};
