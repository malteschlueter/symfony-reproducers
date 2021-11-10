<?php

declare(strict_types=1);

namespace App\Repository;

use App\Exception\ServiceIsNotAvailable;

/**
 * @infection-ignore-all
 */
final class HttpServiceCheck implements ServiceCheck
{
    public function checkService(): void
    {
        // i.e. this service checks external services for availability with a http client

        throw ServiceIsNotAvailable::becauseOfExample();
    }
}
