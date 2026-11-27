<?php

namespace App\Models;

use App\Enums\AlertLevel;
use App\Enums\SensorStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SensorReading extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'device_id',
        'adc_value',
        'co_ppm',
        'status_level',
        'sensor_status',
        'recorded_at',
    ];

    protected function casts(): array
    {
        return [
            'co_ppm' => 'float',
            'status_level' => AlertLevel::class,
            'sensor_status' => SensorStatus::class,
            'recorded_at' => 'datetime',
        ];
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}