<?php

declare(strict_types=1);

namespace App\Repository;

interface ServiceCheck
{
    public function checkService(): void;
}
