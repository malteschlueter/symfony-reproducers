<?php

declare(strict_types=1);

use App\Kernel;

require dirname(__DIR__) . '/vendor/autoload.php';

$kernel = new Kernel('tests', false);
$kernel->boot();

return $kernel->getContainer();
