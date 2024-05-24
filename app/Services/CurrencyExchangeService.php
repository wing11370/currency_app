<?php

namespace App\Services;

use App\Providers\CurrencyRateProvider;

class CurrencyExchangeService
{
    private string $source;
    private string $target;
    private float $amount;
    private CurrencyRateProvider $rateProvider;

    public function __construct(string $source, string $target, string $amount, CurrencyRateProvider $rateProvider)
    {
        $this->source = $source;
        $this->target = $target;
        $this->amount = $this->formatInputAmount($amount);
        $this->rateProvider = $rateProvider;
    }

    public function formatInputAmount($amount): float
    {
        $formatAmount = is_numeric($amount) ? $amount : str_replace(",", "", $amount);
        return number_format($formatAmount, 2, '.', '');
    }

    /**
     * @throws \Exception
     */
    public function convert(): string
    {
        if (!$this->rateProvider->checkCurrency($this->source) || !$this->rateProvider->checkCurrency($this->target)) {
            throw new \Exception('Currency not found');
        }
        $currencyRate = $this->rateProvider->getRate($this->source, $this->target);
        $targetAmount = $currencyRate * $this->amount;
        return $this->formatOutputAmount($targetAmount);
    }

    public function formatOutputAmount(int|float $amount): string
    {
        return number_format($amount, 2);
    }
}
