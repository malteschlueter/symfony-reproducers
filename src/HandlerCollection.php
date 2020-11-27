<?php

declare(strict_types=1);

namespace App;

class HandlerCollection
{
    public $handlers;

    public function __construct(iterable $handlers)
    {
        $this->handlers = iterator_to_array($handlers);
    }
}
