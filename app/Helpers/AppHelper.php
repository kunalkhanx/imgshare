<?php

namespace App\Helpers;

class AppHelper
{
    static function formatReadableNumber(int $number) {
        if (!is_numeric($number)) {
            return "Invalid input";
        }
    
        $suffixes = ['', 'K', 'M', 'B', 'T'];
    
        $index = 0;
        while ($number >= 1000 && $index < count($suffixes) - 1) {
            $number /= 1000;
            $index++;
        }

        return round($number, $number < 10 && $index > 0 ? 1 : 0) . $suffixes[$index];
    }
    
}