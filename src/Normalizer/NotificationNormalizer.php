<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\DTO\Notification;

class NotificationNormalizer
{
    /**
     * @return array<string, mixed>
     */
    public function normalize(Notification $notification): array
    {
        return [
            'title' => $notification->title,
            'description' => $notification->description,
            'cta' => $notification->cta,
        ];
    }
}
