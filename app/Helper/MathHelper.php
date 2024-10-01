<?php

namespace App\Helper;

class MathHelper
{
    public static function percentageDifference(float|int $a, float|int$b): float
    {
        if ($a === $b) {
            return 0;
        }

        return round(abs($a - $b) / (($a + $b) / 2) * 100, 2);
    }
}
