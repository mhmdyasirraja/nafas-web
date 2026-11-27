<?php

namespace App\Models;

use App\Enums\SensorStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Device extends Model
{
    // Hanya field yang boleh diisi dari form pengguna.
    // device_code, token_hash, last_seen_at, dst. diisi oleh server.
    protected $fillable = [
        'name',
        'location',
        'wifi_ssid',
        'warning_ppm',
        'danger_ppm',
        'send_interval_seconds',
        'buzzer_max_seconds',
        'telegram_chat_id',
        'notify_on_warning',
        'notify_on_danger',
    ];

    protected $hidden = ['token_hash'];

    protected function casts(): array
    {
        return [
            'notify_on_warning' => 'boolean',
            'notify_on_danger' => 'boolean',
            'sensor_status' => SensorStatus::class,
            'last_seen_at' => 'datetime',
        ];
    }

    public function isOnline(): bool
    {
        if (!$this->last_seen_at) {
            return false;
        }

        $grace = max(15, $this->send_interval_seconds * 3);

        return $this->last_seen_at->gt(now()->subSeconds($grace));
    }

    /** @return array{0: string, 1: string} [token asli, hash untuk DB] */
    public static function generateToken(): array
    {
        $plain = Str::random(40);

        return [$plain, hash('sha256', $plain)];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function readings(): HasMany
    {
        return $this->hasMany(SensorReading::class);
    }

    public function latestReading(): HasOne
    {
        return $this->hasOne(SensorReading::class)->latestOfMany('recorded_at');
    }

    public function events(): HasMany
    {
        return $this->hasMany(DeviceEvent::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(AlertNotification::class);
    }
}