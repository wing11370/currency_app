<?php

namespace Tests\Unit;

use App\Providers\CurrencyRateProvider;
use App\Services\CurrencyExchangeService;
use PHPUnit\Framework\TestCase;

class CurrencyExchangeServiceTest extends TestCase
{

    /**
     * test for convert currency successfully
     * @return void
     * @throws \Exception
     */
    public function test_convert()
    {
        $rateProvider = new CurrencyRateProvider();
        $service = new CurrencyExchangeService('TWD', 'USD', 1000, $rateProvider);
        $result = $service->convert();
        $this->assertEquals('32.81', $service->convert());
    }

    /**
     * test for the currency not found
     * @return void
     * @throws \Exception
     */
    public function test_invalid_currency()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Currency not found');
        $rateProvider = new CurrencyRateProvider();
        $service = new CurrencyExchangeService('ABC', 'USD', 1000, $rateProvider);
        $result = $service->convert();
    }

    /**
     * test for the type of amount is not numeric
     * @return void
     * @throws \Exception
     */
    public function test_invalid_amount_non_numeric()
    {
        $this->expectException(\TypeError::class);
        $rateProvider = new CurrencyRateProvider();
        $service = new CurrencyExchangeService('TWD', 'USD', 'invalid_amount', $rateProvider);

        $result = $service->convert();

        $this->assertEquals('0.00', $result);
    }

    /**
     * test for the amount is empty string
     * @return void
     * @throws \Exception
     */
    public function test_invalid_amount_empty_string()
    {
        $this->expectException(\TypeError::class);
        $rateProvider = new CurrencyRateProvider();
        $service = new CurrencyExchangeService('TWD', 'USD', '', $rateProvider);

        $result = $service->convert();

        $this->assertEquals('0.00', $result);
    }
}
