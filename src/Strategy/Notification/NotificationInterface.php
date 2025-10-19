<?php

declare(strict_types=1);

namespace App\Strategy\Notification;

use App\DTO\Notification;
use App\Entity\User;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.notification_tag')]
interface NotificationInterface
{
    public function isSupported(User $user): bool;

    public function createNotification(): Notification;
}
