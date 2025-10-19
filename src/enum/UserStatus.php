<?php

declare(strict_types = 1);

namespace App\enum;

enum UserStatus: string
{
    case ACTIVE = 'active';

    case SUSPENDED = 'suspended';
}
