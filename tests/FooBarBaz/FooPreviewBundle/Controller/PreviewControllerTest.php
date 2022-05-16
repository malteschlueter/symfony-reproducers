<?php

declare(strict_types=1);

namespace Tests\FooBarBaz\FooPreviewBundle\Controller;

use FooBarBaz\FooPreviewBundle\Controller\PreviewController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

final class PreviewControllerTest extends WebTestCase
{
    public function test_foo(): void
    {
        $client = self::createClient();

        $client->request(Request::METHOD_GET, '/foo/preview/index');

        $this->assertSame(PreviewController::class . '::indexAction', $client->getResponse()->getContent());
    }
}
