<?php

namespace Tests\Unit;

use App\Providers\CurrencyRateProvider;
use PHPUnit\Framework\TestCase;

class CurrencyRateProviderTest extends TestCase
{
    /**
     * test for check currency successfully
     * @return void
     */
    public function testCheckCurrency()
    {
        $rateProvider = new CurrencyRateProvider();
        $this->assertTrue($rateProvider->checkCurrency('TWD'));
        $this->assertTrue($rateProvider->checkCurrency('JPY'));
    }

    /**
     * test for the currency not found
     * @return void
     */
    public function testCheckCurrencyNotFound()
    {
        $rateProvider = new CurrencyRateProvider();
        $this->assertFalse($rateProvider->checkCurrency('EUR'));
    }

    /**
     * test for get rate successfully
     * @return void
     * @throws \Exception
     */
    public function testGetRate()
    {
        $rateProvider = new CurrencyRateProvider();
        $this->assertEquals(1, $rateProvider->getRate('TWD', 'TWD'));
        $this->assertEquals(3.669, $rateProvider->getRate('TWD', 'JPY'));
        $this->assertEquals(0.03281, $rateProvider->getRate('TWD', 'USD'));
    }

    /**
     * test for the currency rate not found
     * @return void
     */
    public function testGetRateNotExist()
    {
        $this->expectException(\Exception::class);
        $rateProvider = new CurrencyRateProvider();
        $rateProvider->getRate('TWD', 'EUR');
    }
}
