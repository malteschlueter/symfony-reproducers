<?php

declare(strict_types=1);

namespace Tests\FooBarBaz\FooPreviewBundle\Controller;

use FooBarBaz\FooPreviewBundle\Controller\PreviewController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

final class PreviewControllerTest extends WebTestCase
{
    public function test_index_action(): void
    {
        $client = self::createClient();

        $client->request(Request::METHOD_GET, '/foo/preview/index');

        $this->assertSame(PreviewController::class . '::indexAction', $client->getResponse()->getContent());
    }

    public function test_already_exists_with_short_annotation_action(): void
    {
        $client = self::createClient();

        $client->request(Request::METHOD_GET, '/already-exists-with-short-annotation');

        $this->assertSame(PreviewController::class . '::alreadyExistsWithShortAnnotationAction', $client->getResponse()->getContent());
    }

    public function test_already_exists_with_long_annotation_action(): void
    {
        $client = self::createClient();

        $client->request(Request::METHOD_GET, '/already-exists-with-long-annotation');

        $this->assertSame(PreviewController::class . '::alreadyExistsWithLongAnnotationAction', $client->getResponse()->getContent());
    }
}
