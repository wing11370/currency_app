<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\CurrencyRateProvider;

class CurrencyExchangeControllerTest extends TestCase
{
    /**
     * test for exchange successfully
     * @return void
     */
    public function test_exchange_success()
    {
        $response = $this->json('GET', '/api/exchange', [
            'source' => 'TWD',
            'target' => 'USD',
            'amount' => 1000,
        ]);

        $response->assertStatus(200)->assertJson([
            'msg' => 'success',
            'amount' => '32.81',
        ]);
    }

    /**
     * test for exchange invalid currency
     * @return void
     */
    public function test_exchange_invalid_currency()
    {
        $response = $this->json('GET', '/api/exchange', [
            'source' => 'ABC',
            'target' => 'USD',
            'amount' => 1000,
        ]);
        $response->assertStatus(200)->assertJson([
            'msg' => 'Exception',
            'error' => 'Currency not found'
        ]);
    }

    /**
     * test for exchange invalid amount
     * @return void
     */
    public function test_exchange_invalid_amount_non_numeric()
    {
        $response = $this->json('GET', '/api/exchange', [
            'source' => 'TWD',
            'target' => 'USD',
            'amount' => 'invalid_amount',
        ]);

        $response->assertStatus(200)->assertJson(['msg' => 'Invalid input']);
    }

    public function test_exchange_invalid_amount_empty_string()
    {
        $response = $this->json('GET', '/api/exchange', [
            'source' => 'TWD',
            'target' => 'USD',
            'amount' => '',
        ]);

        $response->assertStatus(200)->assertJson(['msg' => 'Invalid input']);
    }
}
