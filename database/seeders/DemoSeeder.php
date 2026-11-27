<?php

namespace Database\Seeders;

use App\Enums\AlertLevel;
use App\Enums\EventType;
use App\Enums\SensorStatus;
use App\Models\Device;
use App\Models\SensorReading;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::factory()->create([
            'name' => 'Demo Pengemudi',
            'email' => 'demo@nafas.test',
        ]);

        [$plain, $hash] = Device::generateToken();
        $now = now()->startOfSecond();

        $device = $user->devices()->forceCreate([
            'device_code' => 'CO-001',
            'name' => 'Nafas CO-01',
            'location' => 'Mobil · Kabin depan',
            'token_hash' => $hash,
            'sensor_status' => SensorStatus::Ok->value,
            'last_seen_at' => $now,
            'firmware_version' => '1.0.0',
        ]);

        // 1 jam data, tiap 5 detik: Aman → Waspada → Bahaya → pulih ke Aman
        $rows = [];
        for ($i = 720; $i >= 0; $i--) {
            $minutesAgo = $i * 5 / 60;
            $ppm = match (true) {
                $minutesAgo > 30 => random_int(900, 1400) / 100,
                $minutesAgo > 20 => random_int(2000, 3000) / 100,
                $minutesAgo > 15 => random_int(4000, 13000) / 100,
                default => random_int(900, 1400) / 100,
            };

            $rows[] = [
                'device_id' => $device->id,
                'adc_value' => (int) (400 + $ppm * 2),
                'co_ppm' => $ppm,
                'status_level' => AlertLevel::fromPpm($ppm, 18, 35)->value,
                'sensor_status' => SensorStatus::Ok->value,
                'recorded_at' => $now->copy()->subSeconds($i * 5),
            ];
        }

        foreach (array_chunk($rows, 200) as $chunk) {
            SensorReading::insert($chunk);
        }

        foreach ([
            [EventType::Connected, null, null, 'Perangkat terhubung', 60],
            [EventType::StatusChanged, AlertLevel::Waspada, 25.0, 'Waspada · CO meningkat', 30],
            [EventType::StatusChanged, AlertLevel::Bahaya, 85.0, 'Bahaya · Alarm diaktifkan', 20],
            [EventType::StatusChanged, AlertLevel::Aman, 12.0, 'Status kembali Aman', 15],
        ] as [$type, $level, $ppm, $message, $minutesAgo]) {
            $device->events()->create([
                'type' => $type,
                'level' => $level,
                'co_ppm' => $ppm,
                'message' => $message,
                'occurred_at' => $now->copy()->subMinutes($minutesAgo),
            ]);
        }

        // Perangkat kedua: sengaja offline (terakhir terlihat 2 jam lalu)
        [, $hash2] = Device::generateToken();
        $user->devices()->forceCreate([
            'device_code' => 'CO-002',
            'name' => 'Nafas CO-02',
            'location' => 'Mobil · Kabin belakang',
            'token_hash' => $hash2,
            'last_seen_at' => $now->copy()->subHours(2),
            'sensor_status' => SensorStatus::Ok->value,
        ]);

        $this->command->info("Token CO-001 (catat, hanya tampil sekali): {$plain}");
    }
}