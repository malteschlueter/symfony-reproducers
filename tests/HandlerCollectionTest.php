<?php

declare(strict_types=1);

namespace App\Tests;

use App\HandlerCollection;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HandlerCollectionTest extends KernelTestCase
{
    public function testIndexedServices(): void
    {
        static::bootKernel();

        $handlerCollection = static::$container->get(HandlerCollection::class);

        $expectedKeys = [
            0,
            1,
        ];

        $this->assertSame($expectedKeys, array_keys($handlerCollection->handlers));
    }
}
