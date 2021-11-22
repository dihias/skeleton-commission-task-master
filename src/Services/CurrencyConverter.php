<?php
declare(strict_types=1);

namespace Feecal\Services;

class CurrencyConverter
{
    const EUR_CONVERSION = [
        'EUR' => 1,
        'USD' => 1.128146,
        'JPY' => 128.675253,
    ];

    public static function convertEur($amount, $currency): float
    {
        $result = $amount * self::EUR_CONVERSION[$currency];

        return (float) $result;
    }

    public static function convertToEur($amount, $currency): float
    {
        $result = $amount / self::EUR_CONVERSION[$currency];

        return (float) $result;
    }
}
