<?php

namespace App\Providers;

class CurrencyRateProvider
{
    private array $currencies = [
        'TWD' => ["TWD" => 1, "JPY" => 3.669, "USD" => 0.03281],
        'JPY' => ["TWD" => 0.26956, "JPY" => 1, "USD" => 0.00885],
        'USD' => ["TWD" => 30.444, "JPY" => 111.801, "USD" => 1],
    ];

    public function checkCurrency(string $currency): bool
    {
        return isset($this->currencies[$currency]);
    }

    /**
     * @throws \Exception
     */
    public function getRate(string $source, string $target): float
    {
        if ( ! isset($this->currencies[$source][$target])) {
            throw new \Exception('Currency rate not found');
        }
        return $this->currencies[$source][$target];
    }
}
