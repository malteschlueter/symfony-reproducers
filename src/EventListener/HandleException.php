<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ServiceIsNotAvailable;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class HandleException implements EventSubscriberInterface
{
    /**
     * @var array<string, int>
     */
    private const EXCEPTION_TO_STATUS_CODE = [
        ServiceIsNotAvailable::class => Response::HTTP_SERVICE_UNAVAILABLE,
    ];

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'mapExceptionToResponse',
        ];
    }

    public function mapExceptionToResponse(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!\array_key_exists($exception::class, self::EXCEPTION_TO_STATUS_CODE)) {
            return;
        }

        $event->setResponse(
            new JsonResponse(
                [
                    'error_message' => $exception->getMessage(),
                ],
                self::EXCEPTION_TO_STATUS_CODE[$exception::class]
            )
        );
    }
}
