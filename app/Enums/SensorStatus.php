<?php

namespace App\Enums;

enum SensorStatus: string
{
    case Ok = 'ok';
    case WarmingUp = 'warming_up';
    case Error = 'error';
}