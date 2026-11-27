<?php

namespace App\Models;

use App\Enums\AlertLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AlertNotification extends Model
{
    protected $fillable = ['level', 'channel', 'message', 'status', 'error', 'sent_at'];

    protected function casts(): array
    {
        return [
            'level' => AlertLevel::class,
            'sent_at' => 'datetime',
        ];
    }

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}