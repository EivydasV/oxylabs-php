<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\DTO\Notification;
use App\Entity\User;
use App\Normalizer\NotificationNormalizer;
use App\Service\NotificationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/notifications')]
class NotificationController extends AbstractController
{
    public function __construct(
        private readonly NotificationService $notificationService,
        private readonly NotificationNormalizer $notificationNormalizer,
    ) {
    }

    #[Route(methods: 'GET')]
    public function index(Request $request): JsonResponse
    {
        $userId = $request->query->getInt('user_id');
        if ($userId === 0) {
            throw new NotFoundHttpException('User ID is required');
        }

        $notifications = $this->notificationService->getViableForUser($userId);

        $normalizedNotifications = array_map(
            fn (Notification $notification) => $this->notificationNormalizer->normalize($notification),
            $notifications
        );

        return $this->json($normalizedNotifications);
    }
}
