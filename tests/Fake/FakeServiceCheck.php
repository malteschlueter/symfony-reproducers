<?php

declare(strict_types=1);

namespace App\Tests\Fake;

use App\Exception\ServiceIsNotAvailable;
use App\Repository\ServiceCheck;

final class FakeServiceCheck implements ServiceCheck
{
    public function checkService(bool $triggerException = false): void
    {
        throw ServiceIsNotAvailable::becauseOfExample();
    }
}
