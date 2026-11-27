<?php

namespace App\Enums;

enum AlertLevel: string
{
    case Aman = 'aman';
    case Waspada = 'waspada';
    case Bahaya = 'bahaya';

    // Batas mengikuti UT-06: 17 = Aman, 18 = Waspada, 35 = Waspada, 36 = Bahaya
    public static function fromPpm(float $ppm, int $warning, int $danger): self
    {
        return match (true) {
            $ppm > $danger => self::Bahaya,
            $ppm >= $warning => self::Waspada,
            default => self::Aman,
        };
    }
}