<?php

namespace App\Models;

use App\Enums\AlertLevel;
use App\Enums\EventType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceEvent extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'device_id',
        'type',
        'level',
        'co_ppm',
        'message',
        'occurred_at',
    ];

    protected function casts(): array
    {
        return [
            'type' => EventType::class,
            'level' => AlertLevel::class,
            'co_ppm' => 'float',
            'occurred_at' => 'datetime',
        ];
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}