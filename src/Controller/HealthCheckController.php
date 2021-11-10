<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ServiceCheck;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;

#[AsController]
final class HealthCheckController
{
    public function __construct(private ServiceCheck $serviceCheck)
    {
    }

    #[Route('/')]
    public function __invoke(Request $request): JsonResponse
    {
        if ($request->query->has('trigger_exception')) {
            $this->serviceCheck->checkService();
        }

        return new JsonResponse(['status' => 'ok']);
    }
}
