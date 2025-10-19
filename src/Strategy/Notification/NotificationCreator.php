<?php

declare(strict_types=1);

namespace App\Strategy\Notification;

use App\DTO\Notification;
use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

class NotificationCreator
{
    /**
     * @param iterable<NotificationInterface> $notificationStrategies
     */
    public function __construct(
        #[AutowireIterator('app.notification_tag')]
        private readonly iterable $notificationStrategies,
    ) {
    }

    /**
     * @return Notification[]
     */
    public function create(User $user): array
    {
        $notifications = [];
        foreach ($this->notificationStrategies as $notificationStrategy) {
            if ($notificationStrategy->isSupported($user)) {
                $notifications[] = $notificationStrategy->createNotification();
            }
        }

        return $notifications;
    }
}
