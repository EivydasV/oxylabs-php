<?php

declare(strict_types=1);

namespace App\enum;

enum DevicePlatform: string
{

    case ANDROID = 'android';

    case IOS = 'ios';

    case WINDOWS = 'windows';
}
