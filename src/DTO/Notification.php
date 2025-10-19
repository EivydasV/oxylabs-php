<?php

declare(strict_types=1);

namespace App\DTO;

class Notification
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly string $cta,
    ) {
    }
}
