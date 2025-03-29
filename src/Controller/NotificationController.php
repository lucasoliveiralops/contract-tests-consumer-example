<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\NotificationFilter;
use App\Services\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class NotificationController extends AbstractController
{
    public function __construct(private readonly NotificationService $service)
    {
    }

    #[Route('/notification', name: 'notification', methods: ['POST'])]
    public function notify(
        #[MapRequestPayload]
        NotificationFilter $notificationFilter
    ): Response {
        if($this->service->notify($notificationFilter)) {
            return new Response(status: 204);
        }

        return new Response(status: 400);
    }
}
