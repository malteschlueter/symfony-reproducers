<?php

declare(strict_types=1);

namespace App\Exception;

final class ServiceIsNotAvailable extends \RuntimeException
{
    public static function becauseOfExample(): self
    {
        return new self('The service is not running correctly');
    }
}
