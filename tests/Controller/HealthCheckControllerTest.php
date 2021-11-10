<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class HealthCheckControllerTest extends WebTestCase
{
    public function test_that_valid_a_valid_response_returns(): void
    {
        $client = self::createClient();

        $client->request('GET', '/');

        $this->assertResponseStatusCodeSame(Response::HTTP_OK);
        $this->assertSame([
            'status' => 'ok',
        ], json_decode($client->getResponse()->getContent(), true));
    }

    public function test_that_a_error_message_will_be_returned(): void
    {
        $client = self::createClient();

        $client->request('GET', '/', ['trigger_exception' => true]);

        $this->assertResponseStatusCodeSame(Response::HTTP_SERVICE_UNAVAILABLE);
        $this->assertSame([
            'error_message' => 'The service is not running correctly',
        ], json_decode($client->getResponse()->getContent(), true));
    }
}
