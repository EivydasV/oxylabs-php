<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\Notification;
use App\Repository\UserRepository;
use App\Strategy\Notification\NotificationCreator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotificationService
{

    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly NotificationCreator $notificationCreator,
    ) {
    }

    /**
     * @return Notification[]
     */
    public function getViableForUser(int $userId): array
    {
        $user = $this->userRepository->findById($userId);
        if ($user === null) {
            throw new NotFoundHttpException('User not found');
        }

        return $this->notificationCreator->create($user);
    }
}
