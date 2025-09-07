<?php
namespace App\Service;

class UnitConverterService
{
    public function celsiusToFahrenheit(float $c): float
    {
        return round(($c * 9/5) + 32, 2);
    }

    public function kmhToMs(float $kmh): float
    {
        return round($kmh / 3.6, 4);
    }
}