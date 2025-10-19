<?php

declare(strict_types=1);

namespace App\Strategy\Notification;

use App\DTO\Notification;
use App\Entity\User;
use App\enum\DevicePlatform;
use App\Repository\DeviceRepository;
use DateTimeImmutable;

class NoAndroidForSpanishUserRule implements NotificationInterface
{
    private const SUPPORTED_COUNTRY = 'ES';

    public function __construct(private readonly DeviceRepository $deviceRepository)
    {
    }

    public function isSupported(User $user): bool
    {
        if ($user->isPremium()) {
            return false;
        }

        if ($user->getCountryCode() !== self::SUPPORTED_COUNTRY) {
            return false;
        }

        if ($this->userWasActiveInLastWeek($user)) {
            return false;
        }

        if ($this->deviceRepository->hasDevice($user->getId(), DevicePlatform::ANDROID)) {
            return false;
        }

        return true;
    }

    public function createNotification(): Notification
    {
        return new Notification(
            'Configurar dispositivo Android',
            'Phasellus rhoncus ante dolor, at semper metus aliquam quis. Praesent finibus pharetra libero, ut feugiat mauris dapibus blandit. Donec sit.',
            'https://developers.oxylabs.io/'
        );
    }

    private function userWasActiveInLastWeek(User $user): bool
    {
        $oneWeekAgo = new DateTimeImmutable('-7 days');

        return $user->getLastActiveAt() >= $oneWeekAgo;
    }
}
