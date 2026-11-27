<?php

namespace App\Enums;

enum EventType: string
{
    case StatusChanged = 'status_changed';
    case Connected = 'connected';
    case SensorStatusChanged = 'sensor_status_changed';
}