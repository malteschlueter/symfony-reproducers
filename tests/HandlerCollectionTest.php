<?php

declare(strict_types=1);

namespace App\Tests;

use App\Handler\Two;
use App\HandlerCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HandlerCollectionTest extends KernelTestCase
{
    public function testIndexedServices(): void
    {
        static::bootKernel();

        $handlerCollection = static::$container->get(HandlerCollection::class);

        $expectedKeys = [
            'handler_one',
            Two::class,
        ];

        $this->assertSame($expectedKeys, array_keys($handlerCollection->handlers));
    }
}
